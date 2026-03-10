<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $phrase = $item['phrase'];
        $frequency = (int) ($item['totalCount'] ?? 0);
        $url = config('app.url') . '/d/' . $item['slug'];
        $title = mb_convert_case($phrase, MB_CASE_TITLE, 'UTF-8') . ' — Axecode';
        $description = "{$phrase} от Axecode: проектируем, разрабатываем и запускаем решение под задачи бизнеса. Прозрачные сроки, понятный бюджет и поддержка после релиза.";

        $seoPage = \App\Models\SeoKeywordPage::query()
            ->where('used_for', '/d/' . (string) $item['slug'])
            ->first();

        if ($seoPage === null) {
            $seoPage = \App\Models\SeoKeywordPage::query()
                ->where('keyword', (string) $phrase)
                ->first();
        }

        $heroHeading = (string) ($seoPage?->h1 ?: mb_convert_case($phrase, MB_CASE_TITLE, 'UTF-8'));

        $heroDescription = (string) ($seoPage?->description ?: 'Поможем запустить решение под ваши цели: разберём требования, предложим оптимальный формат разработки, согласуем сроки и бюджет, а после запуска останемся на связи для развития и поддержки продукта.');

        $landingServices = json_decode((string) \App\Models\Setting::get('landing_services_json', ''), true);
        $landingFaq = json_decode((string) \App\Models\Setting::get('landing_faq_json', ''), true);
        $landingContent = [
            'services' => is_array($landingServices) ? $landingServices : null,
            'faq' => is_array($landingFaq) ? $landingFaq : null,
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => $phrase,
                    'serviceType' => 'Custom software development',
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Axecode',
                        'url' => config('app.url'),
                    ],
                    'areaServed' => 'RU',
                    'url' => $url,
                    'description' => $description,
                ],
            ],
        ];
    @endphp

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#020618">
    <meta name="msapplication-TileColor" content="#020618">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $url }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ config('app.url') }}/og-image.png">

    @vite(['resources/css/app.css', 'resources/js/landing-sections.jsx'])
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header')

<main>
    <section id="home" class="pt-28 pb-20">
        <div class="mx-auto max-w-6xl px-6">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-4xl">{{ $heroHeading }}</h1>
            <p class="text-gray-300 text-lg mt-6 max-w-3xl">
                {{ $heroDescription }}
            </p>
            <a href="/#contact" class="inline-block mt-8 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-8 py-3 font-semibold text-white hover:from-cyan-300 hover:to-purple-500 transition-all">
                Обсудить проект
            </a>
        </div>
    </section>

    <script id="landing-content-data" type="application/json">{!! json_encode($landingContent, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <div id="landing-sections-root"></div>
</main>

@include('partials.site-footer')
</body>
</html>
