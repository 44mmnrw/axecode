<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->seo_title ?: ($page->title . ' — Axecode') }}</title>
    <meta name="description" content="{{ $page->seo_description ?: $page->title }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/pages/{{ $page->slug }}">
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
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
    @include('partials.site-header', [
        'maxWidthClass' => 'max-w-5xl',
        'actionHref' => '/',
        'actionText' => '← На главную',
        'actionTextClass' => 'text-gray-400',
    ])

    <main class="mx-auto max-w-4xl px-6 py-16">
        <h1 class="text-3xl sm:text-4xl font-bold mb-8">{{ $page->title }}</h1>

        <div class="prose-privacy">
            {!! $page->content !!}
        </div>
    </main>

    @include('partials.site-footer', [
        'maxWidthClass' => 'max-w-5xl',
        'marginTopClass' => 'mt-16',
        'privacyLink' => '/pages/privacy',
    ])

</body>
</html>

<style>
.prose-privacy h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(to right, #00d3f2, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.prose-privacy .updated {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 2.5rem;
}
.prose-privacy h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #e2e8f0;
    margin-top: 2.5rem;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.prose-privacy p {
    color: #94a3b8;
    line-height: 1.75;
    margin-bottom: 1rem;
}
.prose-privacy ul {
    color: #94a3b8;
    list-style: disc;
    padding-left: 1.5rem;
    margin-bottom: 1rem;
    line-height: 1.75;
}
.prose-privacy ul li {
    margin-bottom: 0.4rem;
}
.prose-privacy a {
    color: #00d3f2;
    text-decoration: underline;
    text-underline-offset: 3px;
}
.prose-privacy a:hover {
    color: #a855f7;
}
.prose-privacy strong {
    color: #e2e8f0;
}
</style>
