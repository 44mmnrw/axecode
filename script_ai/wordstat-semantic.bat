@echo off
chcp 65001 >nul
cd /d D:\laragon\www\axecode

set CODE=%1
if "%CODE%"=="" (
  set /p CODE=Введите verification code: 
)

echo Запускаю сбор семантики через Wordstat API...
pwsh -ExecutionPolicy Bypass -File "D:\laragon\www\axecode\script_ai\wordstat-semantic.ps1" -Code "%CODE%"

if %errorlevel% neq 0 (
  echo.
  echo [ERROR] Скрипт завершился с ошибкой.
  pause
  exit /b 1
)

echo.
echo [OK] Семантическое ядро обновлено.
pause
