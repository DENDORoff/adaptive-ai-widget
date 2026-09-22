@echo off
setlocal EnableDelayedExpansion
title Adaptive AI Widget - DEMO

set "ROOT=%~dp0"
set "SITE=D:\DW\Colledge\CollegeWebsite-main"

echo.
echo   === ДЕМО адаптивного ИИ-виджета колледжа ===
echo.

rem ---------------------------------------------------------------
rem   1/3  Сайт колледжа (php -S 127.0.0.1:8000)
rem ---------------------------------------------------------------
echo [1/3] Сайт колледжа ...
curl -s --max-time 3 -o nul http://127.0.0.1:8000/
if not errorlevel 1 (
    echo [*] Сайт уже работает: http://127.0.0.1:8000
) else (
    start "CollegeSite" /D "%SITE%" cmd /c "set PATH=C:\php84;%PATH% && php -S 127.0.0.1:8000 -t public"
    echo [*] Сайт запущен: http://127.0.0.1:8000
)

rem ---------------------------------------------------------------
rem   2/3  Виджет-сервер (node server\server.js, порт 3000)
rem ---------------------------------------------------------------
echo.
echo [2/3] Виджет-сервер ...
curl -s --max-time 3 -o nul http://127.0.0.1:3000/api/health
if not errorlevel 1 (
    echo [*] Виджет-сервер уже работает.
) else (
    start "WidgetServer" /D "%ROOT%" cmd /k "node server\server.js"
    echo [*] Виджет-сервер запущен: http://127.0.0.1:3000
)

rem ---------------------------------------------------------------
rem   3/3  Ollama + модель qwen2.5:3b (долго, если ещё не скачана)
rem ---------------------------------------------------------------
echo.
echo [3/3] Ollama + модель qwen2.5:3b ...
call "%ROOT%ollama-start.bat" --nopause
if errorlevel 1 echo [!] Ollama не поднялась - ИИ сейчас не отвечает (повторите позже).

echo.
echo ================================================
echo   Готово! Откройте в браузере:
echo     Сайт колледжа:  http://127.0.0.1:8000
echo     Админка виджета:http://127.0.0.1:3000/admin
echo     Демо виджета:   http://127.0.0.1:3000/demo
echo ================================================
echo.
echo  ВАЖНО: на сайте две кнопки справа:
echo   - верхняя - "Связь с администратором" (телефоны/e-mail)
echo   - нижняя  - ИИ-виджет (поддержка/FAQ)
echo.
pause