<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог Axecode — статьи о разработке и SEO</title>
    <meta name="description" content="Практические статьи Axecode про разработку сайтов и приложений, SEO и запуск цифровых продуктов.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/blog">

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
@include('partials.site-header', ['actionText' => 'На главную', 'actionHref' => '/'])

<main class="mx-auto max-w-6xl px-6 py-16">
    <h1 class="text-3xl md:text-4xl font-bold">Блог Axecode</h1>
    <p class="text-gray-300 mt-4 max-w-3xl">Пишем о том, как запускать сайты и приложения без хаоса: архитектура, UX, SEO и реальные рабочие подходы.</p>

    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <article class="rounded-2xl border border-white/10 p-5 bg-white/[0.02] hover:border-cyan-400/60 transition-colors">
                @if($post->category)
                    <p class="text-xs uppercase tracking-wide text-cyan-300">{{ $post->category->name }}</p>
                @endif
                <h2 class="mt-2 text-xl font-semibold leading-snug">
                    <a href="{{ url('/blog/' . $post->slug) }}" class="hover:text-cyan-300 transition-colors">{{ $post->title }}</a>
                </h2>
                <p class="mt-3 text-sm text-gray-300">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 140) }}</p>
                <p class="mt-4 text-xs text-gray-500">{{ optional($post->published_at ?? $post->created_at)->format('d.m.Y') }}</p>
            </article>
        @empty
            <p class="text-gray-400">Пока нет опубликованных статей.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</main>

@include('partials.site-footer', ['privacyLink' => '/privacy'])
</body>
</html>
