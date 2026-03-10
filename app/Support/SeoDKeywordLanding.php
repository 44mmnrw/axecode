<?php

namespace App\Support;

use Illuminate\Support\Str;

class SeoDKeywordLanding
{
    public static function allRows(): array
    {
        $decoded = self::loadRowsFromSnapshotJson();
        if ($decoded === []) {
            $decoded = self::loadRowsFromSemanticCoreMarkdown();
        }

        if ($decoded === []) {
            return [];
        }

        $rows = array_values(array_filter($decoded, function ($row): bool {
            if (! is_array($row)) {
                return false;
            }

            $priority = (string) ($row['priority'] ?? '');
            $count = (int) ($row['totalCount'] ?? 0);
            $phrase = trim((string) ($row['phrase'] ?? ''));

            return $priority === 'D' && $count > 0 && $phrase !== '';
        }));

        usort($rows, static function (array $a, array $b): int {
            return ((int) ($b['totalCount'] ?? 0)) <=> ((int) ($a['totalCount'] ?? 0));
        });

        return $rows;
    }

    private static function loadRowsFromSnapshotJson(): array
    {
        $snapshotPath = self::latestSnapshotPath();

        if ($snapshotPath === null) {
            return [];
        }

        $raw = file_get_contents($snapshotPath);
        if ($raw === false) {
            return [];
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }

    private static function loadRowsFromSemanticCoreMarkdown(): array
    {
        $corePath = base_path('SEO/SEO_SEMANTIC_CORE.md');
        if (! is_file($corePath)) {
            return [];
        }

        $raw = file_get_contents($corePath);
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $rows = [];
        $inPriorityTable = false;

        foreach (preg_split('/\R/u', $raw) as $line) {
            $trimmed = trim((string) $line);

            if (Str::startsWith($trimmed, '## Приоритизированный список запросов')) {
                $inPriorityTable = true;
                continue;
            }

            if (! $inPriorityTable) {
                continue;
            }

            if ($trimmed === '' || Str::startsWith($trimmed, '## ')) {
                if ($trimmed !== '') {
                    break;
                }

                continue;
            }

            if (! Str::startsWith($trimmed, '|')) {
                continue;
            }

            // Пропускаем заголовок/разделитель таблицы.
            if (Str::contains($trimmed, '| Приоритет | Запрос |') || Str::contains($trimmed, '|---|---|---:|')) {
                continue;
            }

            if (! preg_match('/^\|\s*([A-D])\s*\|\s*(.*?)\s*\|\s*(\d+)\s*\|$/u', $trimmed, $matches)) {
                continue;
            }

            $rows[] = [
                'priority' => $matches[1],
                'phrase' => trim($matches[2]),
                'totalCount' => (int) $matches[3],
            ];
        }

        return $rows;
    }

    public static function bySlugMap(): array
    {
        $rows = self::allRows();
        $bySlug = [];

        foreach ($rows as $row) {
            $phrase = trim((string) ($row['phrase'] ?? ''));
            if ($phrase === '') {
                continue;
            }

            $baseSlug = Str::slug($phrase, '-', 'ru');
            if ($baseSlug === '') {
                $baseSlug = 'query-' . substr(md5($phrase), 0, 8);
            }

            $slug = $baseSlug;
            $suffix = 2;
            while (isset($bySlug[$slug])) {
                $slug = $baseSlug . '-' . $suffix;
                $suffix++;
            }

            $bySlug[$slug] = [
                'slug' => $slug,
                'phrase' => $phrase,
                'totalCount' => (int) ($row['totalCount'] ?? 0),
                'priority' => 'D',
            ];
        }

        return $bySlug;
    }

    private static function latestSnapshotPath(): ?string
    {
        $files = glob(storage_path('app/wordstat_semantic_snapshot_*.json'));
        if (! is_array($files) || $files === []) {
            return null;
        }

        rsort($files, SORT_STRING);

        return $files[0] ?? null;
    }
}
