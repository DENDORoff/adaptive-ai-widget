<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной главной страницы...');
            
            // Удаляем старые записи для главной страницы
            $deleted = PageSection::where('page_key', 'home')->delete();
            Log::info("Удалено старых записей Home: {$deleted}");
            $this->command->info('🗑️ Удалены старые записи для главной страницы');

            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'home',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные главной страницы',
                    'description' => 'SEO и общие настройки главной страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Высший Колледж Электроники и Связи',
                            'kk' => 'Электроника және Байланыс Жоғары Колледжі',
                            'en' => 'Higher College of Electronics and Communications',
                        ],
                        'meta_title' => [
                            'ru' => 'Высший Колледж Электроники и Связи | Образование в IT и телекоммуникациях',
                            'kk' => 'Электроника және Байланыс Жоғары Колледжі | IT және телекоммуникация саласындағы білім',
                            'en' => 'Higher College of Electronics and Communications | Education in IT and telecommunications',
                        ],
                        'meta_description' => [
                            'ru' => 'Ведущий колледж в области IT, электроники и связи. Подготовка специалистов железнодорожного транспорта, телекоммуникаций и информационных технологий.',
                            'kk' => 'IT, электроника және байланыс саласындағы жетекші колледж. Теміржол көлігі, телекоммуникация және ақпараттық технологиялар саласында мамандар даярлау.',
                            'en' => 'Leading college in IT, electronics and communications. Training specialists in railway transport, telecommunications and information technology.',
                        ],
                    ],
                ],

                // Главная страница - Hero секция
                [
                    'page_key' => 'home',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с каруселью и заголовком',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Высший Колледж Электроники и Связи',
                            'kk' => 'Электроника және Байланыс Жоғары Колледжі',
                            'en' => 'Higher College of Electronics and Communications',
                        ],
                        'main_description' => [
                            'ru' => 'Мы открываем двери для будущих специалистов в области железнодорожного транспорта, телекоммуникаций и информационных технологий',
                            'kk' => 'Біз теміржол көлігі, телекоммуникация және ақпараттық технологиялар саласындағы болашақ мамандарға есіктер ашамыз',
                            'en' => 'We open doors for future specialists in railway transport, telecommunications and information technology',
                        ],
                        
                        'button_1_text' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual tour',
                        ],
                        'button_1_link' => [
                            'ru' => '#virtual-tour',
                            'kk' => '#virtual-tour',
                            'en' => '#virtual-tour',
                        ],
                        
                        'button_2_text' => [
                            'ru' => 'Личный кабинет студента',
                            'kk' => 'Студенттің жеке кабинеті',
                            'en' => 'Student\'s personal account',
                        ],
                        'button_2_link' => [
                            'ru' => 'https://college.smartnation.kz/ru/mng/login',
                            'kk' => 'https://college.smartnation.kz/kk/mng/login',
                            'en' => 'https://college.smartnation.kz/en/mng/login',
                        ],
                        
                        'button_3_text' => [
                            'ru' => 'Полезные ссылки',
                            'kk' => 'Пайдалы сілтемелер',
                            'en' => 'Useful links',
                        ],
                        
                        // Картинки для карусели (одинаковые для всех языков)
                        'carousel_image_1' => [
                            'ru' => 'images/back.jpg',
                            'kk' => 'images/back.jpg',
                            'en' => 'images/back.jpg',
                        ],
                        'carousel_image_2' => [
                            'ru' => 'images/college1.jpg',
                            'kk' => 'images/college1.jpg',
                            'en' => 'images/college1.jpg',
                        ],
                        'carousel_image_3' => [
                            'ru' => 'images/college2.jpg',
                            'kk' => 'images/college2.jpg',
                            'en' => 'images/college2.jpg',
                        ],
                        'carousel_image_4' => [
                            'ru' => 'images/college3.jpg',
                            'kk' => 'images/college3.jpg',
                            'en' => 'images/college3.jpg',
                        ],
                        
                        // Альтернативные тексты для изображений
                        'carousel_alt_1' => [
                            'ru' => 'Высший Колледж Электроники и Связи - Главное здание',
                            'kk' => 'Электроника және Байланыс Жоғары Колледжі - Негізгі ғимарат',
                            'en' => 'Higher College of Electronics and Communications - Main building',
                        ],
                        'carousel_alt_2' => [
                            'ru' => 'Территория колледжа',
                            'kk' => 'Колледж аумағы',
                            'en' => 'College territory',
                        ],
                        'carousel_alt_3' => [
                            'ru' => 'Студенты в аудитории',
                            'kk' => 'Аудиториядағы студенттер',
                            'en' => 'Students in the classroom',
                        ],
                        'carousel_alt_4' => [
                            'ru' => 'Лаборатория колледжа',
                            'kk' => 'Колледж зертханасы',
                            'en' => 'College laboratory',
                        ],
                    ],
                ],

                // Главная страница - Статистика
                [
                    'page_key' => 'home',
                    'section_key' => 'stats',
                    'title' => 'Статистика главной страницы',
                    'description' => 'Цифры и показатели в герое',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'stat_1_value' => [
                            'ru' => '45',
                            'kk' => '45',
                            'en' => '45',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Лет опыта',
                            'kk' => 'Жыл тәжірибе',
                            'en' => 'Years of experience',
                        ],
                        
                        'stat_2_value' => [
                            'ru' => '956',
                            'kk' => '956',
                            'en' => '956',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Студентов',
                            'kk' => 'Студент',
                            'en' => 'Students',
                        ],
                        
                        'stat_3_value' => [
                            'ru' => '100',
                            'kk' => '100',
                            'en' => '100',
                        ],
                        'stat_3_label' => [
                            'ru' => 'Трудоустройство и занятость',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'stat_3_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        
                        'stat_4_value' => [
                            'ru' => '71',
                            'kk' => '71',
                            'en' => '71',
                        ],
                        'stat_4_label' => [
                            'ru' => 'Преподаватель',
                            'kk' => 'Оқытушы',
                            'en' => 'Teachers',
                        ],
                    ],
                ],

                // Главная страница - Полезные ссылки
                [
                    'page_key' => 'home',
                    'section_key' => 'useful_links',
                    'title' => 'Полезные ссылки',
                    'description' => 'Быстрые ссылки на официальные ресурсы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Полезные ссылки',
                            'kk' => 'Пайдалы сілтемелер',
                            'en' => 'Useful links',
                        ],
                        
                        'link_1_title' => [
                            'ru' => 'Официальный сайт Президента Республики Казахстан',
                            'kk' => 'Қазақстан Республикасы Президентінің ресми сайты',
                            'en' => 'Official website of the President of the Republic of Kazakhstan',
                        ],
                        'link_1_url' => [
                            'ru' => 'https://www.akorda.kz/',
                            'kk' => 'https://www.akorda.kz/',
                            'en' => 'https://www.akorda.kz/',
                        ],
                        'link_1_icon' => [
                            'ru' => 'https://www.gov.kz/favicon.ico',
                            'kk' => 'https://www.gov.kz/favicon.ico',
                            'en' => 'https://www.gov.kz/favicon.ico',
                        ],
                        
                        'link_2_title' => [
                            'ru' => 'Официальный информационный ресурс Премьер-Министра РК',
                            'kk' => 'ҚР Премьер-Министрінің ресми ақпараттық ресурсы',
                            'en' => 'Official information resource of the Prime Minister of the Republic of Kazakhstan',
                        ],
                        'link_2_url' => [
                            'ru' => 'https://www.primeminister.kz/',
                            'kk' => 'https://www.primeminister.kz/',
                            'en' => 'https://www.primeminister.kz/',
                        ],
                        'link_2_icon' => [
                            'ru' => 'https://www.gov.kz/favicon.ico',
                            'kk' => 'https://www.gov.kz/favicon.ico',
                            'en' => 'https://www.gov.kz/favicon.ico',
                        ],
                        
                        'link_3_title' => [
                            'ru' => 'Министерство просвещения Республики Казахстан',
                            'kk' => 'Қазақстан Республикасы Ағарту министрлігі',
                            'en' => 'Ministry of Education of the Republic of Kazakhstan',
                        ],
                        'link_3_url' => [
                            'ru' => 'https://www.gov.kz/memleket/entities/edu',
                            'kk' => 'https://www.gov.kz/memleket/entities/edu',
                            'en' => 'https://www.gov.kz/memleket/entities/edu',
                        ],
                        'link_3_icon' => [
                            'ru' => 'https://www.gov.kz/favicon.ico',
                            'kk' => 'https://www.gov.kz/favicon.ico',
                            'en' => 'https://www.gov.kz/favicon.ico',
                        ],
                        
                        'link_4_title' => [
                            'ru' => 'Управление образования Павлодарской области',
                            'kk' => 'Павлодар облысының Білім басқармасы',
                            'en' => 'Education Department of Pavlodar region',
                        ],
                        'link_4_url' => [
                            'ru' => 'https://www.gov.kz/memleket/entities/pavlodar-edu',
                            'kk' => 'https://www.gov.kz/memleket/entities/pavlodar-edu',
                            'en' => 'https://www.gov.kz/memleket/entities/pavlodar-edu',
                        ],
                        'link_4_icon' => [
                            'ru' => 'https://www.gov.kz/favicon.ico',
                            'kk' => 'https://www.gov.kz/favicon.ico',
                            'en' => 'https://www.gov.kz/favicon.ico',
                        ],
                    ],
                ],

                // Главная страница - Новости (заголовок секции)
                [
                    'page_key' => 'home',
                    'section_key' => 'news_section',
                    'title' => 'Секция новостей на главной',
                    'description' => 'Заголовок и кнопка секции новостей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Новости колледжа',
                            'kk' => 'Колледждің жаңалықтары',
                            'en' => 'College news',
                        ],
                        'subtitle' => [
                            'ru' => 'Будьте в курсе всех событий',
                            'kk' => 'Барлық оқиғалардан хабардар болыңыз',
                            'en' => 'Stay up to date with all events',
                        ],
                        'view_all_text' => [
                            'ru' => 'Все новости',
                            'kk' => 'Барлық жаңалықтар',
                            'en' => 'All news',
                        ],
                        'view_all_url' => [
                            'ru' => '/news',
                            'kk' => '/news',
                            'en' => '/news',
                        ],
                    ],
                ],

                // Главная страница - Навигация
                [
                    'page_key' => 'home',
                    'section_key' => 'navigation',
                    'title' => 'Навигационные элементы',
                    'description' => 'Навигационные кнопки и ссылки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'quick_links_title' => [
                            'ru' => 'Быстрые ссылки',
                            'kk' => 'Жылдам сілтемелер',
                            'en' => 'Quick links',
                        ],
                        'goto_about' => [
                            'ru' => 'О колледже',
                            'kk' => 'Колледж туралы',
                            'en' => 'About college',
                        ],
                        'goto_staff' => [
                            'ru' => 'Администрация',
                            'kk' => 'Әкімшілік',
                            'en' => 'Administration',
                        ],
                        'goto_contact' => [
                            'ru' => 'Контакты',
                            'kk' => 'Байланыстар',
                            'en' => 'Contacts',
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
                    Log::info("Создана многоязычная Home секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Home секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Home секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Home были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Home были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных Home секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная главная страница успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Home секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🏠 Разделы главной страницы:");
                $this->command->info("   👑 Герой-секция с каруселью и кнопками");
                $this->command->info("   📊 Статистика колледжа (4 показателя)");
                $this->command->info("   🔗 Полезные ссылки (4 официальных ресурса)");
                $this->command->info("   📰 Секция новостей с заголовками");
                $this->command->info("   🧭 Навигационные элементы");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
            // Показать созданные секции
            $this->command->info("\n📋 Созданные секции для home:");
            PageSection::where('page_key', 'home')
                ->orderBy('sort_order')
                ->get(['id', 'section_key', 'title', 'is_active'])
                ->each(function ($section) {
                    $status = $section->is_active ? '🟢' : '🔴';
                    $this->command->info("{$status} {$section->id}. {$section->section_key} - {$section->title}");
                });
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании главной страницы: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании главной страницы: {$e->getMessage()}");
            throw $e;
        }
    }
}