<?php

use App\Services\SemanticCoverageAuditService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seo:audit-coverage', function (SemanticCoverageAuditService $auditService) {
    $data = $auditService->runAudit();
    $kpis = $data['kpis'] ?? [];

    $this->info('SEO coverage audit completed.');
    $this->line('Coverage: ' . ($kpis['coverage_percent'] ?? 0) . '%');
    $this->line('Weighted coverage: ' . ($kpis['weighted_coverage_percent'] ?? 0) . '%');
    $this->line('Missing: ' . ($kpis['missing_keywords'] ?? 0));
    $this->line('Partial: ' . ($kpis['partial_keywords'] ?? 0));
    $this->line('Covered: ' . ($kpis['covered_keywords'] ?? 0));
})->purpose('Run semantic core coverage audit and refresh KPI fields');
