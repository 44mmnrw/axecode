<x-filament-panels::page>
    @vite('resources/js/editor/privacy-editor.js')

    <form
        x-data="privacyEditor(@js($editorDataJson))"
        x-init="init()"
        @submit.prevent="submit($wire)"
        class="space-y-6"
    >
        <div>
            <label class="block text-sm font-medium mb-2">Контент политики (Editor.js)</label>
            <div
                x-show="!loadFailed"
                x-cloak
                class="rounded-xl border border-amber-200 dark:border-amber-900/50 bg-amber-50/70 dark:bg-slate-900 p-5 md:p-6 shadow-sm"
            >
                <div
                    id="privacy-editor"
                    wire:ignore
                    class="prose prose-sm dark:prose-invert max-w-none min-h-[140px] md:min-h-[180px] text-slate-900 dark:text-slate-100 leading-7"
                ></div>
            </div>

            <div x-show="loadFailed" x-cloak class="space-y-2">
                <p class="text-xs text-amber-600 dark:text-amber-400">
                    Editor.js временно недоступен — используйте резервное поле ниже.
                </p>
                <textarea
                    x-model="fallbackText"
                    rows="14"
                    class="w-full rounded-lg border border-amber-300 dark:border-amber-900/50 bg-amber-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-amber-500 focus:ring-amber-500"
                    placeholder="Введите текст политики..."
                ></textarea>
            </div>

            <input type="hidden" x-model="editorJson" />

            <p x-show="submitError" x-cloak class="text-sm text-danger-600 mt-1" x-text="submitError"></p>

            @error('editorDataJson')
                <p class="text-sm text-danger-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <x-filament::button type="submit" x-bind:disabled="submitting">
            Сохранить
        </x-filament::button>
    </form>

    <style>
        #privacy-editor .codex-editor__redactor {
            padding-bottom: 0.5rem !important;
        }

        #privacy-editor .ce-block {
            margin-bottom: 0.25rem;
        }

        #privacy-editor .ce-paragraph {
            font-size: 1rem;
            line-height: 1.75;
            color: rgb(15 23 42);
        }

        #privacy-editor .ce-header {
            font-weight: 800;
            line-height: 1.25;
            color: rgb(2 6 23);
            margin-top: 0.6rem;
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }

        #privacy-editor h1.ce-header { font-size: 2rem; }
        #privacy-editor h2.ce-header { font-size: 1.6rem; }
        #privacy-editor h3.ce-header { font-size: 1.3rem; }
        #privacy-editor h4.ce-header { font-size: 1.1rem; }

        .dark #privacy-editor .ce-paragraph {
            color: rgb(226 232 240);
        }

        .dark #privacy-editor .ce-header {
            color: rgb(248 250 252);
        }

        #privacy-editor .ce-block__content,
        #privacy-editor .ce-toolbar__content {
            max-width: 100%;
        }
    </style>

    <script>
        function privacyEditor(initialJson) {
            return {
                editor: null,
                editorReady: false,
                loadFailed: false,
                submitting: false,
                submitError: '',
                editorJson: initialJson || '{"blocks":[]}',
                fallbackText: '',

                parseInitial() {
                    try {
                        const parsed = JSON.parse(this.editorJson);
                        return parsed && Array.isArray(parsed.blocks)
                            ? parsed
                            : { blocks: [] };
                    } catch (_) {
                        return { blocks: [] };
                    }
                },

                init() {
                    if (this.editor) {
                        return;
                    }

                    const data = this.parseInitial();
                    const textParts = (data.blocks || [])
                        .map((block) => {
                            const d = block && block.data ? block.data : {};
                            return d.text || d.caption || '';
                        })
                        .filter(Boolean);
                    this.fallbackText = textParts.join('\n\n');

                    if (!window.PrivacyEditorAssetsLoaded || typeof EditorJS === 'undefined') {
                        this.editorReady = false;
                        this.loadFailed = true;
                        return;
                    }

                    const holderEl = document.getElementById('privacy-editor');
                    if (holderEl) {
                        holderEl.innerHTML = '';
                    }

                    try {
                        this.editor = new EditorJS({
                            holder: 'privacy-editor',
                            data,
                            autofocus: false,
                            placeholder: 'Введите текст политики конфиденциальности...',
                            onReady: () => {
                                this.editorReady = true;
                                this.loadFailed = false;
                            },
                            tools: {
                                header: {
                                    class: Header,
                                    inlineToolbar: true,
                                    config: {
                                        levels: [1, 2, 3, 4],
                                        defaultLevel: 2,
                                    },
                                },
                                list: {
                                    class: List,
                                    inlineToolbar: true,
                                },
                                quote: {
                                    class: Quote,
                                    inlineToolbar: true,
                                },
                                delimiter: Delimiter,
                            },
                        });
                    } catch (_) {
                        this.editorReady = false;
                        this.loadFailed = true;
                    }
                },

                async submit($wire) {
                    if (this.submitting) {
                        return;
                    }

                    this.submitting = true;
                    this.submitError = '';

                    try {
                        let output;

                        if (this.loadFailed || !this.editor || !this.editorReady) {
                            const lines = (this.fallbackText || '')
                                .split(/\n{2,}/)
                                .map((line) => line.trim())
                                .filter(Boolean);

                            output = {
                                blocks: lines.length
                                    ? lines.map((line) => ({
                                        type: 'paragraph',
                                        data: { text: line },
                                    }))
                                    : [{ type: 'paragraph', data: { text: '' } }],
                            };
                        } else {
                            if (this.editor.isReady) {
                                await this.editor.isReady;
                            }

                            output = await this.editor.save();
                        }

                        this.editorJson = JSON.stringify(output);
                        await $wire.call('save', this.editorJson);
                    } catch (error) {
                        this.submitError = 'Не удалось сохранить. Обновите страницу и попробуйте снова.';
                        console.error('Privacy save error:', error);
                    } finally {
                        this.submitting = false;
                    }
                },
            };
        }
    </script>
</x-filament-panels::page>
