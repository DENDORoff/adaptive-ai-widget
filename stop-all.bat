@echo off
setlocal
title Adaptive Widget - остановка сервисов

echo.
echo  Останавливаю все Node-серверы и все PHP-процессы (artisan serve)...
echo  ВНИМАНИЕ: будут закрыты ВСЕ процессы node.exe и php.exe на этой машине.
choice /c yn /m "Продолжить"
if errorlevel 2 exit /b 0

taskkill /F /IM node.exe >nul 2>nul
taskkill /F /IM php.exe >nul 2>nul
timeout /t 1 /nobreak >nul

echo  Готово. Окна серверов закрыты.
pause