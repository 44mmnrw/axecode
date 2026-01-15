# Axecode (Laravel 12 + React + Vite) — инструкции для AI-агентов

## Картина проекта (что где)
- Backend: Laravel 12. Основная точка маршрутов подключается в `bootstrap/app.php` через `withRouting(web: routes/web.php, commands: routes/console.php, health: '/up')`.
- Frontend: React SPA, монтируется в `#app` в `resources/views/app.blade.php`.
- Сборка/стили: Vite + `laravel-vite-plugin` (`vite.config.js`), Tailwind v4 (`resources/css/app.css`).

## Как устроен UI
- React entrypoint: `resources/js/app.jsx` (ищет `document.getElementById('app')` и рендерит `<Root />`).
- Корневой компонент: `resources/js/Root.jsx` — собирает секции страницы.
- Компоненты секций лежат в `resources/js/components/*` (например `Hero.jsx`, `Navigation.jsx`).
- Навигация — якорная (пример: `Navigation.jsx` ведёт на `#home/#services/...`). При добавлении/переименовании секций синхронизируй `href` в `Navigation.jsx` и `id` секции.
- В Hero используется WebGL-эффект: `HeroWavesCanvas.jsx` (есть `fallback` на SVG в `Hero.jsx`). Учитывай `prefers-reduced-motion` (в компоненте уже есть хук).

## Где править стили
- Tailwind подключён через `@import 'tailwindcss';` в `resources/css/app.css`.
- Кастомные анимации/утилиты проекта добавляются в `resources/css/app.css` в `@layer utilities` (пример: `.hero-waves-float`, `.hero-beam-pulse`).
- В компонентах в основном используется inline Tailwind-классы; отдельные CSS-файлы под компоненты сейчас не применяются.

## Сетевые запросы
- Axios и базовые заголовки инициализируются в `resources/js/bootstrap.js` и импортируются из `resources/js/app.jsx`.

## Команды разработчика (главные)
- Первичная установка (из `composer.json`): `composer run setup` (создаёт `.env`, генерирует ключ, миграции, `npm install`, `npm run build`).
- Dev-режим (рекомендуемый): `composer run dev` (одновременно `php artisan serve`, queue listener, pail logs, vite).
- Только фронтенд: `npm run dev`.
- Сборка ассетов: `npm run build`.
- Тесты: `composer test` или `php artisan test` (см. `phpunit.xml`: SQLite in-memory).

## Если добавляешь новые маршруты
- Сейчас зарегистрирован только web routing (`routes/web.php`). Если нужен отдельный набор API-роутов, его придётся явно подключить в `bootstrap/app.php` (по аналогии с `web:`).

## Production deployment (на сервер)

### Сервер и инфраструктура
- **IP**: 212.113.120.197
- **Домен**: axecode.tech
- **Путь на сервере**: `/var/www/axecode_tech_usr/data/www/axecode.tech/`
- **Веб-сервер**: Nginx
- **PHP**: PHP 8.3 с PHP-FPM (Unix socket: `/var/run/php-fpm-axecode.sock`)
- **БД**: SQLite (`database/database.sqlite`, должна быть writable: `chmod 666 database/database.sqlite`)
- **GitHub репо**: `https://github.com/44mmnrw/axecode.git`

### Процесс деплоя (для изменений React/JS)

**Внимание**: На сервере нет Node.js, поэтому ассеты собираются локально и коммитятся в гит.

1. **Локально**:
   ```bash
   npm run build                    # Собрать ассеты в public/build/
   git add public/build .gitignore  # Убедись, что /public/build НЕ в .gitignore
   git add .                        # Добавить все изменения
   git commit -m "Описание изменений"
   git push origin main
   ```

2. **На сервере** (SSH в `/var/www/axecode_tech_usr/data/www/axecode.tech/`):
   ```bash
   git pull origin main
   /opt/php83/bin/php /usr/local/bin/composer install
   /opt/php83/bin/php artisan migrate --force
   /opt/php83/bin/php artisan db:seed --class=AdminSeeder
   ```

3. **Перезагрузка PHP-FPM** (если менялась конфигурация):
   ```bash
   kill -USR2 <php-fpm-pid>
   ```

### Важное о public/build
- `public/build/` содержит скомпилированные React ассеты, CSS и JS
- **УБЕДИСЬ**: в `.gitignore` строка `/public/build` должна быть **удалена** (чтобы ассеты попадали в гит)
- После `npm run build` локально, коммитишь папку целиком вместе с манифестом

### Автоматический деплой (webhook)
TODO: Настроить GitHub webhook для автоматического pull и migrate при push в main ветку.

### Окружение (production .env)
- `APP_ENV=production`
- `APP_DEBUG=false` (обязательно в продакшене)
- `HTTPS_REDIRECT=true` (когда будет SSL)
- Все остальные ключи как в `.env.example`

## Примеры файлов для ориентира
- Blade-шаблон SPA: `resources/views/app.blade.php`
- Точка входа React: `resources/js/app.jsx`
- Компоновка страницы: `resources/js/Root.jsx`
- Секция Hero + fallback: `resources/js/components/Hero.jsx`
