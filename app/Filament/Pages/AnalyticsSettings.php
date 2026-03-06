<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use UnitEnum;

class AnalyticsSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Аналитика';

    protected static ?string $title = 'Настройки аналитики';

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected string $view = 'filament.pages.analytics-settings';

    public ?string $yandexMetrikaId = '';

    public ?string $googleAnalyticsId = '';

    public ?string $googleTagManagerId = '';

    public function mount(): void
    {
        $this->yandexMetrikaId = Setting::get('yandex_metrika_id', '');
        $this->googleAnalyticsId = Setting::get('google_analytics_id', '');
        $this->googleTagManagerId = Setting::get('google_tag_manager_id', '');
    }

    public function save(): void
    {
        $this->yandexMetrikaId = $this->normalizeString($this->yandexMetrikaId);
        $this->googleAnalyticsId = strtoupper($this->normalizeString($this->googleAnalyticsId));
        $this->googleTagManagerId = strtoupper($this->normalizeString($this->googleTagManagerId));

        $this->validate([
            'yandexMetrikaId' => ['nullable', 'regex:/^\d{5,10}$/'],
            // Поддерживаем GA4 (G-XXXX) и legacy UA, если нужен перенос старого счётчика.
            'googleAnalyticsId' => ['nullable', 'regex:/^(G-[A-Z0-9]{4,14}|UA-\d{4,10}-\d{1,4})$/'],
            'googleTagManagerId' => ['nullable', 'regex:/^GTM-[A-Z0-9]{4,14}$/'],
        ], [
            'yandexMetrikaId.regex' => 'ID Яндекс Метрики должен содержать только цифры (5–10 символов).',
            'googleAnalyticsId.regex' => 'Google Analytics ID должен быть в формате G-XXXXXXXXXX или UA-XXXXXX-X.',
            'googleTagManagerId.regex' => 'Google Tag Manager ID должен быть в формате GTM-XXXXXXX.',
        ]);

        Setting::set('yandex_metrika_id', $this->yandexMetrikaId ?? '');
        Setting::set('google_analytics_id', $this->googleAnalyticsId ?? '');
        Setting::set('google_tag_manager_id', $this->googleTagManagerId ?? '');

        Notification::make()
            ->title('Настройки аналитики сохранены')
            ->success()
            ->send();
    }

    private function normalizeString(?string $value): string
    {
        return trim((string) $value);
    }
}
