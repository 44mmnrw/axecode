<?php

namespace Database\Seeders;

use App\Models\SeoKeywordPage;
use App\Support\SeoDKeywordLanding;
use Illuminate\Database\Seeder;

class SeoKeywordPagesSeeder extends Seeder
{
    public function run(): void
    {
        $staticPages = [
            [
                'keyword' => 'разработка сайтов под ключ',
                'cluster' => 'site-development',
                'used_for' => '/razrabotka-saitov-pod-klyuch',
                'frequency' => 935,
                'title' => 'Разработка сайтов под ключ для бизнеса — Axecode',
                'h1' => 'Разработка сайтов под ключ для бизнеса',
                'h2' => 'Что входит в разработку под ключ',
                'description' => 'Разработка сайтов под ключ помогает бизнесу системно привлекать заявки и усиливать доверие к бренду. Проектируем структуру, реализуем функционал и сопровождаем запуск.',
                'meta_title' => 'Разработка сайтов под ключ для бизнеса — Axecode',
                'meta_description' => 'Разрабатываем сайты под задачи бизнеса: корпоративные, лендинги и интернет-магазины. Ведём проект от идеи и прототипа до запуска и развития.',
                'meta_keywords' => 'разработка сайтов под ключ, создание сайта, корпоративный сайт, лендинг, интернет-магазин',
                'meta_fields' => ['canonical' => '/razrabotka-saitov-pod-klyuch'],
                'is_active' => true,
            ],
            [
                'keyword' => 'разработка веб-приложений',
                'cluster' => 'web-app-development',
                'used_for' => '/razrabotka-veb-prilozheniy',
                'frequency' => 4185,
                'title' => 'Разработка веб-приложений под ключ — Axecode',
                'h1' => 'Разработка веб-приложений под ключ',
                'h2' => 'Какие веб-продукты мы разрабатываем',
                'description' => 'Разработка веб-приложений позволяет автоматизировать процессы и масштабировать бизнес без лишней нагрузки на команду. Создаём архитектуру, интерфейсы и интеграции под ваши цели.',
                'meta_title' => 'Разработка веб-приложений под ключ — Axecode',
                'meta_description' => 'Разрабатываем веб-приложения для бизнеса: личные кабинеты, CRM, SaaS и B2B-порталы. От аналитики и UX до запуска.',
                'meta_keywords' => 'разработка веб-приложений, crm, saas, личный кабинет, b2b портал',
                'meta_fields' => ['canonical' => '/razrabotka-veb-prilozheniy'],
                'is_active' => true,
            ],
            [
                'keyword' => 'разработка мобильных приложений',
                'cluster' => 'mobile-development',
                'used_for' => '/razrabotka-mobilnyh-prilozheniy',
                'frequency' => 8023,
                'title' => 'Разработка мобильных приложений iOS и Android — Axecode',
                'h1' => 'Разработка мобильных приложений iOS и Android',
                'h2' => 'Что вы получаете в результате',
                'description' => 'Разработка мобильных приложений помогает быстро запустить удобный цифровой продукт для клиентов и команды. Берём проект от идеи и UX до релиза и дальнейшего развития.',
                'meta_title' => 'Разработка мобильных приложений iOS и Android — Axecode',
                'meta_description' => 'Разработка мобильных приложений для iOS и Android: от продуктовой идеи и UX до релиза в сторах и развития.',
                'meta_keywords' => 'разработка мобильных приложений, ios, android, мобильная разработка, app development',
                'meta_fields' => ['canonical' => '/razrabotka-mobilnyh-prilozheniy'],
                'is_active' => true,
            ],
            [
                'keyword' => 'разработка интернет-магазина',
                'cluster' => 'ecommerce-development',
                'used_for' => '/razrabotka-internet-magazina',
                'frequency' => 1298,
                'title' => 'Разработка интернет-магазина под ключ — Axecode',
                'h1' => 'Разработка интернет-магазина под ключ',
                'h2' => 'Что получает ваш e-commerce проект',
                'description' => 'Разработка интернет-магазина нацелена на рост продаж и повышение конверсии. Настраиваем каталог, checkout, интеграции с CRM и сквозную аналитику.',
                'meta_title' => 'Разработка интернет-магазина под ключ — Axecode',
                'meta_description' => 'Разработка интернет-магазинов для роста продаж: удобный каталог, быстрый checkout, интеграции с CRM, складом и аналитикой.',
                'meta_keywords' => 'разработка интернет-магазина, ecommerce, каталог, корзина, онлайн-оплата',
                'meta_fields' => ['canonical' => '/razrabotka-internet-magazina'],
                'is_active' => true,
            ],
            [
                'keyword' => 'техническая поддержка сайта',
                'cluster' => 'support-development',
                'used_for' => '/tehnicheskaya-podderzhka-sayta',
                'frequency' => 2332,
                'title' => 'Техническая поддержка и сопровождение сайта — Axecode',
                'h1' => 'Техническая поддержка и сопровождение сайта',
                'h2' => 'Как мы ведём поддержку проекта',
                'description' => 'Техническая поддержка сайта обеспечивает стабильную работу проекта после релиза и предсказуемое развитие функционала. Оперативно закрываем инциденты и ведём плановые улучшения.',
                'meta_title' => 'Техническая поддержка и сопровождение сайта — Axecode',
                'meta_description' => 'Техническая поддержка и развитие сайта: обновления, исправление ошибок, ускорение и контроль стабильности.',
                'meta_keywords' => 'техническая поддержка сайта, сопровождение сайта, развитие проекта, sla, поддержка',
                'meta_fields' => ['canonical' => '/tehnicheskaya-podderzhka-sayta'],
                'is_active' => true,
            ],
        ];

        foreach ($staticPages as $page) {
            SeoKeywordPage::updateOrCreate(
                ['keyword' => $page['keyword']],
                $page
            );
        }

        foreach (SeoDKeywordLanding::bySlugMap() as $slug => $item) {
            $phrase = (string) ($item['phrase'] ?? '');
            $frequency = (int) ($item['totalCount'] ?? 0);

            if ($phrase === '') {
                continue;
            }

            $normalizedPhrase = $this->humanizePhrase($phrase);
            $displayPhrase = $this->cleanDisplayPhrase($normalizedPhrase);
            $title = $normalizedPhrase . ' — Axecode';
            $description = $this->buildDDescription($displayPhrase, $frequency, $slug);
            $metaDescription = $this->buildDMetaDescription($normalizedPhrase, $frequency, $slug);

            SeoKeywordPage::updateOrCreate(
                ['keyword' => $phrase],
                [
                    'cluster' => 'd-keyword',
                    'used_for' => '/d/' . $slug,
                    'frequency' => $frequency,
                    'title' => $title,
                    'h1' => $displayPhrase,
                    'h2' => 'Решения под задачи бизнеса',
                    'description' => $description,
                    'meta_title' => $title,
                    'meta_description' => $metaDescription,
                    'meta_keywords' => $phrase,
                    'meta_fields' => [
                        'canonical' => '/d/' . $slug,
                        'priority' => 'D',
                    ],
                    'is_active' => true,
                ]
            );
        }
    }

    private function uppercaseFirst(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return $value;
        }

        $first = mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8');
        $rest = mb_substr($value, 1, null, 'UTF-8');

        return $first . $rest;
    }

    private function humanizePhrase(string $phrase): string
    {
        $value = mb_strtolower(trim($phrase), 'UTF-8');
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        // Базовая нормализация частых «ломаных» форм по сайтам.
        $value = preg_replace('/\bсоздание\s+сайт\b/u', 'создание сайта', $value) ?? $value;
        $value = preg_replace('/\bсоздание\s+сайты\b/u', 'создание сайтов', $value) ?? $value;
        $value = preg_replace('/\bразработка\s+сайт\b/u', 'разработка сайта', $value) ?? $value;
        $value = preg_replace('/\bразработка\s+сайты\b/u', 'разработка сайтов', $value) ?? $value;

        // Человекопонятные формы для городов в конце фразы.
        $cityForms = [
            ['pattern' => 'москва', 'in' => 'Москве'],
            ['pattern' => 'санкт[\s-]*петербург', 'in' => 'Санкт-Петербурге'],
            ['pattern' => 'казань', 'in' => 'Казани'],
            ['pattern' => 'екатеринбург', 'in' => 'Екатеринбурге'],
            ['pattern' => 'новосибирск', 'in' => 'Новосибирске'],
            ['pattern' => 'нижний\s+новгород', 'in' => 'Нижнем Новгороде'],
            ['pattern' => 'самара', 'in' => 'Самаре'],
            ['pattern' => 'омск', 'in' => 'Омске'],
            ['pattern' => 'ростов[\s-]*на[\s-]*дону', 'in' => 'Ростове-на-Дону'],
            ['pattern' => 'краснодар', 'in' => 'Краснодаре'],
            ['pattern' => 'уфа', 'in' => 'Уфе'],
            ['pattern' => 'пермь', 'in' => 'Перми'],
            ['pattern' => 'воронеж', 'in' => 'Воронеже'],
            ['pattern' => 'волгоград', 'in' => 'Волгограде'],
            ['pattern' => 'красноярск', 'in' => 'Красноярске'],
            ['pattern' => 'челябинск', 'in' => 'Челябинске'],
            ['pattern' => 'тюмень', 'in' => 'Тюмени'],
        ];

        foreach ($cityForms as $cityForm) {
            $pattern = '/\s(?:' . $cityForm['pattern'] . ')$/u';
            if (preg_match($pattern, $value) === 1) {
                $value = preg_replace($pattern, ' в ' . $cityForm['in'], $value) ?? $value;
                break;
            }
        }

        return $this->polishPhrase($this->uppercaseFirst($value));
    }

    private function polishPhrase(string $text): string
    {
        $value = $text;

        // Орфография и дефисы в частых техфразах.
        $value = preg_replace('/\bинтернет\s+магазин\b/ui', 'интернет-магазин', $value) ?? $value;
        $value = preg_replace('/\bинтернет\s+магазина\b/ui', 'интернет-магазина', $value) ?? $value;
        $value = preg_replace('/\bинтернет\s+магазины\b/ui', 'интернет-магазины', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сайт\b/ui', 'веб-сайт', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сайта\b/ui', 'веб-сайта', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сайты\b/ui', 'веб-сайты', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сервис\b/ui', 'веб-сервис', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сервиса\b/ui', 'веб-сервиса', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+сервисы\b/ui', 'веб-сервисы', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+портал\b/ui', 'веб-портал', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+портала\b/ui', 'веб-портала', $value) ?? $value;
        $value = preg_replace('/\bвеб\s+порталы\b/ui', 'веб-порталы', $value) ?? $value;
        $value = preg_replace('/\bлендинг\s+пейдж\b/ui', 'лендинг-пейдж', $value) ?? $value;
        $value = preg_replace('/\blanding\s+page\b/ui', 'Landing Page', $value) ?? $value;

        // Частые лексические упрощения.
        $value = preg_replace('/\bсделать\b/ui', 'Создать', $value) ?? $value;
        $value = preg_replace('/\bзаказать\s+разработку\b/ui', 'Разработка', $value) ?? $value;
        $value = preg_replace('/\bзаказать\s+создание\b/ui', 'Создание', $value) ?? $value;

        // Нормализация техтерминов.
        $value = preg_replace('/\bios\b/ui', 'iOS', $value) ?? $value;
        $value = preg_replace('/\bandroid\b/ui', 'Android', $value) ?? $value;
        $value = preg_replace('/\bcrm\b/ui', 'CRM', $value) ?? $value;
        $value = preg_replace('/\bsaas\b/ui', 'SaaS', $value) ?? $value;
        $value = preg_replace('/\bb2b\b/ui', 'B2B', $value) ?? $value;
        $value = preg_replace('/\bb2c\b/ui', 'B2C', $value) ?? $value;
        $value = preg_replace('/\bapi\b/ui', 'API', $value) ?? $value;
        $value = preg_replace('/\bui\s*\/\s*ux\b/ui', 'UI/UX', $value) ?? $value;

        return $value;
    }

    private function buildDDescription(string $phrase, int $frequency, string $slug): string
    {
        $seed = abs(crc32($slug));

        $leadVariants = [
            $phrase . ' — востребованное направление для компаний, которым важно получать предсказуемый результат и прозрачный процесс разработки.',
            $phrase . ' — практический запрос бизнеса, когда нужно быстро перейти от идеи к работающему цифровому решению без лишних рисков.',
            $phrase . ' — задача, которую мы решаем как продуктово, так и технически: от структуры и UX до запуска и развития.',
            $phrase . ' — сценарий, где особенно важны сроки, качество и понятная коммуникация на каждом этапе проекта.',
        ];

        $processVariants = [
            'Сначала фиксируем цели, метрики и ограничения, затем проектируем архитектуру, готовим интерфейсы и собираем реализацию по этапам с регулярной демонстрацией прогресса.',
            'Начинаем с анализа требований и пользовательских сценариев, после чего формируем roadmap, оцениваем объём работ и запускаем итеративную разработку с контролем качества.',
            'Проводим бриф, декомпозируем функционал, определяем приоритеты и внедряем решение итерациями, чтобы вы видели ценность уже на ранних этапах.',
            'Выстраиваем работу через понятные этапы: аналитика, прототипирование, разработка, тестирование и релиз с обязательной проверкой ключевых бизнес-сценариев.',
        ];

        $benefitVariants = [
            'В результате вы получаете не просто код, а инструмент для роста: стабильный релиз, управляемый бюджет, гибкий план развития и поддержку после запуска.',
            'На выходе формируется рабочий продукт с учётом SEO, производительности и масштабирования, чтобы проект приносил пользу не только сегодня, но и в долгую.',
            'Итог — практичное решение под ваши цели: прозрачные сроки, контроль рисков, понятные приоритеты и возможность развивать функционал без хаоса.',
            'Фокусируемся на бизнес-эффекте: сокращаем путь до результата, повышаем управляемость проекта и создаём базу для дальнейшего роста продукта.',
        ];

        $frequencySentence = $this->buildFrequencySentence($frequency);

        $lead = $leadVariants[$seed % count($leadVariants)];
        $process = $processVariants[($seed >> 2) % count($processVariants)];
        $benefit = $benefitVariants[($seed >> 4) % count($benefitVariants)];

        return $lead . ' ' . $process . ' ' . $frequencySentence . ' ' . $benefit;
    }

    private function buildDMetaDescription(string $phrase, int $frequency, string $slug): string
    {
        $seed = abs(crc32('meta-' . $slug));

        $metaVariants = [
            $phrase . ' от Axecode: анализируем задачи, проектируем решение, реализуем и сопровождаем запуск. Понятные сроки, прозрачный бюджет и контроль качества.',
            $phrase . ' с Axecode: от брифа и архитектуры до релиза и поддержки. Работаем по этапам, держим фокус на бизнес-результате и масштабировании.',
            $phrase . ' под ключ в Axecode: UX, разработка, интеграции, тестирование и развитие после релиза. Коммуникация без хаоса и прогнозируемые сроки.',
            $phrase . ' для бизнеса: команда Axecode выстраивает процесс от целей до запуска, снижает риски и помогает получить измеримый результат.',
        ];

        $base = $metaVariants[$seed % count($metaVariants)];
        $tail = $frequency > 0
            ? ' Учитываем спрос по запросу и адаптируем стратегию под приоритеты вашего проекта.'
            : '';

        return $base . $tail;
    }

    private function buildFrequencySentence(int $frequency): string
    {
        if ($frequency >= 1000) {
            return 'По частотности видно устойчивый интерес аудитории, поэтому закладываем в реализацию акцент на конверсию, производительность и масштабируемость.';
        }

        if ($frequency >= 100) {
            return 'Запрос имеет стабильный спрос, поэтому делаем упор на понятный пользовательский путь, корректную структуру контента и техническую надёжность.';
        }

        if ($frequency > 0) {
            return 'Даже при нишевом спросе важно быстро проверить гипотезу и запустить решение, которое можно безопасно развивать по мере роста проекта.';
        }

        return 'Для редких сценариев фокусируемся на точной реализации требований и гибкой архитектуре, чтобы проект можно было развивать без переработки основы.';
    }

    private function cleanDisplayPhrase(string $phrase): string
    {
        $value = trim($phrase);

        // Убираем коммерческие хвосты из отображаемой фразы (H1/description),
        // но оставляем их в keyword/meta для SEO-сигнала.
        $value = preg_replace('/\s+под\s+ключ$/ui', '', $value) ?? $value;
        $value = preg_replace('/\s+цена$/ui', '', $value) ?? $value;
        $value = preg_replace('/\s+стоимость$/ui', '', $value) ?? $value;

        // Повторная очистка пробелов и капитализация на случай редких комбинаций.
        $value = preg_replace('/\s+/u', ' ', trim($value)) ?? trim($value);

        return $this->uppercaseFirst($value);
    }
}
