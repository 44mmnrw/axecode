<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('app');
});

// Политика конфиденциальности
Route::get('/privacy', function () {
    return view('privacy');
});

// Sitemap
Route::get('/sitemap.xml', function () {
    $url = config('app.url');
    $lastmod = now()->toAtomString();

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
        . '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

// Contact form
Route::post('/api/contact', [ContactController::class, 'send']);

// Auth
Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Admin panel (protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::delete('/admin/messages/{id}', [AdminController::class, 'deleteMessage'])->name('admin.messages.delete');

    Route::get('/admin/analytics', [AdminController::class, 'analyticsSettings'])->name('admin.analytics');
    Route::post('/admin/analytics', [AdminController::class, 'saveAnalyticsSettings'])->name('admin.analytics.save');

    Route::get('/admin/privacy', [AdminController::class, 'privacyPage'])->name('admin.privacy');
    Route::post('/admin/privacy', [AdminController::class, 'savePrivacyPage'])->name('admin.privacy.save');
});
