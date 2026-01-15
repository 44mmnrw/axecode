<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | axecode</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background: #020618;
            color: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#020618] flex items-center justify-center px-6">
        <div class="w-full max-w-md">
            <!-- Logo/Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-300 to-purple-400 bg-clip-text text-transparent mb-2">
                    axecode
                </h1>
                <p class="text-gray-400">Админ-панель</p>
            </div>

            <!-- Login Form -->
            <div class="bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-2xl p-8">
                <h2 class="text-xl font-bold mb-6">Вход в админ-панель</h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-300 rounded-lg text-sm">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-300 font-semibold mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500/50 transition-colors"
                            placeholder="admin@example.com"
                        />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-300 font-semibold mb-2">Пароль</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full bg-[rgba(15,23,43,0.5)] border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500/50 transition-colors"
                            placeholder="••••••••"
                        />
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-cyan-400 to-purple-600 hover:from-cyan-300 hover:to-purple-500 text-white font-semibold py-3 rounded-lg transition-all duration-300 mt-6"
                    >
                        Войти
                    </button>
                </form>
            </div>

            <!-- Info -->
            <div class="text-center mt-8 text-gray-400 text-sm">
                <p>Демо: <code class="bg-black/30 px-2 py-1 rounded">admin@axecode.dev</code></p>
                <p class="mt-1">Пароль: <code class="bg-black/30 px-2 py-1 rounded">password</code></p>
            </div>
        </div>
    </div>
</body>
</html>
