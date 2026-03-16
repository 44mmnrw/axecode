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
    @include('partials.google-tag')

    @php
        $seoPage = \App\Models\SeoKeywordPage::query()
            ->where('used_for', '/tehnicheskaya-podderzhka-sayta')
            ->first();

        $heroDescription = (string) ($seoPage?->description ?: 'Берём проект на сопровождение после запуска: быстро закрываем инциденты, развиваем функционал и следим, чтобы сайт работал стабильно и без просадок.');

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
                    '@id' => $baseUrl . '/tehnicheskaya-podderzhka-sayta#service',
                    'name' => 'Техническая поддержка и сопровождение сайта',
                    'serviceType' => 'Website support',
                    'provider' => [
                        '@id' => $baseUrl . '/#organization',
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/tehnicheskaya-podderzhka-sayta',
                    'mainEntityOfPage' => [
                        '@id' => $baseUrl . '/tehnicheskaya-podderzhka-sayta#webpage',
                    ],
                    'description' => 'Техническая поддержка сайта и развитие веб-проекта: обновления, исправления, ускорение и мониторинг.',
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $baseUrl . '/tehnicheskaya-podderzhka-sayta#webpage',
                    'url' => $baseUrl . '/tehnicheskaya-podderzhka-sayta',
                    'name' => 'Техническая поддержка и сопровождение сайта — Axecode',
                    'description' => 'Поддержка и развитие сайта: обновления, исправление ошибок, ускорение и контроль стабильности.',
                    'mainEntity' => [
                        '@id' => $baseUrl . '/tehnicheskaya-podderzhka-sayta#service',
                    ],
                    'inLanguage' => 'ru-RU',
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Что входит в техническую поддержку сайта?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'В поддержку входит мониторинг, исправление ошибок, обновления, технические доработки и профилактика проблем безопасности и производительности.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Как быстро вы реагируете на инциденты?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Скорость реакции зависит от уровня SLA. Критические инциденты обрабатываются в приоритетном порядке, плановые задачи — по согласованному графику.',
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
    <section class="py-20">
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-cyan-300 text-sm mb-4">Поддержка и развитие</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Техническая поддержка и сопровождение сайта</h1>
            <p class="text-cyan-200/90 text-base mt-4 max-w-3xl">Коротко: обеспечиваем стабильную работу сайта и быстрое развитие функционала без остановки бизнес-процессов.</p>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">{{ $heroDescription }}</p>
        </div>
    </section>

    <section class="py-14 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Краткий ответ по услуге</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Когда нужна поддержка</h3>
                    <p class="text-gray-300 mt-2">Когда сайт уже запущен, но нужны стабильность, быстрые исправления, плановые обновления и развитие без простоев бизнеса.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Сроки реакции</h3>
                    <p class="text-gray-300 mt-2">Определяются форматом SLA: критические задачи закрываем в приоритетном порядке, плановые доработки — по согласованному спринт-плану.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Стоимость</h3>
                    <p class="text-gray-300 mt-2">Зависит от нагрузки, сложности проекта и требуемого режима поддержки: почасово, пакет часов или постоянное сопровождение.</p>
                </article>
                <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Что получите</h3>
                    <p class="text-gray-300 mt-2">Предсказуемую работу проекта, прозрачный backlog задач, контроль качества релизов и команду, которая отвечает за технический результат.</p>
                </article>
            </div>
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

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Частые вопросы</h2>
            <div class="space-y-4">
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">Что входит в техническую поддержку сайта?</h3>
                    <p class="text-gray-300 mt-2">В поддержку входит мониторинг, исправление ошибок, обновления, технические доработки и профилактика проблем безопасности и производительности.</p>
                </article>
                <article class="rounded-2xl border border-white/10 p-6">
                    <h3 class="font-semibold text-lg">Как быстро вы реагируете на инциденты?</h3>
                    <p class="text-gray-300 mt-2">Скорость реакции зависит от уровня SLA. Критические инциденты обрабатываются в приоритетном порядке, плановые задачи — по согласованному графику.</p>
                </article>
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

    @include('partials.blog-articles-section', [
        'heading' => 'Статьи о поддержке и развитии проектов',
        'slugs'   => [
            'soprovozhdenie-sayta-chto-i-zachem',
            'tehnicheskaya-podderzhka-saita-chto-vhodit',
            'razvitie-i-soprovozhdenie-proekta-posle-zapuska',
            'ci-cd-pipeline-kak-avtomatizaciya-deploya-zashchishchaet',
            'docker-i-konteynerizaciya-dlya-proekta',
            'veb-analitika-s-nulya-chto-nastroit',
        ],
    ])
</main>
@include('partials.site-footer')
</body>
</html>
