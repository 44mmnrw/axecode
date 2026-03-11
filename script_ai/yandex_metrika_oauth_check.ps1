param(
    [Parameter(Mandatory = $true)]
    [string]$Code
)

$ErrorActionPreference = 'Stop'

$envPath = Join-Path $PSScriptRoot '..\.env'
if (-not (Test-Path $envPath)) {
    throw ".env not found: $envPath"
}

$lines = Get-Content $envPath

function Get-EnvValue([string]$name) {
    $prefix = "$name="
    foreach ($line in $lines) {
        if ($line.StartsWith($prefix)) {
            return $line.Substring($prefix.Length).Trim()
        }
    }
    return $null
}

$clientId = Get-EnvValue 'YANDEX_METRIKA_CLIENT_ID'
$clientSecret = Get-EnvValue 'YANDEX_METRIKA_CLIENT_SECRET'
$redirectUri = Get-EnvValue 'YANDEX_WORDSTAT_REDIRECT_URI'

if ([string]::IsNullOrWhiteSpace($clientId) -or [string]::IsNullOrWhiteSpace($clientSecret)) {
    throw 'YANDEX_METRIKA_CLIENT_ID / YANDEX_METRIKA_CLIENT_SECRET are missing in .env'
}

if ([string]::IsNullOrWhiteSpace($redirectUri)) {
    $redirectUri = 'https://oauth.yandex.ru/verification_code'
}

Write-Host 'Requesting user OAuth token from Yandex...' -ForegroundColor Cyan

$tokenResponse = Invoke-RestMethod -Method Post -Uri 'https://oauth.yandex.ru/token' -ContentType 'application/x-www-form-urlencoded' -Body @{
    grant_type = 'authorization_code'
    code = $Code
    client_id = $clientId
    client_secret = $clientSecret
    redirect_uri = $redirectUri
}

if (-not $tokenResponse.access_token) {
    throw 'No access_token in token response'
}

$token = [string]$tokenResponse.access_token
Write-Host 'Token received successfully.' -ForegroundColor Green
Write-Host ('Token type: ' + $tokenResponse.token_type)
Write-Host ('Expires in: ' + $tokenResponse.expires_in)

Write-Host 'Checking Yandex Metrika API /management/v1/counters...' -ForegroundColor Cyan

$headers = @{ Authorization = "OAuth $token" }
$countersResponse = Invoke-RestMethod -Method Get -Uri 'https://api-metrika.yandex.net/management/v1/counters' -Headers $headers

$count = 0
if ($null -ne $countersResponse.counters) {
    $count = @($countersResponse.counters).Count
}

Write-Host ('Metrika API OK. Counters found: ' + $count) -ForegroundColor Green

# Optional: save token to .env
$tokenKey = 'YANDEX_METRIKA_ACCESS_TOKEN'
$tokenLine = "$tokenKey=$token"
$updated = $false

for ($i = 0; $i -lt $lines.Count; $i++) {
    if ($lines[$i].StartsWith("$tokenKey=")) {
        $lines[$i] = $tokenLine
        $updated = $true
        break
    }
}

if (-not $updated) {
    $lines += $tokenLine
}

Set-Content -Path $envPath -Value $lines -Encoding UTF8
Write-Host 'Saved token to .env as YANDEX_METRIKA_ACCESS_TOKEN' -ForegroundColor Yellow
