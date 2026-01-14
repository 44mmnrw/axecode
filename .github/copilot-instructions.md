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

## Примеры файлов для ориентира
- Blade-шаблон SPA: `resources/views/app.blade.php`
- Точка входа React: `resources/js/app.jsx`
- Компоновка страницы: `resources/js/Root.jsx`
- Секция Hero + fallback: `resources/js/components/Hero.jsx`
