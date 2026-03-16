<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Разработка веб-приложений под ключ — Axecode</title>
    <meta name="description" content="Разрабатываем веб-приложения для бизнеса: личные кабинеты, CRM, SaaS и B2B-порталы. От аналитики и UX до запуска и развития продукта.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/razrabotka-veb-prilozheniy">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}/razrabotka-veb-prilozheniy">
    <meta property="og:title" content="Разработка веб-приложений под ключ — Axecode">
    <meta property="og:description" content="Создаём веб-приложения для бизнеса: CRM, личные кабинеты, SaaS и внутренние корпоративные системы.">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Разработка веб-приложений под ключ — Axecode">
    <meta name="twitter:description" content="Веб-приложения для автоматизации бизнеса: от проектирования до запуска и развития.">
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
            ->where('used_for', '/razrabotka-veb-prilozheniy')
            ->first();

        $heroDescription = (string) ($seoPage?->description ?: 'Проектируем и разрабатываем веб-продукты, которые автоматизируют процессы и помогают бизнесу масштабироваться: CRM, личные кабинеты, SaaS-сервисы, клиентские и внутренние порталы.');

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
                    '@id' => $baseUrl . '/razrabotka-veb-prilozheniy#service',
                    'name' => 'Разработка веб-приложений под ключ',
                    'serviceType' => 'Web application development',
                    'provider' => [
                        '@id' => $baseUrl . '/#organization',
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/razrabotka-veb-prilozheniy',
                    'mainEntityOfPage' => [
                        '@id' => $baseUrl . '/razrabotka-veb-prilozheniy#webpage',
                    ],
                    'description' => 'Разработка веб-приложений для бизнеса: CRM, SaaS, личные кабинеты, B2B/B2C порталы.',
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $baseUrl . '/razrabotka-veb-prilozheniy#webpage',
                    'url' => $baseUrl . '/razrabotka-veb-prilozheniy',
                    'name' => 'Разработка веб-приложений под ключ — Axecode',
                    'description' => 'Разрабатываем веб-приложения для бизнеса: личные кабинеты, CRM, SaaS и B2B-порталы.',
                    'mainEntity' => [
                        '@id' => $baseUrl . '/razrabotka-veb-prilozheniy#service',
                    ],
                    'inLanguage' => 'ru-RU',
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Сколько стоит разработка веб-приложения?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Стоимость рассчитывается после discovery и зависит от модулей, интеграций, ролей пользователей и требований к нагрузке.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'За сколько можно запустить MVP?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'В большинстве случаев MVP запускается за 6–12 недель. Срок зависит от сложности бизнес-логики и количества интеграций.',
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
        <div class="absolute -top-20 right-1/4 h-72 w-72 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-cyan-300 text-sm mb-4">Услуги Axecode</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Разработка веб-приложений под ключ</h1>
            <p class="text-cyan-200/90 text-base mt-4 max-w-3xl">Коротко: строим веб-продукты, которые автоматизируют процессы и масштабируют бизнес — от MVP до стабильной production-системы.</p>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">
                {{ $heroDescription }}
            </p>
        </div>
    </section>

    <section class="py-14 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Краткий ответ по услуге</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Когда нужен веб-продукт</h3>
                    <p class="text-gray-300 mt-2">Если бизнесу нужна автоматизация процессов, личные кабинеты, CRM или SaaS-сервис с масштабируемой архитектурой и интеграциями.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Сроки</h3>
                    <p class="text-gray-300 mt-2">MVP обычно запускается за 6–12 недель. Полноценный релиз зависит от бизнес-логики, ролей, интеграций и нагрузки.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Бюджет</h3>
                    <p class="text-gray-300 mt-2">Формируется по модулям: UX/UI, backend, frontend, интеграции, DevOps и поддержка. После discovery фиксируем этапы и приоритеты.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Результат</h3>
                    <p class="text-gray-300 mt-2">Рабочая веб-система с понятной архитектурой, API-интеграциями, аналитикой и дорожной картой развития после запуска.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Какие веб-продукты мы разрабатываем</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">CRM и автоматизация продаж</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Личные кабинеты клиентов и партнёров</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">SaaS и подписочные сервисы</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">B2B/B2C веб-платформы</div>
            </div>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Стек и подход</h2>
            <p class="text-gray-300 leading-relaxed max-w-4xl">
                Используем современный стек (Laravel, React, API-first архитектура), проектируем масштабируемую
                структуру, покрываем бизнес-логику, интеграции, роли/права, аналитику и поддержку после релиза.
            </p>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Частые вопросы</h2>
            <div class="space-y-4">
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">Сколько стоит разработка веб-приложения?</h3>
                    <p class="text-gray-300 mt-2">Стоимость рассчитывается после discovery и зависит от модулей, интеграций, ролей пользователей и требований к нагрузке.</p>
                </article>
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">За сколько можно запустить MVP?</h3>
                    <p class="text-gray-300 mt-2">В большинстве случаев MVP запускается за 6–12 недель. Срок зависит от сложности бизнес-логики и количества интеграций.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="py-20 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-3xl font-bold">Планируете запуск веб-приложения?</h2>
            <p class="text-gray-300 mt-4">Соберём архитектуру, зафиксируем этапы и дадим ориентир по срокам и бюджету.</p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">Обсудить архитектуру</a>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-6">Смотрите также</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="/razrabotka-saitov-pod-klyuch" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка сайтов под ключ →
                </a>
                <a href="/razrabotka-mobilnyh-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка мобильных приложений iOS и Android →
                </a>
            </div>
        </div>
    </section>

    @include('partials.blog-articles-section', [
        'heading' => 'Полезные статьи о разработке веб-приложений',
        'slugs'   => [
            'razrabotka-onlain-servisa-i-saas-mvp',
            'razrabotka-lichnogo-kabineta-arhitektura-roli-bezopasnost',
            'razrabotka-saas-ot-arhitektury-do-pervyh-klientov',
            'bezopasnost-api-chto-dolzhen-znat-zakazchik',
            'mikroservisy-ili-monolit-kak-vybrat-arhitekturu',
            'razrabotka-veb-servisa-api-integracii-arhitektura',
        ],
    ])
</main>
@include('partials.site-footer')
</body>
</html>
