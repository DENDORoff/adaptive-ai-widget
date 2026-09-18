# College Website

Веб-портал колледжа на Laravel 12 с админ-панелью Filament, многоязычностью и современным интерфейсом.

## 🌟 Особенности

- **Современная архитектура** - Laravel 12 + Filament 4
- **Многоязычность** - поддержка КАЗ, РУС, ENG
- **Реактивная админка** - Filament с CRUD операциями
- **SEO оптимизация** - Open Graph, Twitter Card, hreflang теги
- **Кэширование** - Redis для высокой производительности
- **Облачное хранилище** - AWS S3 интеграция
- **Интернационализация** - laravel-lang
- **Экспорт данных** - Excel через Maatwebsite
- **Чат и поддержка** - встроенная система обращений
- **Полнотекстовый поиск** - быстрый поиск по контенту

## 📋 Требования

- PHP 8.2+
- PostgreSQL 12+
- Node.js 18+
- Composer
- Redis (опционально)

## 🚀 Быстрое развёртывание

### Локальное развитие

```bash
# 1. Клонируем репозиторий
git clone <repository-url>
cd college-website

# 2. Устанавливаем зависимости PHP
composer install

# 3. Устанавливаем зависимости Node.js
npm install

# 4. Копируем файл окружения
cp .env.example .env

# 5. Генерируем ключ приложения
php artisan key:generate

# 6. Создаём структуру БД (миграции)
php artisan migrate

# 7. Заполняем БД тестовыми данными (сидеры)
php artisan db:seed

# Или в одну команду - миграции + сидеры:
php artisan migrate --seed

# 8. Собираем CSS и JavaScript
npm run build

# 9. Запускаем локальный сервер
php artisan serve
```

Открыть http://localhost:8000 в браузере.

**Админка:** http://localhost:8000/admin

### Что делают миграции и сидеры?

**Миграции** (`php artisan migrate`):
- Создают все таблицы БД
- Настраивают связи между таблицами
- Определяют типы полей

**Сидеры** (`php artisan db:seed`):
- Заполняют БД начальными данными
- Создают тестовые записи для разработки
- Добавляют иерархии и справочные данные

**Основные сидеры:**
- `DashboardStatisticSeeder` - статистика дашборда
- `PageSectionSeeder` - контент страниц
- `UserSeeder` - тестовых пользователей и админов
- И другие...

Если нужно только разработка без заполнения данных:
```bash
php artisan migrate --fresh  # Пересоздать БД с нуля
```

### Деплой на хостинг (VPS/Linux)

```bash
# 1. Клонируем репозиторий
git clone <repository-url>
cd college-website

# 2. Установка без dev-зависимостей
composer install --no-dev --optimize-autoloader

# 3. Node.js зависимости
npm ci
npm run build

# 4. Конфигурация
cp .env.example .env
php artisan key:generate

# 5. Настройка БД PostgreSQL
# Отредактируйте .env с реальными учётными данными PostgreSQL
# Убедитесь что PostgreSQL сервер запущен

# 6. Миграции БД
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder

# 7. Оптимизация
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Установка прав доступа
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 9. Настройка Nginx
# Пример конфигурации Nginx для Laravel (см. ниже)

# 10. Установка SSL сертификата (Let's Encrypt)
certbot certonly --webroot -w /path/to/public -d college.kz
```

**Пример конфигурации Nginx:**
```nginx
server {
    listen 80;
    server_name college.kz www.college.kz;
    
    root /var/www/college-website/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## ⚙️ Настройка окружения

Отредактируйте `.env` файл с вашими параметрами:

```env
APP_NAME="College"
APP_URL=https://college.kz

# Database (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=college_db
DB_USERNAME=college_user
DB_PASSWORD=your_secure_password

# Redis (кэширование)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (для уведомлений)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=

# AWS S3 (для загрузок)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# Yandex Metrika
YANDEX_METRIKA_COUNTER_ID=
YANDEX_METRIKA_TOKEN=

# Weather API
OPENWEATHERMAP_API_KEY=
```

## 📁 Структура проекта

```
app/
├── Models/           # Модели данных
├── Http/
│   ├── Controllers/  # Контроллеры
│   └── Middleware/   # Middleware
├── Filament/
│   ├── Resources/    # Админ-ресурсы
│   ├── Pages/        # Админ-страницы
│   └── Actions/      # Кастомные экшены
├── Services/         # Бизнес-логика
├── Helpers/          # Вспомогательные функции
└── Livewire/         # Компоненты реактивности

resources/
├── views/            # Blade шаблоны
├── css/              # Tailwind CSS
└── js/               # JavaScript (Alpine.js, Livewire)

database/
├── migrations/       # Миграции БД
├── seeders/          # Заполнение БД
└── factories/        # Фабрики для тестов
```

## 🔐 Безопасность

- Используйте длинные пароли для админ-аккаунта
- Обновляйте зависимости регулярно: `composer update`
- Включите HTTPS на продакшене
- Скройте админку за `.htaccess` или Nginx правилом
- Используйте фаервол и ограничивайте доступ по IP

## 🛠️ Основные команды

```bash
## 🛠️ Основные команды

### Миграции и Сидеры

```bash
# Применить все миграции
php artisan migrate

# Откатить последнюю партию миграций
php artisan migrate:rollback

# Откатить все миграции и заново применить
php artisan migrate:refresh

# Пересоздать БД с нуля и применить все миграции
php artisan migrate:fresh

# Заполнить БД тестовыми данными через сидеры
php artisan db:seed

# Заполнить конкретным сидером
php artisan db:seed --class=DashboardStatisticSeeder

# Миграции + сидеры в одну команду
php artisan migrate --seed

# Пересоздать БД + миграции + сидеры
php artisan migrate:fresh --seed
```

### Кэш и Оптимизация

```bash
# Очистить все кэши
php artisan cache:clear

# Очистить view кэш
php artisan view:clear

# Очистить кэш маршрутов
php artisan route:clear

# Закэшировать конфигурацию
php artisan config:cache

# Закэшировать маршруты
php artisan route:cache

# Полная оптимизация
php artisan optimize
```

### Разработка

```bash
# Laravel REPL для тестирования кода
php artisan tinker

# Создать новую миграцию
php artisan make:migration create_table_name

# Создать новую модель
php artisan make:model ModelName

# Создать контроллер
php artisan make:controller ControllerName

# Запустить тесты
php artisan test
```

## 📚 Документация

- [Laravel 12 Docs](https://laravel.com/docs/12)
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)

## 🤝 Контрибьютинг

1. Fork репозиторий
2. Создайте feature branch (`git checkout -b feature/AmazingFeature`)
3. Сделайте commit (`git commit -m 'Add AmazingFeature'`)
4. Push в branch (`git push origin feature/AmazingFeature`)
5. Откройте Pull Request

## 📝 Лицензия

MIT License - смотрите [LICENSE](LICENSE) файл для деталей.

## 👥 Автор

College Development Team

## 💬 Поддержка

Для вопросов и поддержки создайте Issue в репозитории.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
