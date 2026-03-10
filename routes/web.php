<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SeoDKeywordLandingController;
use App\Http\Controllers\UserPageController;
use App\Models\BlogPost;
use App\Models\UserPage;
use App\Support\SeoDKeywordLanding;

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

// SEO посадочная: интернет-магазины
Route::get('/razrabotka-internet-magazina', function () {
    return view('landing.ecommerce-development');
});

// SEO посадочная: поддержка и сопровождение
Route::get('/tehnicheskaya-podderzhka-sayta', function () {
    return view('landing.support-development');
});

// Массовые SEO-посадочные по D-запросам (только totalCount > 0)
Route::get('/d', [SeoDKeywordLandingController::class, 'index']);
Route::get('/d/{slug}', [SeoDKeywordLandingController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+');

// Блог
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+');

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

    $dKeywordPagesXml = collect(SeoDKeywordLanding::bySlugMap())
        ->map(function (array $item) use ($lastmod) {
            return '<url>'
                . '<loc>' . config('app.url') . '/d/' . $item['slug'] . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>monthly</changefreq>'
                . '<priority>0.5</priority>'
                . '</url>';
        })
        ->implode('');

    $blogPostsXml = BlogPost::query()
        ->published()
        ->get(['slug', 'updated_at', 'published_at'])
        ->map(function (BlogPost $post) {
            $lastmod = ($post->updated_at ?? $post->published_at ?? now())->toAtomString();

            return '<url>'
                . '<loc>' . config('app.url') . '/blog/' . $post->slug . '</loc>'
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
        . '<url>'
        .   '<loc>' . $url . '/razrabotka-internet-magazina</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.8</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/d</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.6</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/blog</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.7</priority>'
        . '</url>'
        . '<url>'
        .   '<loc>' . $url . '/tehnicheskaya-podderzhka-sayta</loc>'
        .   '<lastmod>' . $lastmod . '</lastmod>'
        .   '<changefreq>weekly</changefreq>'
        .   '<priority>0.7</priority>'
        . '</url>'
        . $pagesXml
        . $dKeywordPagesXml
        . $blogPostsXml
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
Route::redirect('/admin/blog', '/admin/blog-posts');
