<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;

class SchemaOrgSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $navigationLabel = 'Schema.org';

    protected static ?string $title = 'Schema.org разметка';

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.schema-org-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'orgName'        => (string) Setting::get('schema_org_name', 'Axecode'),
            'orgDescription' => (string) Setting::get('schema_org_description', 'Веб-студия полного цикла: разработка сайтов под ключ, веб-приложений и мобильных приложений, UI/UX дизайн, техподдержка и SEO-оптимизация.'),
            'orgFoundingDate'=> (string) Setting::get('schema_org_founding_date', '2019'),
            'orgTelephone'   => (string) Setting::get('schema_org_telephone', '+7-495-109-25-44'),
            'orgEmail'       => (string) Setting::get('schema_org_email', 'hello@axecode.tech'),
            'orgAreaServed'  => (string) Setting::get('schema_org_area_served', 'RU'),
            'orgLogoPath'    => (string) Setting::get('schema_org_logo_path', '/logo.png'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Организация (Organization)')
                    ->description('Данные компании для поискового блока "Organization". Используются в @graph во всех страницах сайта.')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextInput::make('orgName')
                            ->label('Название компании')
                            ->required()
                            ->maxLength(120)
                            ->columnSpan(1),

                        TextInput::make('orgFoundingDate')
                            ->label('Год основания')
                            ->required()
                            ->maxLength(10)
                            ->placeholder('2019')
                            ->columnSpan(1),

                        Textarea::make('orgDescription')
                            ->label('Описание организации')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('orgTelephone')
                            ->label('Телефон')
                            ->tel()
                            ->required()
                            ->maxLength(30)
                            ->placeholder('+7-495-109-25-44')
                            ->columnSpan(1),

                        TextInput::make('orgEmail')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(120)
                            ->placeholder('hello@axecode.tech')
                            ->columnSpan(1),

                        TextInput::make('orgAreaServed')
                            ->label('Регион (areaServed)')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('RU')
                            ->helperText('Код страны/региона ISO 3166-1. Пример: RU, RU-MOW')
                            ->columnSpan(1),

                        TextInput::make('orgLogoPath')
                            ->label('Путь к логотипу (URL или /path)')
                            ->required()
                            ->maxLength(300)
                            ->placeholder('/logo.png')
                            ->helperText('Абсолютный URL или путь от корня сайта. Рекомендуемый размер: минимум 112×112 px.')
                            ->columnSpan(1),
                    ]),

                Section::make('Услуги и FAQ')
                    ->description('Список услуг (OfferCatalog) и FAQ-вопросы берутся автоматически из раздела «Контент лендинга». Редактировать их здесь не нужно.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Placeholder::make('services_info')
                            ->label('Услуги (OfferCatalog)')
                            ->content('Используются названия услуг из «Настройки → Контент лендинга → Блок услуг».'),

                        Placeholder::make('faq_info')
                            ->label('FAQ-вопросы (FAQPage)')
                            ->content('Используются вопросы и ответы из «Настройки → Контент лендинга → FAQ».'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set('schema_org_name',         trim($state['orgName'] ?? ''));
        Setting::set('schema_org_description',  trim($state['orgDescription'] ?? ''));
        Setting::set('schema_org_founding_date',trim($state['orgFoundingDate'] ?? ''));
        Setting::set('schema_org_telephone',    trim($state['orgTelephone'] ?? ''));
        Setting::set('schema_org_email',        trim($state['orgEmail'] ?? ''));
        Setting::set('schema_org_area_served',  trim($state['orgAreaServed'] ?? ''));
        Setting::set('schema_org_logo_path',    trim($state['orgLogoPath'] ?? ''));

        Notification::make()
            ->title('Schema.org настройки сохранены')
            ->success()
            ->send();
    }
}
