<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class LibraryPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы библиотеки...');
            $this->command->info('🔄 Начинаем заполнение страницы библиотеки...');
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', 'library')->delete();
            Log::info("Удалено старых записей Library: {$deleted}");
            $this->command->info("🗑️ Удалено старых записей: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'library',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы библиотеки',
                    'description' => 'SEO и общие настройки страницы библиотеки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Библиотека колледжа',
                            'kk' => 'Колледж кітапханасы',
                            'en' => 'College library',
                        ],
                        'meta_title' => [
                            'ru' => 'Библиотека | Цифровая библиотека колледжа электроники и связи',
                            'kk' => 'Кітапхана | Электроника және байланыс колледжінің цифрлық кітапханасы',
                            'en' => 'Library | Digital library of the College of Electronics and Communications',
                        ],
                        'meta_description' => [
                            'ru' => 'Современная цифровая библиотека колледжа. Электронные книги, читальный зал, виртуальный тур, онлайн-ресурсы для студентов.',
                            'kk' => 'Колледждің заманауи цифрлық кітапханасы. Электрондық кітаптар, оқу залы, виртуалды тур, студенттерге арналған онлайн ресурстар.',
                            'en' => 'Modern digital library of the college. E-books, reading room, virtual tour, online resources for students.',
                        ],
                    ],
                ],

                // Герой секция библиотеки
                [
                    'page_key' => 'library',
                    'section_key' => 'hero',
                    'title' => 'Герой секция библиотеки',
                    'description' => 'Основной баннер с заголовком и кнопками призыва к действию',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'badge_text' => [
                            'ru' => 'DIGITAL LIBRARY',
                            'kk' => 'ЦИФРЛЫҚ КІТАПХАНА',
                            'en' => 'DIGITAL LIBRARY',
                        ],
                        'main_title_part1' => [
                            'ru' => 'Библиотека',
                            'kk' => 'Кітапхана',
                            'en' => 'Library',
                        ],
                        'main_title_part2' => [
                            'ru' => 'колледжа',
                            'kk' => 'колледжі',
                            'en' => 'of the college',
                        ],
                        'description' => [
                            'ru' => 'Современное пространство для обучения, исследований и инноваций. Место, где знания встречаются с технологиями.',
                            'kk' => 'Оқу, зерттеу және инновацияларға арналған заманауи кеңістік. Білім технологиялармен кездесетін орын.',
                            'en' => 'A modern space for learning, research and innovation. A place where knowledge meets technology.',
                        ],
                        'button_1_text' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual tour',
                        ],
                        'button_1_link' => [
                            'ru' => '#virtual',
                            'kk' => '#virtual',
                            'en' => '#virtual',
                        ],
                        'button_2_text' => [
                            'ru' => 'Узнать больше',
                            'kk' => 'Көбірек білу',
                            'en' => 'Learn more',
                        ],
                        'button_2_link' => [
                            'ru' => '#features',
                            'kk' => '#features',
                            'en' => '#features',
                        ],
                    ],
                ],

                // Ключевые возможности библиотеки
                [
                    'page_key' => 'library',
                    'section_key' => 'key_features',
                    'title' => 'Ключевые возможности библиотеки',
                    'description' => 'Блок с тремя карточками, описывающими основные преимущества библиотеки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Ключевые возможности',
                            'kk' => 'Негізгі мүмкіндіктер',
                            'en' => 'Key features',
                        ],
                        
                        // Главная карточка
                        'main_card_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800',
                            'kk' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800',
                            'en' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800',
                        ],
                        'main_card_badge' => [
                            'ru' => 'Premium Space',
                            'kk' => 'Премиум кеңістік',
                            'en' => 'Premium Space',
                        ],
                        'main_card_title' => [
                            'ru' => 'Читальный зал нового поколения',
                            'kk' => 'Жаңа буын оқу залы',
                            'en' => 'Next generation reading room',
                        ],
                        'main_card_description' => [
                            'ru' => 'Просторный зал на 150 мест, оборудованный современной мебелью, индивидуальными рабочими местами с розетками USB-C и беспроводной зарядкой. Система климат-контроля и звукоизоляция обеспечивают максимальный комфорт.',
                            'kk' => '150 орынға арналған кең зал, заманауи жиһаздармен жабдықталған, USB-C разеткалары мен сымсыз зарядтау құрылғылары бар жеке жұмыс орындары. Климатты басқару жүйесі мен дыбысты оқшаулау максималды ыңғайлылықты қамтамасыз етеді.',
                            'en' => 'A spacious hall for 150 seats, equipped with modern furniture, individual workplaces with USB-C sockets and wireless charging. Climate control system and sound insulation provide maximum comfort.',
                        ],
                        'main_card_stat_1_label' => [
                            'ru' => '150 мест',
                            'kk' => '150 орын',
                            'en' => '150 seats',
                        ],
                        'main_card_stat_2_label' => [
                            'ru' => 'Высокоскоростной Wi-Fi',
                            'kk' => 'Жоғары жылдамдықты Wi-Fi',
                            'en' => 'High-speed Wi-Fi',
                        ],
                        
                        // Карточка 2
                        'card_2_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=800',
                            'kk' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=800',
                            'en' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=800',
                        ],
                        'card_2_badge' => [
                            'ru' => 'Digital Access',
                            'kk' => 'Цифрлық қол жетімділік',
                            'en' => 'Digital Access',
                        ],
                        'card_2_title' => [
                            'ru' => 'Электронная библиотека',
                            'kk' => 'Электрондық кітапхана',
                            'en' => 'Electronic library',
                        ],
                        'card_2_description' => [
                            'ru' => '50,000+ электронных книг и научных журналов с доступом 24/7',
                            'kk' => '50,000+ электрондық кітаптар мен ғылыми журналдар 24/7 қол жетімді',
                            'en' => '50,000+ e-books and scientific journals with 24/7 access',
                        ],
                        'card_2_stat' => [
                            'ru' => '50,000+ книг',
                            'kk' => '50,000+ кітап',
                            'en' => '50,000+ books',
                        ],
                        
                        // Карточка 3
                        'card_3_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800',
                            'kk' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800',
                            'en' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800',
                        ],
                        'card_3_badge' => [
                            'ru' => 'Collaboration',
                            'kk' => 'Ынтымақтастық',
                            'en' => 'Collaboration',
                        ],
                        'card_3_title' => [
                            'ru' => 'Коворкинг-зоны',
                            'kk' => 'Коворкинг-аймақтар',
                            'en' => 'Coworking zones',
                        ],
                        'card_3_description' => [
                            'ru' => 'Современные переговорные для командной работы над проектами',
                            'kk' => 'Жобалар бойынша командалық жұмыс үшін заманауи кеңселер',
                            'en' => 'Modern meeting rooms for team work on projects',
                        ],
                        'card_3_stat' => [
                            'ru' => '8 переговорных',
                            'kk' => '8 кеңсе',
                            'en' => '8 meeting rooms',
                        ],
                    ],
                ],

                // Виртуальный тур по библиотеке
                [
                    'page_key' => 'library',
                    'section_key' => 'virtual_tour',
                    'title' => 'Виртуальный тур по библиотеке',
                    'description' => 'Блок с iframe для виртуальной экскурсии 360°',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Виртуальный тур 360°',
                            'kk' => '360° виртуалды тур',
                            'en' => '360° Virtual tour',
                        ],
                        'section_description' => [
                            'ru' => 'Совершите виртуальную прогулку по библиотеке не выходя из дома',
                            'kk' => 'Үйден шықпай кітапхана бойынша виртуалды серуен жасаңыз',
                            'en' => 'Take a virtual walk through the library without leaving home',
                        ],
                        'iframe_src' => [
                            'ru' => 'https://www.google.com/maps/embed?pb=!4v1234567890!6m8!1m7!1sCAoSLEFGMVFpcE5rOXBxYzRCNVpfX0hfRVE4QlFwQkxVRV8!2m2!1d40.7127281!2d-74.0060152!3f0!4f0!5f0.7820865974627469',
                            'kk' => 'https://www.google.com/maps/embed?pb=!4v1234567890!6m8!1m7!1sCAoSLEFGMVFpcE5rOXBxYzRCNVpfX0hfRVE4QlFwQkxVRV8!2m2!1d40.7127281!2d-74.0060152!3f0!4f0!5f0.7820865974627469',
                            'en' => 'https://www.google.com/maps/embed?pb=!4v1234567890!6m8!1m7!1sCAoSLEFGMVFpcE5rOXBxYzRCNVpfX0hfRVE4QlFwQkxVRV8!2m2!1d40.7127281!2d-74.0060152!3f0!4f0!5f0.7820865974627469',
                        ],
                    ],
                ],

                // Статистика библиотеки
                [
                    'page_key' => 'library',
                    'section_key' => 'library_stats',
                    'title' => 'Статистика библиотеки',
                    'description' => 'Цифры и показатели библиотечных ресурсов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Цифры библиотеки',
                            'kk' => 'Кітапхана сандары',
                            'en' => 'Library numbers',
                        ],
                        
                        'stat_1_value' => [
                            'ru' => '50,000',
                            'kk' => '50,000',
                            'en' => '50,000',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Электронных книг',
                            'kk' => 'Электрондық кітаптар',
                            'en' => 'E-books',
                        ],
                        
                        'stat_2_value' => [
                            'ru' => '2,500',
                            'kk' => '2,500',
                            'en' => '2,500',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Научных журналов',
                            'kk' => 'Ғылыми журналдар',
                            'en' => 'Scientific journals',
                        ],
                        
                        'stat_3_value' => [
                            'ru' => '150',
                            'kk' => '150',
                            'en' => '150',
                        ],
                        'stat_3_label' => [
                            'ru' => 'Рабочих мест',
                            'kk' => 'Жұмыс орындары',
                            'en' => 'Workplaces',
                        ],
                        
                        'stat_4_value' => [
                            'ru' => '24/7',
                            'kk' => '24/7',
                            'en' => '24/7',
                        ],
                        'stat_4_label' => [
                            'ru' => 'Доступ онлайн',
                            'kk' => 'Онлайн қол жетімділік',
                            'en' => 'Online access',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'library',
                    'section_key' => 'navigation',
                    'title' => 'Навигация библиотеки',
                    'description' => 'Навигационные элементы на странице библиотеки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад к главной',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'hours_title' => [
                            'ru' => 'Часы работы',
                            'kk' => 'Жұмыс сағаттары',
                            'en' => 'Working hours',
                        ],
                        'hours_weekdays' => [
                            'ru' => 'Пн-Пт: 9:00 - 20:00',
                            'kk' => 'Дүйсен-Жұма: 9:00 - 20:00',
                            'en' => 'Mon-Fri: 9:00 - 20:00',
                        ],
                        'hours_weekend' => [
                            'ru' => 'Сб: 10:00 - 16:00',
                            'kk' => 'Сенбі: 10:00 - 16:00',
                            'en' => 'Sat: 10:00 - 16:00',
                        ],
                        'hours_online' => [
                            'ru' => 'Онлайн доступ: круглосуточно',
                            'kk' => 'Онлайн қол жетімділік: тәулік бойы',
                            'en' => 'Online access: 24/7',
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
                    Log::info("Создана многоязычная Library секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Library секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Library секции {$section['section_key']}: {$e->getMessage()}");
                    $this->command->error("❌ Ошибка при создании секции {$section['title']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Library были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Library были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных Library секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Библиотека' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Library секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📚 Разделы страницы 'Библиотека':");
                $this->command->info("   👑 Герой-секция с цифровой библиотекой");
                $this->command->info("   🎯 Ключевые возможности (3 карточки)");
                $this->command->info("   🏛️ Виртуальный тур 360°");
                $this->command->info("   📊 Статистика библиотеки (4 показателя)");
                $this->command->info("   ⏰ Часы работы и доступность");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
            $this->command->info("🎉 Страница библиотеки заполнена! Создано секций: {$createdCount}");
            $this->command->info('📝 Теперь вы можете редактировать контент через Filament в разделе PageSection');
            
        } catch (\Exception $e) {
            Log::critical('LibraryPageSeeder критическая ошибка', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->command->error("💥 Критическая ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}