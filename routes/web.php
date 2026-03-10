<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserPageController;
use App\Models\UserPage;

Route::get('/', function () {
    return view('app');
});

// Публичные пользовательские страницы
Route::get('/privacy', [UserPageController::class, 'showBySlug'])
    ->defaults('slug', 'privacy');

Route::get('/pages/{slug}', [UserPageController::class, 'showBySlug'])
    ->where('slug', '[A-Za-z0-9\-]+');

// SEO посадочная: разработка сайтов
Route::get('/razrabotka-saitov-pod-klyuch', function () {
    return view('landing.site-development');
});

// SEO посадочная: веб-приложения
Route::get('/razrabotka-veb-prilozheniy', function () {
    return view('landing.web-app-development');
});

// SEO посадочная: мобильная разработка
Route::get('/razrabotka-mobilnyh-prilozheniy', function () {
    return view('landing.mobile-development');
});

// Sitemap
Route::get('/sitemap.xml', function () {
    $url = config('app.url');
    $lastmod = now()->toAtomString();

    $pagesXml = UserPage::query()
        ->published()
        ->get(['slug', 'updated_at'])
        ->map(function (UserPage $page) {
            $lastmod = ($page->updated_at ?? now())->toAtomString();

            return '<url>'
                . '<loc>' . config('app.url') . '/pages/' . $page->slug . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>monthly</changefreq>'
                . '<priority>0.6</priority>'
                . '</url>';
        })
        ->implode('');

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
        . '<url>'
        .   '<loc>' . $url . '/</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>1.0</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/privacy</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>yearly</changefreq>'
        .   '<priority>0.3</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/razrabotka-saitov-pod-klyuch</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.8</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/razrabotka-veb-prilozheniy</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.8</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/razrabotka-mobilnyh-prilozheniy</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.8</priority>'
        . '</url>'
        . $pagesXml
        . '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

// Contact form
Route::post('/api/contact', [ContactController::class, 'send']);

// Legacy admin auth URLs -> Filament
Route::redirect('/auth/login', '/admin/login')->name('login');
Route::redirect('/admin/messages', '/admin/contact-messages');
Route::redirect('/admin/analytics', '/admin/analytics-settings');
Route::redirect('/admin/privacy', '/admin/user-pages');
