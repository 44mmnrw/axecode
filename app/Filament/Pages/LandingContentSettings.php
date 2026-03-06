<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class LandingContentSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Контент лендинга';

    protected static ?string $title = 'Контент лендинга';

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected string $view = 'filament.pages.landing-content-settings';

    public array $hero = [];

    public string $servicesTitle = '';

    public string $servicesSubtitle = '';

    public array $servicesItems = [];

    public string $faqTitle = '';

    public string $faqSubtitle = '';

    public array $faqItems = [];

    public function mount(): void
    {
        $this->hero = $this->loadHero();

        $services = $this->loadServices();
        $this->servicesTitle = (string) ($services['title'] ?? $this->defaultServices()['title']);
        $this->servicesSubtitle = (string) ($services['subtitle'] ?? $this->defaultServices()['subtitle']);
        $this->servicesItems = $this->normalizeServicesItems($services['items'] ?? []);

        $faq = $this->loadFaq();
        $this->faqTitle = (string) ($faq['title'] ?? $this->defaultFaq()['title']);
        $this->faqSubtitle = (string) ($faq['subtitle'] ?? $this->defaultFaq()['subtitle']);
        $this->faqItems = $this->normalizeFaqItems($faq['items'] ?? []);
    }

    public function addFaqItem(): void
    {
        $this->faqItems[] = [
            'question' => '',
            'answer' => '',
        ];
    }

    public function removeFaqItem(int $index): void
    {
        unset($this->faqItems[$index]);
        $this->faqItems = array_values($this->faqItems);
    }

    public function save(): void
    {
        $this->servicesItems = $this->normalizeServicesItems($this->servicesItems);
        $this->faqItems = $this->normalizeFaqItems($this->faqItems);

        $this->validate([
            'hero.badge' => ['required', 'string', 'max:140'],
            'hero.title' => ['required', 'string', 'max:220'],
            'hero.description' => ['required', 'string', 'max:1200'],
            'hero.primaryButtonText' => ['required', 'string', 'max:80'],
            'hero.secondaryButtonText' => ['required', 'string', 'max:80'],

            'servicesTitle' => ['required', 'string', 'max:120'],
            'servicesSubtitle' => ['required', 'string', 'max:220'],
            'servicesItems' => ['array', 'min:1'],
            'servicesItems.*.title' => ['required', 'string', 'max:120'],
            'servicesItems.*.description' => ['required', 'string', 'max:600'],
            'servicesItems.*.href' => ['required', 'string', 'max:200'],

            'faqTitle' => ['required', 'string', 'max:220'],
            'faqSubtitle' => ['required', 'string', 'max:300'],
            'faqItems' => ['array', 'min:1'],
            'faqItems.*.question' => ['required', 'string', 'max:260'],
            'faqItems.*.answer' => ['required', 'string', 'max:1200'],
        ]);

        Setting::set('landing_hero_json', json_encode($this->hero, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        Setting::set('landing_services_json', json_encode([
            'title' => $this->servicesTitle,
            'subtitle' => $this->servicesSubtitle,
            'items' => $this->servicesItems,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        Setting::set('landing_faq_json', json_encode([
            'title' => $this->faqTitle,
            'subtitle' => $this->faqSubtitle,
            'items' => $this->faqItems,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        Notification::make()
            ->title('Контент лендинга сохранён')
            ->success()
            ->send();
    }

    private function loadHero(): array
    {
        $raw = Setting::get('landing_hero_json', '');
        $data = is_string($raw) ? json_decode($raw, true) : null;

        return array_merge($this->defaultHero(), is_array($data) ? $data : []);
    }

    private function loadServices(): array
    {
        $raw = Setting::get('landing_services_json', '');
        $data = is_string($raw) ? json_decode($raw, true) : null;

        if (!is_array($data)) {
            return $this->defaultServices();
        }

        return [
            'title' => (string) ($data['title'] ?? $this->defaultServices()['title']),
            'subtitle' => (string) ($data['subtitle'] ?? $this->defaultServices()['subtitle']),
            'items' => is_array($data['items'] ?? null) ? $data['items'] : $this->defaultServices()['items'],
        ];
    }

    private function loadFaq(): array
    {
        $raw = Setting::get('landing_faq_json', '');
        $data = is_string($raw) ? json_decode($raw, true) : null;

        if (!is_array($data)) {
            return $this->defaultFaq();
        }

        return [
            'title' => (string) ($data['title'] ?? $this->defaultFaq()['title']),
            'subtitle' => (string) ($data['subtitle'] ?? $this->defaultFaq()['subtitle']),
            'items' => is_array($data['items'] ?? null) ? $data['items'] : $this->defaultFaq()['items'],
        ];
    }

    private function normalizeServicesItems(array $items): array
    {
        $defaults = $this->defaultServices()['items'];

        $normalized = [];
        foreach ($defaults as $index => $defaultItem) {
            $item = $items[$index] ?? [];
            $normalized[] = [
                'title' => trim((string) ($item['title'] ?? $defaultItem['title'])),
                'description' => trim((string) ($item['description'] ?? $defaultItem['description'])),
                'href' => trim((string) ($item['href'] ?? $defaultItem['href'])),
            ];
        }

        return $normalized;
    }

    private function normalizeFaqItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $question = trim((string) ($item['question'] ?? ''));
            $answer = trim((string) ($item['answer'] ?? ''));

            if ($question === '' && $answer === '') {
                continue;
            }

            $normalized[] = [
                'question' => $question,
                'answer' => $answer,
            ];
        }

        return count($normalized) ? $normalized : $this->defaultFaq()['items'];
    }

    private function defaultHero(): array
    {
        return [
            'badge' => 'Технологии будущего • Здесь и сейчас',
            'title' => "Создаём будущее\nцифровых технологий",
            'description' => 'Разрабатываем современные веб-сайты и мобильные приложения, которые помогают бизнесу расти и развиваться в цифровой среде. Наши решения сочетают передовые технологии с безупречным дизайном.',
            'primaryButtonText' => 'Начать проект',
            'secondaryButtonText' => 'Наши услуги',
        ];
    }

    private function defaultServices(): array
    {
        return [
            'title' => 'Наши услуги',
            'subtitle' => 'Комплексные решения для вашего цифрового успеха',
            'items' => [
                [
                    'title' => 'Веб-разработка',
                    'description' => 'Создаём современные и производительные веб-сайты с адаптивным дизайном и интуитивным интерфейсом.',
                    'href' => '/razrabotka-saitov-pod-klyuch',
                ],
                [
                    'title' => 'Мобильные приложения',
                    'description' => 'Разрабатываем нативные и кроссплатформенные приложения для iOS и Android с безупречным UX.',
                    'href' => '/razrabotka-mobilnyh-prilozheniy',
                ],
                [
                    'title' => 'UI/UX Дизайн',
                    'description' => 'Проектируем пользовательские интерфейсы, которые сочетают эстетику с функциональностью.',
                    'href' => '#contact',
                ],
                [
                    'title' => 'Кастомные решения',
                    'description' => 'Создаём индивидуальные программные решения под уникальные задачи вашего бизнеса.',
                    'href' => '/razrabotka-veb-prilozheniy',
                ],
                [
                    'title' => 'Оптимизация',
                    'description' => 'Повышаем производительность существующих приложений и сайтов для лучшего пользовательского опыта.',
                    'href' => '#contact',
                ],
                [
                    'title' => 'Техподдержка',
                    'description' => 'Обеспечиваем надёжную поддержку и обслуживание ваших цифровых продуктов 24/7.',
                    'href' => '/tehnicheskaya-podderzhka-sayta',
                ],
            ],
        ];
    }

    private function defaultFaq(): array
    {
        return [
            'title' => 'Частые вопросы о разработке сайтов и мобильных приложений',
            'subtitle' => 'Ответы на популярные вопросы клиентов перед стартом проекта.',
            'items' => [
                [
                    'question' => 'Сколько стоит разработка сайта под ключ?',
                    'answer' => 'Стоимость зависит от типа проекта, сложности функционала и сроков. После брифа мы формируем прозрачную смету и поэтапный план работ.',
                ],
                [
                    'question' => 'Вы разрабатываете мобильные приложения для iOS и Android?',
                    'answer' => 'Да, мы создаём мобильные приложения под iOS и Android: нативные и кроссплатформенные решения в зависимости от задач бизнеса.',
                ],
                [
                    'question' => 'Какие сроки создания корпоративного сайта или веб-приложения?',
                    'answer' => 'Обычно корпоративный сайт занимает от 3 до 8 недель, веб-приложение — от 2 до 4 месяцев. Точные сроки определяются после анализа требований.',
                ],
                [
                    'question' => 'Можно ли заказать редизайн и SEO-оптимизацию существующего сайта?',
                    'answer' => 'Да, мы выполняем редизайн, техническую SEO-оптимизацию, ускорение загрузки и доработку структуры под поисковые запросы.',
                ],
                [
                    'question' => 'Работаете ли вы с поддержкой и развитием проекта после запуска?',
                    'answer' => 'Да, предоставляем техническую поддержку, мониторинг, обновления и развитие продукта после релиза.',
                ],
            ],
        ];
    }
}
