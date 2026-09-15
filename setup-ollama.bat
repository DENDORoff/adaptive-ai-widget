@echo off
echo ============================================
echo   Adaptive AI Widget - Ollama Setup
echo ============================================
echo.

where ollama >nul 2>nul
if %errorlevel% neq 0 (
    echo [!] Ollama не найден в PATH.
    echo     Скачайте с https://ollama.com/download/windows
    echo     Установите и перезапустите этот скрипт.
    pause
    exit /b 1
)

echo [*] Проверяю, запущен ли Ollama...
curl -s http://localhost:11434/api/tags >nul 2>nul
if %errorlevel% neq 0 (
    echo [*] Запускаю Ollama...
    start "" ollama serve
    timeout /t 3 >nul
)

echo [*] Проверяю доступные модели...
for /f "tokens=*" %%i in ('curl -s http://localhost:11434/api/tags ^| findstr "qwen2.5"') do (
    set FOUND=1
)

if defined FOUND (
    echo [+] Модель qwen2.5 уже скачана.
) else (
    echo [*] Скачиваю модель qwen2.5:3b (~2GB)...
    ollama pull qwen2.5:3b
)

echo.
echo ============================================
echo   Готово! Теперь откройте demo/index.html
echo ============================================
echo.
echo   Ollama: http://localhost:11434
echo   Модель: qwen2.5:3b
echo.
pause
