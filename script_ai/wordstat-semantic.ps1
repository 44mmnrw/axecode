param(
    [string]$Code,
    [string]$ProjectRoot = "D:\laragon\www\axecode",
    [switch]$NoUpdateCore,
    [switch]$NoColloquialForms
)

$ErrorActionPreference = 'Stop'

function Get-EnvMap {
    param([string]$EnvPath)

    if (-not (Test-Path $EnvPath)) {
        throw ".env file not found at: $EnvPath"
    }

    $map = @{}
    Get-Content $EnvPath | ForEach-Object {
        $line = $_.Trim()
        if ($line -eq '' -or $line.StartsWith('#')) {
            return
        }

        $idx = $line.IndexOf('=')
        if ($idx -lt 1) {
            return
        }

        $key = $line.Substring(0, $idx).Trim()
        $value = $line.Substring($idx + 1).Trim().Trim('"')
        $map[$key] = $value
    }

    return $map
}

function Get-Priority {
    param([int]$Count)

    if ($Count -ge 10000) { return 'A' }
    if ($Count -ge 3000) { return 'B' }
    if ($Count -ge 700) { return 'C' }
    return 'D'
}

function Add-Phrase {
    param(
        [System.Collections.Generic.HashSet[string]]$Set,
        [string]$Phrase
    )

    $normalized = ($Phrase ?? '').Trim().ToLowerInvariant()
    if ([string]::IsNullOrWhiteSpace($normalized)) {
        return
    }

    $null = $Set.Add($normalized)
}

function Add-PhraseBatch {
    param(
        [System.Collections.Generic.HashSet[string]]$Set,
        [string[]]$Phrases
    )

    foreach ($phrase in $Phrases) {
        Add-Phrase -Set $Set -Phrase $phrase
    }
}

function Split-IntoChunks {
    param(
        [string[]]$Items,
        [int]$ChunkSize = 50
    )

    $chunks = @()
    for ($i = 0; $i -lt $Items.Count; $i += $ChunkSize) {
        $end = [Math]::Min($i + $ChunkSize - 1, $Items.Count - 1)
        $chunks += ,($Items[$i..$end])
    }

    return $chunks
}

function Load-TokenCache {
    param([string]$Path)

    if (-not (Test-Path $Path)) {
        return $null
    }

    try {
        return Get-Content $Path -Raw | ConvertFrom-Json
    } catch {
        return $null
    }
}

function Save-TokenCache {
    param(
        [string]$Path,
        [object]$TokenResponse
    )

    $expiresIn = [int]($TokenResponse.expires_in ?? 0)
    $expiresAt = if ($expiresIn -gt 0) { (Get-Date).AddSeconds($expiresIn).ToString('o') } else { $null }

    $cache = [PSCustomObject]@{
        access_token = $TokenResponse.access_token
        refresh_token = $TokenResponse.refresh_token
        token_type = $TokenResponse.token_type
        scope = $TokenResponse.scope
        expires_in = $expiresIn
        expires_at = $expiresAt
        updated_at = (Get-Date).ToString('o')
    }

    $cache | ConvertTo-Json -Depth 10 | Set-Content -Path $Path -Encoding UTF8
}

function Request-TokenByCode {
    param(
        [string]$ClientId,
        [string]$ClientSecret,
        [string]$RedirectUri,
        [string]$Code
    )

    return Invoke-RestMethod -Method Post -Uri 'https://oauth.yandex.ru/token' -ContentType 'application/x-www-form-urlencoded' -Body "grant_type=authorization_code&code=$Code&client_id=$ClientId&client_secret=$ClientSecret&redirect_uri=$([uri]::EscapeDataString($RedirectUri))"
}

function Request-TokenByRefresh {
    param(
        [string]$ClientId,
        [string]$ClientSecret,
        [string]$RefreshToken
    )

    return Invoke-RestMethod -Method Post -Uri 'https://oauth.yandex.ru/token' -ContentType 'application/x-www-form-urlencoded' -Body "grant_type=refresh_token&refresh_token=$([uri]::EscapeDataString($RefreshToken))&client_id=$ClientId&client_secret=$ClientSecret"
}

$envPath = Join-Path $ProjectRoot '.env'
$envMap = Get-EnvMap -EnvPath $envPath

$clientId = $envMap['YANDEX_WORDSTAT_CLIENT_ID']
$clientSecret = $envMap['YANDEX_WORDSTAT_CLIENT_SECRET']
$redirectUri = $envMap['YANDEX_WORDSTAT_REDIRECT_URI']

if ([string]::IsNullOrWhiteSpace($clientId) -or [string]::IsNullOrWhiteSpace($clientSecret) -or [string]::IsNullOrWhiteSpace($redirectUri)) {
    throw "Missing YANDEX_WORDSTAT_CLIENT_ID / YANDEX_WORDSTAT_CLIENT_SECRET / YANDEX_WORDSTAT_REDIRECT_URI in .env"
}


$tokenCachePath = Join-Path $ProjectRoot 'storage\app\wordstat_token_cache.json'
$tokenCache = Load-TokenCache -Path $tokenCachePath
$tokenResp = $null

if (-not [string]::IsNullOrWhiteSpace($Code)) {
    Write-Host "[1/4] Exchange code -> token..."
    $tokenResp = Request-TokenByCode -ClientId $clientId -ClientSecret $clientSecret -RedirectUri $redirectUri -Code $Code
} else {
    if ($tokenCache -and -not [string]::IsNullOrWhiteSpace($tokenCache.access_token) -and -not [string]::IsNullOrWhiteSpace($tokenCache.expires_at)) {
        $expiresAt = [datetime]::Parse($tokenCache.expires_at)
        if ($expiresAt -gt (Get-Date).AddMinutes(2)) {
            Write-Host "[1/4] Use cached access token..."
            $tokenResp = [PSCustomObject]@{
                access_token = $tokenCache.access_token
                refresh_token = $tokenCache.refresh_token
                token_type = $tokenCache.token_type
                expires_in = [int]([math]::Max(0, ($expiresAt - (Get-Date)).TotalSeconds))
                scope = $tokenCache.scope
            }
        }
    }

    if (-not $tokenResp -and $tokenCache -and -not [string]::IsNullOrWhiteSpace($tokenCache.refresh_token)) {
        Write-Host "[1/4] Refresh access token..."
        $tokenResp = Request-TokenByRefresh -ClientId $clientId -ClientSecret $clientSecret -RefreshToken $tokenCache.refresh_token
    }

    if (-not $tokenResp) {
        $Code = Read-Host 'Введите verification code'
        if ([string]::IsNullOrWhiteSpace($Code)) {
            throw 'Verification code is empty and no cached token available.'
        }

        Write-Host "[1/4] Exchange code -> token..."
        $tokenResp = Request-TokenByCode -ClientId $clientId -ClientSecret $clientSecret -RedirectUri $redirectUri -Code $Code
    }
}

if (-not $tokenResp.access_token) {
    throw 'OAuth response does not contain access_token.'
}

Save-TokenCache -Path $tokenCachePath -TokenResponse $tokenResp

$token = $tokenResp.access_token

Write-Host "[2/4] Check /v1/userInfo..."
$userInfo = Invoke-RestMethod -Method Post -Uri 'https://api.wordstat.yandex.net/v1/userInfo' -Headers @{ Authorization = "Bearer $token"; 'Content-Type' = 'application/json;charset=utf-8' } -Body '{}'


$phraseSet = [System.Collections.Generic.HashSet[string]]::new([System.StringComparer]::OrdinalIgnoreCase)

$basePhrases = @(
    'заказать сайт',
    'сайт под ключ',
    'создание сайта',
    'разработка сайта',
    'разработка сайтов',
    'создание сайтов под ключ',
    'разработка сайтов под ключ',
    'заказать разработку сайта',
    'создание сайта для бизнеса',
    'разработка корпоративного сайта',
    'создание корпоративного сайта',
    'разработка лендинга',
    'разработка landing page',
    'разработка лендинг пейдж',
    'разработка веб-приложений',
    'разработка web приложений',
    'разработка веб приложения',
    'заказать разработку веб приложения',
    'разработка веб сервиса',
    'разработка онлайн сервиса',
    'разработка веб портала',
    'разработка crm',
    'разработка crm системы',
    'разработка личного кабинета',
    'разработка saas',
    'разработка saas платформы',
    'разработка b2b портала',
    'разработка b2c платформы',
    'создание интернет магазина',
    'разработка интернет-магазина',
    'интернет магазин под ключ',
    'разработка маркетплейса',
    'разработка мобильного приложения',
    'разработка мобильных приложений',
    'мобильная разработка',
    'заказать мобильное приложение',
    'мобильное приложение под ключ',
    'разработка приложения ios',
    'разработка приложения android',
    'разработка приложения для ios',
    'разработка приложения для android',
    'разработка приложений ios',
    'разработка приложений android',
    'кроссплатформенная разработка',
    'кроссплатформенная мобильная разработка',
    'flutter разработка',
    'react native разработка',
    'разработка сайта на laravel',
    'разработка сайта на react',
    'backend разработка laravel',
    'веб студия',
    'веб-студия разработки сайтов',
    'веб разработка',
    'техническая поддержка',
    'техническая поддержка сайта',
    'поддержка сайта',
    'сопровождение сайта',
    'развитие и сопровождение проекта',
    'редизайн сайта',
    'редизайн сайта под конверсию',
    'ускорение сайта',
    'ускорение загрузки сайта',
    'оптимизация сайта',
    'ui ux дизайн',
    'ui ux дизайн сайта',
    'ux дизайн сайта',
    'дизайн интерфейсов'
)

Add-PhraseBatch -Set $phraseSet -Phrases $basePhrases

$objectsForOrder = @(
    'сайт',
    'сайты',
    'корпоративный сайт',
    'веб сайт',
    'лендинг',
    'интернет магазин',
    'веб приложение',
    'онлайн сервис',
    'веб сервис',
    'веб портал',
    'crm систему',
    'личный кабинет',
    'saas платформу',
    'маркетплейс',
    'мобильное приложение',
    'мобильные приложения',
    'приложение ios',
    'приложение android'
)

$objectsForDevelopment = @(
    'сайта',
    'сайтов',
    'корпоративного сайта',
    'веб сайта',
    'лендинга',
    'интернет-магазина',
    'веб-приложения',
    'веб-сервиса',
    'онлайн-сервиса',
    'веб-портала',
    'crm системы',
    'личного кабинета',
    'saas платформы',
    'маркетплейса',
    'мобильного приложения',
    'мобильных приложений',
    'приложения ios',
    'приложения android'
)

$buyIntentPrefixes = @(
    'заказать',
    'сделать'
)

$commercialSuffixes = @(
    '',
    'под ключ',
    'для бизнеса',
    'цена',
    'стоимость',
    'москва',
    'санкт петербург'
)

foreach ($prefix in $buyIntentPrefixes) {
    foreach ($obj in $objectsForOrder) {
        Add-Phrase -Set $phraseSet -Phrase "$prefix $obj"
        foreach ($suffix in $commercialSuffixes) {
            if (-not [string]::IsNullOrWhiteSpace($suffix)) {
                Add-Phrase -Set $phraseSet -Phrase "$prefix $obj $suffix"
            }
        }
    }
}

$developmentPrefixes = @(
    'создание',
    'разработка',
    'заказать разработку'
)

foreach ($prefix in $developmentPrefixes) {
    foreach ($obj in $objectsForDevelopment) {
        Add-Phrase -Set $phraseSet -Phrase "$prefix $obj"
        foreach ($suffix in $commercialSuffixes) {
            if (-not [string]::IsNullOrWhiteSpace($suffix)) {
                Add-Phrase -Set $phraseSet -Phrase "$prefix $obj $suffix"
            }
        }
    }
}

# Реальные «поисковые» словоформы (в т.ч. неграмотные),
# которые часто встречаются в Wordstat и дают дополнительную семантику.
if (-not $NoColloquialForms) {
    $objectsForColloquial = @(
        'сайт',
        'сайты',
        'корпоративный сайт',
        'веб сайт',
        'лендинг',
        'интернет магазин',
        'веб приложение',
        'онлайн сервис',
        'веб сервис',
        'веб портал',
        'crm',
        'crm система',
        'личный кабинет',
        'saas платформа',
        'маркетплейс',
        'мобильное приложение',
        'мобильные приложения',
        'приложение ios',
        'приложение android'
    )

    $colloquialPrefixes = @(
        'создание',
        'разработка'
    )

    foreach ($prefix in $colloquialPrefixes) {
        foreach ($obj in $objectsForColloquial) {
            Add-Phrase -Set $phraseSet -Phrase "$prefix $obj"
            foreach ($suffix in $commercialSuffixes) {
                if (-not [string]::IsNullOrWhiteSpace($suffix)) {
                    Add-Phrase -Set $phraseSet -Phrase "$prefix $obj $suffix"
                }
            }
        }
    }
}

$techAndStack = @(
    'laravel разработка',
    'react разработка',
    'vue разработка',
    'php разработка',
    'javascript разработка',
    'typescript разработка',
    'ios разработка',
    'android разработка'
)

Add-PhraseBatch -Set $phraseSet -Phrases $techAndStack

$phrases = @($phraseSet) | Sort-Object

Write-Host "[3/4] Prepared $($phrases.Count) phrases for Wordstat..."

Write-Host "[3/4] Fetch /v1/topRequests in batches..."
$chunks = Split-IntoChunks -Items $phrases -ChunkSize 50
$apiItems = @()

for ($chunkIndex = 0; $chunkIndex -lt $chunks.Count; $chunkIndex++) {
    $chunk = $chunks[$chunkIndex]
    Write-Host ("  -> batch {0}/{1} ({2} phrases)" -f ($chunkIndex + 1), $chunks.Count, $chunk.Count)

    $body = @{ phrases = $chunk } | ConvertTo-Json -Depth 5
    $chunkResp = Invoke-RestMethod -Method Post -Uri 'https://api.wordstat.yandex.net/v1/topRequests' -Headers @{ Authorization = "Bearer $token"; 'Content-Type' = 'application/json;charset=utf-8' } -Body $body

    if ($chunkResp) {
        if ($chunkResp -is [System.Array]) {
            $apiItems += $chunkResp
        } else {
            $apiItems += @($chunkResp)
        }
    }

    Start-Sleep -Milliseconds 150
}

if (-not $apiItems -or $apiItems.Count -eq 0) {
    throw 'Wordstat topRequests returned empty response for all batches.'
}

$rows = foreach ($item in $apiItems) {
    [PSCustomObject]@{
        phrase = $item.requestPhrase
        totalCount = [int]($item.totalCount ?? 0)
        priority = Get-Priority -Count ([int]($item.totalCount ?? 0))
        error = $item.error
    }
}

$rows = $rows |
    Sort-Object phrase, totalCount -Descending |
    Group-Object phrase |
    ForEach-Object { $_.Group | Select-Object -First 1 } |
    Sort-Object totalCount -Descending

$commercialRegex = '(заказать|сделать|под ключ|разработка|создание|веб\s*-?студ|сопровождение|поддержка|интернет\s*-?магазин|маркетплейс|мобильн|корпоративн|crm|saas|личн(ый|ого)\s+кабинет)'
$commercialRows = $rows | Where-Object { $_.phrase -match $commercialRegex } | Sort-Object totalCount -Descending

$today = Get-Date -Format 'yyyy-MM-dd'
$snapshotPath = Join-Path $ProjectRoot "storage\app\wordstat_semantic_snapshot_$today.json"
$rows | ConvertTo-Json -Depth 10 | Set-Content -Path $snapshotPath -Encoding UTF8

if (-not $NoUpdateCore) {
    Write-Host "[4/4] Update SEO_SEMANTIC_CORE.md..."
    $corePath = Join-Path $ProjectRoot 'SEO\SEO_SEMANTIC_CORE.md'

    $lines = @()
    $lines += "# Семантическое ядро Axecode (обновлено через Wordstat API, $today)"
    $lines += ''
    $lines += '## Технические параметры сбора'
    $lines += "- Источник: Яндекс Wordstat API (/v1/topRequests)"
    $lines += "- Пользователь: $($userInfo.userInfo.login)"
    $lines += "- Квота в день: $($userInfo.userInfo.dailyLimit), остаток: $($userInfo.userInfo.dailyLimitRemaining)"
    $lines += "- Ограничение в секунду: $($userInfo.userInfo.limitPerSecond)"
    $lines += "- Проанализировано фраз: $($phrases.Count)"
    $lines += "- Получено запросов (уникальных): $($rows.Count)"
    $lines += "- Релевантных коммерческих: $($commercialRows.Count)"
    $lines += ''
    $lines += '## Максимально релевантные коммерческие запросы (Top 150)'
    $lines += '| Приоритет | Запрос | Частотность (totalCount) |'
    $lines += '|---|---|---:|'

    foreach ($row in ($commercialRows | Select-Object -First 150)) {
        $safePhrase = ($row.phrase -replace '\|', '\\|')
        $lines += "| $($row.priority) | $safePhrase | $($row.totalCount) |"
    }
    $lines += ''
    $lines += '## Приоритизированный список запросов (по totalCount)'
    $lines += '| Приоритет | Запрос | Частотность (totalCount) |'
    $lines += '|---|---|---:|'

    foreach ($row in $rows) {
        $safePhrase = ($row.phrase -replace '\|', '\\|')
        $lines += "| $($row.priority) | $safePhrase | $($row.totalCount) |"
    }

    $lines += ''
    $lines += '## Пометки'
    $lines += '- totalCount — число запросов, содержащих все слова фразы в любом порядке (по данным метода /v1/topRequests).'
    $lines += '- Рекомендуется пересбор 1 раз в 2-4 недели для актуализации приоритетов.'
    $lines += "- JSON-снимок текущего запуска: storage/app/wordstat_semantic_snapshot_$today.json"

    Set-Content -Path $corePath -Value ($lines -join [Environment]::NewLine) -Encoding UTF8
}

Write-Host ''
Write-Host 'Готово.'
Write-Host "JSON: $snapshotPath"
if (-not $NoUpdateCore) {
    Write-Host 'Markdown: SEO_SEMANTIC_CORE.md'
}
Write-Host ''
Write-Host 'Top-10:'
$rows | Select-Object -First 10 phrase, totalCount, priority | Format-Table -AutoSize
