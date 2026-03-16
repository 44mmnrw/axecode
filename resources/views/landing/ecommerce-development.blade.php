<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Разработка интернет-магазина под ключ — Axecode</title>
    <meta name="description" content="Разработка интернет-магазинов для роста продаж: удобный каталог, быстрый checkout, интеграции с CRM, складом и аналитикой.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/razrabotka-internet-magazina">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}/razrabotka-internet-magazina">
    <meta property="og:title" content="Разработка интернет-магазина под ключ — Axecode">
    <meta property="og:description" content="Создаём интернет-магазины и e-commerce платформы: от проектирования до запуска и поддержки.">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Разработка интернет-магазина под ключ — Axecode">
    <meta name="twitter:description" content="Интернет-магазин под ключ: каталог, корзина, онлайн-оплата, интеграции и аналитика.">
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
        $seoPage = \App\Models\SeoKeywordPage::query()
            ->where('used_for', '/razrabotka-internet-magazina')
            ->first();

        $heroDescription = (string) ($seoPage?->description ?: 'Создаём интернет-магазины, которые помогают стабильно расти в продажах: продуманный каталог, удобный checkout, интеграции с CRM/ERP и сквозной аналитикой.');

        $baseUrl = config('app.url');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => $baseUrl . '/#organization',
                    'name' => 'Axecode',
                    'url' => $baseUrl,
                ],
                [
                    '@type' => 'Service',
                    'name' => 'Разработка интернет-магазина под ключ',
                    'serviceType' => 'E-commerce development',
                    'provider' => [
                        '@id' => $baseUrl . '/#organization',
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/razrabotka-internet-magazina',
                    'description' => 'Разработка интернет-магазинов и e-commerce решений: каталог, корзина, оплата, интеграции с CRM и аналитикой.',
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
            <p class="text-cyan-300 text-sm mb-4">E-commerce решения</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Разработка интернет-магазина под ключ</h1>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">{{ $heroDescription }}</p>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Что получает ваш e-commerce проект</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Каталог, карточки товара и фильтры</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Корзина, оформление заказа и онлайн-оплата</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Интеграции с CRM, складом и доставкой</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">SEO-структура, микроразметка и аналитика</div>
            </div>
        </div>
    </section>

    <section class="py-20 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-3xl font-bold">Планируете запуск или перезапуск интернет-магазина?</h2>
            <p class="text-gray-300 mt-4">Подготовим план запуска, предложим архитектуру и оценим сроки с учётом вашей бизнес-модели.</p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">Запросить оценку проекта</a>
        </div>
    </section>

    @include('partials.blog-articles-section', [
        'heading' => 'Полезные статьи об интернет-магазинах',
        'slugs'   => [
            'internet-magazin-pod-klyuch-9-shagov',
            'razrabotka-marketpleisa-arhitektura-i-otlichiya',
            'integraciya-crm-s-saytom-zachem-i-kak',
            'stoimost-razrabotki-saita-struktura-smety',
            'veb-analitika-s-nulya-chto-nastroit',
            'seo-v-razrabotke-chto-zakladyvat-v-tz',
        ],
    ])
</main>
@include('partials.site-footer')
</body>
</html>
