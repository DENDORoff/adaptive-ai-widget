<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class NewsShowPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы показа новости...');
            $this->command->info('🔄 Начинаем сидинг страницы показа новости...');
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', 'news_show')->delete();
            Log::info("Удалено старых записей News Show: {$deleted}");
            $this->command->info('🗑️ Удалены старые записи для news_show');
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'news_show',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы новости',
                    'description' => 'SEO и общие настройки страницы отдельной новости',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title_pattern' => [
                            'ru' => '{{title}} | Новости колледжа',
                            'kk' => '{{title}} | Колледждің жаңалықтары',
                            'en' => '{{title}} | College news',
                        ],
                        'meta_title_pattern' => [
                            'ru' => '{{title}} | Новости колледжа электроники и связи',
                            'kk' => '{{title}} | Электроника және байланыс колледжінің жаңалықтары',
                            'en' => '{{title}} | News of the College of Electronics and Communications',
                        ],
                        'meta_description_pattern' => [
                            'ru' => '{{excerpt}}... Читайте полную новость на сайте колледжа.',
                            'kk' => '{{excerpt}}... Толық жаңалықты колледж сайтында оқыңыз.',
                            'en' => '{{excerpt}}... Read the full news on the college website.',
                        ],
                    ],
                ],

                // Хлебные крошки
                [
                    'page_key' => 'news_show',
                    'section_key' => 'breadcrumbs',
                    'title' => 'Хлебные крошки',
                    'description' => 'Тексты для навигационной цепочки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'home_label' => [
                            'ru' => 'Главная',
                            'kk' => 'Басты бет',
                            'en' => 'Home',
                        ],
                        'news_label' => [
                            'ru' => 'Новости',
                            'kk' => 'Жаңалықтар',
                            'en' => 'News',
                        ],
                        'news_single_label' => [
                            'ru' => 'Новость',
                            'kk' => 'Жаңалық',
                            'en' => 'News',
                        ],
                        'back_to_news' => [
                            'ru' => '← Назад к новостям',
                            'kk' => '← Жаңалықтарға оралу',
                            'en' => '← Back to news',
                        ],
                    ],
                ],

                // Бейджи и метки
                [
                    'page_key' => 'news_show',
                    'section_key' => 'badges',
                    'title' => 'Бейджи и метки',
                    'description' => 'Тексты для бейджей и статусов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'news_badge' => [
                            'ru' => '📢 Новость',
                            'kk' => '📢 Жаңалық',
                            'en' => '📢 News',
                        ],
                        'news_badge_alt' => [
                            'ru' => 'Новость',
                            'kk' => 'Жаңалық',
                            'en' => 'News',
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
                        'exclusive_badge' => [
                            'ru' => 'ЭКСКЛЮЗИВ',
                            'kk' => 'ЭКСКЛЮЗИВТІ',
                            'en' => 'EXCLUSIVE',
                        ],
                        'updated_badge' => [
                            'ru' => 'ОБНОВЛЕНО',
                            'kk' => 'ЖАҢАРТЫЛДЫ',
                            'en' => 'UPDATED',
                        ],
                        'category_prefix' => [
                            'ru' => 'Категория:',
                            'kk' => 'Санат:',
                            'en' => 'Category:',
                        ],
                    ],
                ],

                // Карусель изображений
                [
                    'page_key' => 'news_show',
                    'section_key' => 'carousel',
                    'title' => 'Карусель изображений',
                    'description' => 'Тексты для управления каруселью',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'previous_button_title' => [
                            'ru' => 'Предыдущее изображение',
                            'kk' => 'Алдыңғы сурет',
                            'en' => 'Previous image',
                        ],
                        'next_button_title' => [
                            'ru' => 'Следующее изображение',
                            'kk' => 'Келесі сурет',
                            'en' => 'Next image',
                        ],
                        'fullscreen_button_title' => [
                            'ru' => 'Открыть на весь экран',
                            'kk' => 'Толық экранда ашу',
                            'en' => 'Open in fullscreen',
                        ],
                        'close_button_title' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'image_counter' => [
                            'ru' => 'из',
                            'kk' => '/',
                            'en' => 'of',
                        ],
                        'zoom_in' => [
                            'ru' => 'Увеличить',
                            'kk' => 'Үлкейту',
                            'en' => 'Zoom in',
                        ],
                        'zoom_out' => [
                            'ru' => 'Уменьшить',
                            'kk' => 'Кішірейту',
                            'en' => 'Zoom out',
                        ],
                        'download_image' => [
                            'ru' => 'Скачать изображение',
                            'kk' => 'Суретті жүктеп алу',
                            'en' => 'Download image',
                        ],
                    ],
                ],

                // Социальные сети
                [
                    'page_key' => 'news_show',
                    'section_key' => 'social',
                    'title' => 'Социальные сети',
                    'description' => 'Тексты для кнопок соцсетей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'share_label' => [
                            'ru' => 'Поделиться:',
                            'kk' => 'Бөлісу:',
                            'en' => 'Share:',
                        ],
                        'vk_title' => [
                            'ru' => 'Поделиться ВКонтакте',
                            'kk' => 'ВКонтакте арқылы бөлісу',
                            'en' => 'Share via VKontakte',
                        ],
                        'telegram_title' => [
                            'ru' => 'Поделиться в Telegram',
                            'kk' => 'Telegram арқылы бөлісу',
                            'en' => 'Share via Telegram',
                        ],
                        'whatsapp_title' => [
                            'ru' => 'Поделиться в WhatsApp',
                            'kk' => 'WhatsApp арқылы бөлісу',
                            'en' => 'Share via WhatsApp',
                        ],
                        'facebook_title' => [
                            'ru' => 'Поделиться в Facebook',
                            'kk' => 'Facebook арқылы бөлісу',
                            'en' => 'Share via Facebook',
                        ],
                        'twitter_title' => [
                            'ru' => 'Поделиться в Twitter',
                            'kk' => 'Twitter арқылы бөлісу',
                            'en' => 'Share via Twitter',
                        ],
                        'copy_link' => [
                            'ru' => 'Копировать ссылку',
                            'kk' => 'Сілтемені көшіру',
                            'en' => 'Copy link',
                        ],
                        'link_copied' => [
                            'ru' => 'Ссылка скопирована',
                            'kk' => 'Сілтеме көшірілді',
                            'en' => 'Link copied',
                        ],
                    ],
                ],

                // Похожие новости
                [
                    'page_key' => 'news_show',
                    'section_key' => 'related',
                    'title' => 'Похожие новости',
                    'description' => 'Заголовок и описание блока похожих новостей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Похожие новости',
                            'kk' => 'Ұқсас жаңалықтар',
                            'en' => 'Related news',
                        ],
                        'subtitle' => [
                            'ru' => 'Другие интересные материалы',
                            'kk' => 'Басқа қызықты материалдар',
                            'en' => 'Other interesting materials',
                        ],
                        'read_more' => [
                            'ru' => 'Читать далее',
                            'kk' => 'Толығырақ оқу',
                            'en' => 'Read more',
                        ],
                        'no_related_text' => [
                            'ru' => 'Похожих новостей пока нет',
                            'kk' => 'Ұқсас жаңалықтар әлі жоқ',
                            'en' => 'No related news yet',
                        ],
                    ],
                ],

                // Комментарии
                [
                    'page_key' => 'news_show',
                    'section_key' => 'comments',
                    'title' => 'Комментарии',
                    'description' => 'Тексты для секции комментариев',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Комментарии',
                            'kk' => 'Пікірлер',
                            'en' => 'Comments',
                        ],
                        'no_comments' => [
                            'ru' => 'Комментариев пока нет',
                            'kk' => 'Пікірлер әлі жоқ',
                            'en' => 'No comments yet',
                        ],
                        'add_comment' => [
                            'ru' => 'Добавить комментарий',
                            'kk' => 'Пікір қосу',
                            'en' => 'Add comment',
                        ],
                        'name_placeholder' => [
                            'ru' => 'Ваше имя',
                            'kk' => 'Сіздің атыңыз',
                            'en' => 'Your name',
                        ],
                        'comment_placeholder' => [
                            'ru' => 'Ваш комментарий',
                            'kk' => 'Сіздің пікіріңіз',
                            'en' => 'Your comment',
                        ],
                        'submit_button' => [
                            'ru' => 'Отправить',
                            'kk' => 'Жіберу',
                            'en' => 'Submit',
                        ],
                        'rules_text' => [
                            'ru' => 'Комментарий будет опубликован после проверки модератором',
                            'kk' => 'Пікір модератор тексергеннен кейін жарияланады',
                            'en' => 'Comment will be published after moderator review',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'news_show',
                    'section_key' => 'navigation',
                    'title' => 'Навигация по новости',
                    'description' => 'Кнопки и элементы навигации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'print_button' => [
                            'ru' => 'Распечатать новость',
                            'kk' => 'Жаңалықты басып шығару',
                            'en' => 'Print news',
                        ],
                        'pdf_button' => [
                            'ru' => 'Скачать в PDF',
                            'kk' => 'PDF түрінде жүктеп алу',
                            'en' => 'Download as PDF',
                        ],
                        'email_button' => [
                            'ru' => 'Отправить по email',
                            'kk' => 'Email арқылы жіберу',
                            'en' => 'Send via email',
                        ],
                        'read_time' => [
                            'ru' => 'Время чтения',
                            'kk' => 'Оқу уақыты',
                            'en' => 'Reading time',
                        ],
                        'minutes' => [
                            'ru' => 'минут',
                            'kk' => 'минут',
                            'en' => 'minutes',
                        ],
                        'views' => [
                            'ru' => 'просмотров',
                            'kk' => 'қаралым',
                            'en' => 'views',
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
                    Log::info("Создана многоязычная News Show секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                    $this->command->info("✅ Создана секция: {$section['title']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания News Show секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания News Show секции {$section['section_key']}: {$e->getMessage()}");
                    $this->command->error("❌ Ошибка создания секции {$section['title']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании News Show были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании News Show были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных News Show секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Показа новости' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные News Show секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📄 Разделы страницы 'Показа новости':");
                $this->command->info("   🏷️ SEO метаданные с шаблонами");
                $this->command->info("   🍞 Хлебные крошки навигации");
                $this->command->info("   🏅 Бейджи и статусы новости");
                $this->command->info("   🖼️ Карусель изображений с управлением");
                $this->command->info("   📱 Социальные сети и шаринг");
                $this->command->info("   🔗 Похожие новости");
                $this->command->info("   💬 Система комментариев");
                $this->command->info("   🧭 Навигационные элементы (PDF, печать и др.)");
            }
            
            $this->command->info('🎉 Сидинг страницы news_show завершен!');
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании страницы показа новости: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании страницы показа новости: {$e->getMessage()}");
            throw $e;
        }
    }
}