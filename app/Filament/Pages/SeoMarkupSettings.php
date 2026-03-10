<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;

class SeoMarkupSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'SEO и Open Graph';

    protected static ?string $title = 'SEO и Open Graph';

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected string $view = 'filament.pages.seo-markup-settings';

    public ?array $data = [];

    public string $seoTitle = '';

    public string $seoDescription = '';

    public string $seoKeywords = '';

    public string $ogTitle = '';

    public string $ogDescription = '';

    public string $ogImage = '';

    public string $twitterTitle = '';

    public string $twitterDescription = '';

    public function mount(): void
    {
        $this->seoTitle = (string) Setting::get('seo_title', 'Разработка сайтов и мобильных приложений под ключ — Axecode');
        $this->seoDescription = (string) Setting::get('seo_description', 'Axecode — веб-студия полного цикла. Разработка сайтов, веб-приложений и мобильных приложений под ключ: UX/UI дизайн, интеграции, техподдержка и SEO-оптимизация.');
        $this->seoKeywords = (string) Setting::get('seo_keywords', 'разработка сайтов под ключ, создание сайта для бизнеса, разработка веб-приложений, мобильные приложения iOS Android, UI UX дизайн, техническая поддержка сайта, SEO оптимизация сайта, веб-студия Axecode');

        $this->ogTitle = (string) Setting::get('seo_og_title', $this->seoTitle);
        $this->ogDescription = (string) Setting::get('seo_og_description', 'Разрабатываем сайты, веб-приложения и мобильные приложения для бизнеса. UX/UI дизайн, интеграции, техподдержка и SEO-оптимизация.');
        $storedOgImage = (string) Setting::get('seo_og_image', '');
        $this->ogImage = $this->resolveOgImageUrl($storedOgImage);

        $this->twitterTitle = (string) Setting::get('seo_twitter_title', $this->seoTitle);
        $this->twitterDescription = (string) Setting::get('seo_twitter_description', 'Сайты, веб-приложения и мобильные приложения для бизнеса: от аналитики и дизайна до запуска и поддержки 24/7.');

        $this->form->fill([
            'seoTitle' => $this->seoTitle,
            'seoDescription' => $this->seoDescription,
            'seoKeywords' => $this->seoKeywords,
            'ogTitle' => $this->ogTitle,
            'ogDescription' => $this->ogDescription,
            'ogImageFile' => $this->extractStoragePath($storedOgImage),
            'twitterTitle' => $this->twitterTitle,
            'twitterDescription' => $this->twitterDescription,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                TextInput::make('seoTitle')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('seoDescription')
                    ->label('Description')
                    ->rows(3)
                    ->required()
                    ->maxLength(500),

                Textarea::make('seoKeywords')
                    ->label('Keywords (через запятую)')
                    ->rows(3)
                    ->maxLength(1000),

                TextInput::make('ogTitle')
                    ->label('OG Title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('ogDescription')
                    ->label('OG Description')
                    ->rows(3)
                    ->required()
                    ->maxLength(500),

                FileUpload::make('ogImageFile')
                    ->label('OG-картинка (рекомендуется 1200x630)')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('seo')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->helperText('Используется встроенный загрузчик Filament с превью.'),

                TextInput::make('twitterTitle')
                    ->label('Twitter Title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('twitterDescription')
                    ->label('Twitter Description')
                    ->rows(3)
                    ->required()
                    ->maxLength(500),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $this->seoTitle = $this->normalizeString($state['seoTitle'] ?? '');
        $this->seoDescription = $this->normalizeString($state['seoDescription'] ?? '');
        $this->seoKeywords = $this->normalizeString($state['seoKeywords'] ?? '');

        $this->ogTitle = $this->normalizeString($state['ogTitle'] ?? '');
        $this->ogDescription = $this->normalizeString($state['ogDescription'] ?? '');
        $ogImagePath = $this->normalizeString($state['ogImageFile'] ?? '');

        $this->twitterTitle = $this->normalizeString($state['twitterTitle'] ?? '');
        $this->twitterDescription = $this->normalizeString($state['twitterDescription'] ?? '');

        if ($ogImagePath !== '') {
            Setting::set('seo_og_image', $ogImagePath);
            $this->ogImage = asset('storage/' . ltrim($ogImagePath, '/'));
        }

        Setting::set('seo_title', $this->seoTitle);
        Setting::set('seo_description', $this->seoDescription);
        Setting::set('seo_keywords', $this->seoKeywords);

        Setting::set('seo_og_title', $this->ogTitle);
        Setting::set('seo_og_description', $this->ogDescription);

        Setting::set('seo_twitter_title', $this->twitterTitle);
        Setting::set('seo_twitter_description', $this->twitterDescription);

        Notification::make()
            ->title('SEO и Open Graph настройки сохранены')
            ->success()
            ->send();
    }

    private function normalizeString(?string $value): string
    {
        return trim((string) $value);
    }

    private function resolveOgImageUrl(string $value): string
    {
        if ($value === '') {
            return config('app.url') . '/og-image.png';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    private function extractStoragePath(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            $parts = parse_url($value);
            $path = (string) ($parts['path'] ?? '');

            if (str_contains($path, '/storage/')) {
                return ltrim(substr($path, strpos($path, '/storage/') + 9), '/');
            }

            return null;
        }

        return ltrim($value, '/');
    }
}
