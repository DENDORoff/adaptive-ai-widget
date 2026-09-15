@echo off
setlocal EnableExtensions
title Adaptive AI Widget - Ollama Setup

echo ============================================
echo   Adaptive AI Widget - Ollama Setup
echo ============================================
echo.

where ollama >nul 2>nul
if errorlevel 1 (
    echo [!] Ollama not found in PATH.
    echo     Download from https://ollama.com/download/windows
    echo     Install and run this script again.
    pause
    exit /b 1
)

echo [*] Checking if Ollama server is running...
curl -s -o nul http://localhost:11434/api/tags
if errorlevel 1 (
    echo [*] Ollama is not running - starting it...
    start "Ollama" ollama serve
)

echo [*] Waiting for Ollama to answer on http://localhost:11434 ...
set /a TRIES=0
:wait_loop
set /a TRIES+=1
curl -s -o nul http://localhost:11434/api/tags
if not errorlevel 1 goto server_up
if %TRIES% geq 30 (
    echo [!] Ollama did not answer in 30 seconds.
    echo     Check: is the antivirus blocking port 11434?
    pause
    exit /b 1
)
timeout /t 1 >nul
goto wait_loop
:server_up

echo [*] Checking available models...
curl -s http://localhost:11434/api/tags > "%TEMP%\aw_ollama_tags.json"
findstr /c:"qwen2.5" "%TEMP%\aw_ollama_tags.json" >nul
if not errorlevel 1 (
    echo [+] Model qwen2.5:3b is already downloaded.
    goto done
)

echo [*] Model qwen2.5:3b not found - downloading (~2GB)...
ollama pull qwen2.5:3b
if errorlevel 1 (
    echo [!] Failed to download the model. Try running: ollama pull qwen2.5:3b
    pause
    exit /b 1
)

:done
echo.
echo ============================================
echo   Ready! Now open demo/index.html
echo ============================================
echo.
echo   Ollama: http://localhost:11434
echo   Model:  qwen2.5:3b
echo.
pause
