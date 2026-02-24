<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ─── Primary SEO ────────────────────────────────────────────────── --}}
    <title>Axecode — Разработка сайтов и мобильных приложений</title>
    <meta name="description" content="Axecode — веб-студия полного цикла. Разрабатываем сайты, мобильные приложения, UI/UX дизайн и кастомные IT-решения. Более 150 успешных проектов, 5+ лет опыта.">
    <meta name="keywords" content="разработка сайтов, мобильные приложения, веб-студия, UI UX дизайн, веб-разработка, React, Laravel, Node.js, Axecode">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Axecode">
    <link rel="canonical" href="{{ config('app.url') }}">

    {{-- ─── Open Graph (Facebook, Telegram, VK, Slack…) ──────────────── --}}
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ config('app.url') }}">
    <meta property="og:title"        content="Axecode — Разработка сайтов и мобильных приложений">
    <meta property="og:description"  content="Веб-студия полного цикла: сайты, мобильные приложения, дизайн и IT-решения. 150+ проектов, поддержка 24/7.">
    <meta property="og:image"        content="{{ config('app.url') }}/og-image.png">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="Axecode — Технологии будущего">
    <meta property="og:locale"       content="ru_RU">
    <meta property="og:site_name"    content="Axecode">

    {{-- ─── Twitter Card ───────────────────────────────────────────────── --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="Axecode — Разработка сайтов и мобильных приложений">
    <meta name="twitter:description" content="Веб-студия полного цикла: сайты, мобильные приложения, дизайн и IT-решения. 150+ проектов, поддержка 24/7.">
    <meta name="twitter:image"       content="{{ config('app.url') }}/og-image.png">

    {{-- ─── Preconnect (ускоряем загрузку внешних ресурсов) ──────────── --}}
    <link rel="preconnect" href="https://mc.yandex.ru">

    {{-- ─── Favicon ────────────────────────────────────────────────────── --}}
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    {{-- ─── Vite assets ────────────────────────────────────────────────── --}}
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    {{-- ─── Analytics (управляется через админку) ─────────────────────── --}}
    @php
        $yandexId = \App\Models\Setting::get('yandex_metrika_id');
        $googleId  = \App\Models\Setting::get('google_analytics_id');
    @endphp

    @if ($googleId)
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleId }}');
    </script>
    @endif

    @if ($yandexId)
    <!-- Yandex Metrika -->
    <script>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym({{ $yandexId }}, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ $yandexId }}" style="position:absolute; left:-9999px;" alt=""></div></noscript>
    @endif

    {{-- ─── Schema.org JSON-LD ─────────────────────────────────────────── --}}
    @php
        $baseUrl = config('app.url');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'       => 'Organization',
                    '@id'         => $baseUrl . '/#organization',
                    'name'        => 'Axecode',
                    'url'         => $baseUrl,
                    'logo'        => ['@type' => 'ImageObject', 'url' => $baseUrl . '/favicon.ico'],
                    'description' => 'Веб-студия полного цикла: разработка сайтов, мобильных приложений, UI/UX дизайн и кастомные IT-решения.',
                    'foundingDate' => '2019',
                    'contactPoint' => ['@type' => 'ContactPoint', 'contactType' => 'customer support', 'availableLanguage' => 'Russian'],
                ],
                [
                    '@type'       => 'WebSite',
                    '@id'         => $baseUrl . '/#website',
                    'url'         => $baseUrl,
                    'name'        => 'Axecode',
                    'description' => 'Разработка сайтов и мобильных приложений',
                    'publisher'   => ['@id' => $baseUrl . '/#organization'],
                    'inLanguage'  => 'ru-RU',
                ],
                [
                    '@type'       => 'WebPage',
                    '@id'         => $baseUrl . '/#webpage',
                    'url'         => $baseUrl,
                    'name'        => 'Axecode — Разработка сайтов и мобильных приложений',
                    'description' => 'Axecode — веб-студия полного цикла. Разрабатываем сайты, мобильные приложения, UI/UX дизайн и кастомные IT-решения.',
                    'isPartOf'    => ['@id' => $baseUrl . '/#website'],
                    'about'       => ['@id' => $baseUrl . '/#organization'],
                    'inLanguage'  => 'ru-RU',
                ],
                [
                    '@type'       => 'ProfessionalService',
                    '@id'         => $baseUrl . '/#service',
                    'name'        => 'Axecode',
                    'url'         => $baseUrl,
                    'description' => 'Веб-студия полного цикла: разработка сайтов, мобильных приложений, UI/UX дизайн и кастомные IT-решения.',
                    'provider'    => ['@id' => $baseUrl . '/#organization'],
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name'  => 'Услуги Axecode',
                        'itemListElement' => [
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Веб-разработка']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Мобильные приложения']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'UI/UX Дизайн']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Кастомные решения']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Оптимизация']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Техподдержка 24/7']],
                        ],
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">

    {{-- ─── SEO prerender: контент для поисковиков без JavaScript ─────── --}}
    {{-- Показывается только если JS отключён (noscript), но боты         --}}
    {{-- без JS тоже видят этот контент и индексируют его.                --}}
    <noscript>
        <main style="max-width:900px;margin:0 auto;padding:40px 20px;font-family:sans-serif;color:#fff;background:#020618;">
            <h1>Создаём будущее цифровых технологий</h1>
            <p>Разрабатываем современные веб-сайты и мобильные приложения, которые помогают бизнесу расти и развиваться в цифровой среде. Наши решения сочетают передовые технологии с безупречным дизайном.</p>
            <section>
                <h2>Наши услуги</h2>
                <ul>
                    <li><strong>Веб-разработка</strong> — Создаём современные и производительные веб-сайты с адаптивным дизайном и интуитивным интерфейсом.</li>
                    <li><strong>Мобильные приложения</strong> — Разрабатываем нативные и кроссплатформенные приложения для iOS и Android с безупречным UX.</li>
                    <li><strong>UI/UX Дизайн</strong> — Проектируем пользовательские интерфейсы, которые сочетают эстетику с функциональностью.</li>
                    <li><strong>Кастомные решения</strong> — Создаём индивидуальные программные решения под уникальные задачи вашего бизнеса.</li>
                    <li><strong>Оптимизация</strong> — Повышаем производительность существующих приложений и сайтов.</li>
                    <li><strong>Техподдержка</strong> — Обеспечиваем надёжную поддержку и обслуживание ваших цифровых продуктов 24/7.</li>
                </ul>
            </section>
            <section>
                <h2>О нас</h2>
                <p>Мы — команда энтузиастов, создающих цифровые продукты мирового уровня. С момента основания мы помогли десяткам компаний реализовать их идеи и вывести бизнес на новый уровень.</p>
                <p>Технологии: React, Next.js, Node.js, Laravel, мобильная разработка iOS и Android.</p>
                <ul>
                    <li>150+ реализованных проектов</li>
                    <li>98% довольных клиентов</li>
                    <li>5+ лет опыта</li>
                    <li>Поддержка 24/7</li>
                </ul>
            </section>
        </main>
    </noscript>

    {{-- ─── React root ──────────────────────────────────────────────────── --}}
    <div id="app" class="min-h-screen"></div>

</body>
</html>
