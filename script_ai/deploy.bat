@echo off
chcp 65001 >nul
cd /d D:\laragon\www\axecode

echo ================================================
echo   DEPLOY :: axecode.tech
echo ================================================
echo.

:: ── 1. Запрашиваем сообщение коммита ─────────────────────────────────────
set /p COMMIT_MSG="Commit message (Enter = 'deploy: update'): "
if "%COMMIT_MSG%"=="" set COMMIT_MSG=deploy: update

:: ── 2. Git: add, commit, push ─────────────────────────────────────────────
echo.
echo [1/4] Git commit ^& push...
git add .
git commit -m "%COMMIT_MSG%"
if %errorlevel% neq 0 (
    echo   Нечего коммитить или ошибка — продолжаем...
)
git push origin main
if %errorlevel% neq 0 (
    echo [ERROR] git push завершился с ошибкой.
    pause
    exit /b 1
)
echo   OK

:: ── 3. SSH на сервер и деплой ────────────────────────────────────────────
echo.
echo [2/4] Подключаемся к серверу и деплоим...
echo       (85.239.57.126 :: axecode_tech_usr)
echo.

ssh axecode_tech_usr@85.239.57.126 "bash -s" << 'ENDSSH'
set -e
cd /var/www/axecode_tech_usr/data/www/axecode.tech

echo "[3/4] git pull..."
git pull origin main

echo "[4/4] npm build..."
npm install --silent
npm run build

echo "composer install..."
/opt/php83/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader --quiet

echo "migrate..."
/opt/php83/bin/php artisan migrate --force

echo ""
echo "================================================"
echo "  DEPLOY DONE :: axecode.tech"
echo "================================================"
ENDSSH

if %errorlevel% neq 0 (
    echo [ERROR] Деплой на сервере завершился с ошибкой.
    pause
    exit /b 1
)

echo.
echo Готово! Сайт обновлён: https://axecode.tech
echo.
pause
