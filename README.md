# Adaptive AI Widget

Адаптивный ИИ-виджет для сайтов с локальным ИИ на Ollama: один `<script>` — виджет автоматически подстраивает стиль и отвечает на основе данных страницы.

## Быстрый старт

### 1. Установить Ollama

```bash
# Windows
# Скачайте с https://ollama.com/download/windows
# Или запустите:
setup-ollama.bat
```

### 2. Скачать модель

```bash
ollama pull qwen2.5:3b
```

### 3. Запустить Ollama

```bash
ollama serve
```

### 4. Открыть демо

```bash
# Светлая тема (GadgetHub)
start demo\index.html

# Тёмная тема (Nebula Commerce)  
start demo\dark-store.html
```

## Как это работает

1. **Экстракция стиля** — читает CSS-переменные (`--brand`, `--accent`), цвета кнопок, шрифт, тему (dark/light)
2. **Экстракция знаний** — парсит JSON-LD, заголовки, FAQ, товары, контакты из DOM
3. **Поиск** — взвешенный поиск по извлечённым токенам (заголовок весит x3)
4. **ИИ** — RAG: контекст из знаний сайта + вопрос → Ollama (локально) или облачный API (OpenAI/OpenRouter/Groq/Mistral), вывод через OpenAI-совместимый формат

## Архитектура

```
Пользователь → Вопрос
        ↓
┌───────────────────────────────────┐
│       Адаптивный ИИ-Агент        │
├───────────────────────────────────┤
│  1. Экстракция стиля сайта       │  ← getComputedStyle(), CSS variables
│  2. Экстракция знаний            │  ← JSON-LD, headings, FAQ, products
│  3. Построение индекса            │  ← tokenization, scoring
│  4. Поиск ответа                 │  ← weighted TF matching
│  5. ИИ-ответ (RAG)               │  ← Ollama или облако, контекст + вопрос
└───────────────────────────────────┘
        ↓
  Ответ с источником
```

## Подключение на свой сайт

```html
<script>
window.ADAPTIVE_WIDGET = {
  siteName: 'Мой магазин',
  aiEnabled: true,
  model: 'qwen2.5:3b'
};
</script>
<script src="widget/adaptive-widget.js" defer></script>
```

### Альтернативные LLM

Виджет умеет работать с любым OpenAI-совместимым API — локальным (Ollama) или облачным (OpenAI, OpenRouter, Groq, Mistral, свой сервер):

```html
<script>
window.ADAPTIVE_WIDGET = {
  aiEnabled: true,
  provider: 'openai',         // openai | openrouter | groq | mistral | ollama | custom
  apiKey: 'sk-...',           // ключ облачного API
  model: 'gpt-4o-mini'        // если не указан — берётся модель по умолчанию провайдера
};
</script>
```

Если `provider` не задан, виджет выбирает его автоматически: есть `apiKey` → `openai` (+ `gpt-4o-mini`), нет → локальная `ollama`.

Свой OpenAI-совместимый сервер (или прокси):

```html
<script>
window.ADAPTIVE_WIDGET = {
  aiEnabled: true,
  provider: 'custom',
  endpoint: 'https://my-ai.example.com/v1/chat/completions',
  apiKey: 'secret',
  model: 'my-model'
};
</script>
```

## Конфигурация

| Параметр | По умолчанию | Описание |
|---|---|---|
| `siteName` | заголовок страницы | Имя, показываемое в шапке виджета |
| `position` | `'right'` | Позиция: `'right'` или `'left'` |
| `aiEnabled` | `true` | Включить LLM-режим |
| `provider` | `'auto'` | `'ollama'`, `'openai'`, `'openrouter'`, `'groq'`, `'mistral'`, `'custom'` или `'auto'` |
| `model` | из провайдера | Модель (`qwen2.5:3b`, `gpt-4o-mini`, `openrouter/auto` и т.д.) |
| `apiKey` | `''` | API-ключ (не нужен для Ollama) |
| `endpoint` | Ollama localhost | URL OpenAI-совместимого API (для `custom`) |
| `autoOpen` | `true` | Автопоявление подсказки через 1.5с |
| `teaser` | *(текст из языка)* | Текст всплывающей подсказки |
| `lang` | определение из `<html lang>` | Язык интерфейса (`'ru'` / `'en'`) |

## Тесты

```bash
npm install   # один раз
npm test      # 26 проверок: стиль, знания, RAG, Ollama и облачные провайдеры
```

## Отладка

```js
window.__ADAPTIVE_DEBUG__.palette    // какие цвета увидел виджет
window.__ADAPTIVE_DEBUG__.knowledge  // извлечённые фрагменты знаний
window.__ADAPTIVE_DEBUG__.backend    // какой LLM-провайдер и модель выбраны
```

## Структура проекта

```
.
├── widget/
│   └── adaptive-widget.js    # виджет (без зависимостей)
├── tests/
│   └── widget.test.js        # e2e-тесты (Puppeteer + мок-API, 26 проверок)
├── demo/
│   ├── index.html            # демо: светлый интернет-магазин
│   └── dark-store.html       # демо: тёмная игровая платформа
├── docs/
│   ├── IDEA.md               # концепция и архитектура
│   ├── PITCH.md              # структура питча (5 минут)
│   └── BUSINESS_PLAN.md      # бизнес-план и монетизация
├── package.json              # dev-зависимости только для тестов
├── setup-ollama.bat          # скрипт установки Ollama
└── README.md
```

## Демо-сценарии

**Интернет-магазин (GadgetHub):**
- «Сколько стоят наушники Aurora X?» → цена из JSON-LD
- «Как вернуть товар?» → ответ из FAQ
- «Куда позвонить?» → контакты из данных сайта

**Игровая платформа (Nebula Commerce):**
- «Как быстро приходит ключ?» → ответ из FAQ  
- «Можно ли оплатить картами РФ?» → ответ из контента
- «Как связаться с поддержкой?» → контакты

## Сравнение с аналогами

| | Tidio / Chatwoot | Intercom | **Наш виджет** |
|---|---|---|---|
| Конфигурация | Часы работы | Часы, интегратор | **Ноль конфигурации** |
| Обновление данных | Ручное | Ручное | **Автоматически** |
| Стиль | Шаблонный | Шаблонный | **Адаптивный** |
| ИИ | Облачный | Облачный | **Локальный** |
| Стоимость | $29+/мес | $74+/мес | **Бесплатно** |
