@echo off
setlocal EnableExtensions EnableDelayedExpansion
cd /d D:\laragon\www\axecode

echo ================================================
echo   DEPLOY :: axecode.tech
echo ================================================
echo.

set "SERVER=axecode_tech_usr@85.239.57.126"
set "DEPLOY_PATH=/var/www/axecode_tech_usr/data/www/axecode.tech"
set "PHP=/usr/bin/php8.3"
set "COMPOSER=/usr/local/bin/composer"
set "BRANCH=main"

for /f "usebackq delims=" %%i in (`powershell -NoProfile -Command "Get-Date -Format \"yyyy-MM-dd HH:mm:ss\""`) do set "TS=%%i"
set "COMMIT_MSG=deploy: auto %TS%"

echo.
echo [1/3] Git sync...

git status --short >nul 2>&1
if errorlevel 1 (
    echo [ERROR] git status failed.
    exit /b 1
)

set "HAS_CHANGES="
for /f "delims=" %%i in ('git status --porcelain') do set "HAS_CHANGES=1"

if defined HAS_CHANGES (
    echo   Changes found. Creating commit...
    git add -A
    git commit -m "%COMMIT_MSG%"
    if errorlevel 1 (
        echo [ERROR] git commit failed.
        exit /b 1
    )
) else (
    echo   No local changes. Commit skipped.
)

echo   Pushing to origin/%BRANCH%...
git push origin %BRANCH%
if errorlevel 1 (
    echo [ERROR] git push failed.
    exit /b 1
)
echo   OK

echo.
echo [2/3] Deploy on server...
echo.
ssh %SERVER% "set -e; cd %DEPLOY_PATH% && git fetch origin && git checkout %BRANCH% && git pull origin %BRANCH% && npm install --silent && npm run build && (%PHP% %COMPOSER% install --no-dev --optimize-autoloader --quiet || %PHP% %COMPOSER% install --no-dev --optimize-autoloader --quiet --ignore-platform-req=ext-intl) && %PHP% artisan migrate --force && (%PHP% artisan db:seed --class=AdminSeeder --force || true) && %PHP% artisan db:seed --class=SeoKeywordPagesSeeder --force && %PHP% artisan optimize:clear && %PHP% artisan optimize && echo DEPLOY_OK"
if errorlevel 1 (
    echo.
    echo [ERROR] Server deploy failed.
    exit /b 1
)

echo.
echo [3/3] Site check...
curl -I -L --max-time 20 https://axecode.tech >nul 2>&1
if errorlevel 1 (
    echo [WARN] Could not verify https://axecode.tech automatically.
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
