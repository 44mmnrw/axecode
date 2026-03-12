<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $seoTitle = (string) \App\Models\Setting::get('seo_title', 'Разработка сайтов и приложений для бизнеса — Axecode');
        $seoDescription = (string) \App\Models\Setting::get('seo_description', 'Axecode — команда разработки полного цикла. Проектируем и запускаем сайты, веб-сервисы и мобильные приложения: от аналитики и UX до поддержки и развития продукта.');
        $seoKeywords = (string) \App\Models\Setting::get('seo_keywords', 'разработка сайтов под ключ, создание сайта для бизнеса, разработка веб-приложений, мобильные приложения iOS Android, UI UX дизайн, техническая поддержка сайта, SEO оптимизация сайта, веб-студия Axecode');

        $seoOgTitle = (string) \App\Models\Setting::get('seo_og_title', $seoTitle);
        $seoOgDescription = (string) \App\Models\Setting::get('seo_og_description', 'Разрабатываем цифровые продукты для бизнеса: сайты, веб-сервисы и мобильные приложения. Понятный процесс, сильная экспертиза и сопровождение после запуска.');
        $seoOgImageRaw = (string) \App\Models\Setting::get('seo_og_image', '');
        $seoOgImage = $seoOgImageRaw !== ''
            ? ((str_starts_with($seoOgImageRaw, 'http://') || str_starts_with($seoOgImageRaw, 'https://'))
                ? $seoOgImageRaw
                : asset('storage/' . ltrim($seoOgImageRaw, '/')))
            : (config('app.url') . '/og-image.png');

        $seoTwitterTitle = (string) \App\Models\Setting::get('seo_twitter_title', $seoTitle);
        $seoTwitterDescription = (string) \App\Models\Setting::get('seo_twitter_description', 'Сайты и приложения для бизнеса: от аналитики и дизайна до запуска, поддержки и развития продукта.');
    @endphp

    {{-- ─── Primary SEO ────────────────────────────────────────────────── --}}
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Axecode">
    <link rel="canonical" href="{{ config('app.url') }}">

    {{-- ─── Open Graph (Facebook, Telegram, VK, Slack…) ──────────────── --}}
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ config('app.url') }}">
    <meta property="og:title"        content="{{ $seoOgTitle }}">
    <meta property="og:description"  content="{{ $seoOgDescription }}">
    <meta property="og:image"        content="{{ $seoOgImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="Axecode — Технологии будущего">
    <meta property="og:locale"       content="ru_RU">
    <meta property="og:site_name"    content="Axecode">

    {{-- ─── Twitter Card ───────────────────────────────────────────────── --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $seoTwitterTitle }}">
    <meta name="twitter:description" content="{{ $seoTwitterDescription }}">
    <meta name="twitter:image"       content="{{ $seoOgImage }}">

    {{-- ─── Preconnect (ускоряем загрузку внешних ресурсов) ──────────── --}}
    <link rel="preconnect" href="https://mc.yandex.ru">

    {{-- ─── Favicon (Google + Яндекс) ─────────────────────────────────── --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#020618">
    <meta name="msapplication-TileColor" content="#020618">
    <meta name="msapplication-config" content="/browserconfig.xml">

    {{-- ─── Vite assets ────────────────────────────────────────────────── --}}
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    {{-- ─── Analytics (управляется через админку) ─────────────────────── --}}
    @php
        $yandexId = \App\Models\Setting::get('yandex_metrika_id');
        $googleId  = \App\Models\Setting::get('google_analytics_id');
        $gtmId = \App\Models\Setting::get('google_tag_manager_id');

        $landingHero = json_decode((string) \App\Models\Setting::get('landing_hero_json', ''), true);
        $landingServices = json_decode((string) \App\Models\Setting::get('landing_services_json', ''), true);
        $landingFaq = json_decode((string) \App\Models\Setting::get('landing_faq_json', ''), true);

        $landingContent = [
            'hero' => is_array($landingHero) ? $landingHero : null,
            'services' => is_array($landingServices) ? $landingServices : null,
            'faq' => is_array($landingFaq) ? $landingFaq : null,
        ];
    @endphp

    @if ($gtmId)
    <!-- Google Tag Manager -->
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{ $gtmId }}');
            }, 1500);
        }, { once: true });
    </script>
    @endif

    @if ($googleId)
    <!-- Google Analytics -->
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                var script = document.createElement('script');
                script.async = true;
                script.src = 'https://www.googletagmanager.com/gtag/js?id={{ $googleId }}';
                document.head.appendChild(script);

                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $googleId }}');
            }, 2000);
        }, { once: true });
    </script>
    @endif

    @if ($yandexId)
    <!-- Yandex Metrika -->
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
                const yandexCounterId = Number('{{ $yandexId }}');
                ym(yandexCounterId, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
            }, 3000);
        }, { once: true });
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
                    'logo'        => ['@type' => 'ImageObject', 'url' => $baseUrl . '/logo.png'],
                    'description' => 'Веб-студия полного цикла: разработка сайтов под ключ, веб-приложений и мобильных приложений, UI/UX дизайн, техподдержка и SEO-оптимизация.',
                    'foundingDate' => '2019',
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'contactType' => 'customer support',
                        'telephone' => '+7-495-109-25-44',
                        'email' => 'hello@axecode.tech',
                        'availableLanguage' => 'Russian',
                    ],
                ],
                [
                    '@type'       => 'WebSite',
                    '@id'         => $baseUrl . '/#website',
                    'url'         => $baseUrl,
                    'name'        => 'Axecode',
                    'description' => 'Разработка сайтов, веб-приложений и мобильных приложений',
                    'publisher'   => ['@id' => $baseUrl . '/#organization'],
                    'inLanguage'  => 'ru-RU',
                ],
                [
                    '@type'       => 'WebPage',
                    '@id'         => $baseUrl . '/#webpage',
                    'url'         => $baseUrl,
                    'name'        => 'Разработка сайтов и мобильных приложений под ключ — Axecode',
                    'description' => 'Axecode — веб-студия полного цикла. Разрабатываем сайты, веб-приложения и мобильные приложения, выполняем UX/UI дизайн, интеграции и поддержку.',
                    'keywords'    => [
                        'разработка сайтов под ключ',
                        'разработка веб-приложений',
                        'мобильные приложения iOS Android',
                        'UI UX дизайн',
                        'техническая поддержка сайтов',
                        'SEO оптимизация сайта',
                    ],
                    'isPartOf'    => ['@id' => $baseUrl . '/#website'],
                    'about'       => ['@id' => $baseUrl . '/#organization'],
                    'inLanguage'  => 'ru-RU',
                ],
                [
                    '@type'       => 'ProfessionalService',
                    '@id'         => $baseUrl . '/#service',
                    'name'        => 'Axecode',
                    'url'         => $baseUrl,
                    'description' => 'Создаём цифровые продукты под ключ: сайты, веб-приложения, мобильные приложения, дизайн и поддержку.',
                    'provider'    => ['@id' => $baseUrl . '/#organization'],
                    'areaServed'  => 'RU',
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name'  => 'Услуги Axecode',
                        'itemListElement' => [
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Веб-разработка']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Разработка веб-приложений']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Мобильные приложения']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'UI/UX Дизайн']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Кастомные решения']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'SEO-оптимизация']],
                            ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Техподдержка 24/7']],
                        ],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    '@id' => $baseUrl . '/#faq',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Сколько стоит разработка сайта под ключ?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Стоимость зависит от типа проекта, функционала и сроков. После брифа формируем прозрачную смету и поэтапный план работ.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Вы разрабатываете мобильные приложения для iOS и Android?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Да, создаём мобильные приложения под iOS и Android: нативные и кроссплатформенные решения в зависимости от целей бизнеса.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Можно ли заказать редизайн и SEO-оптимизацию существующего сайта?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Да, выполняем редизайн, техническую SEO-оптимизацию, ускорение загрузки и улучшение структуры сайта под поисковые запросы.',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">

    @if ($gtmId)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('partials.site-header')

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
            <section>
                <h2>Частые вопросы</h2>
                <h3>Сколько стоит разработка сайта под ключ?</h3>
                <p>Стоимость зависит от типа проекта, сроков и набора функций. После брифа мы предоставляем прозрачную смету.</p>
                <h3>Вы разрабатываете мобильные приложения для iOS и Android?</h3>
                <p>Да, разрабатываем мобильные приложения для iOS и Android, включая нативные и кроссплатформенные решения.</p>
                <h3>Можно ли заказать SEO-оптимизацию уже существующего сайта?</h3>
                <p>Да, мы выполняем техническую SEO-оптимизацию, ускорение загрузки и доработку структуры сайта под поисковые запросы.</p>
            </section>
        </main>
    </noscript>

    {{-- ─── React root ──────────────────────────────────────────────────── --}}
    <script id="landing-content-data" type="application/json">{!! json_encode($landingContent, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    <div id="app" class="min-h-screen"></div>

</body>
</html>
