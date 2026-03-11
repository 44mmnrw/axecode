<x-filament-panels::page>
    @php
        $kpis = $data['kpis'] ?? [];
        $topGaps = $data['top_gaps'] ?? collect();
        $clusterStats = $data['cluster_stats'] ?? collect();
        $coreOverview = $data['core_overview'] ?? [];
        $priorityStats = $data['core_priority_stats'] ?? collect();
        $coreTopGaps = $data['core_top_gaps'] ?? collect();
        $blogCoverage = $data['blog_coverage'] ?? [];
        $blogOverview = $blogCoverage['overview'] ?? [];
        $blogCoveredKeywords = $blogCoverage['covered_keywords'] ?? [];
        $blogUncoveredKeywords = $blogCoverage['uncovered_keywords'] ?? [];
        $blogPriorityStats = $blogCoverage['priority_stats'] ?? [];
        $metrika = $this->metrika ?? [];
        $metrikaSummary = $metrika['summary'] ?? [];
        $metrikaSources = $metrika['sources'] ?? [];
        $hasLocalGaps = is_countable($topGaps) ? count($topGaps) > 0 : false;
        $hasCoreGaps = ($coreOverview['missing_core_keywords'] ?? 0) > 0;
        $coreCriticalGaps = collect($coreTopGaps)->take(8);

        $blogRowsBase = $this->blogOnlyUncovered ? $blogUncoveredKeywords : $blogCoveredKeywords;
        $blogRowsFiltered = collect($blogRowsBase)
            ->filter(function (array $item): bool {
                if ($this->blogPriorityFilter !== 'ALL' && ($item['priority'] ?? '') !== $this->blogPriorityFilter) {
                    return false;
                }

                return (int) ($item['total_count'] ?? 0) >= (int) $this->blogMinFrequency;
            })
            ->values();
    @endphp

    <div class="space-y-6 semantic-dashboard">
        <div class="flex flex-wrap gap-3 items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold">Сводка покрытия</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Последний аудит:
                    {{ !empty($kpis['last_audit_at']) ? \Illuminate\Support\Carbon::parse($kpis['last_audit_at'])->format('d.m.Y H:i') : 'не запускался' }}
                </p>
            </div>

            <x-filament::button wire:click="runAudit" color="warning">
                Пересчитать аудит
            </x-filament::button>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4">
            <h3 class="text-base font-semibold mb-3">Что важно сейчас</h3>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="metric-card metric-card--highlight">
                    <p class="metric-title">Покрытие ядра A-D</p>
                    <p class="metric-value">{{ $coreOverview['core_coverage_percent'] ?? 0 }}%</p>
                    <p class="metric-sub">{{ $coreOverview['covered_core_keywords'] ?? 0 }} / {{ $coreOverview['total_core_keywords'] ?? 0 }} ключей</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Непокрытые ключи core</p>
                    <p class="metric-value">{{ number_format($coreOverview['missing_core_keywords'] ?? 0, 0, '.', ' ') }}</p>
                    <p class="metric-sub">приоритет на новые страницы</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Покрытие локальной SEO-базы</p>
                    <p class="metric-value">{{ $kpis['coverage_percent'] ?? 0 }}%</p>
                    <p class="metric-sub">{{ $kpis['covered_keywords'] ?? 0 }} / {{ $kpis['total_keywords'] ?? 0 }} записей</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Статус отчёта</p>
                    <p class="metric-value text-lg">
                        @if($hasCoreGaps)
                            Нужна проработка
                        @else
                            Ядро покрыто
                        @endif
                    </p>
                    <p class="metric-sub">фокус: блок «Top gap по семантическому ядру»</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                <h3 class="text-base font-semibold">Яндекс Метрика (7 дней)</h3>
                <x-filament::button wire:click="refreshMetrika" color="gray" size="sm">
                    Обновить Метрику
                </x-filament::button>
            </div>

            @if(!empty($metrika['connected']))
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4 mb-4">
                    <div class="metric-card">
                        <p class="metric-title">Визиты</p>
                        <p class="metric-value">{{ number_format($metrikaSummary['visits'] ?? 0, 0, '.', ' ') }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="metric-title">Пользователи</p>
                        <p class="metric-value">{{ number_format($metrikaSummary['users'] ?? 0, 0, '.', ' ') }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="metric-title">Просмотры</p>
                        <p class="metric-value">{{ number_format($metrikaSummary['pageviews'] ?? 0, 0, '.', ' ') }}</p>
                    </div>
                    <div class="metric-card">
                        <p class="metric-title">Отказы</p>
                        <p class="metric-value">{{ number_format($metrikaSummary['bounce_rate'] ?? 0, 2, '.', ' ') }}%</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                            <th class="py-2 pr-3">Источник</th>
                            <th class="py-2 pr-3">Визиты</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($metrikaSources as $source)
                            <tr class="border-b border-gray-100 dark:border-gray-900">
                                <td class="py-2 pr-3">{{ $source['source'] }}</td>
                                <td class="py-2 pr-3">{{ number_format($source['visits'], 0, '.', ' ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-gray-500">Нет данных по источникам.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-lg border border-amber-300 bg-amber-50 text-amber-900 px-3 py-2 text-sm">
                    {{ $metrika['error'] ?? 'Метрика не подключена.' }}
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4 space-y-4">
            <h3 class="text-base font-semibold">Какие ключи покрывают статьи блога</h3>

            <div class="grid gap-3 md:grid-cols-4 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Приоритет</label>
                    <select wire:model.live="blogPriorityFilter" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        <option value="ALL">Все (A/B/C/D)</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Мин. частотность</label>
                    <input type="number" min="0" step="1" wire:model.live="blogMinFrequency" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm" />
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="blogOnlyUncovered" class="rounded border-gray-300 dark:border-gray-700" />
                        Показывать только непокрытые блогом ключи
                    </label>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="metric-card">
                    <p class="metric-title">Статей в блоге</p>
                    <p class="metric-value">{{ number_format($blogOverview['posts_count'] ?? 0, 0, '.', ' ') }}</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Ключей покрыто блогом</p>
                    <p class="metric-value">{{ number_format($blogOverview['covered_keywords'] ?? 0, 0, '.', ' ') }}</p>
                    <p class="metric-sub">из {{ number_format($blogOverview['total_keywords'] ?? 0, 0, '.', ' ') }}</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Покрытие (ядро)</p>
                    <p class="metric-value">{{ $blogOverview['coverage_percent'] ?? 0 }}%</p>
                </div>
                <div class="metric-card">
                    <p class="metric-title">Взвешенное покрытие</p>
                    <p class="metric-value">{{ $blogOverview['weighted_coverage_percent'] ?? 0 }}%</p>
                    <p class="metric-sub">по частотности Wordstat</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                        <th class="py-2 pr-3">Приоритет</th>
                        <th class="py-2 pr-3">Покрыто / Всего</th>
                        <th class="py-2 pr-3">Покрытие</th>
                        <th class="py-2 pr-3">Взвешенное</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($blogPriorityStats as $row)
                        <tr class="border-b border-gray-100 dark:border-gray-900">
                            <td class="py-2 pr-3"><span class="priority-chip">{{ $row['priority'] }}</span></td>
                            <td class="py-2 pr-3">{{ $row['covered'] }} / {{ $row['total'] }}</td>
                            <td class="py-2 pr-3">{{ $row['coverage_percent'] }}%</td>
                            <td class="py-2 pr-3">{{ $row['weighted_coverage_percent'] }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-gray-500">Нет данных по приоритетам блога.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                        <th class="py-2 pr-3">Ключ</th>
                        <th class="py-2 pr-3">Приоритет</th>
                        <th class="py-2 pr-3">Частотность</th>
                        <th class="py-2 pr-3">
                            @if($this->blogOnlyUncovered)
                                Статус
                            @else
                                Покрывающие статьи
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($blogRowsFiltered as $item)
                        <tr class="border-b border-gray-100 dark:border-gray-900 align-top">
                            <td class="py-2 pr-3">{{ $item['phrase'] }}</td>
                            <td class="py-2 pr-3"><span class="priority-chip">{{ $item['priority'] }}</span></td>
                            <td class="py-2 pr-3">{{ number_format($item['total_count'], 0, '.', ' ') }}</td>
                            <td class="py-2 pr-3">
                                @if($this->blogOnlyUncovered)
                                    <span class="text-red-600">не покрыт блогом</span>
                                @else
                                    <div class="space-y-1">
                                        @foreach($item['posts'] as $post)
                                            <a class="text-primary-600 hover:underline" href="{{ url('/blog/' . $post['slug']) }}" target="_blank" rel="noopener noreferrer">
                                                {{ $post['title'] }}
                                            </a>
                                        @endforeach
                                        @if(($item['posts_count'] ?? 0) > 3)
                                            <div class="text-xs text-gray-500">+ ещё {{ $item['posts_count'] - 3 }}</div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-gray-500">
                                @if($this->blogOnlyUncovered)
                                    По текущим фильтрам непокрытых ключей не найдено.
                                @else
                                    По текущим фильтрам покрытых блогом ключей не найдено.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($hasCoreGaps)
            <div class="rounded-xl border border-red-200 dark:border-red-900 bg-red-50/50 dark:bg-red-950/30 p-4">
                <h3 class="text-base font-semibold mb-2">Что делать в первую очередь</h3>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach($coreCriticalGaps as $gap)
                        <li>
                            <span class="font-semibold">[{{ $gap['priority'] }}]</span>
                            {{ $gap['phrase'] }}
                            <span class="text-gray-500">({{ number_format($gap['total_count'], 0, '.', ' ') }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4 overflow-x-auto">
            <h3 class="text-base font-semibold mb-3">Покрытие по приоритетам ядра (A/B/C/D)</h3>
            <div class="space-y-3">
                @forelse($priorityStats as $row)
                    @php
                        $barClass = match($row['priority']) {
                            'A' => 'bar--a',
                            'B' => 'bar--b',
                            'C' => 'bar--c',
                            default => 'bar--d',
                        };
                    @endphp
                    <div class="priority-row">
                        <div class="priority-head">
                            <div class="priority-chip">{{ $row['priority'] }}</div>
                            <div class="text-sm font-medium">
                                {{ $row['covered'] }} / {{ $row['total'] }}
                                <span class="text-gray-500">(взвешенно {{ $row['weighted_coverage_percent'] }}%)</span>
                            </div>
                            <div class="text-sm font-semibold">{{ $row['coverage_percent'] }}%</div>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill {{ $barClass }}" style="width: {{ $row['coverage_percent'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Нет данных по приоритетам ядра.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4 overflow-x-auto">
            <h3 class="text-base font-semibold mb-3">Top gap по семантическому ядру</h3>
            <table class="w-full text-sm">
                <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                    <th class="py-2 pr-3">Приоритет</th>
                    <th class="py-2 pr-3">Запрос</th>
                    <th class="py-2 pr-3">Частотность</th>
                    <th class="py-2 pr-3">Статус</th>
                    <th class="py-2 pr-3">Target URL</th>
                </tr>
                </thead>
                <tbody>
                @forelse($coreTopGaps as $gap)
                    <tr class="border-b border-gray-100 dark:border-gray-900">
                        <td class="py-2 pr-3"><span class="priority-chip">{{ $gap['priority'] }}</span></td>
                        <td class="py-2 pr-3">{{ $gap['phrase'] }}</td>
                        <td class="py-2 pr-3">{{ number_format($gap['total_count'], 0, '.', ' ') }}</td>
                        <td class="py-2 pr-3">
                            @if($gap['status'] === 'partial')
                                <span class="text-amber-600">partial</span>
                            @else
                                <span class="text-red-600">missing</span>
                            @endif
                        </td>
                        <td class="py-2 pr-3 text-xs">{{ $gap['target_url'] ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">По ядру нет разрывов — красота.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4 overflow-x-auto">
            <h3 class="text-base font-semibold mb-1">Топ ключей с наибольшим gap (локальная SEO-база)</h3>
            <p class="text-xs text-gray-500 mb-3">
                Этот блок строится только по таблице <code>seo_keyword_pages</code> (активные записи).
                Для полного ядра A/B/C/D используйте блок выше «Top gap по семантическому ядру».
            </p>
            @if($hasLocalGaps)
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                        <th class="py-2 pr-3">Ключ</th>
                        <th class="py-2 pr-3">Кластер</th>
                        <th class="py-2 pr-3">URL</th>
                        <th class="py-2 pr-3">Частотность</th>
                        <th class="py-2 pr-3">Статус</th>
                        <th class="py-2 pr-3">Приоритет</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topGaps as $item)
                        <tr class="border-b border-gray-100 dark:border-gray-900">
                            <td class="py-2 pr-3">{{ $item['keyword'] }}</td>
                            <td class="py-2 pr-3">{{ $item['cluster'] }}</td>
                            <td class="py-2 pr-3 text-xs">{{ $item['target_url'] ?: '-' }}</td>
                            <td class="py-2 pr-3">{{ number_format($item['frequency'], 0, '.', ' ') }}</td>
                            <td class="py-2 pr-3">
                                @if($item['coverage_status'] === 'covered')
                                    <span class="text-green-600">covered</span>
                                @elseif($item['coverage_status'] === 'partial')
                                    <span class="text-amber-600">partial</span>
                                @else
                                    <span class="text-red-600">missing</span>
                                @endif
                            </td>
                            <td class="py-2 pr-3">{{ number_format($item['priority_score'], 0, '.', ' ') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="rounded-lg border border-green-300 bg-green-50 text-green-900 px-3 py-2 text-sm">
                    В локальной SEO-базе gaps не обнаружены.
                    @if($hasCoreGaps)
                        По полному ядру всё ещё есть {{ $coreOverview['missing_core_keywords'] }} непокрытых ключей — ориентируйтесь на блок «Top gap по семантическому ядру».
                    @endif
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 p-4 overflow-x-auto">
            <h3 class="text-base font-semibold mb-1">Покрытие по кластерам (локальная SEO-база)</h3>
            <p class="text-xs text-gray-500 mb-3">
                Считается по активным записям <code>seo_keyword_pages</code>.
            </p>
            <table class="w-full text-sm">
                <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-800">
                    <th class="py-2 pr-3">Кластер</th>
                    <th class="py-2 pr-3">Покрытие</th>
                    <th class="py-2 pr-3">Покрыто / Всего</th>
                    <th class="py-2 pr-3">Суммарная частотность</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clusterStats as $cluster)
                    <tr class="border-b border-gray-100 dark:border-gray-900">
                        <td class="py-2 pr-3">{{ $cluster['cluster'] }}</td>
                        <td class="py-2 pr-3">{{ $cluster['coverage_percent'] }}%</td>
                        <td class="py-2 pr-3">{{ $cluster['covered'] }} / {{ $cluster['total'] }}</td>
                        <td class="py-2 pr-3">{{ number_format($cluster['total_frequency'], 0, '.', ' ') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">
                            Нет данных по кластерам. Проверьте, что в <code>seo_keyword_pages</code> есть активные записи и выполнен аудит.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .semantic-dashboard .metric-card {
            border: 1px solid #d6d9df;
            border-radius: 14px;
            background: #fff;
            padding: 1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
        }

        .semantic-dashboard .metric-card--highlight {
            background: linear-gradient(135deg, #fff7ed 0%, #fffbeb 100%);
            border-color: #f59e0b;
        }

        .semantic-dashboard .metric-title {
            font-size: .85rem;
            color: #64748b;
            margin-bottom: .25rem;
        }

        .semantic-dashboard .metric-value {
            font-size: 1.75rem;
            line-height: 1.1;
            font-weight: 800;
            color: #0f172a;
        }

        .semantic-dashboard .metric-sub {
            font-size: .76rem;
            color: #64748b;
            margin-top: .3rem;
        }

        .semantic-dashboard .priority-row {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: .65rem .8rem;
        }

        .semantic-dashboard .priority-head {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: .7rem;
            margin-bottom: .55rem;
        }

        .semantic-dashboard .priority-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 1.7rem;
            height: 1.7rem;
            border-radius: 999px;
            background: #0f172a;
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
        }

        .semantic-dashboard .progress-track {
            height: .58rem;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .semantic-dashboard .progress-fill {
            height: 100%;
            border-radius: 999px;
            transition: width .25s ease;
        }

        .semantic-dashboard .bar--a { background: linear-gradient(90deg, #ef4444, #f97316); }
        .semantic-dashboard .bar--b { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .semantic-dashboard .bar--c { background: linear-gradient(90deg, #84cc16, #22c55e); }
        .semantic-dashboard .bar--d { background: linear-gradient(90deg, #06b6d4, #3b82f6); }

        .dark .semantic-dashboard .metric-card {
            background: #0f172a;
            border-color: #334155;
        }

        .dark .semantic-dashboard .metric-card--highlight {
            background: linear-gradient(135deg, #1e293b 0%, #111827 100%);
            border-color: #f59e0b;
        }

        .dark .semantic-dashboard .metric-value { color: #f8fafc; }
        .dark .semantic-dashboard .metric-title,
        .dark .semantic-dashboard .metric-sub { color: #94a3b8; }

        .dark .semantic-dashboard .priority-row { border-color: #334155; }
        .dark .semantic-dashboard .progress-track { background: #334155; }
    </style>
</x-filament-panels::page>
