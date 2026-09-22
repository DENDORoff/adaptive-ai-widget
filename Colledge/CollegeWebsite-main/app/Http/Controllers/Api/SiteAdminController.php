<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CacheResponse;
use App\Models\News;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteAdminController extends Controller
{
    public function overview(): \Illuminate\Http\JsonResponse
    {
        $online = $this->onlineUsers();

        try {
            $newsTotal = News::count();
            $newsPublished = News::where('is_published', true)->count();
            $newsFeatured = News::where('is_featured', true)->count();
        } catch (\Throwable $e) {
            $newsTotal = $newsPublished = $newsFeatured = null;
        }

        try {
            $pages = PageSection::distinct()->pluck('page_key')->count();
            $sections = PageSection::count();
            $sectionsActive = PageSection::where('is_active', true)->count();
        } catch (\Throwable $e) {
            $pages = $sections = $sectionsActive = null;
        }

        $siteName = null;
        try {
            $siteName = PageSection::getFrontendValue('home', 'metadata', 'title')
                ?? PageSection::getFrontendValue('home', 'hero', 'main_title')
                ?? PageSection::getFrontendValue('home', 'about', 'title')
                ?? config('app.name', 'College');
        } catch (\Throwable $e) {
        }

        $stats = null;
        try {
            $stats = [
                'total' => DB::table('portal_visit_statistics')->count(),
                'latest' => DB::table('portal_visit_statistics')->max('date'),
            ];
        } catch (\Throwable $e) {
        }

        return response()->json([
            'ok' => true,
            'siteName' => $siteName,
            'url' => config('app.url'),
            'cacheDriver' => config('cache.default'),
            'online' => $online,
            'news' => [
                'total' => $newsTotal,
                'published' => $newsPublished,
                'featured' => $newsFeatured,
                'drafts' => $newsTotal !== null ? $newsTotal - $newsPublished : null,
            ],
            'sections' => [
                'pages' => $pages,
                'total' => $sections,
                'active' => $sectionsActive,
            ],
            'visits' => $stats,
            'time' => now()->toDateTimeString(),
        ]);
    }

    public function newsList(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 15);

        $query = News::query()->orderBy('published_at', 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%");
            });
        }

        $paginated = $query->paginate($perPage);

        return response()->json([
            'ok' => true,
            'items' => $paginated->items(),
            'pagination' => [
                'total' => $paginated->total(),
                'per_page' => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
            ],
        ]);
    }

    public function newsShow(int $id): \Illuminate\Http\JsonResponse
    {
        $news = News::findOrFail($id);

        return response()->json(['ok' => true, 'item' => $this->newsPayload($news)]);
    }

    public function newsStore(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->validateNews($request);

        $news = new News();
        $this->fillNews($news, $data, $request);

        if (empty($news->slug)) {
            $news->slug = $this->uniqueSlug($news->getTranslatedTitle('ru'), null);
        }

        $news->save();
        CacheResponse::clearPageCache();

        return response()->json(['ok' => true, 'item' => $this->newsPayload($news->refresh())], 201);
    }

    public function newsUpdate(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $news = News::findOrFail($id);
        $data = $this->validateNews($request);

        $this->fillNews($news, $data, $request);

        $changedTitle = isset($data['title']['ru']) && $data['title']['ru'] !== '' && $data['title']['ru'] !== $news->getTranslatedTitle('ru');

        if ($request->boolean('regenerate_slug') || ($changedTitle && (empty($news->slug) || empty($request->input('slug'))))) {
            $news->slug = $this->uniqueSlug($news->getTranslatedTitle('ru'), $news->id);
        }

        $news->save();
        CacheResponse::clearPageCache();

        return response()->json(['ok' => true, 'item' => $this->newsPayload($news->refresh())]);
    }

    public function newsDelete(int $id): \Illuminate\Http\JsonResponse
    {
        $news = News::findOrFail($id);
        $news->delete();
        CacheResponse::clearPageCache();

        return response()->json(['ok' => true]);
    }

    public function sections(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = trim((string) $request->input('search', ''));
        $pageKey = trim((string) $request->input('page', ''));

        $query = PageSection::query()->orderBy('page_key')->orderBy('sort_order');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('page_key', 'like', "%{$search}%")
                    ->orWhere('section_key', 'like', "%{$search}%");
            });
        }

        if ($pageKey !== '') {
            $query->where('page_key', $pageKey);
        }

        $items = $query->limit(400)->get();
        $grouped = $items->groupBy('page_key');

        return response()->json([
            'ok' => true,
            'pages' => PageSection::distinct()->pluck('page_key'),
            'sections' => $grouped->map(function ($group) {
                return $group->map(fn ($s) => [
                    'id' => $s->id,
                    'page_key' => $s->page_key,
                    'section_key' => $s->section_key,
                    'title' => $s->title,
                    'is_active' => $s->is_active,
                    'is_multilang' => $s->is_multilang,
                    'sort_order' => $s->sort_order,
                    'updated_at' => optional($s->updated_at)->toDateTimeString(),
                ])->values();
            }),
        ]);
    }

    public function sectionShow(int $id): \Illuminate\Http\JsonResponse
    {
        $section = PageSection::with([])->findOrFail($id);

        return response()->json([
            'ok' => true,
            'item' => [
                'id' => $section->id,
                'page_key' => $section->page_key,
                'section_key' => $section->section_key,
                'title' => $section->title,
                'description' => $section->description,
                'is_active' => $section->is_active,
                'is_multilang' => $section->is_multilang,
                'sort_order' => $section->sort_order,
                'meta_title' => $section->meta_title,
                'meta_description' => $section->meta_description,
                'meta_keywords' => $section->meta_keywords ?? [],
                'content' => $section->getAllContent(),
                'updated_at' => optional($section->updated_at)->toDateTimeString(),
            ],
        ]);
    }

    public function sectionUpdate(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $section = PageSection::findOrFail($id);

        if ($request->exists('title')) {
            $section->title = (string) $request->input('title', '');
        }
        if ($request->exists('description')) {
            $section->description = (string) $request->input('description', '');
        }
        if ($request->exists('is_active')) {
            $section->is_active = $request->boolean('is_active');
        }
        if ($request->exists('sort_order')) {
            $section->sort_order = (int) $request->input('sort_order', 0);
        }
        foreach (['meta_title', 'meta_description'] as $field) {
            if ($request->exists($field)) {
                $section->{$field} = (string) $request->input($field, '');
            }
        }
        if ($request->exists('meta_keywords')) {
            $section->meta_keywords = $request->input('meta_keywords') === '' ? [] : $request->input('meta_keywords', []);
        }

        if ($request->exists('content') && is_array($request->input('content'))) {
            $incoming = $request->input('content');
            $existing = [];
            if (is_array($section->content)) {
                foreach ($section->content as $item) {
                    if (is_array($item) && isset($item['key'])) {
                        $existing[(string) $item['key']] = $item;
                    }
                }
            }

            foreach ($incoming as $key => $value) {
                if (is_string($key) === false) {
                    continue;
                }

                if (is_array($value) && (isset($value['ru']) || isset($value['kk']) || isset($value['en']))) {
                    $existing[(string) $key] = [
                        'ru' => (string) ($value['ru'] ?? ''),
                        'kk' => (string) ($value['kk'] ?? ''),
                        'en' => (string) ($value['en'] ?? ''),
                    ];
                } else {
                    $existing[(string) $key] = ['ru' => (string) $value, 'kk' => '', 'en' => ''];
                }
            }

            $list = [];
            $hasOtherLang = false;
            foreach ($existing as $key => $row) {
                $list[] = ['key' => $key, 'ru' => $row['ru'], 'kk' => $row['kk'], 'en' => $row['en']];
                if ($row['kk'] !== '' || $row['en'] !== '') {
                    $hasOtherLang = true;
                }
            }

            $section->content = $list;
            if ($request->exists('is_multilang')) {
                $section->is_multilang = $request->boolean('is_multilang');
            } else {
                $section->is_multilang = $hasOtherLang;
            }
        }

        $section->save();
        PageSection::clearCacheForPage($section->page_key);
        CacheResponse::clearPageCache();

        return response()->json(['ok' => true, 'item' => $this->sectionPayload($section->refresh())]);
    }

    public function cacheClear(): \Illuminate\Http\JsonResponse
    {
        PageSection::clearAllPagesCache();
        Cache::flush();

        return response()->json(['ok' => true, 'cleared_at' => now()->toDateTimeString()]);
    }

    public function onlinePing(Request $request): \Illuminate\Http\JsonResponse
    {
        $fp = substr((string) $request->input('fp', ''), 0, 64);
        if ($fp === '') {
            $fp = md5($request->ip());
        }

        $page = substr((string) $request->input('page', ''), 0, 191);
        $map = Cache::get('site.online', []);

        $map[$fp] = ['page' => $page, 'ts' => now()->getTimestamp(), 'ip' => (string) $request->ip()];

        if (count($map) > 60) {
            $map = array_slice($map, -60, 60, true);
        }

        Cache::put('site.online', $map, now()->addMinutes(30));

        return response()->json(['ok' => true, 'users' => count($this->onlineUsers())]);
    }

    public function online(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['ok' => true, 'online' => $this->onlineUsers()]);
    }

    private function onlineUsers(): array
    {
        try {
            $map = Cache::get('site.online', []);
            if (!is_array($map)) {
                return ['total' => 0, 'users' => []];
            }

            $now = now()->getTimestamp();
            $users = [];
            foreach ($map as $fp => $u) {
                if (!is_array($u) || !isset($u['ts'])) {
                    continue;
                }
                if ($now - (int) $u['ts'] < 300) {
                    $users[$fp] = $u;
                }
            }

            return ['total' => count($users), 'users' => array_values($users)];
        } catch (\Throwable $e) {
            return ['total' => 0, 'users' => []];
        }
    }

    private function validateNews(Request $request): array
    {
        $rules = [
            'title.ru' => 'required|string|max:255',
            'content.ru' => 'required|string',
            'excerpt.ru' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'gallery' => 'nullable|array',
            'gallery.*' => 'string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ];

        return $request->validate($rules);
    }

    private function fillNews(News $news, array $data, Request $request): void
    {
        $title = $this->locMap($request, 'title');
        $excerpt = $this->locMap($request, 'excerpt');
        $content = $this->locMap($request, 'content');

        $multilang = $request->boolean('is_multilang')
            || ($title['kk'] ?? '') !== ''
            || ($title['en'] ?? '') !== ''
            || ($excerpt['kk'] ?? '') !== ''
            || ($excerpt['en'] ?? '') !== ''
            || ($content['kk'] ?? '') !== ''
            || ($content['en'] ?? '') !== '';

        $news->is_multilang = $multilang;

        if ($multilang) {
            $news->title = json_encode($title, JSON_UNESCAPED_UNICODE);
            $news->excerpt = json_encode($excerpt, JSON_UNESCAPED_UNICODE);
            $news->content = json_encode($content, JSON_UNESCAPED_UNICODE);
        } else {
            $news->title = $title['ru'] ?? '';
            $news->excerpt = $excerpt['ru'] ?? null;
            $news->content = $content['ru'] ?? '';
        }

        $news->image = $request->input('image') === '' ? null : $request->input('image');
        $news->gallery = $request->input('gallery', []);

        if ($request->exists('slug')) {
            $news->slug = trim((string) $request->input('slug', ''));
        }

        if ($request->exists('is_published')) {
            $news->is_published = $request->boolean('is_published');
        }

        if ($request->exists('is_featured')) {
            $news->is_featured = $request->boolean('is_featured');
        }

        if ($request->exists('published_at')) {
            $value = $request->input('published_at');
            $news->published_at = ($value === '' || $value === null) ? null : \Carbon\Carbon::parse($value);
        } elseif ($news->is_published && $news->published_at === null) {
            $news->published_at = now();
        }
    }

    private function locMap(Request $request, string $field): array
    {
        $raw = $request->input($field);
        $result = ['ru' => '', 'kk' => '', 'en' => ''];

        if (is_array($raw)) {
            foreach (['ru', 'kk', 'en'] as $lang) {
                $result[$lang] = (string) ($raw[$lang] ?? '');
            }
        } elseif (is_string($raw)) {
            $result['ru'] = $raw;
        }

        return $result;
    }

    private function uniqueSlug(string $base, ?int $ignoreId): string
    {
        $slug = Str::slug($base) ?: ('news-' . time());
        $candidate = $slug;
        $n = 2;

        while (News::where('slug', $candidate)
            ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $candidate = $slug . '-' . $n++;
        }

        return $candidate;
    }

    private function newsPayload(News $news): array
    {
        return [
            'id' => $news->id,
            'slug' => $news->slug,
            'title' => $news->is_multilang ? $news->getTranslations('title') : ['ru' => $news->title, 'kk' => '', 'en' => ''],
            'excerpt' => $news->is_multilang ? $news->getTranslations('excerpt') : ['ru' => $news->excerpt ?? '', 'kk' => '', 'en' => ''],
            'content' => $news->is_multilang ? $news->getTranslations('content') : ['ru' => $news->content, 'kk' => '', 'en' => ''],
            'image' => $news->image,
            'gallery' => $news->gallery ?? [],
            'is_published' => $news->is_published,
            'is_featured' => $news->is_featured,
            'is_multilang' => $news->is_multilang,
            'published_at' => optional($news->published_at)->format('Y-m-d H:i'),
            'created_at' => optional($news->created_at)->toDateTimeString(),
            'updated_at' => optional($news->updated_at)->toDateTimeString(),
        ];
    }

    private function sectionPayload(PageSection $section): array
    {
        return [
            'id' => $section->id,
            'page_key' => $section->page_key,
            'section_key' => $section->section_key,
            'title' => $section->title,
            'description' => $section->description,
            'is_active' => $section->is_active,
            'is_multilang' => $section->is_multilang,
            'sort_order' => $section->sort_order,
            'meta_title' => $section->meta_title,
            'meta_description' => $section->meta_description,
            'meta_keywords' => $section->meta_keywords ?? [],
            'content' => $section->getAllContent(),
            'updated_at' => optional($section->updated_at)->toDateTimeString(),
        ];
    }
}