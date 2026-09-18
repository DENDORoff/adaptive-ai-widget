<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

/**
 * SEO Routes
 */
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap.xml');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');

// Redirect static files
Route::redirect('/ads.txt', '/ads.txt', 301);
Route::redirect('/security.txt', '/.well-known/security.txt', 301);
