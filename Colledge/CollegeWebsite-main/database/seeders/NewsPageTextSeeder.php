<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class NewsPageTextSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычных текстовых данных страницы "Новости"...');
            $this->command->info('🔄 Запуск сидера для текстовых данных страницы "Новости"');
            
            $pageKey = 'news';
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', $pageKey)
                ->whereIn('section_key', ['hero', 'listing'])
                ->delete();
                
            Log::info("Удалено старых записей News Text: {$deleted}");
            $this->command->info("🗑️ Удалено {$deleted} старых записей для страницы '{$pageKey}'");
            
            $sections = [
                // Секция 1: Герой (заголовок страницы)
                [
                    'page_key' => $pageKey,
                    'section_key' => 'hero',
                    'title' => 'Заголовок страницы новостей',
                    'description' => 'Основной заголовок и подзаголовок страницы новостей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'meta_title' => [
                            'ru' => 'Новости колледжа',
                            'kk' => 'Колледждің жаңалықтары',
                            'en' => 'College news',
                        ],
                        'main_title' => [
                            'ru' => 'Новости колледжа',
                            'kk' => 'Колледждің жаңалықтары',
                            'en' => 'College news',
                        ],
                        'subtitle' => [
                            'ru' => 'Будьте в курсе последних событий и важных обновлений',
                            'kk' => 'Соңғы оқиғалар мен маңызды жаңартулардан хабардар болыңыз',
                            'en' => 'Stay up to date with the latest events and important updates',
                        ],
                        'description' => [
                            'ru' => 'Актуальные новости, события, объявления и достижения нашего колледжа',
                            'kk' => 'Біздің колледждің өзекті жаңалықтары, оқиғалары, хабарландырулары мен жетістіктері',
                            'en' => 'Current news, events, announcements and achievements of our college',
                        ],
                    ],
                ],
                
                // Секция 2: Листинг новостей
                [
                    'page_key' => $pageKey,
                    'section_key' => 'listing',
                    'title' => 'Блок с новостями',
                    'description' => 'Заголовки и тексты в блоке листинга новостей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Последние новости',
                            'kk' => 'Соңғы жаңалықтар',
                            'en' => 'Latest news',
                        ],
                        'total_text' => [
                            'ru' => 'Всего публикаций',
                            'kk' => 'Барлығы жарияланымдар',
                            'en' => 'Total publications',
                        ],
                        'new_badge' => [
                            'ru' => 'НОВОЕ',
                            'kk' => 'ЖАҢА',
                            'en' => 'NEW',
                        ],
                        'popular_badge' => [
                            'ru' => 'ПОПУЛЯРНОЕ',
                            'kk' => 'ТАНЫМАЛ',
                            'en' => 'POPULAR',
                        ],
                        'urgent_badge' => [
                            'ru' => 'СРОЧНО',
                            'kk' => 'ШИЕЛІ',
                            'en' => 'URGENT',
                        ],
                        
                        // Категории для новостей
                        'category_0_name' => [
                            'ru' => 'Событие',
                            'kk' => 'Оқиға',
                            'en' => 'Event',
                        ],
                        'category_1_name' => [
                            'ru' => 'Обновление',
                            'kk' => 'Жаңарту',
                            'en' => 'Update',
                        ],
                        'category_2_name' => [
                            'ru' => 'Инфо',
                            'kk' => 'Ақпарат',
                            'en' => 'Info',
                        ],
                        'category_3_name' => [
                            'ru' => 'Достижение',
                            'kk' => 'Жетістік',
                            'en' => 'Achievement',
                        ],
                        'category_4_name' => [
                            'ru' => 'Объявление',
                            'kk' => 'Хабарландыру',
                            'en' => 'Announcement',
                        ],
                        
                        // Текст для кнопок и ссылок
                        'read_more_text' => [
                            'ru' => 'Читать далее',
                            'kk' => 'Оқуды жалғастыру',
                            'en' => 'Read more',
                        ],
                        'share_text' => [
                            'ru' => 'Поделиться',
                            'kk' => 'Бөлісу',
                            'en' => 'Share',
                        ],
                        'save_text' => [
                            'ru' => 'Сохранить',
                            'kk' => 'Сақтау',
                            'en' => 'Save',
                        ],
                        'print_text' => [
                            'ru' => 'Распечатать',
                            'kk' => 'Басып шығару',
                            'en' => 'Print',
                        ],
                        
                        // Тексты для пустого состояния
                        'empty_title' => [
                            'ru' => 'Новостей пока нет',
                            'kk' => 'Жаңалықтар әлі жоқ',
                            'en' => 'No news yet',
                        ],
                        'empty_subtitle' => [
                            'ru' => 'Следите за обновлениями, скоро здесь появятся интересные материалы',
                            'kk' => 'Жаңартуларды бақылап отырыңыз, жақында мұнда қызықты материалдар пайда болады',
                            'en' => 'Follow updates, interesting materials will appear here soon',
                        ],
                        'subscribe_button' => [
                            'ru' => 'Подписаться на обновления',
                            'kk' => 'Жаңартуларға жазылу',
                            'en' => 'Subscribe to updates',
                        ],
                        'suggest_news_button' => [
                            'ru' => 'Предложить новость',
                            'kk' => 'Жаңалық ұсыну',
                            'en' => 'Suggest news',
                        ],
                    ],
                ],

                // Секция 3: Пагинация
                [
                    'page_key' => $pageKey,
                    'section_key' => 'pagination',
                    'title' => 'Пагинация новостей',
                    'description' => 'Тексты для пагинации и навигации по страницам',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'previous_text' => [
                            'ru' => 'Предыдущая',
                            'kk' => 'Алдыңғы',
                            'en' => 'Previous',
                        ],
                        'next_text' => [
                            'ru' => 'Следующая',
                            'kk' => 'Келесі',
                            'en' => 'Next',
                        ],
                        'page_text' => [
                            'ru' => 'Страница',
                            'kk' => 'Бет',
                            'en' => 'Page',
                        ],
                        'of_text' => [
                            'ru' => 'из',
                            'kk' => '/',
                            'en' => 'of',
                        ],
                        'showing_text' => [
                            'ru' => 'Показано',
                            'kk' => 'Көрсетілген',
                            'en' => 'Showing',
                        ],
                        'to_text' => [
                            'ru' => 'до',
                            'kk' => 'дейін',
                            'en' => 'to',
                        ],
                        'of_total_text' => [
                            'ru' => 'из',
                            'kk' => ' / ',
                            'en' => 'of',
                        ],
                        'results_text' => [
                            'ru' => 'результатов',
                            'kk' => 'нәтижелер',
                            'en' => 'results',
                        ],
                        'per_page_text' => [
                            'ru' => 'на странице',
                            'kk' => 'бетте',
                            'en' => 'per page',
                        ],
                    ],
                ],

                // Секция 4: Подписка на новости
                [
                    'page_key' => $pageKey,
                    'section_key' => 'subscription',
                    'title' => 'Подписка на новости',
                    'description' => 'Тексты для формы подписки на новости',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Подписаться на новости',
                            'kk' => 'Жаңалықтарға жазылу',
                            'en' => 'Subscribe to news',
                        ],
                        'subtitle' => [
                            'ru' => 'Получайте самые свежие новости первыми',
                            'kk' => 'Ең жаңа жаңалықтарды бірінші болып алыңыз',
                            'en' => 'Get the latest news first',
                        ],
                        'email_placeholder' => [
                            'ru' => 'Введите ваш email',
                            'kk' => 'Электрондық поштаңызды енгізіңіз',
                            'en' => 'Enter your email',
                        ],
                        'subscribe_button' => [
                            'ru' => 'Подписаться',
                            'kk' => 'Жазылу',
                            'en' => 'Subscribe',
                        ],
                        'success_message' => [
                            'ru' => 'Вы успешно подписались на новости!',
                            'kk' => 'Сіз жаңалықтарға сәтті жазылдыңыз!',
                            'en' => 'You have successfully subscribed to news!',
                        ],
                        'already_subscribed' => [
                            'ru' => 'Вы уже подписаны на новости',
                            'kk' => 'Сіз жаңалықтарға қазірдің өзінде жазылғансыз',
                            'en' => 'You are already subscribed to news',
                        ],
                        'privacy_text' => [
                            'ru' => 'Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности',
                            'kk' => 'Түймені басу арқылы сіз құпиялылық саясатымен келісесіз',
                            'en' => 'By clicking the button, you agree to the privacy policy',
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
                    Log::info("Создана многоязычная News Text секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания News Text секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания News Text секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании News Text были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании News Text были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных News Text секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычные текстовые данные страницы 'Новости' успешно созданы!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные News Text секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📝 Текстовые разделы страницы 'Новости':");
                $this->command->info("   👑 Герой-секция с заголовками");
                $this->command->info("   📰 Листинг новостей с категориями и бейджами");
                $this->command->info("   📑 Пагинация и навигация по страницам");
                $this->command->info("   ✉️ Подписка на email-рассылку новостей");
            }
            
            $this->command->info("\n💾 Для запуска сидера выполните: php artisan db:seed --class=NewsPageTextSeeder");
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании текстовых данных новостей: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании текстовых данных новостей: {$e->getMessage()}");
            throw $e;
        }
    }
}