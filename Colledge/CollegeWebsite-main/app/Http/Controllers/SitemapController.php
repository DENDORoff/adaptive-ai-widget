<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\BlogPost;

class SitemapController extends Controller
{
    public function sitemap()
    {
        // Получаем все страницы сайта
        $urls = [];

        // Основные статические страницы
        $staticPages = [
            ['url' => '/', 'priority' => '1.0'],
            ['url' => '/about', 'priority' => '0.9'],
            ['url' => '/structure', 'priority' => '0.8'],
            ['url' => '/blog', 'priority' => '0.8'],
            ['url' => '/documents', 'priority' => '0.7'],
            ['url' => '/contacts', 'priority' => '0.7'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => url($page['url']),
                'lastmod' => now()->toAtomString(),
                'changefreq' => $this->getChangefreq($page['url']),
                'priority' => $page['priority'],
            ];
        }

        // Добавляем все блог-посты
        $blogPosts = BlogPost::where('published', true)->get();
        foreach ($blogPosts as $post) {
            $urls[] = [
                'loc' => url('/blog/' . $post->slug),
                'lastmod' => $post->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        // Альтернативные версии на других языках
        foreach ($urls as &$url) {
            $url['alternates'] = [
                ['hreflang' => 'en', 'href' => $url['loc']],
                ['hreflang' => 'ru', 'href' => url('/ru' . str_replace(url('/'), '', $url['loc']))],
                ['hreflang' => 'kk', 'href' => url('/kk' . str_replace(url('/'), '', $url['loc']))],
            ];
        }

        return response()->view('sitemap', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    public function robots()
    {
        return response()->file(public_path('robots.txt'), [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    private function getChangefreq($url)
    {
        return match($url) {
            '/' => 'daily',
            '/blog' => 'weekly',
            default => 'monthly',
        };
    }
}
