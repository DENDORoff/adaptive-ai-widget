<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class StaffPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Администрация и преподаватели...');
            
            // Удаляем старые записи для страницы staff
            $deleted = PageSection::where('page_key', 'staff')->delete();
            Log::info("Удалено старых записей Staff: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'staff',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Администрация и преподаватели',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'page_title' => [
                            'ru' => 'Администрация и преподавательский состав',
                            'kk' => 'Әкімшілік және оқытушылар құрамы',
                            'en' => 'Administration and Teaching Staff',
                        ],
                        'meta_title' => [
                            'ru' => 'Администрация и преподаватели | Технический колледж современных технологий',
                            'kk' => 'Әкімшілік және оқытушылар | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Administration and Teachers | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Знакомство с профессиональной командой администрации и преподавателей колледжа. Опытные педагоги, квалифицированные специалисты.',
                            'kk' => 'Колледж әкімшілігі мен оқытушыларының кәсіби командасымен танысу. Тәжірибелі педагогтар, білікті мамандар.',
                            'en' => 'Get to know the professional team of college administration and teachers. Experienced educators, qualified specialists.',
                        ],
                    ],
                ],
                
                // Герой-секция
                [
                    'page_key' => 'staff',
                    'section_key' => 'hero',
                    'title' => 'Герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_part1' => [
                            'ru' => 'Администрация',
                            'kk' => 'Әкімшілік',
                            'en' => 'Administration',
                        ],
                        'main_title_part2' => [
                            'ru' => 'и преподаватели',
                            'kk' => 'және оқытушылар',
                            'en' => 'and Teachers',
                        ],
                        'description' => [
                            'ru' => 'Знакомство с профессиональной командой, которая создаёт будущее нашего образовательного учреждения',
                            'kk' => 'Біздің білім беру мекемесінің болашағын құрастыратын кәсіби командамен танысыңыз',
                            'en' => 'Meet the professional team that creates the future of our educational institution',
                        ],
                    ],
                ],
                
                // Заголовок администрации
                [
                    'page_key' => 'staff',
                    'section_key' => 'administration_header',
                    'title' => 'Заголовок раздела администрации',
                    'description' => 'Заголовок для раздела администрации колледжа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'Администрация колледжа',
                            'kk' => 'Колледж әкімшілігі',
                            'en' => 'College Administration',
                        ],
                    ],
                ],
                
                // Заголовок преподавателей
                [
                    'page_key' => 'staff',
                    'section_key' => 'teachers_header',
                    'title' => 'Заголовок раздела преподавателей',
                    'description' => 'Заголовок для раздела преподавательского состава',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Преподавательский состав',
                            'kk' => 'Оқытушылар құрамы',
                            'en' => 'Teaching Staff',
                        ],
                    ],
                ],
                
                // Плейсхолдеры поиска
                [
                    'page_key' => 'staff',
                    'section_key' => 'search_placeholder',
                    'title' => 'Плейсхолдер поиска',
                    'description' => 'Текст в поле поиска преподавателей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'text' => [
                            'ru' => 'Поиск по ФИО, должности или дисциплинам...',
                            'kk' => 'Аты-жөні, лауазымы немесе пәндері бойынша іздеу...',
                            'en' => 'Search by name, position or subjects...',
                        ],
                    ],
                ],
                
                // Опции сортировки
                [
                    'page_key' => 'staff',
                    'section_key' => 'sort_options',
                    'title' => 'Опции сортировки',
                    'description' => 'Названия опций в выпадающем списке сортировки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'name_asc' => [
                            'ru' => 'По имени А-Я',
                            'kk' => 'Аты бойынша А-Я',
                            'en' => 'By name A-Z',
                        ],
                        'name_desc' => [
                            'ru' => 'По имени Я-А',
                            'kk' => 'Аты бойынша Я-А',
                            'en' => 'By name Z-A',
                        ],
                        'position_asc' => [
                            'ru' => 'По должности А-Я',
                            'kk' => 'Лауазымы бойынша А-Я',
                            'en' => 'By position A-Z',
                        ],
                        'position_desc' => [
                            'ru' => 'По должности Я-А',
                            'kk' => 'Лауазымы бойынша Я-А',
                            'en' => 'By position Z-A',
                        ],
                        'experience_desc' => [
                            'ru' => 'По стажу (убыв.)',
                            'kk' => 'Тәжірибесі бойынша (кему)',
                            'en' => 'By experience (desc)',
                        ],
                        'experience_asc' => [
                            'ru' => 'По стажу (возр.)',
                            'kk' => 'Тәжірибесі бойынша (өсу)',
                            'en' => 'By experience (asc)',
                        ],
                        'category_asc' => [
                            'ru' => 'По категории А-Я',
                            'kk' => 'Санаты бойынша А-Я',
                            'en' => 'By category A-Z',
                        ],
                    ],
                ],
                
                // Подписи к полям
                [
                    'page_key' => 'staff',
                    'section_key' => 'field_labels',
                    'title' => 'Подписи к полям',
                    'description' => 'Названия полей в карточках преподавателей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'education_label' => [
                            'ru' => 'Образование:',
                            'kk' => 'Білімі:',
                            'en' => 'Education:',
                        ],
                        'specialty_label' => [
                            'ru' => 'Специальность:',
                            'kk' => 'Мамандығы:',
                            'en' => 'Specialty:',
                        ],
                        'category_label' => [
                            'ru' => 'Категория:',
                            'kk' => 'Санаты:',
                            'en' => 'Category:',
                        ],
                        'total_experience_label' => [
                            'ru' => 'Общий стаж:',
                            'kk' => 'Жалпы тәжірибесі:',
                            'en' => 'Total experience:',
                        ],
                        'pedagogical_experience_label' => [
                            'ru' => 'Пед. стаж:',
                            'kk' => 'Пед. тәжірибесі:',
                            'en' => 'Pedagogical experience:',
                        ],
                        'teaching_subjects_label' => [
                            'ru' => 'Дисциплины:',
                            'kk' => 'Пәндер:',
                            'en' => 'Subjects:',
                        ],
                    ],
                ],
                
                // Надписи на кнопках
                [
                    'page_key' => 'staff',
                    'section_key' => 'button_labels',
                    'title' => 'Надписи на кнопках',
                    'description' => 'Тексты на всех кнопках страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'apply_filter_btn' => [
                            'ru' => 'Применить',
                            'kk' => 'Қолдану',
                            'en' => 'Apply',
                        ],
                        'reset_filter_btn' => [
                            'ru' => 'Сбросить фильтр',
                            'kk' => 'Сүзгіні қалпына келтіру',
                            'en' => 'Reset filter',
                        ],
                        'reset_all_btn' => [
                            'ru' => 'Сбросить все',
                            'kk' => 'Барлығын қалпына келтіру',
                            'en' => 'Reset all',
                        ],
                        'remove_filter_btn' => [
                            'ru' => 'Удалить фильтр',
                            'kk' => 'Сүзгіні жою',
                            'en' => 'Remove filter',
                        ],
                        'reset_filters_btn' => [
                            'ru' => 'Сбросить фильтры',
                            'kk' => 'Сүзгілерді қалпына келтіру',
                            'en' => 'Reset filters',
                        ],
                    ],
                ],
                
                // Статистические метки
                [
                    'page_key' => 'staff',
                    'section_key' => 'stats_labels',
                    'title' => 'Статистические метки',
                    'description' => 'Подписи к блокам статистики',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'stat_1_label' => [
                            'ru' => 'Всего преподавателей',
                            'kk' => 'Барлық оқытушылар',
                            'en' => 'Total teachers',
                        ],
                        'stat_2_label' => [
                            'ru' => 'С категорией',
                            'kk' => 'Санаты бар',
                            'en' => 'With category',
                        ],
                        'stat_3_label' => [
                            'ru' => 'На странице',
                            'kk' => 'Бетте',
                            'en' => 'On page',
                        ],
                        'stat_4_label' => [
                            'ru' => 'Текущая страница',
                            'kk' => 'Ағымдағы бет',
                            'en' => 'Current page',
                        ],
                    ],
                ],
                
                // Активные фильтры
                [
                    'page_key' => 'staff',
                    'section_key' => 'active_filters',
                    'title' => 'Активные фильтры',
                    'description' => 'Тексты для блока активных фильтров',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'title' => [
                            'ru' => 'Активные фильтры:',
                            'kk' => 'Белсенді сүзгілер:',
                            'en' => 'Active filters:',
                        ],
                        'search_label' => [
                            'ru' => 'Поиск:',
                            'kk' => 'Іздеу:',
                            'en' => 'Search:',
                        ],
                        'sort_label' => [
                            'ru' => 'Сортировка:',
                            'kk' => 'Сұрыптау:',
                            'en' => 'Sort:',
                        ],
                    ],
                ],
                
                // Нет результатов
                [
                    'page_key' => 'staff',
                    'section_key' => 'no_results',
                    'title' => 'Нет результатов',
                    'description' => 'Сообщение при отсутствии результатов поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'message' => [
                            'ru' => 'Преподаватели не найдены',
                            'kk' => 'Оқытушылар табылмады',
                            'en' => 'Teachers not found',
                        ],
                    ],
                ],
                
                // Модальное окно преподавателя
                [
                    'page_key' => 'staff',
                    'section_key' => 'modal_labels',
                    'title' => 'Модальное окно преподавателя',
                    'description' => 'Тексты для модального окна с детальной информацией',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 12,
                    'content' => [
                        'close_btn' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'bio_title' => [
                            'ru' => 'О преподавателе',
                            'kk' => 'Оқытушы туралы',
                            'en' => 'About teacher',
                        ],
                        'education_title' => [
                            'ru' => 'Образование',
                            'kk' => 'Білімі',
                            'en' => 'Education',
                        ],
                        'specialty_title' => [
                            'ru' => 'Специальность',
                            'kk' => 'Мамандығы',
                            'en' => 'Specialty',
                        ],
                        'subjects_title' => [
                            'ru' => 'Преподаваемые дисциплины',
                            'kk' => 'Оқытатын пәндері',
                            'en' => 'Teaching subjects',
                        ],
                        'category_title' => [
                            'ru' => 'Категория',
                            'kk' => 'Санаты',
                            'en' => 'Category',
                        ],
                        'pedagogical_experience_title' => [
                            'ru' => 'Педагогический стаж',
                            'kk' => 'Педагогикалық тәжірибесі',
                            'en' => 'Pedagogical experience',
                        ],
                        'total_experience_title' => [
                            'ru' => 'Общий стаж',
                            'kk' => 'Жалпы тәжірибесі',
                            'en' => 'Total experience',
                        ],
                        'awards_title' => [
                            'ru' => 'Награды и достижения',
                            'kk' => 'Марапаттар мен жетістіктер',
                            'en' => 'Awards and achievements',
                        ],
                        'development_title' => [
                            'ru' => 'Повышение квалификации',
                            'kk' => 'Біліктілігін арттыру',
                            'en' => 'Professional development',
                        ],
                        'contact_info_title' => [
                            'ru' => 'Контактная информация',
                            'kk' => 'Байланыс ақпараты',
                            'en' => 'Contact information',
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
                    Log::info("Создана многоязычная Staff секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Staff были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Staff были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных секций Staff: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Администрация и преподаватели' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🎉 Разделы страницы 'Администрация и преподаватели':");
                $this->command->info("   👑 Герой-секция с заголовком");
                $this->command->info("   🏛️  Заголовок администрации");
                $this->command->info("   👨‍🏫 Заголовок преподавателей");
                $this->command->info("   🔍 Плейсхолдер поиска");
                $this->command->info("   🔢 Опции сортировки");
                $this->command->info("   📝 Подписи к полям карточек");
                $this->command->info("   🎛️  Надписи на кнопках");
                $this->command->info("   📊 Статистические метки");
                $this->command->info("   🎚️  Активные фильтры");
                $this->command->info("   🚫 Нет результатов");
                $this->command->info("   💬 Модальное окно преподавателя");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка Staff: {$e->getMessage()}");
            $this->command->error("❌ Ошибка Staff: {$e->getMessage()}");
            throw $e;
        }
    }
}