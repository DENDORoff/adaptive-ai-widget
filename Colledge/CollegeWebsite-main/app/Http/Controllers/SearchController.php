<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\BlogPost;
use App\Models\Staff;
use App\Models\Vacancy;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function live(Request $request)
    {
        try {
            Log::info('Search request received', ['query' => $request->input('q')]);
            $query = $request->input('q');
            
            if (!$query || strlen($query) < 2) {
                return response()->json([]);
            }

            $results = $this->performSearch($query, 5);
            Log::info('Search completed', ['results_count' => $results->count()]);
            
            return response()->json($results);
            
        } catch (\Exception $e) {
            Log::error('Search API error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Search failed',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    private function performSearch($query, $limit = null)
    {
        $results = collect();
        
        try {
            Log::info('Starting search in News');
            $news = News::query()
                ->where('is_published', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'ILIKE', "%{$query}%")
                      ->orWhere('content', 'ILIKE', "%{$query}%");
                })
                ->latest()
                ->when($limit, function($q) use ($limit) {
                    return $q->limit($limit);
                })
                ->get()
                ->map(function($item) use ($query) {
                    return [
                        'type' => 'news',
                        'title' => $item->title ?? 'Без названия',
                        'excerpt' => $this->generateExcerpt($item->content ?? '', $query),
                        'url' => route('news.show', $item->slug),
                        'date' => optional($item->published_at)->format('d.m.Y'),
                        'relevance' => $this->calculateRelevance($item, $query, ['title', 'content']),
                        'target' => '_self'
                    ];
                });
            Log::info('News search completed', ['count' => $news->count()]);
        } catch (\Exception $e) {
            Log::error('News search error: ' . $e->getMessage());
            $news = collect();
        }

        try {
            Log::info('Starting search in BlogPosts');
            $blogPosts = BlogPost::query()
                ->where('is_published', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'ILIKE', "%{$query}%")
                      ->orWhere('content', 'ILIKE', "%{$query}%");
                })
                ->latest()
                ->when($limit, function($q) use ($limit) {
                    return $q->limit($limit);
                })
                ->get()
                ->map(function($item) use ($query) {
                    return [
                        'type' => 'blog',
                        'title' => $item->title ?? 'Без названия',
                        'excerpt' => $this->generateExcerpt($item->content ?? '', $query),
                        'url' => route('blog.show', $item->slug),
                        'date' => optional($item->published_at)->format('d.m.Y'),
                        'relevance' => $this->calculateRelevance($item, $query, ['title', 'content']),
                        'target' => '_self'
                    ];
                });
            Log::info('BlogPosts search completed', ['count' => $blogPosts->count()]);
        } catch (\Exception $e) {
            Log::error('BlogPosts search error: ' . $e->getMessage());
            $blogPosts = collect();
        }


        try {
            Log::info('Starting search in Vacancies');
            $vacancies = Vacancy::query()
                ->where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'ILIKE', "%{$query}%")
                      ->orWhere('description', 'ILIKE', "%{$query}%");
                })
                ->latest()
                ->when($limit, function($q) use ($limit) {
                    return $q->limit($limit);
                })
                ->get()
                ->map(function($item) use ($query) {
                    return [
                        'type' => 'vacancy',
                        'title' => $item->title ?? 'Без названия',
                        'excerpt' => $this->generateExcerpt($item->description ?? '', $query),
                        'url' => route('vacancies.show', $item->slug),
                        'date' => optional($item->created_at)->format('d.m.Y'),
                        'relevance' => $this->calculateRelevance($item, $query, ['title', 'description']),
                        'target' => '_self'
                    ];
                });
            Log::info('Vacancies search completed', ['count' => $vacancies->count()]);
        } catch (\Exception $e) {
            Log::error('Vacancies search error: ' . $e->getMessage());
            $vacancies = collect();
        }

        try {
            Log::info('Starting search in Pages');
            $pages = $this->searchInPages($query, $limit);
            Log::info('Pages search completed', ['count' => $pages->count()]);
        } catch (\Exception $e) {
            Log::error('Pages search error: ' . $e->getMessage());
            $pages = collect();
        }

        $results = $results
            ->concat($news)
            ->concat($blogPosts)
            ->concat($vacancies)
            ->concat($pages)
            ->sortByDesc('relevance')
            ->values();

        if ($limit) {
            $results = $results->take($limit);
        }

        return $results;
    }

    private function searchInPages($query, $limit = null)
    {
        $query = mb_strtolower($query);
        
        $pages = [
            [
                'title' => 'О колледже',
                'keywords' => ['о нас', 'о колледже', 'about', 'история', 'миссия', 'цели', 'задачи'],
                'url' => route('about'),
                'excerpt' => 'Информация о высшем колледже электроники и коммуникаций',
                'relevance' => 0
            ],
            [
                'title' => 'Достижения колледжа',
                'keywords' => ['достижения', 'awards', 'успехи', 'награды', 'победы', 'олимпиады'],
                'url' => route('achievements.index'),
                'excerpt' => 'Достижения студентов и колледжа в различных конкурсах и олимпиадах',
                'relevance' => 0
            ],
            [
                'title' => 'Наши выпускники',
                'keywords' => ['выпускники', 'alumni', 'graduates', 'студенты'],
                'url' => route('achievements.index') . '#graduates',
                'excerpt' => 'Информация о выпускниках колледжа и их достижениях',
                'relevance' => 0
            ],
            [
                'title' => 'Администрация и преподаватели',
                'keywords' => ['администрация', 'преподаватели', 'staff', 'учителя', 'педагоги', 'руководство'],
                'url' => route('staff.index'),
                'excerpt' => 'Сотрудники колледжа: администрация и преподавательский состав',
                'relevance' => 0
            ],
            [
                'title' => 'Кураторы групп',
                'keywords' => ['кураторы', 'curators', 'группы', 'классные руководители'],
                'url' => route('curators.index'),
                'excerpt' => 'Информация о кураторах учебных групп',
                'relevance' => 0
            ],
            [
                'title' => 'Телефонный справочник',
                'keywords' => ['контакты', 'телефоны', 'справочник', 'contacts', 'phone'],
                'url' => route('contacts.index'),
                'excerpt' => 'Телефонный справочник колледжа',
                'relevance' => 0
            ],
            [
                'title' => 'Библиотека',
                'keywords' => ['библиотека', 'library', 'книги', 'литература', 'учебники'],
                'url' => route('library.index'),
                'excerpt' => 'Электронная библиотека колледжа',
                'relevance' => 0
            ],
            [
                'title' => 'Государственные символы',
                'keywords' => ['символы', 'герб', 'флаг', 'гимн', 'государственные символы'],
                'url' => route('state-symbols.index'),
                'excerpt' => 'Государственные символы Республики Казахстан',
                'relevance' => 0
            ],
            [
                'title' => 'Виртуальный тур',
                'keywords' => ['тур', 'виртуальный тур', 'экскурсия', 'tour', '3d'],
                'url' => route('home') . '#virtual-tour',
                'excerpt' => 'Виртуальная экскурсия по территории колледжа',
                'relevance' => 0
            ],
            [
                'title' => 'Часто задаваемые вопросы',
                'keywords' => ['вопросы', 'faq', 'частые вопросы', 'ответы', 'помощь'],
                'url' => route('home') . '#faq',
                'excerpt' => 'Ответы на часто задаваемые вопросы',
                'relevance' => 0
            ],
            [
                'title' => 'Новости',
                'keywords' => ['новости', 'news', 'события', 'мероприятия'],
                'url' => route('news.index'),
                'excerpt' => 'Актуальные новости и события колледжа',
                'relevance' => 0
            ],
            [
                'title' => 'Блог руководителя',
                'keywords' => ['блог', 'blog', 'руководитель', 'директор', 'мнение'],
                'url' => route('blog.index'),
                'excerpt' => 'Блог руководителя колледжа',
                'relevance' => 0
            ],
            [
                'title' => 'Вакансии педагогов',
                'keywords' => ['вакансии', 'работа', 'vacancies', 'педагоги', 'трудоустройство'],
                'url' => route('vacancies.index'),
                'excerpt' => 'Открытые вакансии для преподавателей',
                'relevance' => 0
            ],
        ];

        foreach ($pages as &$page) {
            $relevance = 0;
            
            if (str_contains(mb_strtolower($page['title']), $query)) {
                $relevance += 100;
            }
            
            foreach ($page['keywords'] as $keyword) {
                if (str_contains($keyword, $query) || str_contains($query, $keyword)) {
                    $relevance += 50;
                }
            }
            
            if (str_contains(mb_strtolower($page['excerpt']), $query)) {
                $relevance += 30;
            }
            
            $page['relevance'] = $relevance;
        }

        $pages = collect($pages)
            ->filter(function($page) {
                return $page['relevance'] > 0;
            })
            ->map(function($page) {
                return [
                    'type' => 'page',
                    'title' => $page['title'],
                    'excerpt' => $page['excerpt'],
                    'url' => $page['url'],
                    'date' => null,
                    'relevance' => $page['relevance'],
                    'target' => '_self'
                ];
            })
            ->sortByDesc('relevance')
            ->values();

        if ($limit) {
            $pages = $pages->take($limit);
        }

        return $pages;
    }

    private function generateExcerpt($content, $query, $maxLength = 150)
    {
        if (!$content) return '';
        
        try {
            $text = strip_tags($content);
            $position = stripos($text, $query);
            
            if ($position !== false) {
                $start = max(0, $position - 50);
                $excerpt = Str::substr($text, $start, $maxLength);
                
                if ($start > 0) {
                    $excerpt = '...' . $excerpt;
                }
                if (strlen($text) > $start + $maxLength) {
                    $excerpt .= '...';
                }
            } else {
                $excerpt = Str::limit($text, $maxLength);
            }
            
            return $excerpt;
        } catch (\Exception $e) {
            Log::error('Excerpt generation error: ' . $e->getMessage());
            return '';
        }
    }

    private function calculateRelevance($item, $query, $fields)
    {
        try {
            $relevance = 0;
            $query = mb_strtolower($query);
            
            foreach ($fields as $index => $field) {
                if (!isset($item->$field)) {
                    continue;
                }
                
                $fieldValue = mb_strtolower($item->$field ?? '');
                
                if (str_starts_with($fieldValue, $query)) {
                    $relevance += 100 - ($index * 10);
                }
                elseif (str_contains($fieldValue, $query)) {
                    $relevance += 50 - ($index * 10);
                }
                else {
                    $words = explode(' ', $query);
                    foreach ($words as $word) {
                        if (strlen($word) > 2 && str_contains($fieldValue, $word)) {
                            $relevance += 10 - ($index * 2);
                        }
                    }
                }
            }
            
            return $relevance;
        } catch (\Exception $e) {
            Log::error('Relevance calculation error: ' . $e->getMessage());
            return 0;
        }
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return view('search.index', [
                'query' => $query,
                'results' => collect([]),
                'totalResults' => 0
            ]);
        }

        try {
            $results = $this->performSearch($query);
            
            return view('search.index', [
                'query' => $query,
                'results' => $results,
                'totalResults' => $results->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Search page error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('search.index', [
                'query' => $query,
                'results' => collect([]),
                'totalResults' => 0,
                'error' => config('app.debug') ? $e->getMessage() : 'Произошла ошибка при поиске'
            ]);
        }
    }
}