param(
    [string]$Code,
    [string]$ProjectRoot = "D:\laragon\www\axecode",
    [switch]$NoUpdateCore
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

$phrases = @(
    'создание сайта',
    'разработка сайта',
    'заказать сайт',
    'сайт под ключ',
    'создание сайтов под ключ',
    'разработка сайтов',
    'создание веб сайта',
    'сделать сайт для бизнеса',
    'веб разработка',
    'веб студия',
    'разработка сайтов под ключ',
    'создание сайта для бизнеса',
    'заказать разработку сайта',
    'веб-студия разработки сайтов',
    'разработка корпоративного сайта',
    'создание корпоративного сайта',
    'разработка лендинга',
    'разработка веб-приложений',
    'разработка web приложений',
    'разработка личного кабинета',
    'разработка crm',
    'разработка crm системы',
    'разработка saas',
    'разработка saas платформы',
    'разработка b2b портала',
    'разработка b2c платформы',
    'разработка e commerce',
    'создание интернет магазина',
    'интернет магазин под ключ',
    'разработка интернет-магазина',
    'разработка маркетплейса',
    'разработка мобильного приложения',
    'разработка мобильных приложений',
    'мобильная разработка',
    'разработка приложения',
    'разработка приложений ios',
    'разработка приложений android',
    'разработка приложения ios',
    'разработка приложения android',
    'мобильное приложение',
    'мобильное приложение под ключ',
    'кроссплатформенная разработка',
    'кроссплатформенная мобильная разработка',
    'react native разработка',
    'flutter разработка',
    'разработка мобильных приложений ios android',
    'разработка landing page',
    'разработка лендинг пейдж',
    'разработка сайта на laravel',
    'разработка сайта на react',
    'backend разработка laravel',
    'разработка аналитической панели',
    'ui ux дизайн',
    'ui ux дизайн сайта',
    'ux дизайн сайта',
    'дизайн интерфейсов',
    'продуктовый дизайн интерфейсов',
    'редизайн сайта',
    'редизайн сайта под конверсию',
    'оптимизация сайта',
    'ускорение сайта',
    'ускорение загрузки сайта',
    'техническая поддержка',
    'техническая поддержка сайта',
    'поддержка сайта',
    'сопровождение сайта',
    'развитие и сопровождение проекта',
    'seo',
    'seo сайта',
    'seo продвижение',
    'seo оптимизация',
    'seo оптимизация сайта',
    'продвижение сайта',
    'продвижение сайта в яндексе',
    'контекстная реклама',
    'разработка и продвижение сайта',
    'создание и продвижение сайта',
    'стоимость разработки сайта',
    'цена разработки сайта',
    'сколько стоит сайт',
    'сколько стоит разработка сайта',
    'сроки разработки сайта',
    'этапы разработки сайта',
    'этапы создания мобильного приложения',
    'разработка приложения для ios',
    'разработка приложения для android',
    'разработка веб сервиса',
    'разработка веб портала',
    'разработка онлайн сервиса',
    'заказать разработку веб приложения',
    'заказать мобильное приложение'
)

Write-Host "[3/4] Fetch /v1/topRequests..."
$body = @{ phrases = $phrases } | ConvertTo-Json -Depth 5
$apiResp = Invoke-RestMethod -Method Post -Uri 'https://api.wordstat.yandex.net/v1/topRequests' -Headers @{ Authorization = "Bearer $token"; 'Content-Type' = 'application/json;charset=utf-8' } -Body $body

if (-not $apiResp) {
    throw 'Wordstat topRequests returned empty response.'
}

if ($apiResp -isnot [System.Array]) {
    $apiResp = @($apiResp)
}

$rows = foreach ($item in $apiResp) {
    [PSCustomObject]@{
        phrase = $item.requestPhrase
        totalCount = [int]($item.totalCount ?? 0)
        priority = Get-Priority -Count ([int]($item.totalCount ?? 0))
        error = $item.error
    }
}

$rows = $rows | Sort-Object totalCount -Descending

$today = Get-Date -Format 'yyyy-MM-dd'
$snapshotPath = Join-Path $ProjectRoot "storage\app\wordstat_semantic_snapshot_$today.json"
$rows | ConvertTo-Json -Depth 10 | Set-Content -Path $snapshotPath -Encoding UTF8

if (-not $NoUpdateCore) {
    Write-Host "[4/4] Update SEO_SEMANTIC_CORE.md..."
    $corePath = Join-Path $ProjectRoot 'SEO_SEMANTIC_CORE.md'

    $lines = @()
    $lines += "# Семантическое ядро Axecode (обновлено через Wordstat API, $today)"
    $lines += ''
    $lines += '## Технические параметры сбора'
    $lines += "- Источник: Яндекс Wordstat API (/v1/topRequests)"
    $lines += "- Пользователь: $($userInfo.userInfo.login)"
    $lines += "- Квота в день: $($userInfo.userInfo.dailyLimit), остаток: $($userInfo.userInfo.dailyLimitRemaining)"
    $lines += "- Ограничение в секунду: $($userInfo.userInfo.limitPerSecond)"
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
