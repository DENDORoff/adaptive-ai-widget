<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class SearchPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Поиска...');
            
            $deleted = PageSection::where('page_key', 'search')->delete();
            Log::info("Удалено старых записей Search: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'search',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы поиска',
                    'description' => 'SEO и общие настройки страницы поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'page_title' => [
                            'ru' => 'Поиск',
                            'kk' => 'Іздеу',
                            'en' => 'Search',
                        ],
                        'meta_title' => [
                            'ru' => 'Поиск по сайту | Технический колледж современных технологий',
                            'kk' => 'Сайт бойынша іздеу | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Site search | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Поиск по сайту Технического колледжа современных технологий. Найдите новости, статьи блога, информацию о сотрудниках и вакансии.',
                            'kk' => 'Заманауи технологиялардың техникалық колледжі сайтында іздеу. Жаңалықтарды, блог мақалаларын, қызметкерлер туралы ақпаратты және бос орындарды табыңыз.',
                            'en' => 'Search the website of the Technical College of Modern Technologies. Find news, blog articles, staff information and vacancies.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'search',
                    'section_key' => 'header',
                    'title' => 'Заголовок и форма поиска',
                    'description' => 'Заголовок страницы и тексты для формы поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Результаты поиска',
                            'kk' => 'Іздеу нәтижелері',
                            'en' => 'Search results',
                        ],
                        'search_placeholder' => [
                            'ru' => 'Введите поисковый запрос...',
                            'kk' => 'Іздеу сұранысын енгізіңіз...',
                            'en' => 'Enter search query...',
                        ],
                        'search_button' => [
                            'ru' => 'Найти',
                            'kk' => 'Табу',
                            'en' => 'Search',
                        ],
                        'search_for' => [
                            'ru' => 'По запросу:',
                            'kk' => 'Сұраныс бойынша:',
                            'en' => 'For query:',
                        ],
                        'results_found' => [
                            'ru' => 'найдено результатов:',
                            'kk' => 'табылған нәтижелер:',
                            'en' => 'results found:',
                        ],
                    ],
                ],

                [
                    'page_key' => 'search',
                    'section_key' => 'result_types',
                    'title' => 'Типы результатов поиска',
                    'description' => 'Названия типов контента в результатах поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'news' => [
                            'ru' => 'Новость',
                            'kk' => 'Жаңалық',
                            'en' => 'News',
                        ],
                        'blog' => [
                            'ru' => 'Блог',
                            'kk' => 'Блог',
                            'en' => 'Blog',
                        ],
                        'staff' => [
                            'ru' => 'Сотрудник',
                            'kk' => 'Қызметкер',
                            'en' => 'Staff',
                        ],
                        'vacancy' => [
                            'ru' => 'Вакансия',
                            'kk' => 'Бос орын',
                            'en' => 'Vacancy',
                        ],
                    ],
                ],

                [
                    'page_key' => 'search',
                    'section_key' => 'messages',
                    'title' => 'Системные сообщения',
                    'description' => 'Сообщения при отсутствии результатов или пустом запросе',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'no_results_title' => [
                            'ru' => 'Ничего не найдено',
                            'kk' => 'Ештеңе табылмады',
                            'en' => 'Nothing found',
                        ],
                        'no_results_text' => [
                            'ru' => 'Попробуйте изменить поисковый запрос или использовать другие ключевые слова.',
                            'kk' => 'Іздеу сұранысын өзгертуге немесе басқа кілт сөздерді пайдалануға тырысыңыз.',
                            'en' => 'Try changing your search query or using other keywords.',
                        ],
                        'enter_query_title' => [
                            'ru' => 'Введите поисковый запрос',
                            'kk' => 'Іздеу сұранысын енгізіңіз',
                            'en' => 'Enter search query',
                        ],
                        'enter_query_text' => [
                            'ru' => 'Вы можете найти новости, статьи блога, информацию о сотрудниках и вакансии',
                            'kk' => 'Сіз жаңалықтарды, блог мақалаларын, қызметкерлер туралы ақпаратты және бос орындарды таба аласыз',
                            'en' => 'You can find news, blog articles, staff information and vacancies',
                        ],
                    ],
                ],

                [
                    'page_key' => 'search',
                    'section_key' => 'buttons',
                    'title' => 'Кнопки и ссылки',
                    'description' => 'Тексты для кнопок и ссылок',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'back_to_home' => [
                            'ru' => 'На главную',
                            'kk' => 'Басты бетке',
                            'en' => 'To home',
                        ],
                    ],
                ],

                [
                    'page_key' => 'search',
                    'section_key' => 'modal',
                    'title' => 'Модальное окно сотрудника',
                    'description' => 'Тексты в модальном окне информации о сотруднике',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'staff_modal_title' => [
                            'ru' => 'Информация о сотруднике',
                            'kk' => 'Қызметкер туралы ақпарат',
                            'en' => 'Staff information',
                        ],
                        'position_label' => [
                            'ru' => 'Должность',
                            'kk' => 'Лауазым',
                            'en' => 'Position',
                        ],
                        'department_label' => [
                            'ru' => 'Отдел',
                            'kk' => 'Бөлім',
                            'en' => 'Department',
                        ],
                        'email_label' => [
                            'ru' => 'Email',
                            'kk' => 'Электрондық пошта',
                            'en' => 'Email',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'about_label' => [
                            'ru' => 'О сотруднике',
                            'kk' => 'Қызметкер туралы',
                            'en' => 'About',
                        ],
                        'loading_error_title' => [
                            'ru' => 'Ошибка загрузки',
                            'kk' => 'Жүктеу қатесі',
                            'en' => 'Loading error',
                        ],
                        'loading_error_text' => [
                            'ru' => 'Не удалось загрузить информацию о сотруднике',
                            'kk' => 'Қызметкер туралы ақпаратты жүктеу мүмкін болмады',
                            'en' => 'Failed to load staff information',
                        ],
                    ],
                ],

                [
                    'page_key' => 'search',
                    'section_key' => 'aria_labels',
                    'title' => 'ARIA-лейблы и доступность',
                    'description' => 'Тексты для улучшения доступности',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'search_form_label' => [
                            'ru' => 'Форма поиска',
                            'kk' => 'Іздеу формасы',
                            'en' => 'Search form',
                        ],
                        'search_input_label' => [
                            'ru' => 'Поисковый запрос',
                            'kk' => 'Іздеу сұранысы',
                            'en' => 'Search query',
                        ],
                        'modal_close_label' => [
                            'ru' => 'Закрыть модальное окно',
                            'kk' => 'Модалды тережені жабу',
                            'en' => 'Close modal window',
                        ],
                    ],
                ],
            ];
            
            $createdCount = 0;
            $errors = [];
            
            foreach ($sections as $section) {
                try {
                    PageSection::create($section);
                    $createdCount++;
                    Log::info("Создана многоязычная Search секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных секций Search: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Поиск' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🔍 Поддерживаемые типы поиска: Новости, Блог, Сотрудники, Вакансии");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}