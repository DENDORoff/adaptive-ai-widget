<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class VacanciesPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Вакансии...');
            
            // Удаляем старые записи для страницы vacancies
            $deleted = PageSection::where('page_key', 'vacancies')->delete();
            Log::info("Удалено старых записей Вакансий: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы',
                    'content' => [
                        'title' => [
                            'ru' => 'Вакансии',
                            'kk' => 'Бос орындар',
                            'en' => 'Vacancies',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                ],

                // Фоновый паттерн
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'background',
                    'title' => 'Фоновый паттерн',
                    'description' => 'Base64 SVG паттерн для фона',
                    'content' => [
                        'pattern_base64' => 'PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnoiIHN0cm9rZT0iIzFFMzA0RSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9nPjwvc3ZnPg==',
                        'pattern_alt' => [
                            'ru' => 'Декоративный фон для страницы вакансий',
                            'kk' => 'Бос орындар беті үшін декоративті фон',
                            'en' => 'Decorative background for vacancies page',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                ],

                // Главный баннер
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'hero',
                    'title' => 'Главный баннер',
                    'description' => 'Заголовок и подзаголовок страницы',
                    'content' => [
                        'title' => [
                            'ru' => 'Вакансии',
                            'kk' => 'Бос орындар',
                            'en' => 'Vacancies',
                        ],
                        'subtitle' => [
                            'ru' => 'Присоединяйтесь к нашей команде профессионалов',
                            'kk' => 'Біздің кәсіби командамызға қосылыңыз',
                            'en' => 'Join our team of professionals',
                        ],
                        'search_placeholder' => [
                            'ru' => 'Поиск вакансий...',
                            'kk' => 'Бос орындарды іздеу...',
                            'en' => 'Search vacancies...',
                        ],
                        'filter_all' => [
                            'ru' => 'Все вакансии',
                            'kk' => 'Барлық бос орындар',
                            'en' => 'All vacancies',
                        ],
                        'filter_active' => [
                            'ru' => 'Активные',
                            'kk' => 'Белсенді',
                            'en' => 'Active',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                ],

                // Объявление о конкурсе
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'announcement',
                    'title' => 'Объявление о конкурсе',
                    'description' => 'Официальное объявление и бейджи',
                    'content' => [
                        'title' => [
                            'ru' => 'КГП на ПХВ «Высший колледж электроники и коммуникаций»<br class="hidden md:block">управления образования Павлодарской области акимата Павлодарской области<br class="hidden md:block">объявляет о конкурсе на вакантные должности',
                            'kk' => 'КГП ҰБЖ «Электроника және коммуникациялар жоғары колледжі»<br class="hidden md:block">Павлодар облысы әкімдігінің білім басқармасы<br class="hidden md:block">бос лауазымдар бойынша байқау туралы хабарлайды',
                            'en' => 'State Communal Enterprise «Higher College of Electronics and Communications»<br class="hidden md:block">of the Education Department of Pavlodar region akimat of Pavlodar region<br class="hidden md:block">announces a competition for vacant positions',
                        ],
                        'badge_1' => [
                            'ru' => 'Текущие вакансии',
                            'kk' => 'Ағымдағы бос орындар',
                            'en' => 'Current vacancies',
                        ],
                        'badge_2' => [
                            'ru' => 'Полная занятость',
                            'kk' => 'Толық жұмыс күні',
                            'en' => 'Full-time',
                        ],
                        'badge_3' => [
                            'ru' => 'Павлодарская область',
                            'kk' => 'Павлодар облысы',
                            'en' => 'Pavlodar region',
                        ],
                        'official_note' => [
                            'ru' => 'Официальное объявление',
                            'kk' => 'Ресми хабарландыру',
                            'en' => 'Official announcement',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                ],

                // Список вакансий
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'vacancies_list',
                    'title' => 'Список вакансий',
                    'description' => 'Заголовок и метка списка вакансий',
                    'content' => [
                        'title' => [
                            'ru' => 'Открытые вакансии',
                            'kk' => 'Ашық бос орындар',
                            'en' => 'Open vacancies',
                        ],
                        'found_label' => [
                            'ru' => 'Найдено вакансий:',
                            'kk' => 'Табылған бос орындар:',
                            'en' => 'Found vacancies:',
                        ],
                        'sort_by' => [
                            'ru' => 'Сортировать по:',
                            'kk' => 'Сұрыптау:',
                            'en' => 'Sort by:',
                        ],
                        'sort_newest' => [
                            'ru' => 'Сначала новые',
                            'kk' => 'Алдымен жаңалары',
                            'en' => 'Newest first',
                        ],
                        'sort_salary' => [
                            'ru' => 'По зарплате',
                            'kk' => 'Жалақы бойынша',
                            'en' => 'By salary',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                ],

                // Детали вакансии
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'vacancy_details',
                    'title' => 'Детали вакансии',
                    'description' => 'Тексты для деталей каждой вакансии',
                    'content' => [
                        'description_title' => [
                            'ru' => 'Описание вакансии',
                            'kk' => 'Бос орын сипаттамасы',
                            'en' => 'Vacancy description',
                        ],
                        'salary_label' => [
                            'ru' => 'Оклад',
                            'kk' => 'Жалақы',
                            'en' => 'Salary',
                        ],
                        'employment_label' => [
                            'ru' => 'Тип занятости',
                            'kk' => 'Жұмыс түрі',
                            'en' => 'Employment type',
                        ],
                        'requirements_title' => [
                            'ru' => 'Требования',
                            'kk' => 'Талаптар',
                            'en' => 'Requirements',
                        ],
                        'responsibilities_title' => [
                            'ru' => 'Обязанности',
                            'kk' => 'Міндеттер',
                            'en' => 'Responsibilities',
                        ],
                        'conditions_title' => [
                            'ru' => 'Условия работы',
                            'kk' => 'Жұмыс жағдайлары',
                            'en' => 'Working conditions',
                        ],
                        'apply_button' => [
                            'ru' => 'Подать заявку',
                            'kk' => 'Өтініш беру',
                            'en' => 'Apply',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                ],

                // Особенности вакансии
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'vacancy_features',
                    'title' => 'Особенности вакансии',
                    'description' => 'Характеристики и преимущества вакансий',
                    'content' => [
                        'feature_1' => [
                            'ru' => 'Официальное трудоустройство',
                            'kk' => 'Ресми жұмысқа орналасу',
                            'en' => 'Official employment',
                        ],
                        'feature_2' => [
                            'ru' => 'Работа в государственном учреждении',
                            'kk' => 'Мемлекеттік мекемеде жұмыс',
                            'en' => 'Work in a state institution',
                        ],
                        'feature_3' => [
                            'ru' => 'Конкурсный отбор',
                            'kk' => 'Байқаулық іріктеу',
                            'en' => 'Competitive selection',
                        ],
                        'date_label' => [
                            'ru' => 'Дата публикации:',
                            'kk' => 'Жарияланған күні:',
                            'en' => 'Publication date:',
                        ],
                        'deadline_label' => [
                            'ru' => 'Срок подачи:',
                            'kk' => 'Өтініш беру мерзімі:',
                            'en' => 'Application deadline:',
                        ],
                        'workplace_label' => [
                            'ru' => 'Место работы:',
                            'kk' => 'Жұмыс орны:',
                            'en' => 'Workplace:',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                ],

                // Карточка вакансии
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'vacancy_card',
                    'title' => 'Карточка вакансии',
                    'description' => 'Тексты для карточек вакансий',
                    'content' => [
                        'pdf_description' => [
                            'ru' => 'Официальный PDF документ с деталями вакансии',
                            'kk' => 'Бос орын туралы толық ақпараты бар ресми PDF құжат',
                            'en' => 'Official PDF document with vacancy details',
                        ],
                        'expires_label' => [
                            'ru' => 'Актуально до',
                            'kk' => 'Өзекті болған мерзім',
                            'en' => 'Valid until',
                        ],
                        'expired_text' => [
                            'ru' => '(Истекло)',
                            'kk' => '(Мерзімі өткен)',
                            'en' => '(Expired)',
                        ],
                        'pdf_button' => [
                            'ru' => 'Открыть PDF вакансии',
                            'kk' => 'Бос орын PDF ашу',
                            'en' => 'Open vacancy PDF',
                        ],
                        'view_details' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'More details',
                        ],
                        'share_button' => [
                            'ru' => 'Поделиться',
                            'kk' => 'Бөлісу',
                            'en' => 'Share',
                        ],
                        'save_button' => [
                            'ru' => 'Сохранить',
                            'kk' => 'Сақтау',
                            'en' => 'Save',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                ],

                // Состояние без вакансий
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'empty_state',
                    'title' => 'Состояние без вакансий',
                    'description' => 'Тексты для случая когда нет вакансий',
                    'content' => [
                        'title' => [
                            'ru' => 'Вакансий пока нет',
                            'kk' => 'Бос орындар әлі жоқ',
                            'en' => 'No vacancies yet',
                        ],
                        'description' => [
                            'ru' => 'Следите за обновлениями - новые вакансии появятся в ближайшее время',
                            'kk' => 'Жаңартуларды бақылап отырыңыз - жақын арада жаңа бос орындар пайда болады',
                            'en' => 'Follow updates - new vacancies will appear soon',
                        ],
                        'hint' => [
                            'ru' => 'Попробуйте зайти позже',
                            'kk' => 'Кейінірек кіріп көріңіз',
                            'en' => 'Try coming back later',
                        ],
                        'subscribe_button' => [
                            'ru' => 'Подписаться на уведомления',
                            'kk' => 'Хабарландыруларға жазылу',
                            'en' => 'Subscribe to notifications',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                ],

                // Информационный блок
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'info_block',
                    'title' => 'Информационный блок',
                    'description' => 'Информация о PDF документах',
                    'content' => [
                        'title' => [
                            'ru' => 'О PDF документах вакансий',
                            'kk' => 'Бос орындардың PDF құжаттары туралы',
                            'en' => 'About vacancy PDF documents',
                        ],
                        'description' => [
                            'ru' => 'Каждая вакансия содержит официальный PDF документ с полным описанием требований, обязанностей и условий работы в КГП на ПХВ «Высший колледж электроники и коммуникаций» управления образования Павлодарской области.',
                            'kk' => 'Әрбір бос орын Павлодар облысы білім басқармасының КГП ҰБЖ «Электроника және коммуникациялар жоғары колледжіндегі жұмыс талаптарының, міндеттерінің және жағдайларының толық сипаттамасы бар ресми PDF құжатын қамтиды.',
                            'en' => 'Each vacancy contains an official PDF document with a full description of requirements, responsibilities and working conditions at the State Communal Enterprise «Higher College of Electronics and Communications» of the Education Department of Pavlodar region.',
                        ],
                        'point_1' => [
                            'ru' => 'Официальная форма документа',
                            'kk' => 'Құжаттың ресми нысаны',
                            'en' => 'Official document form',
                        ],
                        'point_2' => [
                            'ru' => 'Полные требования к кандидатам',
                            'kk' => 'Үміткерлерге қойылатын толық талаптар',
                            'en' => 'Full requirements for candidates',
                        ],
                        'point_3' => [
                            'ru' => 'Подробные условия работы',
                            'kk' => 'Егжей-тегжейлі жұмыс жағдайлары',
                            'en' => 'Detailed working conditions',
                        ],
                        'download_all' => [
                            'ru' => 'Скачать все документы',
                            'kk' => 'Барлық құжаттарды жүктеп алу',
                            'en' => 'Download all documents',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                ],

                // Навигация
                [
                    'page_key' => 'vacancies',
                    'section_key' => 'navigation',
                    'title' => 'Навигация вакансий',
                    'description' => 'Навигационные элементы на странице вакансий',
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад к главной',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'contact_button' => [
                            'ru' => 'Связаться с отделом кадров',
                            'kk' => 'Кадр бөлімімен байланысу',
                            'en' => 'Contact HR department',
                        ],
                        'print_page' => [
                            'ru' => 'Распечатать список',
                            'kk' => 'Тізімді басып шығару',
                            'en' => 'Print list',
                        ],
                        'refresh_button' => [
                            'ru' => 'Обновить список',
                            'kk' => 'Тізімді жаңарту',
                            'en' => 'Refresh list',
                        ],
                        'contact_email' => [
                            'ru' => 'hr@college.edu.kz',
                            'kk' => 'hr@college.edu.kz',
                            'en' => 'hr@college.edu.kz',
                        ],
                        'contact_phone' => [
                            'ru' => '+7 (701) 490-05-70',
                            'kk' => '+7 (701) 490-05-70',
                            'en' => '+7 (701) 490-05-70',
                        ],
                    ],
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                ],
            ];
            
            $createdCount = 0;
            $errors = [];
            
            foreach ($sections as $section) {
                try {
                    PageSection::create($section);
                    $createdCount++;
                    Log::info("Создана Vacancies секция: {$section['section_key']}");
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Vacancies секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Vacancies секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Вакансий были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Вакансий были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано Vacancies секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница Вакансии успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный с автоматической обработкой");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Vacancies секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n💼 Особенности страницы вакансий:");
                $this->command->info("   📄 PDF документы для каждой вакансии");
                $this->command->info("   🎯 Конкурсный отбор на должности");
                $this->command->info("   📍 Павлодарская область");
                $this->command->info("   💰 Прозрачная информация об окладе");
                $this->command->info("   ⏳ Сроки актуальности вакансий");
                $this->command->info("   🔍 Поиск и фильтрация вакансий");
                $this->command->info("   📧 Контакты отдела кадров");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании страницы Вакансии: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании страницы Вакансии: {$e->getMessage()}");
            throw $e;
        }
    }
}