<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-запросы (Wordstat) — Axecode</title>
    <meta name="description" content="Список посадочных страниц по D-запросам Wordstat с частотностью больше нуля.">
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
    <link rel="canonical" href="{{ config('app.url') }}/d">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">
@include('partials.site-header')

<main class="mx-auto max-w-6xl px-6 py-16">
    <h1 class="text-3xl md:text-4xl font-bold">Каталог посадочных страниц по D-запросам</h1>
    <p class="text-gray-300 mt-4">Здесь собраны страницы с реальным спросом в Wordstat (частотность выше нуля). Всего страниц: {{ count($rows) }}</p>

    <div class="mt-8 grid md:grid-cols-2 gap-4">
        @foreach ($rows as $row)
            <a href="{{ url('/d/' . $row['slug']) }}" class="rounded-2xl border border-white/10 p-5 hover:border-cyan-400/60 transition-colors">
                <div class="font-semibold">{{ $row['phrase'] }}</div>
                <div class="text-sm text-gray-400 mt-1">Частотность: {{ number_format((int) $row['totalCount'], 0, ',', ' ') }}</div>
            </a>
        @endforeach
    </div>
</main>

@include('partials.site-footer')
</body>
</html>
