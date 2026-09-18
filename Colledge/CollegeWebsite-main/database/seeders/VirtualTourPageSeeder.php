<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class VirtualTourPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Виртуальный тур...');
            
            // Удаляем старые записи для страницы virtual-tour
            $deleted = PageSection::where('page_key', 'virtual-tour')->delete();
            Log::info("Удалено старых записей Virtual Tour: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'virtual-tour',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Виртуальный тур',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual Tour',
                        ],
                        'meta_title' => [
                            'ru' => 'Виртуальный тур по колледжу | Технический колледж современных технологий',
                            'kk' => 'Колледждің виртуалды сыры | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Virtual Tour of the College | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Онлайн экскурсия по Техническому колледжу современных технологий. Посетите наши аудитории, лаборатории, спортивные залы и библиотеку не выходя из дома.',
                            'kk' => 'Заманауи технологиялардың техникалық колледжіне онлайн экскурсия. Үйіңізден шықпай біздің сыныптарды, зертханаларды, спорт залдары мен кітапхананы кіріңіз.',
                            'en' => 'Online tour of the Technical College of Modern Technologies. Visit our classrooms, laboratories, gyms and library from the comfort of your home.',
                        ],
                    ],
                ],
                
                // Главная герой-секция
                [
                    'page_key' => 'virtual-tour',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Заголовок, подзаголовок и кнопка',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'Virtual Tour',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual Tour',
                        ],
                        'subtitle' => [
                            'ru' => 'Познакомьтесь с нашим колледжем онлайн',
                            'kk' => 'Колледжімізбен онлайн танысыңыз',
                            'en' => 'Get to know our college online',
                        ],
                        'fullscreen_button_text' => [
                            'ru' => 'Полноэкранный режим',
                            'kk' => 'Толық экран режимі',
                            'en' => 'Fullscreen mode',
                        ],
                    ],
                ],

                // Iframe виртуального тура
                [
                    'page_key' => 'virtual-tour',
                    'section_key' => 'tour_iframe',
                    'title' => 'Iframe виртуального тура',
                    'description' => 'Настройки iframe для встраивания виртуального тура',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'iframe_src' => [
                            'ru' => '/virtual-tour/index.html',
                            'kk' => '/virtual-tour/index.html',
                            'en' => '/virtual-tour/index.html',
                        ],
                        'iframe_alt' => [
                            'ru' => 'Виртуальный тур по колледжу',
                            'kk' => 'Колледждің виртуалды сыры',
                            'en' => 'Virtual tour of the college',
                        ],
                    ],
                ],

                // Карусель видеоматериалов
                [
                    'page_key' => 'virtual-tour',
                    'section_key' => 'videos_carousel',
                    'title' => 'Карусель видеоматериалов',
                    'description' => 'Настройки карусели видео и видео контент',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'carousel_title' => [
                            'ru' => 'Видеоматериалы',
                            'kk' => 'Бейне материалдар',
                            'en' => 'Video Materials',
                        ],
                        'autoplay_enabled' => [
                            'ru' => 'false',
                            'kk' => 'false',
                            'en' => 'false',
                        ],
                        'autoplay_interval' => [
                            'ru' => '5000',
                            'kk' => '5000',
                            'en' => '5000',
                        ],
                        
                        // Видео 1
                        'video_1_id' => [
                            'ru' => 'dQw4w9WgXcQ',
                            'kk' => 'dQw4w9WgXcQ',
                            'en' => 'dQw4w9WgXcQ',
                        ],
                        'video_1_title' => [
                            'ru' => 'Экскурсия по колледжу',
                            'kk' => 'Колледж бойынша экскурсия',
                            'en' => 'College Tour',
                        ],
                        
                        // Видео 2
                        'video_2_id' => [
                            'ru' => '9bZkp7q19f0',
                            'kk' => '9bZkp7q19f0',
                            'en' => '9bZkp7q19f0',
                        ],
                        'video_2_title' => [
                            'ru' => 'День открытых дверей',
                            'kk' => 'Ашық есік күні',
                            'en' => 'Open House Day',
                        ],
                        
                        // Видео 3
                        'video_3_id' => [
                            'ru' => 'kXYiU_JCYtU',
                            'kk' => 'kXYiU_JCYtU',
                            'en' => 'kXYiU_JCYtU',
                        ],
                        'video_3_title' => [
                            'ru' => 'Лаборатории и оборудование',
                            'kk' => 'Зертханалар және жабдықтар',
                            'en' => 'Laboratories and Equipment',
                        ],
                        
                        // Видео 4
                        'video_4_id' => [
                            'ru' => 'n6BwAWiHcSg',
                            'kk' => 'n6BwAWiHcSg',
                            'en' => 'n6BwAWiHcSg',
                        ],
                        'video_4_title' => [
                            'ru' => 'Студенческая жизнь',
                            'kk' => 'Студенттік өмір',
                            'en' => 'Student Life',
                        ],
                        
                        // Видео 5
                        'video_5_id' => [
                            'ru' => '2Vv-BfVoq4g',
                            'kk' => '2Vv-BfVoq4g',
                            'en' => '2Vv-BfVoq4g',
                        ],
                        'video_5_title' => [
                            'ru' => 'Спортивные объекты',
                            'kk' => 'Спорт нысандары',
                            'en' => 'Sports Facilities',
                        ],
                        
                        // Видео 6
                        'video_6_id' => [
                            'ru' => 'T6DJcgm3wNY',
                            'kk' => 'T6DJcgm3wNY',
                            'en' => 'T6DJcgm3wNY',
                        ],
                        'video_6_title' => [
                            'ru' => 'Библиотека и ресурсы',
                            'kk' => 'Кітапхана және ресурстар',
                            'en' => 'Library and Resources',
                        ],
                        
                        // Видео 7
                        'video_7_id' => [
                            'ru' => 'L_jWHffIx5E',
                            'kk' => 'L_jWHffIx5E',
                            'en' => 'L_jWHffIx5E',
                        ],
                        'video_7_title' => [
                            'ru' => 'Мероприятия и праздники',
                            'kk' => 'Іс-шаралар мен мерекелер',
                            'en' => 'Events and Holidays',
                        ],
                        
                        // Видео 8
                        'video_8_id' => [
                            'ru' => 'CduA0TULnow',
                            'kk' => 'CduA0TULnow',
                            'en' => 'CduA0TULnow',
                        ],
                        'video_8_title' => [
                            'ru' => 'Профессорско-преподавательский состав',
                            'kk' => 'Профессорлық-оқытушылық құрам',
                            'en' => 'Teaching Staff',
                        ],
                        
                        // Видео 9
                        'video_9_id' => [
                            'ru' => 'FEKEjpTzB0Q',
                            'kk' => 'FEKEjpTzB0Q',
                            'en' => 'FEKEjpTzB0Q',
                        ],
                        'video_9_title' => [
                            'ru' => 'Международные программы',
                            'kk' => 'Халықаралық бағдарламалар',
                            'en' => 'International Programs',
                        ],
                        
                        // Видео 10
                        'video_10_id' => [
                            'ru' => 'ZbZSe6N_BXs',
                            'kk' => 'ZbZSe6N_BXs',
                            'en' => 'ZbZSe6N_BXs',
                        ],
                        'video_10_title' => [
                            'ru' => 'Карьерные перспективы',
                            'kk' => 'Мансаптық перспективалар',
                            'en' => 'Career Prospects',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'virtual-tour',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
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
                    Log::info("Создана многоязычная Virtual Tour секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Virtual Tour: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Виртуальный тур' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🎬 Особенности страницы 'Виртуальный тур':");
                $this->command->info("   🏫 Интерактивный виртуальный тур с iframe");
                $this->command->info("   🎥 Карусель из 10 видеоматериалов");
                $this->command->info("   🔄 Автопрокрутка видео (настраиваемая)");
                $this->command->info("   📺 Модальное окно для просмотра видео");
                $this->command->info("   ⏸️ Управление автовоспроизведением");
                $this->command->info("   🖥️ Полноэкранный режим для тура");
                $this->command->info("   📱 Адаптивный дизайн для всех устройств");
                
                $this->command->info("\n🎥 Загруженные видеоматериалы:");
                $this->command->info("   1. Экскурсия по колледжу");
                $this->command->info("   2. День открытых дверей");
                $this->command->info("   3. Лаборатории и оборудование");
                $this->command->info("   4. Студенческая жизнь");
                $this->command->info("   5. Спортивные объекты");
                $this->command->info("   6. Библиотека и ресурсы");
                $this->command->info("   7. Мероприятия и праздники");
                $this->command->info("   8. Преподавательский состав");
                $this->command->info("   9. Международные программы");
                $this->command->info("   10. Карьерные перспективы");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}