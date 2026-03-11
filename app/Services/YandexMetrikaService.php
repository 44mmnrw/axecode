<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Throwable;

class YandexMetrikaService
{
    /**
     * @return array<string, mixed>
     */
    public function getDashboardData(): array
    {
        $counterId = trim((string) Setting::get('yandex_metrika_id', ''));
        $token = trim((string) config('services.yandex_metrika.access_token'));

        if ($counterId === '') {
            return [
                'connected' => false,
                'error' => 'Не задан ID счётчика Яндекс Метрики в настройках аналитики.',
                'summary' => [],
                'sources' => [],
            ];
        }

        if ($token === '') {
            return [
                'connected' => false,
                'error' => 'Отсутствует YANDEX_METRIKA_ACCESS_TOKEN в .env.',
                'summary' => [],
                'sources' => [],
            ];
        }

        $summary = $this->fetchSummary($counterId, $token);
        $sources = $this->fetchSources($counterId, $token);

        if (! empty($summary['error'])) {
            return [
                'connected' => false,
                'error' => $summary['error'],
                'summary' => [],
                'sources' => [],
            ];
        }

        return [
            'connected' => true,
            'error' => null,
            'summary' => [
                'visits' => $summary['visits'] ?? 0,
                'users' => $summary['users'] ?? 0,
                'pageviews' => $summary['pageviews'] ?? 0,
                'bounce_rate' => $summary['bounce_rate'] ?? 0,
            ],
            'sources' => $sources['sources'] ?? [],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchSummary(string $counterId, string $token): array
    {
        try {
            $response = $this->httpClient($token)
                ->get('https://api-metrika.yandex.net/stat/v1/data', [
                    'ids' => $counterId,
                    'date1' => '7daysAgo',
                    'date2' => 'today',
                    'metrics' => 'ym:s:visits,ym:s:users,ym:s:pageviews,ym:s:bounceRate',
                    'accuracy' => 'full',
                    'limit' => 1,
                ]);
        } catch (Throwable $e) {
            return [
                'error' => 'Ошибка подключения к API Метрики: ' . $e->getMessage(),
            ];
        }

        if (! $response->successful()) {
            return [
                'error' => 'Ошибка запроса к Метрике: HTTP ' . $response->status() . ' ' . $response->body(),
            ];
        }

        $json = $response->json();
        $totals = $json['totals'] ?? [];

        return [
            'visits' => (int) round((float) ($totals[0] ?? 0)),
            'users' => (int) round((float) ($totals[1] ?? 0)),
            'pageviews' => (int) round((float) ($totals[2] ?? 0)),
            'bounce_rate' => round((float) ($totals[3] ?? 0), 2),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchSources(string $counterId, string $token): array
    {
        try {
            $response = $this->httpClient($token)
                ->get('https://api-metrika.yandex.net/stat/v1/data', [
                    'ids' => $counterId,
                    'date1' => '7daysAgo',
                    'date2' => 'today',
                    'dimensions' => 'ym:s:lastTrafficSource',
                    'metrics' => 'ym:s:visits',
                    'sort' => '-ym:s:visits',
                    'limit' => 5,
                    'accuracy' => 'full',
                ]);
        } catch (Throwable) {
            return ['sources' => []];
        }

        if (! $response->successful()) {
            return ['sources' => []];
        }

        $json = $response->json();
        $rows = $json['data'] ?? [];

        $sources = [];
        foreach ($rows as $row) {
            $name = (string) ($row['dimensions'][0]['name'] ?? '—');
            $visits = (int) round((float) ($row['metrics'][0] ?? 0));

            $sources[] = [
                'source' => $name,
                'visits' => $visits,
            ];
        }

        return ['sources' => $sources];
    }

    private function httpClient(string $token): PendingRequest
    {
        $request = Http::timeout(20)
            ->withHeaders([
                    'Authorization' => 'OAuth ' . $token,
                    'Accept' => 'application/json',
            ]);

        if (app()->environment('local')) {
            $request = $request->withoutVerifying();
        }

        return $request;
    }
}
