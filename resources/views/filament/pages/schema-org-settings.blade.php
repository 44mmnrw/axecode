<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6 max-w-4xl">
        {{ $this->form }}

        <x-filament::button type="submit" size="lg">Сохранить</x-filament::button>
    </form>
</x-filament-panels::page>
