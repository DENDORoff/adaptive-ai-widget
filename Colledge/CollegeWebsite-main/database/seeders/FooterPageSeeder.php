<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class FooterPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование футера...');
            
            $deleted = PageSection::where('page_key', 'footer')->delete();
            Log::info("Удалено старых записей Footer: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'footer',
                    'section_key' => 'map',
                    'title' => 'Карта',
                    'description' => 'Карта местонахождения колледжа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'МЕСТОПОЛОЖЕНИЕ',
                            'kk' => 'ОРЫНДАЛУЫ',
                            'en' => 'LOCATION',
                        ],
                        'iframe_src' => [
                            'ru' => 'https://yandex.ru/map-widget/v1/?ll=76.97822717164688,52.29349433475749&z=15&l=map&pt=76.97822717164688,52.29349433475749,pm2rdm',
                            'kk' => 'https://yandex.ru/map-widget/v1/?ll=76.97822717164688,52.29349433475749&z=15&l=map&pt=76.97822717164688,52.29349433475749,pm2rdm',
                            'en' => 'https://yandex.ru/map-widget/v1/?ll=76.97822717164688,52.29349433475749&z=15&l=map&pt=76.97822717164688,52.29349433475749,pm2rdm',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'footer',
                    'section_key' => 'quick_links',
                    'title' => 'Быстрые ссылки',
                    'description' => 'Ссылки для быстрой навигации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'БЫСТРЫЕ ССЫЛКИ',
                            'kk' => 'ЖЫЛДАМ СІЛТЕМЕЛЕР',
                            'en' => 'QUICK LINKS',
                        ],
                        'link_1_text' => [
                            'ru' => 'Главная',
                            'kk' => 'Басты бет',
                            'en' => 'Home',
                        ],
                        'link_1_url' => [
                            'ru' => '/',
                            'kk' => '/',
                            'en' => '/',
                        ],
                        'link_2_text' => [
                            'ru' => 'О колледже',
                            'kk' => 'Колледж туралы',
                            'en' => 'About',
                        ],
                        'link_2_url' => [
                            'ru' => '/about',
                            'kk' => '/about',
                            'en' => '/about',
                        ],
                        'link_3_text' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual Tour',
                        ],
                        'link_3_url' => [
                            'ru' => '/virtual-tour',
                            'kk' => '/virtual-tour',
                            'en' => '/virtual-tour',
                        ],
                        'link_4_text' => [
                            'ru' => 'Блог руководителя',
                            'kk' => 'Басшының блогы',
                            'en' => 'Director\'s Blog',
                        ],
                        'link_4_url' => [
                            'ru' => '/blog',
                            'kk' => '/blog',
                            'en' => '/blog',
                        ],
                    ],
                ],

                [
                    'page_key' => 'footer',
                    'section_key' => 'for_applicants',
                    'title' => 'Поступающим',
                    'description' => 'Ссылки для абитуриентов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'ПОСТУПАЮЩИМ',
                            'kk' => 'ТҮСЕТІНДЕРГЕ',
                            'en' => 'FOR APPLICANTS',
                        ],
                        'link_1_text' => [
                            'ru' => 'Как поступить',
                            'kk' => 'Қалай түсуге болады',
                            'en' => 'How to apply',
                        ],
                        'link_1_url' => [
                            'ru' => '/admission',
                            'kk' => '/admission',
                            'en' => '/admission',
                        ],
                        'link_1_is_modal' => [
                            'ru' => 'false',
                            'kk' => 'false',
                            'en' => 'false',
                        ],
                        'link_2_text' => [
                            'ru' => 'Специальности',
                            'kk' => 'Мамандықтар',
                            'en' => 'Specialties',
                        ],
                        'link_2_url' => [
                            'ru' => '/specialties',
                            'kk' => '/specialties',
                            'en' => '/specialties',
                        ],
                        'link_2_is_modal' => [
                            'ru' => 'false',
                            'kk' => 'false',
                            'en' => 'false',
                        ],
                        'link_3_text' => [
                            'ru' => 'Документы',
                            'kk' => 'Құжаттар',
                            'en' => 'Documents',
                        ],
                        'link_3_url' => [
                            'ru' => '/documents',
                            'kk' => '/documents',
                            'en' => '/documents',
                        ],
                        'link_3_is_modal' => [
                            'ru' => 'false',
                            'kk' => 'false',
                            'en' => 'false',
                        ],
                        'link_4_text' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual Tour',
                        ],
                        'link_4_url' => [
                            'ru' => '/virtual-tour',
                            'kk' => '/virtual-tour',
                            'en' => '/virtual-tour',
                        ],
                        'link_4_is_modal' => [
                            'ru' => 'false',
                            'kk' => 'false',
                            'en' => 'false',
                        ],
                    ],
                ],

                [
                    'page_key' => 'footer',
                    'section_key' => 'additional',
                    'title' => 'Дополнительно',
                    'description' => 'Дополнительные ссылки и информация',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Дополнительно',
                            'kk' => 'Қосымша',
                            'en' => 'Additional',
                        ],
                        'link_1_text' => [
                            'ru' => 'Противодействие коррупции',
                            'kk' => 'Коррупцияға қарсы күрес',
                            'en' => 'Anti-corruption',
                        ],
                        'link_1_url' => [
                            'ru' => '/anti-corruption',
                            'kk' => '/anti-corruption',
                            'en' => '/anti-corruption',
                        ],
                        'link_2_text' => [
                            'ru' => 'Новости',
                            'kk' => 'Жаңалықтар',
                            'en' => 'News',
                        ],
                        'link_2_url' => [
                            'ru' => '/news',
                            'kk' => '/news',
                            'en' => '/news',
                        ],
                        'link_3_text' => [
                            'ru' => 'Вакансии',
                            'kk' => 'Бос орындар',
                            'en' => 'Vacancies',
                        ],
                        'link_3_url' => [
                            'ru' => '/vacancies',
                            'kk' => '/vacancies',
                            'en' => '/vacancies',
                        ],
                        'bug_report_text' => [
                            'ru' => 'Нашли ошибку на сайте?',
                            'kk' => 'Сайтта қате таптыңыз ба?',
                            'en' => 'Found a bug on the site?',
                        ],
                        'bug_report_function' => [
                            'ru' => 'openBugReportModal()',
                            'kk' => 'openBugReportModal()',
                            'en' => 'openBugReportModal()',
                        ],
                    ],
                ],

                [
                    'page_key' => 'footer',
                    'section_key' => 'contacts',
                    'title' => 'Контакты',
                    'description' => 'Контактная информация колледжа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'КОНТАКТЫ',
                            'kk' => 'БАЙЛАНЫСТАР',
                            'en' => 'CONTACTS',
                        ],
                        'logo_url' => [
                            'ru' => '/images/college-logo.png',
                            'kk' => '/images/college-logo.png',
                            'en' => '/images/college-logo.png',
                        ],
                        'logo_alt' => [
                            'ru' => 'Логотип колледжа',
                            'kk' => 'Колледж логотипі',
                            'en' => 'College logo',
                        ],
                        'logo_fallback' => [
                            'ru' => 'Лого',
                            'kk' => 'Лого',
                            'en' => 'Logo',
                        ],
                        'address' => [
                            'ru' => 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2',
                            'kk' => 'Павлодар қ., Жүсіпбек Аймауытұлы көш., 2',
                            'en' => 'Pavlodar, Zhusipbek Aimautuly st., 2',
                        ],
                        'phone' => [
                            'ru' => '+7 (701) 490-05-66',
                            'kk' => '+7 (701) 490-05-66',
                            'en' => '+7 (701) 490-05-66',
                        ],
                        'email' => [
                            'ru' => 'vkeik@edu.kz',
                            'kk' => 'vkeik@edu.kz',
                            'en' => 'vkeik@edu.kz',
                        ],
                    ],
                ],

                [
                    'page_key' => 'footer',
                    'section_key' => 'copyright',
                    'title' => 'Копирайт',
                    'description' => 'Текст копирайта',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'text' => [
                            'ru' => '© 2025 Высший колледж электроники и коммуникаций. Все права защищены.',
                            'kk' => '© 2025 Электроника және коммуникациялар жоғары колледжі. Барлық құқықтар қорғалған.',
                            'en' => '© 2025 Higher College of Electronics and Communications. All rights reserved.',
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
                    Log::info("Создана многоязычная Footer секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Footer: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычный футер успешно создан!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📍 Структура футера:");
                $this->command->info("   🗺️ Карта местонахождения");
                $this->command->info("   🔗 Быстрые ссылки (4 ссылки)");
                $this->command->info("   🎓 Поступающим (4 ссылки)");
                $this->command->info("   📁 Дополнительно (3 ссылки + отчет об ошибке)");
                $this->command->info("   📞 Контакты (адрес, телефон, email)");
                $this->command->info("   ©️ Копирайт");
                
                $this->command->info("\n🔗 Быстрые ссылки:");
                $this->command->info("   • Главная");
                $this->command->info("   • О колледже");
                $this->command->info("   • Виртуальный тур");
                $this->command->info("   • Блог руководителя");
                
                $this->command->info("\n🎓 Для поступающих:");
                $this->command->info("   • Как поступить");
                $this->command->info("   • Специальности");
                $this->command->info("   • Документы");
                $this->command->info("   • Виртуальный тур");
                
                $this->command->info("\n📁 Дополнительные ссылки:");
                $this->command->info("   • Противодействие коррупции");
                $this->command->info("   • Новости");
                $this->command->info("   • Вакансии");
                $this->command->info("   • Отчет об ошибке на сайте");
                
                $this->command->info("\n📞 Контактная информация:");
                $this->command->info("   • Адрес: г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2");
                $this->command->info("   • Телефон: +7 (701) 490-05-66");
                $this->command->info("   • Email: vkeik@edu.kz");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}