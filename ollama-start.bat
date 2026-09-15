@echo off
setlocal
title Ollama - Adaptive Widget server

where ollama >nul 2>nul
if errorlevel 1 (
    echo [!] Ollama not found in PATH.
    echo     Download from https://ollama.com/download/windows and install.
    pause
    exit /b 1
)

echo [*] Checking if Ollama is already running on http://localhost:11434 ...
curl -s -o nul http://localhost:11434/api/tags
if not errorlevel 1 (
    echo [+] Ollama is already running. Just open demo/index.html
    timeout /t 3 >nul
    exit /b 0
)

echo [*] Starting Ollama...
set CUDA_VISIBLE_DEVICES=-1
set OLLAMA_HOST=127.0.0.1:11434
set OLLAMA_ORIGINS=*
ollama serve

echo.
echo ============================================
echo   Ollama stopped. Open demo/index.html again
echo ============================================
pause