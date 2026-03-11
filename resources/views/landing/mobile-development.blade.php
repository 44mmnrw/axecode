<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Разработка мобильных приложений iOS и Android — Axecode</title>
    <meta name="description" content="Разработка мобильных приложений для iOS и Android: от продуктовой идеи и UX до релиза в сторах и дальнейшего развития.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/razrabotka-mobilnyh-prilozheniy">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}/razrabotka-mobilnyh-prilozheniy">
    <meta property="og:title" content="Разработка мобильных приложений iOS и Android — Axecode">
    <meta property="og:description" content="Создаём мобильные приложения для бизнеса: от идеи и UX до публикации и развития.">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Разработка мобильных приложений iOS и Android — Axecode">
    <meta name="twitter:description" content="iOS/Android приложения под ключ: аналитика, дизайн, разработка, релиз и поддержка.">
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
            ->where('used_for', '/razrabotka-mobilnyh-prilozheniy')
            ->first();

        $heroDescription = (string) ($seoPage?->description ?: 'Создаём мобильные приложения, которые решают конкретные бизнес-задачи: от клиентских сервисов до внутренних инструментов. Помогаем пройти путь от идеи и прототипа до публикации и дальнейшего развития продукта.');

        $baseUrl = config('app.url');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'Разработка мобильных приложений',
                    'serviceType' => 'Mobile app development',
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Axecode',
                        'url' => $baseUrl,
                    ],
                    'areaServed' => 'RU',
                    'url' => $baseUrl . '/razrabotka-mobilnyh-prilozheniy',
                    'description' => 'Разработка мобильных приложений под ключ для iOS и Android: аналитика, UX/UI, backend, публикация, поддержка.',
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
        <div class="absolute -top-20 left-1/4 h-72 w-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-cyan-300 text-sm mb-4">Услуги Axecode</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">Разработка мобильных приложений iOS и Android</h1>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">
                {{ $heroDescription }}
            </p>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Что вы получаете в результате</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Приложение для iOS и Android</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Проработанный UX/UI интерфейс</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Надёжный backend и API-интеграции</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">Публикация в сторах и пострелизная поддержка</div>
            </div>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-8">Форматы разработки</h2>
            <ul class="space-y-3 text-gray-300 list-disc pl-6">
                <li>Кроссплатформенная разработка для быстрого выхода на рынок</li>
                <li>Нативные сценарии для high-load и сложного UX</li>
                <li>MVP с последующим масштабированием продукта</li>
            </ul>
        </div>
    </section>

    <section class="py-20 border-t border-white/5">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h2 class="text-3xl font-bold">Готовы запустить мобильный продукт?</h2>
            <p class="text-gray-300 mt-4">Подготовим roadmap, предложим оптимальный формат разработки и дадим реалистичную оценку.</p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">Получить план и оценку</a>
        </div>
    </section>

    <section class="py-16 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-2xl font-semibold mb-6">Смотрите также</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="/razrabotka-saitov-pod-klyuch" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка сайтов под ключ →
                </a>
                <a href="/razrabotka-veb-prilozheniy" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                    Разработка веб-приложений под ключ →
                </a>
            </div>
        </div>
    </section>

    @include('partials.blog-articles-section', [
        'heading' => 'Полезные статьи о мобильной разработке',
        'slugs'   => [
            'razrabotka-mobilnogo-prilozheniya-ios-android',
            'flutter-razrabotka-v-2026-kogda-opravdana',
            'skolko-stoit-razrabotka-mobilnogo-prilozheniya-2026',
            'react-native-vs-flutter-sravnenie-2026',
            'monetizaciya-mobilnogo-prilozheniya-modeli',
            'arhitektura-mobilnogo-prilozheniya-patterny',
        ],
    ])
</main>
@include('partials.site-footer')
</body>
</html>
