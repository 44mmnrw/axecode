<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6 max-w-4xl">
        {{ $this->form }}

        @if ($ogImage)
            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">Текущая сохранённая OG-картинка:</p>
                <img src="{{ $ogImage }}" alt="OG preview" class="max-w-full w-[460px] rounded-lg border border-gray-200 dark:border-gray-700" />
            </div>
        @endif

        <x-filament::button type="submit" size="lg">Сохранить</x-filament::button>
    </form>
</x-filament-panels::page>
