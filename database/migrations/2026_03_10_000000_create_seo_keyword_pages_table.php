<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_keyword_pages', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique();
            $table->string('cluster');
            $table->string('used_for');
            $table->unsignedInteger('frequency');

            $table->string('title')->nullable();
            $table->string('h1')->nullable();
            $table->string('h2')->nullable();
            $table->text('description')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->json('meta_fields')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['cluster', 'frequency']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keyword_pages');
    }
};
