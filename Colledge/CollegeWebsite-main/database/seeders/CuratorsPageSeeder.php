<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class CuratorsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Кураторы групп...');
            
            // Удаляем старые записи
            $deleted = PageSection::where('page_key', 'curators')->delete();
            Log::info("Удалено старых записей Curators: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'curators',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Кураторы групп',
                            'kk' => 'Топтардың кураторлары',
                            'en' => 'Group Curators',
                        ],
                        'meta_title' => [
                            'ru' => 'Кураторы групп | Колледж современных технологий',
                            'kk' => 'Топтардың кураторлары | Заманауи технологиялар колледжі',
                            'en' => 'Group Curators | College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Информация о кураторах учебных групп. Контакты, расписание консультаций и другая полезная информация.',
                            'kk' => 'Оқу топтарының кураторлары туралы ақпарат. Байланыстар, кеңес кестесі және басқа пайдалы ақпарат.',
                            'en' => 'Information about group curators. Contacts, consultation schedule and other useful information.',
                        ],
                    ],
                ],
                
                // HERO SECTION
                [
                    'page_key' => 'curators',
                    'section_key' => 'hero',
                    'title' => 'Заглавная секция',
                    'description' => 'Главный заголовок страницы кураторов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Кураторы групп',
                            'kk' => 'Топтардың кураторлары',
                            'en' => 'Group Curators',
                        ],
                        'description' => [
                            'ru' => 'Познакомьтесь с кураторами ваших учебных групп',
                            'kk' => 'Оқу топтарыңыздың кураторларымен танысыңыз',
                            'en' => 'Get to know the curators of your study groups',
                        ],
                    ],
                ],
                
                // STATS CARDS
                [
                    'page_key' => 'curators',
                    'section_key' => 'stats_cards',
                    'title' => 'Карточки статистики',
                    'description' => 'Три карточки с общей статистикой',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'card_1_title' => [
                            'ru' => 'Всего кураторов',
                            'kk' => 'Барлығы кураторлар',
                            'en' => 'Total curators',
                        ],
                        'card_1_value' => [
                            'ru' => '35',
                            'kk' => '35',
                            'en' => '35',
                        ],
                        'card_1_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'card_2_title' => [
                            'ru' => 'Активные курсы',
                            'kk' => 'Белсенді курс',
                            'en' => 'Active courses',
                        ],
                        'card_2_value' => [
                            'ru' => '4',
                            'kk' => '4',
                            'en' => '4',
                        ],
                        'card_2_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'card_3_title' => [
                            'ru' => 'Специальности',
                            'kk' => 'Мамандық',
                            'en' => 'Specialties',
                        ],
                        'card_3_value' => [
                            'ru' => '9',
                            'kk' => '9',
                            'en' => '9',
                        ],
                        'card_3_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                    ],
                ],
                
                // SEARCH PLACEHOLDER
                [
                    'page_key' => 'curators',
                    'section_key' => 'search_placeholder',
                    'title' => 'Поле поиска',
                    'description' => 'Плейсхолдер для поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'placeholder' => [
                            'ru' => 'Поиск по группе или куратору',
                            'kk' => 'Топ немесе куратор бойынша іздеу',
                            'en' => 'Search by group or curator',
                        ],
                        'search_label' => [
                            'ru' => 'Поиск:',
                            'kk' => 'Іздеу:',
                            'en' => 'Search:',
                        ],
                        'search_button' => [
                            'ru' => 'Найти',
                            'kk' => 'Табу',
                            'en' => 'Search',
                        ],
                        'clear_search' => [
                            'ru' => 'Очистить поиск',
                            'kk' => 'Іздеуді тазарту',
                            'en' => 'Clear search',
                        ],
                    ],
                ],
                
                // FILTER LABELS
                [
                    'page_key' => 'curators',
                    'section_key' => 'filter_labels',
                    'title' => 'Надписи фильтров',
                    'description' => 'Тексты для фильтров и выпадающих списков',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'course_filter_label' => [
                            'ru' => 'Курс:',
                            'kk' => 'Курс:',
                            'en' => 'Course:',
                        ],
                        'course_filter_all' => [
                            'ru' => 'Все курсы',
                            'kk' => 'Барлық курс',
                            'en' => 'All courses',
                        ],
                        'course_suffix' => [
                            'ru' => 'курс',
                            'kk' => 'курс',
                            'en' => 'course',
                        ],
                        
                        'specialty_filter_label' => [
                            'ru' => 'Специальность:',
                            'kk' => 'Мамандық:',
                            'en' => 'Specialty:',
                        ],
                        'specialty_filter_all' => [
                            'ru' => 'Все специальности',
                            'kk' => 'Барлық мамандық',
                            'en' => 'All specialties',
                        ],
                        'specialties_label' => [
                            'ru' => 'специальности',
                            'kk' => 'мамандық',
                            'en' => 'specialties',
                        ],
                        
                        'department_filter_label' => [
                            'ru' => 'Отделение:',
                            'kk' => 'Бөлімше:',
                            'en' => 'Department:',
                        ],
                        'department_filter_all' => [
                            'ru' => 'Все отделения',
                            'kk' => 'Барлық бөлімше',
                            'en' => 'All departments',
                        ],
                        
                        'groups_label' => [
                            'ru' => 'групп',
                            'kk' => 'топ',
                            'en' => 'groups',
                        ],
                        'students_label' => [
                            'ru' => 'студентов',
                            'kk' => 'студент',
                            'en' => 'students',
                        ],
                    ],
                ],
                
                // FILTER BUTTONS
                [
                    'page_key' => 'curators',
                    'section_key' => 'filter_buttons',
                    'title' => 'Кнопки фильтров',
                    'description' => 'Тексты кнопок управления фильтрами',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'reset_button' => [
                            'ru' => 'Сбросить',
                            'kk' => 'Қалпына келтіру',
                            'en' => 'Reset',
                        ],
                        'apply_button' => [
                            'ru' => 'Применить',
                            'kk' => 'Қолдану',
                            'en' => 'Apply',
                        ],
                        'clear_filters' => [
                            'ru' => 'Очистить все фильтры',
                            'kk' => 'Барлық сүзгілерді тазарту',
                            'en' => 'Clear all filters',
                        ],
                        'show_more' => [
                            'ru' => 'Показать ещё',
                            'kk' => 'Тағы көрсету',
                            'en' => 'Show more',
                        ],
                        'show_less' => [
                            'ru' => 'Свернуть',
                            'kk' => 'Жаю',
                            'en' => 'Show less',
                        ],
                    ],
                ],
                
                // EMPTY STATE MESSAGES
                [
                    'page_key' => 'curators',
                    'section_key' => 'empty_state',
                    'title' => 'Сообщения пустого состояния',
                    'description' => 'Тексты когда нет результатов поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'loading' => [
                            'ru' => 'Загрузка...',
                            'kk' => 'Жүктелуде...',
                            'en' => 'Loading...',
                        ],
                        'no_results_title' => [
                            'ru' => 'Ничего не найдено',
                            'kk' => 'Ештеңе табылмады',
                            'en' => 'No results found',
                        ],
                        'no_results_description' => [
                            'ru' => 'Попробуйте изменить параметры поиска или фильтры',
                            'kk' => 'Іздеу параметрлерін немесе сүзгілерді өзгертіп көріңіз',
                            'en' => 'Try changing search parameters or filters',
                        ],
                        'no_results_button' => [
                            'ru' => 'Сбросить фильтры',
                            'kk' => 'Сүзгілерді қалпына келтіру',
                            'en' => 'Reset filters',
                        ],
                        'try_again' => [
                            'ru' => 'Попробовать снова',
                            'kk' => 'Қайта байқап көру',
                            'en' => 'Try again',
                        ],
                        'error_message' => [
                            'ru' => 'Произошла ошибка при загрузке',
                            'kk' => 'Жүктеу кезінде қате орын алды',
                            'en' => 'An error occurred while loading',
                        ],
                    ],
                ],
                
                // CARD LABELS
                [
                    'page_key' => 'curators',
                    'section_key' => 'card_labels',
                    'title' => 'Надписи на карточках',
                    'description' => 'Тексты на карточках кураторов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'curator_label' => [
                            'ru' => 'Куратор',
                            'kk' => 'Куратор',
                            'en' => 'Curator',
                        ],
                        'students_label' => [
                            'ru' => 'Студентов',
                            'kk' => 'Студент',
                            'en' => 'Students',
                        ],
                        'room_label' => [
                            'ru' => 'Кабинет',
                            'kk' => 'Кабинет',
                            'en' => 'Room',
                        ],
                        'consultations_label' => [
                            'ru' => 'Консультации',
                            'kk' => 'Кеңестер',
                            'en' => 'Consultations',
                        ],
                        'email_label' => [
                            'ru' => 'Email',
                            'kk' => 'Email',
                            'en' => 'Email',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'schedule_label' => [
                            'ru' => 'Расписание',
                            'kk' => 'Кесте',
                            'en' => 'Schedule',
                        ],
                        'view_details' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'View details',
                        ],
                        'contact_button' => [
                            'ru' => 'Связаться',
                            'kk' => 'Байланысу',
                            'en' => 'Contact',
                        ],
                    ],
                ],
                
                // DETAILS MODAL
                [
                    'page_key' => 'curators',
                    'section_key' => 'details_modal',
                    'title' => 'Модальное окно деталей',
                    'description' => 'Тексты для модального окна с детальной информацией',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'close_button' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'full_info_title' => [
                            'ru' => 'Полная информация о кураторе',
                            'kk' => 'Куратор туралы толық ақпарат',
                            'en' => 'Full information about curator',
                        ],
                        'groups_managed_label' => [
                            'ru' => 'Курируемые группы:',
                            'kk' => 'Кураторлық жасайтын топтар:',
                            'en' => 'Managed groups:',
                        ],
                        'education_label' => [
                            'ru' => 'Образование:',
                            'kk' => 'Білімі:',
                            'en' => 'Education:',
                        ],
                        'experience_label' => [
                            'ru' => 'Стаж работы:',
                            'kk' => 'Жұмыс өтілі:',
                            'en' => 'Work experience:',
                        ],
                        'position_label' => [
                            'ru' => 'Должность:',
                            'kk' => 'Лауазымы:',
                            'en' => 'Position:',
                        ],
                        'schedule_title' => [
                            'ru' => 'Расписание консультаций:',
                            'kk' => 'Кеңестер кестесі:',
                            'en' => 'Consultation schedule:',
                        ],
                        'additional_info_title' => [
                            'ru' => 'Дополнительная информация:',
                            'kk' => 'Қосымша ақпарат:',
                            'en' => 'Additional information:',
                        ],
                        'download_schedule' => [
                            'ru' => 'Скачать расписание',
                            'kk' => 'Кестені жүктеу',
                            'en' => 'Download schedule',
                        ],
                        'print_schedule' => [
                            'ru' => 'Распечатать',
                            'kk' => 'Басып шығару',
                            'en' => 'Print',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'curators',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'help_button' => [
                            'ru' => 'Помощь',
                            'kk' => 'Көмек',
                            'en' => 'Help',
                        ],
                        'feedback_button' => [
                            'ru' => 'Обратная связь',
                            'kk' => 'Кері байланыс',
                            'en' => 'Feedback',
                        ],
                    ],
                ],

                // ПОЛЕЗНАЯ ИНФОРМАЦИЯ
                [
                    'page_key' => 'curators',
                    'section_key' => 'help_section',
                    'title' => 'Полезная информация',
                    'description' => 'Справочная информация для студентов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'title' => [
                            'ru' => 'Полезная информация',
                            'kk' => 'Пайдалы ақпарат',
                            'en' => 'Useful information',
                        ],
                        'tip_1_title' => [
                            'ru' => 'Роль куратора',
                            'kk' => 'Куратордың рөлі',
                            'en' => 'Role of curator',
                        ],
                        'tip_1_description' => [
                            'ru' => 'Куратор помогает студентам в решении учебных и организационных вопросов',
                            'kk' => 'Куратор студенттерге оқу және ұйымдастыру мәселелерін шешуде көмектеседі',
                            'en' => 'The curator helps students with academic and organizational issues',
                        ],
                        'tip_2_title' => [
                            'ru' => 'Консультации',
                            'kk' => 'Кеңестер',
                            'en' => 'Consultations',
                        ],
                        'tip_2_description' => [
                            'ru' => 'Вы можете записаться на индивидуальную консультацию к своему куратору',
                            'kk' => 'Сіз кураторыңызбен жеке кеңесқа жазыла аласыз',
                            'en' => 'You can sign up for an individual consultation with your curator',
                        ],
                        'tip_3_title' => [
                            'ru' => 'Обратная связь',
                            'kk' => 'Кері байланыс',
                            'en' => 'Feedback',
                        ],
                        'tip_3_description' => [
                            'ru' => 'Если у вас есть вопросы, свяжитесь с куратором через email или телефон',
                            'kk' => 'Егер сұрақтарыңыз болса, куратормен email немесе телефон арқылы байланысыңыз',
                            'en' => 'If you have questions, contact the curator via email or phone',
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
                    Log::info("Создана многоязычная Curators секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Curators: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Кураторы групп' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n👨‍🏫 Разделы страницы 'Кураторы групп':");
                $this->command->info("   🔍 SEO метаданные");
                $this->command->info("   👑 Главная заголовочная секция");
                $this->command->info("   📊 Карточки статистики (3 показателя)");
                $this->command->info("   🔎 Поиск с плейсхолдером");
                $this->command->info("   🏷️ Фильтры и выпадающие списки");
                $this->command->info("   🔘 Кнопки управления фильтрами");
                $this->command->info("   📭 Состояние пустого списка");
                $this->command->info("   🗂️ Надписи на карточках кураторов");
                $this->command->info("   🪟 Модальное окно с деталями");
                $this->command->info("   🧭 Навигационные кнопки");
                $this->command->info("   💡 Полезная информация для студентов");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}