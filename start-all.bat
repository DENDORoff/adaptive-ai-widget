@echo off
setlocal
cd /d "%~dp0"

title Adaptive Widget - запуск всех сервисов

echo.
echo  ============================================
echo   Adaptive Widget - запуск всех сервисов
echo  ============================================
echo.

set "SITE_DIR=%~dp0Colledge\CollegeWebsite-main"
set "SRV_DIR=%~dp0server"

REM ---- 1. Php + Laravel сайт (port 8000) ----
if not exist "%SITE_DIR%\artisan" (
  echo  [WARN] artisan не найден - сайт не запущен: %SITE_DIR%
) else (
  start "AdaptiveWidget-Site [:8000]" /d "%SITE_DIR%" cmd /k "php artisan serve --host=127.0.0.1 --port=8000"
  echo  [OK] сайт запускается на http://localhost:8000
)

REM ---- 2. Node-сервер виджета (port 3000) ----
if not exist "%SRV_DIR%\server.js" (
  echo  [WARN] server.js не найден - сервер виджета не запущен: %SRV_DIR%
) else (
  start "AdaptiveWidget-Server [:3000]" /d "%SRV_DIR%" cmd /k "node server.js"
  echo  [OK] сервер запускается на http://localhost:3000
)

echo.
echo  Полезные адреса:
echo      Админка:       http://localhost:3000/admin
echo      API сервера:   http://localhost:3000/api/health
echo      Сайт:          http://localhost:8000
echo      Demo:          http://localhost:3000
echo      Лендинг:       "%~dp0landing\index.html"
echo      Презентация:   "%~dp0presentation\index.html"
echo.
echo  Остановить сервисы:  "%~dp0stop-all.bat"
echo.
pause