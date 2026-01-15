<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель | axecode</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background: #020618;
            color: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#020618] text-white">
        <!-- Header -->
        <header class="border-b border-white/5 bg-[rgba(2,6,24,0.75)] backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Сообщения контактной формы</h1>
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

        <!-- Main -->
        <main class="max-w-7xl mx-auto px-6 py-12">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Messages table -->
            @if ($messages->count())
                <div class="overflow-x-auto rounded-lg border border-gray-700">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-700 bg-[rgba(15,23,43,0.5)]">
                                <th class="px-6 py-4 text-left font-semibold">Имя</th>
                                <th class="px-6 py-4 text-left font-semibold">Email</th>
                                <th class="px-6 py-4 text-left font-semibold">Сообщение</th>
                                <th class="px-6 py-4 text-left font-semibold">Дата</th>
                                <th class="px-6 py-4 text-left font-semibold">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr class="border-b border-gray-700 hover:bg-[rgba(15,23,43,0.3)] transition">
                                    <td class="px-6 py-4 font-medium">{{ $message->name }}</td>
                                    <td class="px-6 py-4 text-gray-300">{{ $message->email }}</td>
                                    <td class="px-6 py-4 max-w-xs truncate text-gray-400">{{ $message->message }}</td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">
                                        {{ $message->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition text-sm font-medium" onclick="return confirm('Вы уверены?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">Нет сообщений</p>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
