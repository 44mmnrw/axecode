<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Разработка сайтов под ключ для бизнеса — Axecode</title>
    <meta name="description" content="Разрабатываем сайты под задачи бизнеса: корпоративные, лендинги и интернет-магазины. Ведём проект от идеи и прототипа до запуска и дальнейшего развития.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/razrabotka-saitov-pod-klyuch">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}/razrabotka-saitov-pod-klyuch">
    <meta property="og:title" content="Разработка сайтов под ключ для бизнеса — Axecode">
    <meta property="og:description" content="Создаём сайты под ключ: от стратегии и UX до разработки, интеграций и запуска.">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Разработка сайтов под ключ для бизнеса — Axecode">
    <meta name="twitter:description" content="Корпоративные сайты, лендинги, интернет-магазины. Полный цикл разработки под ключ.">
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
            ->where('used_for', '/razrabotka-saitov-pod-klyuch')
            ->first();

        $heroDescription = (string) ($seoPage?->description ?: 'Создаём сайты, которые помогают бизнесу расти: усиливают доверие к бренду, приводят заявки и поддерживают продажи. Берём на себя весь цикл — от аналитики и UX до разработки, интеграций и сопровождения после релиза.');

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
                    'name' => 'Разработка сайтов под ключ',
                    'serviceType' => 'Website development',
                    'provider' => [
                        '@id' => $baseUrl . '/#organization',
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/razrabotka-saitov-pod-klyuch',
                    'description' => 'Разработка сайтов под ключ для бизнеса: корпоративные сайты, лендинги, интернет-магазины, интеграции и поддержка.',
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Сколько стоит разработка сайта под ключ?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Стоимость зависит от задач, объёма функционала и интеграций. После брифа готовим смету и план работ.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Какие сроки создания сайта?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Сроки обычно составляют от 3 до 10 недель в зависимости от сложности проекта и этапов согласования.',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header')

<main>
    <section class="relative overflow-hidden py-20">
        <div class="absolute -top-24 left-1/3 h-72 w-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-cyan-300 text-sm mb-4">Услуги Axecode</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Разработка сайтов под ключ для бизнеса</h1>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">
                {{ $heroDescription }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3 text-sm text-gray-300">
                <span class="rounded-full border border-white/10 px-4 py-2">Корпоративные сайты</span>
                <span class="rounded-full border border-white/10 px-4 py-2">Landing Page</span>
                <span class="rounded-full border border-white/10 px-4 py-2">Интернет-магазины</span>
                <span class="rounded-full border border-white/10 px-4 py-2">Интеграции CRM/аналитики</span>
            </div>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Что входит в разработку под ключ</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Анализ ниши, конкурентов и целей проекта</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Прототипирование и UX-структура</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">UI-дизайн и адаптивная верстка</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Backend, CMS/админка и интеграции</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">SEO-база: мета, структура, скорость</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Тестирование, релиз и техническая поддержка</div>
            </div>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Этапы работ</h2>
            <ol class="grid md:grid-cols-4 gap-6">
                <li class="rounded-2xl border border-white/10 p-5"><strong>01</strong><br>Бриф и оценка</li>
                <li class="rounded-2xl border border-white/10 p-5"><strong>02</strong><br>Дизайн и архитектура</li>
                <li class="rounded-2xl border border-white/10 p-5"><strong>03</strong><br>Разработка и интеграции</li>
                <li class="rounded-2xl border border-white/10 p-5"><strong>04</strong><br>Запуск и сопровождение</li>
            </ol>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Частые вопросы</h2>
            <div class="space-y-4">
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">Сколько стоит разработка сайта под ключ?</h3>
                    <p class="text-gray-300 mt-2">Финальная стоимость зависит от объёма страниц, функций, интеграций и сроков. После брифа предоставляем прозрачную смету.</p>
                </article>
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">Какие сроки запуска?</h3>
                    <p class="text-gray-300 mt-2">Обычно от 3 до 10 недель. Для сложных проектов с интеграциями сроки согласовываются отдельно.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="py-20 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-3xl font-bold">Планируете новый сайт или обновление текущего?</h2>
            <p class="text-gray-300 mt-4">Подготовим понятный план работ, предложим архитектуру и дадим прозрачную оценку по срокам и бюджету.</p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">
                Получить план и смету
            </a>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-6">Смотрите также</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="/razrabotka-veb-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка веб-приложений под ключ →
                </a>
                <a href="/razrabotka-mobilnyh-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка мобильных приложений iOS и Android →
                </a>
            </div>
        </div>
    </section>

    @include('partials.blog-articles-section', [
        'heading' => 'Полезные статьи о разработке сайтов',
        'slugs'   => [
            'razrabotka-lendinga-v-2026-rezultat-i-byudzhet',
            'stoimost-razrabotki-saita-struktura-smety',
            'tehnicheskoe-zadanie-na-sayt-kak-napisat',
            'seo-v-razrabotke-chto-zakladyvat-v-tz',
            'kak-vybrat-veb-studiyu-chek-list-dlya-ocenki',
            'priemka-sayta-chekList-zakazchika',
        ],
    ])
</main>

@include('partials.site-footer')
</body>
</html>
