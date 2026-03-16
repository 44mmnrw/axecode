<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $phrase    = $item['phrase'];
        $frequency = (int) ($item['totalCount'] ?? 0);
        $url       = config('app.url') . '/d/' . $item['slug'];
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
                    'name' => $phrase,
                    'serviceType' => 'Custom software development',
                    'provider' => [
                        '@id' => $baseUrl . '/#organization',
                    ],
                    'areaServed' => 'RU',
                    'url' => $url,
                    'description' => $description,
                ],
            ],
        ];

        // ── Перелинковка: определяем тематическую категорию ──────────────
        $phraseLC = mb_strtolower($phrase);
        $relatedCategory = 'guides-and-analytics';
        if (str_contains($phraseLC, 'мобил') || str_contains($phraseLC, 'ios') || str_contains($phraseLC, 'android') || str_contains($phraseLC, 'flutter') || str_contains($phraseLC, 'приложени') || str_contains($phraseLC, 'react native')) {
            $relatedCategory = 'mobile-development';
        } elseif (str_contains($phraseLC, 'дизайн') || str_contains($phraseLC, 'ux') || str_contains($phraseLC, 'ui') || str_contains($phraseLC, 'интерфейс') || str_contains($phraseLC, 'прототип')) {
            $relatedCategory = 'design-and-ux';
        } elseif (str_contains($phraseLC, 'react') || str_contains($phraseLC, 'php') || str_contains($phraseLC, 'javascript') || str_contains($phraseLC, 'typescript') || str_contains($phraseLC, 'docker') || str_contains($phraseLC, 'api') || str_contains($phraseLC, 'безопасност') || str_contains($phraseLC, 'скорост') || str_contains($phraseLC, 'хостинг') || str_contains($phraseLC, 'seo')) {
            $relatedCategory = 'technologies';
        }

        $dRelatedPosts = \App\Models\BlogPost::query()
            ->join('blog_categories', 'blog_posts.category_id', '=', 'blog_categories.id')
            ->where('blog_categories.slug', $relatedCategory)
            ->where('blog_posts.is_published', true)
            ->orderByDesc('blog_posts.published_at')
            ->limit(3)
            ->get(['blog_posts.title', 'blog_posts.slug', 'blog_posts.excerpt']);

        $dServiceLinks = match($relatedCategory) {
            'mobile-development' => [
                ['href' => '/razrabotka-mobilnyh-prilozheniy', 'title' => 'Разработка мобильных приложений'],
                ['href' => '/razrabotka-veb-prilozheniy',      'title' => 'Разработка веб-приложений'],
            ],
            'design-and-ux' => [
                ['href' => '/razrabotka-saitov-pod-klyuch',  'title' => 'Разработка сайтов под ключ'],
                ['href' => '/razrabotka-veb-prilozheniy',    'title' => 'Разработка веб-приложений'],
            ],
            'technologies' => [
                ['href' => '/razrabotka-veb-prilozheniy',    'title' => 'Разработка веб-приложений'],
                ['href' => '/tehnicheskaya-podderzhka-sayta','title' => 'Техническая поддержка сайта'],
            ],
            default => [
                ['href' => '/razrabotka-saitov-pod-klyuch', 'title' => 'Разработка сайтов под ключ'],
                ['href' => '/razrabotka-veb-prilozheniy',   'title' => 'Разработка веб-приложений'],
            ],
        };
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

    {{-- ── Наши услуги ─────────────────────────────────────────────────── --}}
    <section class="py-12 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-xs uppercase tracking-widest text-cyan-400 mb-4">Наши услуги</p>
            <div class="flex flex-wrap gap-3">
                @foreach($dServiceLinks as $sLink)
                    <a href="{{ $sLink['href'] }}"
                       class="inline-block rounded-full border border-white/20 px-5 py-2 text-sm text-gray-200 hover:border-cyan-400/60 hover:text-cyan-300 transition-colors">
                        {{ $sLink['title'] }} →
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Читайте в блоге ──────────────────────────────────────────────── --}}
    @if($dRelatedPosts->isNotEmpty())
    <section class="py-12 border-t border-white/5">
        <div class="mx-auto max-w-6xl px-6">
            <h2 class="text-xl font-semibold mb-6">Читайте в блоге</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                @foreach($dRelatedPosts as $bp)
                    <article class="rounded-2xl border border-white/10 p-5 bg-white/[0.02] hover:border-cyan-400/60 transition-colors">
                        <h3 class="text-sm font-semibold leading-snug">
                            <a href="{{ url('/blog/' . $bp->slug) }}" class="hover:text-cyan-300 transition-colors">
                                {{ $bp->title }}
                            </a>
                        </h3>
                        @if($bp->excerpt)
                            <p class="mt-2 text-xs text-gray-400 line-clamp-2">{{ $bp->excerpt }}</p>
                        @endif
                        <a href="{{ url('/blog/' . $bp->slug) }}"
                           class="inline-block mt-3 text-xs text-cyan-400 hover:text-cyan-300 transition-colors">
                            Читать →
                        </a>
                    </article>
                @endforeach
            </div>
            <div class="mt-6">
                <a href="/blog" class="text-sm text-gray-400 hover:text-cyan-300 transition-colors">Все статьи блога →</a>
            </div>
        </div>
    </section>
    @endif
</main>

@include('partials.site-footer')
</body>
</html>
