<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\SeoKeywordPage;
use App\Models\UserPage;
use App\Support\SeoDKeywordLanding;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SemanticCoverageAuditService
{
    private const CORE_PRIORITY_ORDER = ['A', 'B', 'C', 'D'];

    /**
     * @return array<string, mixed>
     */
    public function runAudit(): array
    {
        $dSlugMap = SeoDKeywordLanding::bySlugMap();
        $staticPaths = $this->staticLandingPaths();
        $publishedUserPageSlugs = UserPage::query()
            ->published()
            ->pluck('slug')
            ->map(fn (string $slug): string => '/pages/' . trim($slug))
            ->all();

        $knownPaths = array_fill_keys(array_merge($staticPaths, $publishedUserPageSlugs), true);

        $now = now();

        SeoKeywordPage::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->chunkById(200, function (Collection $rows) use ($dSlugMap, $knownPaths, $now): void {
                foreach ($rows as $row) {
                    $targetPath = $this->resolveTargetPath($row, $dSlugMap);
                    $hasLanding = $this->detectLandingPresence($targetPath, $knownPaths, $dSlugMap);
                    $hasMeta = $this->hasMeta($row);
                    $hasContent = $this->hasContent($row);

                    $status = $this->resolveStatus($hasLanding, $hasMeta, $hasContent);
                    $priorityScore = $this->priorityScore((int) $row->frequency, $status);

                    $row->forceFill([
                        'target_url' => $targetPath,
                        'has_landing_page' => $hasLanding,
                        'has_meta' => $hasMeta,
                        'has_content' => $hasContent,
                        'coverage_status' => $status,
                        'priority_score' => $priorityScore,
                        'last_audit_at' => $now,
                    ])->save();
                }
            });

        return $this->overview();
    }

    /**
     * @return array<string, mixed>
     */
    public function overview(): array
    {
        $query = SeoKeywordPage::query()->where('is_active', true);
        $total = (int) $query->count();

        $covered = (int) (clone $query)->where('coverage_status', 'covered')->count();
        $partial = (int) (clone $query)->where('coverage_status', 'partial')->count();
        $missing = (int) (clone $query)->where('coverage_status', 'missing')->count();

        $totalFrequency = (int) (clone $query)->sum('frequency');
        $coveredFrequency = (int) (clone $query)
            ->where('coverage_status', 'covered')
            ->sum('frequency');

        $coveragePercent = $total > 0 ? round(($covered / $total) * 100, 1) : 0.0;
        $weightedCoveragePercent = $totalFrequency > 0
            ? round(($coveredFrequency / $totalFrequency) * 100, 1)
            : 0.0;

        $lastAuditAt = (clone $query)->max('last_audit_at');

        $topGaps = (clone $query)
            ->whereIn('coverage_status', ['missing', 'partial'])
            ->orderByDesc('priority_score')
            ->orderByDesc('frequency')
            ->limit(50)
            ->get([
                'id',
                'keyword',
                'cluster',
                'used_for',
                'target_url',
                'frequency',
                'coverage_status',
                'has_landing_page',
                'has_meta',
                'has_content',
                'priority_score',
            ])
            ->map(function (SeoKeywordPage $row): array {
                return [
                    'id' => (int) $row->id,
                    'keyword' => (string) $row->keyword,
                    'cluster' => (string) $row->cluster,
                    'used_for' => (string) $row->used_for,
                    'target_url' => (string) ($row->target_url ?? ''),
                    'frequency' => (int) $row->frequency,
                    'coverage_status' => (string) $row->coverage_status,
                    'has_landing_page' => (bool) $row->has_landing_page,
                    'has_meta' => (bool) $row->has_meta,
                    'has_content' => (bool) $row->has_content,
                    'priority_score' => (int) $row->priority_score,
                ];
            })
            ->values()
            ->all();

        $clusterStats = (clone $query)
            ->selectRaw('cluster')
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when coverage_status = 'covered' then 1 else 0 end) as covered")
            ->selectRaw('sum(frequency) as total_frequency')
            ->groupBy('cluster')
            ->orderByRaw('sum(frequency) desc')
            ->get()
            ->map(function ($row) {
                $total = (int) $row->total;
                $covered = (int) $row->covered;

                return [
                    'cluster' => (string) $row->cluster,
                    'total' => $total,
                    'covered' => $covered,
                    'coverage_percent' => $total > 0 ? round(($covered / $total) * 100, 1) : 0.0,
                    'total_frequency' => (int) $row->total_frequency,
                ];
            })
            ->take(20)
            ->values()
            ->all();

        $coreAnalytics = $this->buildCoreAnalytics();
        $blogCoverage = $this->buildBlogCoverageAnalytics();

        return [
            'kpis' => [
                'total_keywords' => $total,
                'covered_keywords' => $covered,
                'partial_keywords' => $partial,
                'missing_keywords' => $missing,
                'coverage_percent' => $coveragePercent,
                'weighted_coverage_percent' => $weightedCoveragePercent,
                'total_frequency' => $totalFrequency,
                'covered_frequency' => $coveredFrequency,
                'last_audit_at' => $lastAuditAt,
            ],
            'top_gaps' => $topGaps,
            'cluster_stats' => $clusterStats,
            'core_priority_stats' => $coreAnalytics['priority_stats'],
            'core_top_gaps' => $coreAnalytics['top_gaps'],
            'core_overview' => $coreAnalytics['overview'],
            'blog_coverage' => $blogCoverage,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildBlogCoverageAnalytics(): array
    {
        $coreRows = $this->loadSemanticCoreRows();
        $totalKeywords = count($coreRows);

        $posts = BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->get(['id', 'title', 'slug', 'excerpt', 'content']);

        $normalizedPosts = $posts->map(function (BlogPost $post): array {
            $text = $this->normalizePhrase(
                html_entity_decode(
                    strip_tags(trim((string) $post->title . ' ' . (string) $post->excerpt . ' ' . (string) $post->content)),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                )
            );

            return [
                'id' => (int) $post->id,
                'title' => (string) $post->title,
                'slug' => (string) $post->slug,
                'text' => $text,
            ];
        })->values()->all();

        $priorityBuckets = [];
        foreach (self::CORE_PRIORITY_ORDER as $priority) {
            $priorityBuckets[$priority] = [
                'priority' => $priority,
                'total' => 0,
                'covered' => 0,
                'total_frequency' => 0,
                'covered_frequency' => 0,
            ];
        }

        $coveredKeywords = [];
        $uncoveredKeywords = [];
        $coveredCount = 0;
        $totalFrequency = 0;
        $coveredFrequency = 0;

        foreach ($coreRows as $row) {
            $priority = (string) ($row['priority'] ?? 'D');
            $phrase = (string) ($row['phrase'] ?? '');
            $count = (int) ($row['totalCount'] ?? 0);

            if (! isset($priorityBuckets[$priority])) {
                continue;
            }

            $priorityBuckets[$priority]['total']++;
            $priorityBuckets[$priority]['total_frequency'] += $count;
            $totalFrequency += $count;

            $needle = $this->normalizePhrase($phrase);
            if ($needle === '') {
                continue;
            }

            $matchedPosts = [];
            foreach ($normalizedPosts as $post) {
                if ($post['text'] !== '' && mb_stripos($post['text'], $needle) !== false) {
                    $matchedPosts[] = [
                        'title' => $post['title'],
                        'slug' => $post['slug'],
                    ];
                }
            }

            if ($matchedPosts !== []) {
                $coveredCount++;
                $coveredFrequency += $count;
                $priorityBuckets[$priority]['covered']++;
                $priorityBuckets[$priority]['covered_frequency'] += $count;

                $coveredKeywords[] = [
                    'priority' => $priority,
                    'phrase' => $phrase,
                    'total_count' => $count,
                    'posts_count' => count($matchedPosts),
                    'posts' => array_slice($matchedPosts, 0, 3),
                ];
            } else {
                $uncoveredKeywords[] = [
                    'priority' => $priority,
                    'phrase' => $phrase,
                    'total_count' => $count,
                    'posts_count' => 0,
                    'posts' => [],
                ];
            }
        }

        usort($coveredKeywords, function (array $a, array $b): int {
            $pa = array_search($a['priority'], self::CORE_PRIORITY_ORDER, true);
            $pb = array_search($b['priority'], self::CORE_PRIORITY_ORDER, true);
            $pa = $pa === false ? 999 : $pa;
            $pb = $pb === false ? 999 : $pb;

            if ($pa !== $pb) {
                return $pa <=> $pb;
            }

            return ((int) $b['total_count']) <=> ((int) $a['total_count']);
        });

        usort($uncoveredKeywords, function (array $a, array $b): int {
            $pa = array_search($a['priority'], self::CORE_PRIORITY_ORDER, true);
            $pb = array_search($b['priority'], self::CORE_PRIORITY_ORDER, true);
            $pa = $pa === false ? 999 : $pa;
            $pb = $pb === false ? 999 : $pb;

            if ($pa !== $pb) {
                return $pa <=> $pb;
            }

            return ((int) $b['total_count']) <=> ((int) $a['total_count']);
        });

        $priorityStats = collect(self::CORE_PRIORITY_ORDER)
            ->map(function (string $priority) use ($priorityBuckets): array {
                $item = $priorityBuckets[$priority];
                $total = (int) $item['total'];
                $covered = (int) $item['covered'];
                $totalFrequency = (int) $item['total_frequency'];
                $coveredFrequency = (int) $item['covered_frequency'];

                return [
                    ...$item,
                    'coverage_percent' => $total > 0 ? round(($covered / $total) * 100, 1) : 0.0,
                    'weighted_coverage_percent' => $totalFrequency > 0
                        ? round(($coveredFrequency / $totalFrequency) * 100, 1)
                        : 0.0,
                ];
            })
            ->values()
            ->all();

        return [
            'overview' => [
                'posts_count' => count($normalizedPosts),
                'total_keywords' => $totalKeywords,
                'covered_keywords' => $coveredCount,
                'coverage_percent' => $totalKeywords > 0 ? round(($coveredCount / $totalKeywords) * 100, 1) : 0.0,
                'total_frequency' => $totalFrequency,
                'covered_frequency' => $coveredFrequency,
                'weighted_coverage_percent' => $totalFrequency > 0
                    ? round(($coveredFrequency / $totalFrequency) * 100, 1)
                    : 0.0,
            ],
            'priority_stats' => $priorityStats,
            'covered_keywords' => array_slice($coveredKeywords, 0, 80),
            'uncovered_keywords' => array_slice($uncoveredKeywords, 0, 200),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildCoreAnalytics(): array
    {
        $coreRows = $this->loadSemanticCoreRows();

        $seoRowsByKeyword = SeoKeywordPage::query()
            ->where('is_active', true)
            ->get(['keyword', 'coverage_status', 'target_url'])
            ->mapWithKeys(function (SeoKeywordPage $row): array {
                return [$this->normalizePhrase((string) $row->keyword) => $row];
            });

        $priorityBuckets = [];
        foreach (self::CORE_PRIORITY_ORDER as $priority) {
            $priorityBuckets[$priority] = [
                'priority' => $priority,
                'total' => 0,
                'covered' => 0,
                'partial' => 0,
                'missing' => 0,
                'total_frequency' => 0,
                'covered_frequency' => 0,
            ];
        }

        $topGaps = [];
        $totalCoreKeywords = 0;
        $totalCoreFrequency = 0;
        $coveredCoreKeywords = 0;
        $coveredCoreFrequency = 0;

        foreach ($coreRows as $row) {
            $priority = (string) ($row['priority'] ?? 'D');
            if (! isset($priorityBuckets[$priority])) {
                continue;
            }

            $phrase = (string) ($row['phrase'] ?? '');
            $count = (int) ($row['totalCount'] ?? 0);
            $normPhrase = $this->normalizePhrase($phrase);

            /** @var SeoKeywordPage|null $matched */
            $matched = $normPhrase !== '' ? ($seoRowsByKeyword[$normPhrase] ?? null) : null;
            $status = $matched?->coverage_status ?: 'missing';

            $priorityBuckets[$priority]['total']++;
            $priorityBuckets[$priority]['total_frequency'] += $count;

            $totalCoreKeywords++;
            $totalCoreFrequency += $count;

            if ($status === 'covered') {
                $priorityBuckets[$priority]['covered']++;
                $priorityBuckets[$priority]['covered_frequency'] += $count;
                $coveredCoreKeywords++;
                $coveredCoreFrequency += $count;
            } elseif ($status === 'partial') {
                $priorityBuckets[$priority]['partial']++;
            } else {
                $priorityBuckets[$priority]['missing']++;
            }

            if ($status !== 'covered') {
                $topGaps[] = [
                    'priority' => $priority,
                    'phrase' => $phrase,
                    'total_count' => $count,
                    'status' => $status,
                    'target_url' => $matched?->target_url,
                    'matched_keyword' => $matched?->keyword,
                ];
            }
        }

        $priorityStats = collect(self::CORE_PRIORITY_ORDER)
            ->map(function (string $priority) use ($priorityBuckets): array {
                $item = $priorityBuckets[$priority];
                $total = (int) $item['total'];
                $covered = (int) $item['covered'];
                $totalFrequency = (int) $item['total_frequency'];
                $coveredFrequency = (int) $item['covered_frequency'];

                return [
                    ...$item,
                    'coverage_percent' => $total > 0 ? round(($covered / $total) * 100, 1) : 0.0,
                    'weighted_coverage_percent' => $totalFrequency > 0
                        ? round(($coveredFrequency / $totalFrequency) * 100, 1)
                        : 0.0,
                ];
            })
            ->values();

        usort($topGaps, function (array $a, array $b): int {
            $pa = array_search($a['priority'], self::CORE_PRIORITY_ORDER, true);
            $pb = array_search($b['priority'], self::CORE_PRIORITY_ORDER, true);
            $pa = $pa === false ? 999 : $pa;
            $pb = $pb === false ? 999 : $pb;

            if ($pa !== $pb) {
                return $pa <=> $pb;
            }

            return ((int) $b['total_count']) <=> ((int) $a['total_count']);
        });

        return [
            'overview' => [
                'total_core_keywords' => $totalCoreKeywords,
                'covered_core_keywords' => $coveredCoreKeywords,
                'missing_core_keywords' => max($totalCoreKeywords - $coveredCoreKeywords, 0),
                'core_coverage_percent' => $totalCoreKeywords > 0
                    ? round(($coveredCoreKeywords / $totalCoreKeywords) * 100, 1)
                    : 0.0,
                'total_core_frequency' => $totalCoreFrequency,
                'covered_core_frequency' => $coveredCoreFrequency,
                'core_weighted_coverage_percent' => $totalCoreFrequency > 0
                    ? round(($coveredCoreFrequency / $totalCoreFrequency) * 100, 1)
                    : 0.0,
            ],
            'priority_stats' => $priorityStats->all(),
            'top_gaps' => collect($topGaps)->take(80)->values()->all(),
        ];
    }

    /**
     * @return array<int, array{priority:string, phrase:string, totalCount:int}>
     */
    private function loadSemanticCoreRows(): array
    {
        $path = base_path('SEO/SEO_SEMANTIC_CORE.md');
        if (! is_file($path)) {
            return [];
        }

        $raw = file_get_contents($path);
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $rows = [];
        $inPriorityTable = false;

        foreach (preg_split('/\R/u', $raw) as $line) {
            $line = trim((string) $line);

            if (Str::startsWith($line, '## Приоритизированный список запросов')) {
                $inPriorityTable = true;
                continue;
            }

            if (! $inPriorityTable) {
                continue;
            }

            if ($line === '') {
                continue;
            }

            if (Str::startsWith($line, '## ')) {
                break;
            }

            if (! Str::startsWith($line, '|')) {
                continue;
            }

            if (Str::contains($line, '| Приоритет | Запрос |') || Str::contains($line, '|---|---|---:|')) {
                continue;
            }

            if (! preg_match('/^\|\s*([A-D])\s*\|\s*(.*?)\s*\|\s*(\d+)\s*\|$/u', $line, $m)) {
                continue;
            }

            $rows[] = [
                'priority' => trim($m[1]),
                'phrase' => trim($m[2]),
                'totalCount' => (int) $m[3],
            ];
        }

        return $rows;
    }

    private function normalizePhrase(string $phrase): string
    {
        $value = mb_strtolower(trim($phrase));
        $value = str_replace(['ё', '-', '—'], ['е', ' ', ' '], $value);
        $value = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $value) ?? $value;
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return trim($value);
    }

    /**
     * @param array<string, array<string, mixed>> $dSlugMap
     */
    private function resolveTargetPath(SeoKeywordPage $row, array $dSlugMap): string
    {
        $usedFor = trim((string) ($row->used_for ?? ''));

        if ($usedFor !== '') {
            return Str::start($usedFor, '/');
        }

        $slug = Str::slug((string) $row->keyword, '-', 'ru');
        if ($slug !== '' && isset($dSlugMap[$slug])) {
            return '/d/' . $slug;
        }

        return '/';
    }

    /**
     * @param array<string, bool> $knownPaths
     * @param array<string, array<string, mixed>> $dSlugMap
     */
    private function detectLandingPresence(string $targetPath, array $knownPaths, array $dSlugMap): bool
    {
        if (isset($knownPaths[$targetPath])) {
            return true;
        }

        if (Str::startsWith($targetPath, '/d/')) {
            $slug = Str::after($targetPath, '/d/');

            return $slug !== '' && isset($dSlugMap[$slug]);
        }

        return false;
    }

    private function hasMeta(SeoKeywordPage $row): bool
    {
        $title = trim((string) ($row->title ?? ''));
        $h1 = trim((string) ($row->h1 ?? ''));
        $metaTitle = trim((string) ($row->meta_title ?? ''));
        $metaDescription = trim((string) ($row->meta_description ?? ''));

        return $title !== ''
            && $h1 !== ''
            && $metaTitle !== ''
            && mb_strlen($metaDescription) >= 80;
    }

    private function hasContent(SeoKeywordPage $row): bool
    {
        $description = trim((string) ($row->description ?? ''));

        return mb_strlen($description) >= 120;
    }

    private function resolveStatus(bool $hasLanding, bool $hasMeta, bool $hasContent): string
    {
        if ($hasLanding && $hasMeta && $hasContent) {
            return 'covered';
        }

        if ($hasLanding && ($hasMeta || $hasContent)) {
            return 'partial';
        }

        return 'missing';
    }

    private function priorityScore(int $frequency, string $status): int
    {
        return match ($status) {
            'missing' => $frequency * 2,
            'partial' => $frequency,
            default => 0,
        };
    }

    /**
     * @return array<int, string>
     */
    private function staticLandingPaths(): array
    {
        return [
            '/',
            '/privacy',
            '/razrabotka-saitov-pod-klyuch',
            '/razrabotka-veb-prilozheniy',
            '/razrabotka-mobilnyh-prilozheniy',
            '/razrabotka-internet-magazina',
            '/tehnicheskaya-podderzhka-sayta',
            '/d',
            '/blog',
        ];
    }
}
