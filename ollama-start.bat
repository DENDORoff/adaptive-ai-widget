@echo off
setlocal EnableDelayedExpansion
title Adaptive AI Widget - Ollama

rem ---------------------------------------------------------------
rem   Find ollama.exe: in PATH or in common install locations
rem ---------------------------------------------------------------
set "OLLAMA_EXE="
where ollama >nul 2>nul
if not errorlevel 1 (
    set "OLLAMA_EXE=ollama"
) else (
    if exist "%LOCALAPPDATA%\Programs\Ollama\ollama.exe" set "OLLAMA_EXE=%LOCALAPPDATA%\Programs\Ollama\ollama.exe"
)
if not defined OLLAMA_EXE if exist "%USERPROFILE%\ollama.exe" set "OLLAMA_EXE=%USERPROFILE%\ollama.exe"
if not defined OLLAMA_EXE if exist "%ProgramFiles%\Ollama\ollama.exe" set "OLLAMA_EXE=%ProgramFiles%\Ollama\ollama.exe"

if not defined OLLAMA_EXE (
    echo [!] Ollama not found.
    echo     Installed with the installer? It lands here:
    echo         %LOCALAPPDATA%\Programs\Ollama\ollama.exe
    echo     Download from https://ollama.com/download/windows
    echo     Then re-run this script.
    pause
    exit /b 1
)
echo [*] Ollama: !OLLAMA_EXE!

rem ---------------------------------------------------------------
rem   Make sure the server is running
rem ---------------------------------------------------------------
set "OLLAMA_HOST=127.0.0.1:11434"
curl -s -o nul http://localhost:11434/api/tags
if errorlevel 1 (
    echo [*] Ollama is not running - starting it...
    set CUDA_VISIBLE_DEVICES=-1
    start "Ollama" "!OLLAMA_EXE!" serve
)

echo [*] Waiting for Ollama to answer on http://localhost:11434 ...
set /a TRIES=0
:wait_loop
set /a TRIES+=1
curl -s -o nul http://localhost:11434/api/tags
if not errorlevel 1 goto server_up
if %TRIES% geq 30 (
    echo [!] Ollama did not answer in 30 seconds.
    echo     Check the antivirus - it may block port 11434.
    echo     Also make sure this is not an old/existing 'ollama serve' loop.
    pause
    exit /b 1
)
timeout /t 1 >nul
goto wait_loop
:server_up
echo [*] Ollama server is up. Checking model qwen2.5:3b ...

rem ---------------------------------------------------------------
rem   Make sure the model is present
rem ---------------------------------------------------------------
curl -s http://localhost:11434/api/tags > "%TEMP%\aw_ollama_tags.json"
findstr /c:"qwen2.5" "%TEMP%\aw_ollama_tags.json" >nul
if not errorlevel 1 goto done

echo [*] Model qwen2.5:3b not found - downloading (~2GB)...
"!OLLAMA_EXE!" pull qwen2.5:3b
if errorlevel 1 (
    echo [!] Failed to download the model. Try: ollama pull qwen2.5:3b
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