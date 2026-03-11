<?php

namespace App\Filament\Pages;

use App\Services\SemanticCoverageAuditService;
use App\Services\YandexMetrikaService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class SemanticCoverageAnalytics extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationLabel = 'Покрытие семантики';

    protected static ?string $title = 'Аналитика покрытия семантического ядра';

    protected static string|UnitEnum|null $navigationGroup = 'SEO';

    protected string $view = 'filament.pages.semantic-coverage-analytics';

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * @var array<string, mixed>
     */
    public array $metrika = [];

    public string $blogPriorityFilter = 'ALL';

    public int $blogMinFrequency = 0;

    public bool $blogOnlyUncovered = false;

    public function mount(SemanticCoverageAuditService $auditService, YandexMetrikaService $metrikaService): void
    {
        $this->data = $auditService->overview();
        $this->metrika = $metrikaService->getDashboardData();
    }

    public function runAudit(SemanticCoverageAuditService $auditService): void
    {
        $this->data = $auditService->runAudit();

        Notification::make()
            ->title('Аудит покрытия обновлён')
            ->success()
            ->send();
    }

    public function refreshMetrika(YandexMetrikaService $metrikaService): void
    {
        $this->metrika = $metrikaService->getDashboardData();

        if (! empty($this->metrika['connected'])) {
            Notification::make()
                ->title('Метрика обновлена')
                ->success()
                ->send();

            return;
        }

        Notification::make()
            ->title('Метрику обновить не удалось')
            ->body((string) ($this->metrika['error'] ?? 'Неизвестная ошибка.'))
            ->danger()
            ->send();
    }
}
