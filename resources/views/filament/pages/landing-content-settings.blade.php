<x-filament-panels::page>
    <form wire:submit="save" class="landing-editor space-y-8 max-w-5xl">
        <section class="landing-card rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-6 space-y-4">
            <h2 class="text-lg font-semibold">Hero</h2>

            <div>
                <label class="block text-sm font-medium mb-2">Badge</label>
                <input wire:model.defer="hero.badge" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                @error('hero.badge')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Заголовок (перенос строки через Enter)</label>
                <textarea wire:model.defer="hero.title" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                @error('hero.title')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Описание</label>
                <textarea wire:model.defer="hero.description" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                @error('hero.description')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Текст основной кнопки</label>
                    <input wire:model.defer="hero.primaryButtonText" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    @error('hero.primaryButtonText')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Текст второй кнопки</label>
                    <input wire:model.defer="hero.secondaryButtonText" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    @error('hero.secondaryButtonText')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="landing-card rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-6 space-y-4">
            <h2 class="text-lg font-semibold">Services</h2>

            <div>
                <label class="block text-sm font-medium mb-2">Заголовок секции</label>
                <input wire:model.defer="servicesTitle" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                @error('servicesTitle')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Подзаголовок секции</label>
                <input wire:model.defer="servicesSubtitle" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                @error('servicesSubtitle')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-4">
                @foreach($servicesItems as $index => $item)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-4 space-y-3">
                        <div class="text-sm font-semibold">Карточка #{{ $index + 1 }}</div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Название</label>
                            <input wire:model.defer="servicesItems.{{ $index }}.title" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                            @error('servicesItems.' . $index . '.title')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Описание</label>
                            <textarea wire:model.defer="servicesItems.{{ $index }}.description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                            @error('servicesItems.' . $index . '.description')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Ссылка</label>
                            <input wire:model.defer="servicesItems.{{ $index }}.href" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                            @error('servicesItems.' . $index . '.href')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="landing-card rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-6 space-y-4">
            <h2 class="text-lg font-semibold">FAQ</h2>

            <div>
                <label class="block text-sm font-medium mb-2">Заголовок секции</label>
                <input wire:model.defer="faqTitle" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                @error('faqTitle')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Подзаголовок секции</label>
                <input wire:model.defer="faqSubtitle" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                @error('faqSubtitle')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-4">
                @foreach($faqItems as $index => $item)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-semibold">Вопрос #{{ $index + 1 }}</div>
                            <x-filament::button color="gray" size="xs" type="button" wire:click="removeFaqItem({{ $index }})">
                                Удалить
                            </x-filament::button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Вопрос</label>
                            <input wire:model.defer="faqItems.{{ $index }}.question" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                            @error('faqItems.' . $index . '.question')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Ответ</label>
                            <textarea wire:model.defer="faqItems.{{ $index }}.answer" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                            @error('faqItems.' . $index . '.answer')<p class="text-sm text-danger-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <x-filament::button type="button" color="gray" wire:click="addFaqItem">
                Добавить вопрос
            </x-filament::button>
        </section>

        <x-filament::button type="submit" size="lg">
            Сохранить контент
        </x-filament::button>
    </form>

    <style>
        .landing-editor {
            max-width: 980px;
            display: grid;
            gap: 1.25rem;
        }

        .landing-editor .landing-card {
            border: 1px solid #d6d9df;
            border-radius: 16px;
            background: #fff;
            padding: 1.1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
        }

        .landing-editor label {
            display: block;
            margin-bottom: .4rem;
            font-size: .9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .landing-editor input,
        .landing-editor textarea {
            width: 100%;
            display: block;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #fff;
            color: #0f172a;
            padding: .7rem .9rem;
            line-height: 1.35;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .landing-editor textarea {
            resize: vertical;
            min-height: 92px;
        }

        .landing-editor input:focus,
        .landing-editor textarea:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, .2);
            outline: none;
        }

        .dark .landing-editor .landing-card {
            background: #0f172a;
            border-color: #334155;
        }

        .dark .landing-editor label {
            color: #e2e8f0;
        }

        .dark .landing-editor input,
        .dark .landing-editor textarea {
            background: #111827;
            border-color: #374151;
            color: #f8fafc;
        }
    </style>
</x-filament-panels::page>
