<x-filament-panels::page>
    <form wire:submit="save" class="analytics-form">
        <div class="analytics-card">
            <div class="analytics-fields">
                <div class="analytics-field">
                    <label for="yandexMetrikaId" class="analytics-label">
                        Яндекс Метрика ID
                    </label>
                    <input
                        id="yandexMetrikaId"
                        type="text"
                        wire:model.defer="yandexMetrikaId"
                        class="analytics-input"
                        placeholder="12345678"
                    />
                    @error('yandexMetrikaId')
                        <p class="analytics-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="analytics-field">
                    <label for="googleAnalyticsId" class="analytics-label">
                        Google Analytics ID
                    </label>
                    <input
                        id="googleAnalyticsId"
                        type="text"
                        wire:model.defer="googleAnalyticsId"
                        class="analytics-input"
                        placeholder="G-XXXXXXXXXX"
                    />
                    @error('googleAnalyticsId')
                        <p class="analytics-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="analytics-field">
                    <label for="googleTagManagerId" class="analytics-label">
                        Google Tag Manager ID
                    </label>
                    <input
                        id="googleTagManagerId"
                        type="text"
                        wire:model.defer="googleTagManagerId"
                        class="analytics-input"
                        placeholder="GTM-XXXXXXX"
                    />
                    @error('googleTagManagerId')
                        <p class="analytics-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <x-filament::button type="submit" size="lg" class="analytics-save-btn">
            Сохранить
        </x-filament::button>
    </form>

    <style>
        .analytics-form {
            max-width: 760px;
            display: grid;
            gap: 1rem;
        }

        .analytics-card {
            border: 1px solid #d6d9df;
            border-radius: 16px;
            background: #ffffff;
            padding: 1.25rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
        }

        .analytics-fields {
            display: grid;
            gap: 1rem;
        }

        .analytics-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
        }

        .analytics-input {
            display: block;
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #fff;
            color: #0f172a;
            font-size: 1rem;
            line-height: 1.2;
            padding: 0.75rem 0.9rem;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .analytics-input:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }

        .analytics-error {
            margin-top: 0.35rem;
            color: #dc2626;
            font-size: 0.85rem;
        }

        .dark .analytics-card {
            background: #0f172a;
            border-color: #334155;
        }

        .dark .analytics-label {
            color: #e2e8f0;
        }

        .dark .analytics-input {
            background: #111827;
            border-color: #374151;
            color: #f8fafc;
        }
    </style>
</x-filament-panels::page>
