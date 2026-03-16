<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Страница не найдена (404) — Axecode</title>
    <meta name="description" content="Страница не найдена. Перейдите на главную или выберите одну из услуг Axecode.">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#020618">
    <meta name="msapplication-TileColor" content="#020618">
    <meta name="msapplication-config" content="/browserconfig.xml">

    @vite(['resources/css/app.css'])
    @include('partials.google-tag')
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header', [
    'actionHref' => '/',
    'actionText' => 'На главную',
])

<main class="mx-auto max-w-6xl px-6 py-20">
    <section class="text-center">
        <p class="text-cyan-300 text-sm mb-4">Ошибка 404</p>
        <h1 class="text-5xl md:text-7xl font-bold tracking-tight">Страница не найдена</h1>
        <p class="text-gray-300 text-lg mt-6 max-w-2xl mx-auto">
            Похоже, ссылка устарела или была введена с ошибкой. Выберите нужный раздел ниже — поможем быстро вернуться на маршрут успеха.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-3">
            <a href="/" class="rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-6 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">Главная</a>
            <a href="/#contact" class="rounded-full border border-white/15 px-6 py-3 font-semibold text-white hover:border-cyan-400/60 transition-colors">Связаться с нами</a>
        </div>
    </section>

    <section class="mt-16 border-t border-white/5 pt-10">
        <h2 class="text-2xl font-semibold mb-6 text-center">Популярные страницы</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="/razrabotka-saitov-pod-klyuch" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Разработка сайтов под ключ →
            </a>
            <a href="/razrabotka-veb-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Разработка веб-приложений →
            </a>
            <a href="/razrabotka-mobilnyh-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Разработка мобильных приложений →
            </a>
            <a href="/razrabotka-internet-magazina" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Разработка интернет-магазина →
            </a>
            <a href="/tehnicheskaya-podderzhka-sayta" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Техподдержка и сопровождение →
            </a>
            <a href="/pages/privacy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                Политика конфиденциальности →
            </a>
        </div>
    </section>
</main>
@include('partials.site-footer', [
    'privacyLink' => '/pages/privacy',
])
</body>
</html>
