<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class AchievementsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Достижения и выпускники...');
            
            $deleted = PageSection::where('page_key', 'achievements')->delete();
            Log::info("Удалено старых записей Achievements: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'achievements',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Достижения',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Достижения колледжа и наши выпускники',
                            'kk' => 'Колледждің жетістіктері және біздің түлектер',
                            'en' => 'College Achievements and Our Graduates',
                        ],
                        'meta_title' => [
                            'ru' => 'Достижения колледжа и выпускники | Технический колледж современных технологий',
                            'kk' => 'Колледждің жетістіктері мен түлектер | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'College Achievements and Graduates | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Достижения колледжа, победы в конкурсах, успехи выпускников. Истории карьеры наших выпускников в IT, телекоммуникациях и железнодорожном транспорте.',
                            'kk' => 'Колледждің жетістіктері, байқаулардағы жеңістер, түлектердің табыстары. IT, телекоммуникация және теміржол көлігіндегі біздің түлектердің мансап оқиғалары.',
                            'en' => 'College achievements, competition wins, graduate successes. Career stories of our graduates in IT, telecommunications and railway transport.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'achievements',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Достижения колледжа и наши выпускники',
                            'kk' => 'Колледждің жетістіктері және біздің түлектер',
                            'en' => 'College Achievements and Our Graduates',
                        ],
                        'main_description' => [
                            'ru' => 'Мы гордимся нашими достижениями и людьми, которые воплощают наши амбициозные стандарты в профессиональную значимость колледжа и вдохновляющие успехи выпускников.',
                            'kk' => 'Біз жетістіктерімізді және біздің амбициозды стандарттарымызды колледждің кәсіби маңыздылығына және түлектердің жігерлендірілген табыстарына айналдыратын адамдарды мақтан тұтамыз.',
                            'en' => 'We are proud of our achievements and the people who translate our ambitious standards into the college professional significance and inspiring successes of graduates.',
                        ],
                        'button_1_text' => [
                            'ru' => 'Посмотреть достижения',
                            'kk' => 'Жетістіктерді көру',
                            'en' => 'View Achievements',
                        ],
                        'button_2_text' => [
                            'ru' => 'Наши выпускники',
                            'kk' => 'Біздің түлектер',
                            'en' => 'Our Graduates',
                        ],
                    ],
                ],

                [
                    'page_key' => 'achievements',
                    'section_key' => 'stats',
                    'title' => 'Статистика достижений',
                    'description' => 'Карточки со статистикой под героем',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'stat_1_value' => [
                            'ru' => '85',
                            'kk' => '85',
                            'en' => '85',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Профессиональные партнеры',
                            'kk' => 'Кәсіби серіктестер',
                            'en' => 'Professional Partners',
                        ],
                        
                        'stat_2_value' => [
                            'ru' => '91',
                            'kk' => '91',
                            'en' => '91',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Трудоустройство выпускников',
                            'kk' => 'Түлектерді жұмыспен қамту',
                            'en' => 'Graduate Employment',
                        ],
                        
                        'stat_3_value' => [
                            'ru' => '500',
                            'kk' => '500',
                            'en' => '500',
                        ],
                        'stat_3_label' => [
                            'ru' => 'Успешных выпускников',
                            'kk' => 'Табысты түлектер',
                            'en' => 'Successful Graduates',
                        ],
                    ],
                ],

                [
                    'page_key' => 'achievements',
                    'section_key' => 'achievements_section',
                    'title' => 'Секция достижений',
                    'description' => 'Заголовок и подзаголовок раздела достижений',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Достижения колледжа',
                            'kk' => 'Колледждің жетістіктері',
                            'en' => 'College Achievements',
                        ],
                        'section_subtitle' => [
                            'ru' => 'Наши глобальные победы, партнёрство и академическое сотрудничество',
                            'kk' => 'Біздің жаһандық жеңістер, серіктестік және академиялық ынтымақтастық',
                            'en' => 'Our global victories, partnerships and academic collaborations',
                        ],
                        'empty_state_text' => [
                            'ru' => 'Достижения скоро появятся...',
                            'kk' => 'Жетістіктер жақында пайда болады...',
                            'en' => 'Achievements coming soon...',
                        ],
                    ],
                ],

                [
                    'page_key' => 'achievements',
                    'section_key' => 'graduates_section',
                    'title' => 'Секция выпускников',
                    'description' => 'Заголовок и подзаголовок раздела выпускников',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Истории выпускников',
                            'kk' => 'Түлектердің оқиғалары',
                            'en' => 'Graduates Stories',
                        ],
                        'section_subtitle' => [
                            'ru' => 'Карьеры наших выпускников — доказательство качества образования',
                            'kk' => 'Біздің түлектердің мансаптары — білім беру сапасының дәлелі',
                            'en' => 'Careers of our graduates - proof of education quality',
                        ],
                        'empty_state_text' => [
                            'ru' => 'Истории выпускников скоро появятся...',
                            'kk' => 'Түлектердің оқиғалары жақында пайда болады...',
                            'en' => 'Graduates stories coming soon...',
                        ],
                    ],
                ],

                [
                    'page_key' => 'achievements',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
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
                    Log::info("Создана секция Achievements: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано секций Achievements: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница 'Достижения и выпускники' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🏆 Структура страницы 'Достижения':");
                $this->command->info("   👑 Герой-секция с заголовком и кнопками");
                $this->command->info("   📊 Статистика достижений (3 показателя)");
                $this->command->info("   🏆 Секция достижений колледжа");
                $this->command->info("   👨‍🎓 Секция историй выпускников");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}