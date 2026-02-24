<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Политика конфиденциальности | Axecode Admin</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/theme/dracula.min.css">
    <style>
        body { background: #020618; color: white; }

        /* Toolbar */
        .editor-toolbar {
            background: #0f172b;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px 8px 0 0;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .mode-toggle {
            display: flex;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
            padding: 3px;
            gap: 2px;
        }
        .mode-btn {
            padding: 4px 14px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #6b7280;
            transition: all 0.15s;
        }
        .mode-btn.active {
            background: #4f46e5;
            color: #fff;
        }

        /* Quill */
        .ql-toolbar.ql-snow {
            background: #0f172b;
            border: none !important;
            border-bottom: 1px solid rgba(255,255,255,0.07) !important;
        }
        .ql-container.ql-snow {
            background: #020618;
            border: none !important;
            min-height: 520px;
            font-size: 14px;
        }
        .ql-editor { color: #e2e8f0; min-height: 520px; line-height: 1.75; }
        .ql-editor.ql-blank::before { color: #4b5563; }
        .ql-snow .ql-stroke { stroke: #9ca3af; }
        .ql-snow .ql-fill { fill: #9ca3af; }
        .ql-snow .ql-picker { color: #9ca3af; }
        .ql-snow .ql-picker-options { background: #0f172b; border-color: rgba(255,255,255,0.1); }
        .ql-snow .ql-picker-item { color: #e2e8f0; }
        .ql-snow button:hover .ql-stroke, .ql-snow .ql-active .ql-stroke { stroke: #fff; }
        .ql-snow button:hover .ql-fill, .ql-snow .ql-active .ql-fill { fill: #fff; }
        .ql-snow .ql-picker-label:hover, .ql-snow .ql-active .ql-picker-label { color: #fff; }

        /* Wrapper borders */
        .editor-wrap {
            border: 1px solid rgba(255,255,255,0.1);
            border-top: none;
            border-radius: 0 0 8px 8px;
            overflow: hidden;
        }

        /* CodeMirror */
        .CodeMirror {
            height: 600px;
            font-size: 13px;
            font-family: 'Cascadia Code', 'Fira Code', monospace;
        }
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

                <!-- Toolbar with mode toggle -->
                <div class="editor-toolbar">
                    <div class="mode-toggle">
                        <button type="button" class="mode-btn active" id="btn-visual">Текст</button>
                        <button type="button" class="mode-btn" id="btn-html">HTML</button>
                    </div>
                    <span class="text-xs text-gray-600">Ctrl+S — сохранить</span>
                </div>

                <!-- Editors wrapper -->
                <div class="editor-wrap">
                    <!-- Visual (Quill) -->
                    <div id="quill-wrap">
                        <div id="quill-editor"></div>
                    </div>

                    <!-- Code (CodeMirror) -->
                    <div id="cm-wrap" style="display:none;">
                        <div id="codemirror-host"></div>
                    </div>
                </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/addon/edit/closetag.min.js"></script>
    <script>
        const initialHtml = document.getElementById('privacy_policy').value;

        // — Quill (visual mode) —
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
        if (initialHtml.trim()) {
            quill.clipboard.dangerouslyPasteHTML(initialHtml);
        }

        // — CodeMirror (html mode) —
        const cm = CodeMirror(document.getElementById('codemirror-host'), {
            value: initialHtml,
            mode: 'htmlmixed',
            theme: 'dracula',
            lineNumbers: true,
            lineWrapping: true,
            autoCloseTags: true,
            extraKeys: {
                'Ctrl-S': function () { document.getElementById('privacy-form').requestSubmit(); }
            }
        });

        // — Mode toggle —
        let mode = 'visual'; // 'visual' | 'html'

        document.getElementById('btn-visual').addEventListener('click', function () {
            if (mode === 'visual') return;
            // sync html → quill
            quill.clipboard.dangerouslyPasteHTML(cm.getValue());
            document.getElementById('cm-wrap').style.display = 'none';
            document.getElementById('quill-wrap').style.display = '';
            document.getElementById('btn-visual').classList.add('active');
            document.getElementById('btn-html').classList.remove('active');
            mode = 'visual';
        });

        document.getElementById('btn-html').addEventListener('click', function () {
            if (mode === 'html') return;
            // sync quill → html
            cm.setValue(quill.root.innerHTML);
            document.getElementById('quill-wrap').style.display = 'none';
            document.getElementById('cm-wrap').style.display = '';
            document.getElementById('btn-html').classList.add('active');
            document.getElementById('btn-visual').classList.remove('active');
            mode = 'html';
            setTimeout(() => cm.refresh(), 10);
        });

        // — On submit: collect from active editor —
        document.getElementById('privacy-form').addEventListener('submit', function () {
            const value = mode === 'html' ? cm.getValue() : quill.root.innerHTML;
            document.getElementById('privacy_policy').value = value;
        });

        // Global Ctrl+S
        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('privacy-form').requestSubmit();
            }
        });
    </script>
</body>
</html>
