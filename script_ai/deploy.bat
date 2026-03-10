@echo off
chcp 65001 >nul
setlocal EnableExtensions EnableDelayedExpansion
cd /d D:\laragon\www\axecode

echo ================================================
echo   DEPLOY :: axecode.tech
echo ================================================
echo.

set SERVER=axecode_tech_usr@85.239.57.126
set DEPLOY_PATH=/var/www/axecode_tech_usr/data/www/axecode.tech
set PHP=/usr/bin/php8.3
set COMPOSER=/usr/local/bin/composer
set BRANCH=main

for /f %%i in ('powershell -NoProfile -Command "Get-Date -Format \"yyyy-MM-dd HH:mm:ss\""') do set TS=%%i
set COMMIT_MSG=deploy: auto %TS%

:: ── 1. Git (автоматически) ────────────────────────────────────────────────
echo.
echo [1/3] Git sync...

git status --short >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Не удалось получить git status.
    exit /b 1
)

git diff --quiet
if %errorlevel% neq 0 (
    echo   Найдены изменения. Создаю commit...
    git add -A
    git commit -m "%COMMIT_MSG%"
    if !errorlevel! neq 0 (
        echo [ERROR] git commit завершился с ошибкой.
        exit /b 1
    )
) else (
    echo   Локальных изменений нет. Commit пропущен.
)

echo   Push в origin/%BRANCH%...
git push origin %BRANCH%
if %errorlevel% neq 0 (
    echo [ERROR] git push завершился с ошибкой.
    exit /b 1
)
echo   OK

:: ── 2. Деплой на сервере через SSH ────────────────────────────────────────
echo.
echo [2/3] Deploy on server...
echo.
ssh %SERVER% "set -e; cd %DEPLOY_PATH% && git fetch origin && git checkout %BRANCH% && git pull origin %BRANCH% && npm install --silent && npm run build && (%PHP% %COMPOSER% install --no-dev --optimize-autoloader --quiet || %PHP% %COMPOSER% install --no-dev --optimize-autoloader --quiet --ignore-platform-req=ext-intl) && %PHP% artisan migrate --force && %PHP% artisan db:seed --class=AdminSeeder && %PHP% artisan optimize:clear && %PHP% artisan optimize && echo DEPLOY_OK"

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Деплой на сервере завершился с ошибкой.
    exit /b 1
)

:: ── 3. Финальная проверка ─────────────────────────────────────────────────
echo.
echo [3/3] Проверка сайта...
curl -I -L --max-time 20 https://axecode.tech >nul 2>&1
if %errorlevel% neq 0 (
    echo [WARN] Не удалось автоматически проверить https://axecode.tech
) else (
    echo   Site check OK
)

echo.
echo ================================================
echo   DEPLOY DONE :: https://axecode.tech
echo ================================================
echo.
endlocal
exit /b 0
