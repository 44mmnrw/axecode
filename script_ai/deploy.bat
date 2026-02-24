@echo off
chcp 65001 >nul
cd /d D:\laragon\www\axecode

echo ================================================
echo   DEPLOY :: axecode.tech
echo ================================================
echo.

:: ── 1. Сообщение коммита ─────────────────────────────────────────────────
set /p COMMIT_MSG="Commit message (Enter = 'deploy: update'): "
if "%COMMIT_MSG%"=="" set COMMIT_MSG=deploy: update

:: ── 2. Git ────────────────────────────────────────────────────────────────
echo.
echo [1/2] Git commit ^& push...
git add .
git commit -m "%COMMIT_MSG%"
git push origin main
if %errorlevel% neq 0 (
    echo [ERROR] git push завершился с ошибкой.
    pause
    exit /b 1
)
echo   OK

:: ── 3. Деплой на сервере через SSH ───────────────────────────────────────
echo.
echo [2/2] Деплой на сервере...
echo.

set SERVER=axecode_tech_usr@85.239.57.126
set DEPLOY_PATH=/var/www/axecode_tech_usr/data/www/axecode.tech
set PHP=/opt/php83/bin/php
set COMPOSER=/usr/local/bin/composer

ssh %SERVER% "cd %DEPLOY_PATH% && git pull origin main && npm install --silent && npm run build && %PHP% %COMPOSER% install --no-dev --optimize-autoloader --quiet && %PHP% artisan migrate --force && echo DEPLOY_OK"

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Деплой на сервере завершился с ошибкой.
    pause
    exit /b 1
)

echo.
echo ================================================
echo   DEPLOY DONE :: https://axecode.tech
echo ================================================
echo.
pause
