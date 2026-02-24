<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Политика конфиденциальности | Axecode Admin</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        body { background: #020618; color: white; }
        .ql-toolbar { background: #0f172b; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 8px 8px 0 0; }
        .ql-container { background: #020618; border: 1px solid rgba(255,255,255,0.1) !important; border-top: none !important; border-radius: 0 0 8px 8px; min-height: 500px; font-size: 14px; }
        .ql-editor { color: #e2e8f0; min-height: 500px; line-height: 1.7; }
        .ql-editor.ql-blank::before { color: #4b5563; }
        .ql-snow .ql-stroke { stroke: #9ca3af; }
        .ql-snow .ql-fill { fill: #9ca3af; }
        .ql-snow .ql-picker { color: #9ca3af; }
        .ql-snow .ql-picker-options { background: #0f172b; border: 1px solid rgba(255,255,255,0.1); }
        .ql-snow .ql-picker-item { color: #e2e8f0; }
        .ql-snow .ql-picker-item:hover { color: #fff; }
        .ql-snow button:hover .ql-stroke, .ql-snow .ql-active .ql-stroke { stroke: #fff; }
        .ql-snow button:hover .ql-fill, .ql-snow .ql-active .ql-fill { fill: #fff; }
        .ql-snow .ql-picker-label:hover { color: #fff; }
        .ql-snow.ql-toolbar button:hover, .ql-snow .ql-toolbar button:hover { background: rgba(255,255,255,0.05); border-radius: 4px; }
        .ql-editor h1 { font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .ql-editor h2 { font-size: 1.25rem; font-weight: 600; margin-top: 2rem; margin-bottom: 0.5rem; }
        .ql-editor p { margin-bottom: 0.75rem; }
        .ql-editor ul { padding-left: 1.5rem; margin-bottom: 0.75rem; }
        .ql-editor a { color: #00d3f2; }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#020618] text-white">

        <!-- Header -->
        <header class="border-b border-white/5 bg-[rgba(2,6,24,0.75)] backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Политика конфиденциальности</h1>
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
                   class="py-4 text-sm text-gray-400 hover:text-white transition border-b-2 border-transparent">
                    Аналитика
                </a>
                <a href="{{ route('admin.privacy') }}"
                   class="py-4 text-sm text-white border-b-2 border-indigo-500">
                    Политика конфиденциальности
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

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Редактор</h2>
                <a href="/privacy" target="_blank"
                   class="text-sm text-indigo-400 hover:text-indigo-300 transition">
                    Открыть страницу ↗
                </a>
            </div>

            <form id="privacy-form" action="{{ route('admin.privacy.save') }}" method="POST">
                @csrf

                <textarea id="privacy_policy" name="privacy_policy" style="display:none;">{{ old('privacy_policy', $content) }}</textarea>

                <div id="quill-editor"></div>

                <div class="mt-4">
                    <button type="submit"
                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                        Сохранить
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Введите текст политики конфиденциальности...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'clean']
                ]
            }
        });

        // Load existing content
        const existing = document.getElementById('privacy_policy').value;
        if (existing.trim()) {
            quill.clipboard.dangerouslyPasteHTML(existing);
        }

        // On submit — copy Quill HTML to hidden textarea
        document.getElementById('privacy-form').addEventListener('submit', function () {
            document.getElementById('privacy_policy').value = quill.root.innerHTML;
        });
    </script>
</body>
</html>
