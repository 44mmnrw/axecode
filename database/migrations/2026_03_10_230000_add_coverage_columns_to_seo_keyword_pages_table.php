<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_keyword_pages', function (Blueprint $table): void {
            $table->string('target_url')->nullable()->after('used_for');
            $table->string('coverage_status')->default('missing')->after('is_active');
            $table->boolean('has_landing_page')->default(false)->after('coverage_status');
            $table->boolean('has_meta')->default(false)->after('has_landing_page');
            $table->boolean('has_content')->default(false)->after('has_meta');
            $table->unsignedBigInteger('priority_score')->default(0)->after('has_content');
            $table->timestamp('last_audit_at')->nullable()->after('priority_score');

            $table->index('coverage_status');
            $table->index('priority_score');
            $table->index('last_audit_at');
        });
    }

    public function down(): void
    {
        Schema::table('seo_keyword_pages', function (Blueprint $table): void {
            $table->dropIndex(['coverage_status']);
            $table->dropIndex(['priority_score']);
            $table->dropIndex(['last_audit_at']);

            $table->dropColumn([
                'target_url',
                'coverage_status',
                'has_landing_page',
                'has_meta',
                'has_content',
                'priority_score',
                'last_audit_at',
            ]);
        });
    }
};
