<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Техническая поддержка и сопровождение сайта — Axecode</title>
    <meta name="description" content="Техническая поддержка и развитие сайта: обновления, исправление ошибок, ускорение, контроль стабильности и безопасности проекта.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/tehnicheskaya-podderzhka-sayta">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}/tehnicheskaya-podderzhka-sayta">
    <meta property="og:title" content="Техническая поддержка и сопровождение сайта — Axecode">
    <meta property="og:description" content="Берём на сопровождение сайт или веб-продукт: поддержка, доработки, ускорение, контроль стабильности.">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Техническая поддержка и сопровождение сайта — Axecode">
    <meta name="twitter:description" content="Сопровождение сайта: обновления, исправления, развитие и повышение производительности.">
    <meta name="twitter:image" content="{{ config('app.url') }}/og-image.png">

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

    @php
        $baseUrl = config('app.url');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'Техническая поддержка и сопровождение сайта',
                    'serviceType' => 'Website support',
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Axecode',
                        'url' => $baseUrl,
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/tehnicheskaya-podderzhka-sayta',
                    'description' => 'Техническая поддержка сайта и развитие веб-проекта: обновления, исправления, ускорение и мониторинг.',
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header')

<main>
    <section class="py-20">
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-cyan-300 text-sm mb-4">Поддержка и развитие</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Техническая поддержка и сопровождение сайта</h1>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">Берём проект на сопровождение после запуска: быстро закрываем инциденты, развиваем функционал и следим, чтобы сайт работал стабильно и без просадок.</p>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Как мы ведём поддержку проекта</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Исправление багов и аварийных инцидентов</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Плановые обновления и безопасность</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Ускорение загрузки и техническая SEO-оптимизация</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Развитие функционала и интеграции</div>
            </div>
        </div>
    </section>

    <section class="py-20 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-3xl font-bold">Нужна команда, которая держит проект в форме?</h2>
            <p class="text-gray-300 mt-4">Подберём удобный формат сопровождения: от точечных задач до регулярного SLA с понятными сроками реакции.</p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">Подобрать формат поддержки</a>
        </div>
    </section>
</main>
@include('partials.site-footer')
</body>
</html>
