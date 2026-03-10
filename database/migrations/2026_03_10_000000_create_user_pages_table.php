<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $legacyPrivacyContent = DB::table('settings')->where('key', 'privacy_policy')->value('value');

        DB::table('user_pages')->insert([
            'title' => 'Политика конфиденциальности',
            'slug' => 'privacy',
            'content' => is_string($legacyPrivacyContent) && $legacyPrivacyContent !== ''
                ? $legacyPrivacyContent
                : '<h1>Политика конфиденциальности</h1><p>Заполните содержание страницы в админ-панели.</p>',
            'seo_title' => 'Политика конфиденциальности — Axecode',
            'seo_description' => 'Политика конфиденциальности и обработки персональных данных сайта axecode.tech',
            'is_published' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('user_pages');
    }
};
