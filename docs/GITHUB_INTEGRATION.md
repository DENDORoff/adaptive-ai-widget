# Как выложить проект на GitHub

Проект уже является git-репозиторием (ветка `master`), но удалённого репозитория ещё нет. Ниже — два пути: через GitHub CLI (`gh`) и вручную.

## 0. Что попадёт и что не попадёт в репозиторий

Уже настроено в `.gitignore` — не коммитятся:

```
node_modules/
server/config.json      # личный конфиг: adminToken, SMTP-пароль, apiKey
server/data/            # чаты, логи, кэш, outbox, инструкции
*.log
```

Проверьте, что секреты действительно не отслеживаются:

```bash
git status --short
git check-ignore -v server/config.json server/data/chats.json
```

Если `server/config.json` когда-то уже был закоммичен (`git ls-files server/config.json`), удалите его из индекса, не трогая на диске:

```bash
git rm --cached server/config.json
```

Для образца в репозитории держите только `server/config.example.json` — в нём нет реальных ключей.

## 1. Подготовьте коммит

```bash
git add -A
git status
git commit -m "Виджет: AI-стиль, изображения, необязательный email, звук; сервер: TTL, KB, SMTP; админка и демо"
```

> В этом репозитории для демонстрации были настроены временные `user.name` / `user.email` (`team@adaptivewidget.dev`). Перед публикацией задайте свои:
> ```bash
> git config user.name "Ваше Имя"
> git config user.email "you@example.com"
> ```

## 2. Создайте репозиторий на GitHub

### Вариант A — GitHub CLI (проще)

```bash
gh auth login
gh repo create adaptive-ai-widget --public --source=. --remote=origin --push
```

- `--public` / `--private` — видимость репозитория.
- Команда сама добавит `origin` и запушит `master`.

### Вариант B — вручную через сайт

1. Создайте пустой репозиторий на https://github.com/new (без README и .gitignore — они уже есть).
2. Подключите его и запушьте:

```bash
git remote add origin https://github.com/<user>/adaptive-ai-widget.git
git branch -M main          # по желанию: переименовать master -> main
git push -u origin main
```

Для SSH замените URL на `git@github.com:<user>/adaptive-ai-widget.git`.

## 3. Дальнейшая работа

```bash
git add -A
git commit -m "Краткое описание изменений"
git push
```

Полезно:

- `git remote -v` — проверить, куда настроен push;
- `git pull --rebase` — подтянуть изменения перед push, если работаете с нескольких машин;
- ветки под задачи: `git switch -c feature/email-digest`, затем Pull Request в `main`.

## 4. Необязательно: CI и релиз

**Тесты на каждый push** — создайте `.github/workflows/tests.yml`:

```yaml
name: tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: 20 }
      - run: npm ci || npm install
      - run: npm run test:server
      - run: npm run test:auth
```

Виджет-тесты (`test:widget`) требуют Chrome и запускаются локально (`npm run test:widget`).

**Релиз** — пометьте стабильную версию:

```bash
git tag -a v0.2.0 -m "AI-стиль, KB, SMTP, TTL"
git push origin v0.2.0
gh release create v0.2.0 --generate-notes
```

## 5. Что писать в README для внешних пользователей

В корневом `README.md` уже есть быстрый старт. При публикации стоит отдельно подчеркнуть:

- запуск без сервера — один `<script>` и (опционально) Ollama;
- backend-режим — `node server/server.js`, админка на `/admin`;
- `server/config.example.json` нужно скопировать в `server/config.json` и вписать свой `adminToken`;
- SMTP и `ticketTtlDays` настраиваются из админки, секреты в git не попадают.
