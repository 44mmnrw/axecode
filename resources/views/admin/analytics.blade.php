<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аналитика | axecode</title>
    @vite('resources/css/app.css')
    <style>
        body { background: #020618; color: white; }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#020618] text-white">
        <!-- Header -->
        <header class="border-b border-white/5 bg-[rgba(2,6,24,0.75)] backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Настройки аналитики</h1>
                <div class="flex items-center gap-4">
                    <span class="text-gray-400 text-sm">{{ auth()->user()->email }}</span>
                    <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition text-sm">Выход</button>
                    </form>
                    <a href="/" class="text-gray-400 hover:text-white transition">← На сайт</a>
                </div>
            </div>
        </header>

        <!-- Nav tabs -->
        <div class="border-b border-white/5">
            <div class="max-w-7xl mx-auto px-6 flex gap-6">
                <a href="{{ route('admin.messages') }}"
                   class="py-4 text-sm text-gray-400 hover:text-white transition border-b-2 border-transparent">
                    Сообщения
                </a>
                <a href="{{ route('admin.analytics') }}"
                   class="py-4 text-sm text-white border-b-2 border-indigo-500">
                    Аналитика
                </a>
            </div>
        </div>

        <!-- Main -->
        <main class="max-w-7xl mx-auto px-6 py-12">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-300 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.analytics.save') }}" method="POST" class="max-w-xl space-y-8">
                @csrf

                <!-- Yandex Metrika -->
                <div class="rounded-lg border border-white/10 bg-[rgba(15,23,43,0.5)] p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#fc3f1d] flex items-center justify-center text-white font-bold text-sm">Я</div>
                        <h2 class="text-lg font-semibold">Яндекс Метрика</h2>
                    </div>
                    <div>
                        <label for="yandex_metrika_id" class="block text-sm text-gray-400 mb-2">
                            ID счётчика <span class="text-gray-600">(только цифры, например: 98765432)</span>
                        </label>
                        <input
                            type="text"
                            id="yandex_metrika_id"
                            name="yandex_metrika_id"
                            value="{{ old('yandex_metrika_id', $yandexId) }}"
                            placeholder="98765432"
                            class="w-full bg-[#020618] border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-indigo-500 transition"
                        >
                    </div>
                    @if ($yandexId)
                        <p class="text-xs text-green-400">Счётчик подключён: {{ $yandexId }}</p>
                    @else
                        <p class="text-xs text-gray-500">Не настроен — счётчик не будет загружаться на сайте</p>
                    @endif
                </div>

                <!-- Google Analytics -->
                <div class="rounded-lg border border-white/10 bg-[rgba(15,23,43,0.5)] p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#4285f4] flex items-center justify-center text-white font-bold text-sm">G</div>
                        <h2 class="text-lg font-semibold">Google Analytics 4</h2>
                    </div>
                    <div>
                        <label for="google_analytics_id" class="block text-sm text-gray-400 mb-2">
                            Measurement ID <span class="text-gray-600">(формат: G-XXXXXXXXXX)</span>
                        </label>
                        <input
                            type="text"
                            id="google_analytics_id"
                            name="google_analytics_id"
                            value="{{ old('google_analytics_id', $googleId) }}"
                            placeholder="G-XXXXXXXXXX"
                            class="w-full bg-[#020618] border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-indigo-500 transition"
                        >
                    </div>
                    @if ($googleId)
                        <p class="text-xs text-green-400">Счётчик подключён: {{ $googleId }}</p>
                    @else
                        <p class="text-xs text-gray-500">Не настроен — счётчик не будет загружаться на сайте</p>
                    @endif
                </div>

                <button
                    type="submit"
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                    Сохранить
                </button>
            </form>
        </main>
    </div>
</body>
</html>
