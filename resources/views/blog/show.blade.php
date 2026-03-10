<!DOCTYPE html>
<html lang="ru" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $title = $post->seo_title ?: ($post->title . ' — Блог Axecode');
        $description = $post->seo_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 160));
        $url = config('app.url') . '/blog/' . $post->slug;
    @endphp

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $url }}">

    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ config('app.url') }}/og-image.png">

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
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header', ['actionText' => 'К блогу', 'actionHref' => '/blog'])

<main class="mx-auto max-w-4xl px-6 py-16">
    @if($post->category)
        <p class="text-sm uppercase tracking-wide text-cyan-300">{{ $post->category->name }}</p>
    @endif

    <h1 class="mt-2 text-3xl md:text-4xl font-bold leading-tight">{{ $post->title }}</h1>

    <p class="mt-4 text-sm text-gray-400">
        {{ optional($post->published_at ?? $post->created_at)->format('d.m.Y') }}
    </p>

    <article class="max-w-none mt-8 text-gray-200 leading-relaxed [&_h2]:mt-10 [&_h2]:mb-4 [&_h2]:text-2xl [&_h2]:font-semibold [&_h2]:text-white [&_h3]:mt-8 [&_h3]:mb-3 [&_h3]:text-xl [&_h3]:font-semibold [&_h3]:text-white [&_p]:my-4 [&_ul]:my-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:my-4 [&_ol]:list-decimal [&_ol]:pl-6 [&_li]:my-2 [&_a]:text-cyan-300 [&_a]:underline [&_a]:underline-offset-2 hover:[&_a]:text-cyan-200">
        {!! $post->content !!}
    </article>
</main>

@include('partials.site-footer', ['privacyLink' => '/privacy'])
</body>
</html>
