<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Политика конфиденциальности — Axecode</title>
    <meta name="description" content="Политика конфиденциальности и обработки персональных данных сайта axecode.tech">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ config('app.url') }}/privacy">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#020618] text-white antialiased">

    {{-- Навигация --}}
    <header class="sticky top-0 z-50 border-b border-white/5 bg-[rgba(2,6,24,0.85)] backdrop-blur-md">
        <div class="mx-auto flex h-16 max-w-5xl items-center justify-between px-6">
            <a href="/" class="text-lg font-bold bg-gradient-to-r from-[#00d3f2] via-purple-400 to-pink-400 bg-clip-text text-transparent">
                Axecode
            </a>
            <a href="/" class="text-sm text-gray-400 hover:text-white transition-colors">← На главную</a>
        </div>
    </header>

    {{-- Контент --}}
    <main class="mx-auto max-w-4xl px-6 py-16">

        <div class="prose-privacy">
            {!! \App\Models\Setting::get('privacy_policy') !!}
        </div>

    </main>

    {{-- Футер --}}
    <footer class="border-t border-white/5 py-8 mt-16">
        <div class="mx-auto max-w-5xl px-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Axecode. Все права защищены.
            <span class="mx-2">·</span>
            <a href="/privacy" class="hover:text-gray-300 transition-colors">Политика конфиденциальности</a>
        </div>
    </footer>

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
