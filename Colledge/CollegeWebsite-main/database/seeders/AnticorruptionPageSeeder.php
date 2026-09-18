<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class AnticorruptionPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Противодействие коррупции...');
            
            $pageKey = 'anticorruption';
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', $pageKey)->delete();
            Log::info("Удалено старых записей Anticorruption: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => $pageKey,
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Противодействие коррупции',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлыққа қарсы іс-қимыл',
                            'en' => 'Anti-Corruption Activities',
                        ],
                        'meta_title' => [
                            'ru' => 'Противодействие коррупции | Колледж современных технологий',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлыққа қарсы іс-қимыл | Заманауи технологиялар колледжі',
                            'en' => 'Anti-Corruption Activities | College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Информация о противодействии коррупции в колледже. Нормативные документы, информационные материалы и отчеты.',
                            'kk' => 'Колледждегі сыбайлас жемқорлыққа қарсы іс-қимыл туралы ақпарат. Нормативтік құжаттар, ақпараттық материалдар және есептер.',
                            'en' => 'Information on anti-corruption activities in the college. Regulatory documents, informational materials and reports.',
                        ],
                    ],
                ],
                
                // Секция 1: Герой (заголовок страницы)
                [
                    'page_key' => $pageKey,
                    'section_key' => 'hero',
                    'title' => 'Заголовок страницы',
                    'description' => 'Основной заголовок и описание страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title_part1' => [
                            'ru' => 'Противодействие',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлыққа',
                            'en' => 'Anti-Corruption',
                        ],
                        'title_part2' => [
                            'ru' => 'коррупции',
                            'kk' => 'қарсы іс-қимыл',
                            'en' => 'Activities',
                        ],
                        'description' => [
                            'ru' => 'Информационная страница о мерах противодействия коррупции, официальные документы и нормативные акты',
                            'kk' => 'Сыбайлас жемқорлыққа қарсы іс-шаралар, ресми құжаттар және нормативтік актілер туралы ақпараттық бет',
                            'en' => 'Information page about anti-corruption measures, official documents and regulatory acts',
                        ],
                    ],
                ],
                
                // Секция 2: Заголовок информационных материалов
                [
                    'page_key' => $pageKey,
                    'section_key' => 'posters',
                    'title' => 'Заголовок "Информационные материалы"',
                    'description' => 'Заголовок раздела с плакатами',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Информационные материалы',
                            'kk' => 'Ақпараттық материалдар',
                            'en' => 'Informational Materials',
                        ],
                        'empty_title' => [
                            'ru' => 'Материалы отсутствуют',
                            'kk' => 'Материалдар жоқ',
                            'en' => 'No materials available',
                        ],
                        'empty_description' => [
                            'ru' => 'Информационные материалы будут добавлены позже',
                            'kk' => 'Ақпараттық материалдар кейінірек қосылады',
                            'en' => 'Informational materials will be added later',
                        ],
                    ],
                ],
                
                // Секция 3: Документы
                [
                    'page_key' => $pageKey,
                    'section_key' => 'documents',
                    'title' => 'Раздел "Документы"',
                    'description' => 'Заголовки и тексты в разделе документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Документы по противодействию коррупции',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлыққа қарсы іс-қимыл бойынша құжаттар',
                            'en' => 'Anti-Corruption Documents',
                        ],
                        'button_text' => [
                            'ru' => 'Все документы',
                            'kk' => 'Барлық құжаттар',
                            'en' => 'All documents',
                        ],
                        'download_button' => [
                            'ru' => 'Скачать',
                            'kk' => 'Жүктеу',
                            'en' => 'Download',
                        ],
                        'date_label' => [
                            'ru' => 'Дата:',
                            'kk' => 'Күні:',
                            'en' => 'Date:',
                        ],
                        'size_label' => [
                            'ru' => 'Размер:',
                            'kk' => 'Өлшемі:',
                            'en' => 'Size:',
                        ],
                        'empty_title' => [
                            'ru' => 'Документы отсутствуют',
                            'kk' => 'Құжаттар жоқ',
                            'en' => 'No documents available',
                        ],
                        'empty_description' => [
                            'ru' => 'Документы будут добавлены позже',
                            'kk' => 'Құжаттар кейінірек қосылады',
                            'en' => 'Documents will be added later',
                        ],
                    ],
                ],
                
                // Секция 4: Информация
                [
                    'page_key' => $pageKey,
                    'section_key' => 'information',
                    'title' => 'Раздел "Информация"',
                    'description' => 'Заголовки и тексты в разделе информации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Перечень сведений, подлежащих опубликованию',
                            'kk' => 'Жарияланбақ ақпараттар тізімі',
                            'en' => 'List of Information to be Published',
                        ],
                        'table_name' => [
                            'ru' => 'Наименование сведений',
                            'kk' => 'Ақпарат атауы',
                            'en' => 'Information name',
                        ],
                        'table_date' => [
                            'ru' => 'Дата размещения',
                            'kk' => 'Жарияланған күні',
                            'en' => 'Publication date',
                        ],
                        'table_download' => [
                            'ru' => 'Ссылка',
                            'kk' => 'Сілтеме',
                            'en' => 'Link',
                        ],
                        'empty_title' => [
                            'ru' => 'Информация отсутствует',
                            'kk' => 'Ақпарат жоқ',
                            'en' => 'No information available',
                        ],
                        'empty_description' => [
                            'ru' => 'Данные будут добавлены позже',
                            'kk' => 'Деректер кейінірек қосылады',
                            'en' => 'Data will be added later',
                        ],
                    ],
                ],
                
                // Секция 5: Боковое меню
                [
                    'page_key' => $pageKey,
                    'section_key' => 'sidebar',
                    'title' => 'Боковое меню',
                    'description' => 'Навигационное меню страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Содержание',
                            'kk' => 'Мазмұны',
                            'en' => 'Content',
                        ],
                        
                        'item1_title' => [
                            'ru' => 'Информационные материалы',
                            'kk' => 'Ақпараттық материалдар',
                            'en' => 'Informational Materials',
                        ],
                        'item1_description' => [
                            'ru' => 'Плакаты и наглядные материалы',
                            'kk' => 'Плакаттар және көрнекі материалдар',
                            'en' => 'Posters and visual materials',
                        ],
                        
                        'item2_title' => [
                            'ru' => 'Документы',
                            'kk' => 'Құжаттар',
                            'en' => 'Documents',
                        ],
                        'item2_description' => [
                            'ru' => 'Нормативные акты и отчеты',
                            'kk' => 'Нормативтік актілер және есептер',
                            'en' => 'Regulatory acts and reports',
                        ],
                        
                        'item3_title' => [
                            'ru' => 'Информация',
                            'kk' => 'Ақпарат',
                            'en' => 'Information',
                        ],
                        'item3_description' => [
                            'ru' => 'Сведения о противодействии коррупции',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлыққа қарсы іс-қимыл туралы мәліметтер',
                            'en' => 'Information on anti-corruption activities',
                        ],
                    ],
                ],

                // Секция 6: Навигация
                [
                    'page_key' => $pageKey,
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'contact_button' => [
                            'ru' => 'Сообщить о коррупции',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлық туралы хабарлау',
                            'en' => 'Report corruption',
                        ],
                    ],
                ],
                
                // Секция 7: Важная информация
                [
                    'page_key' => $pageKey,
                    'section_key' => 'important_info',
                    'title' => 'Важная информация',
                    'description' => 'Важные уведомления и контакты',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'title' => [
                            'ru' => 'Важная информация',
                            'kk' => 'Маңызды ақпарат',
                            'en' => 'Important information',
                        ],
                        'notice_title' => [
                            'ru' => 'Коррупция – это серьезное правонарушение',
                            'kk' => 'Саяси қызметтегі сыбайлас жемқорлық – бұл қатаң құқық бұзушылық',
                            'en' => 'Corruption is a serious offense',
                        ],
                        'notice_text' => [
                            'ru' => 'Мы призываем всех сообщать о любых случаях коррупции. Ваша информация будет конфиденциальной.',
                            'kk' => 'Біз барлықтан сыбайлас жемқорлықтың кез келген жағдайлары туралы хабарлауды сұраймыз. Сіздің ақпаратыңыз құпия болады.',
                            'en' => 'We urge everyone to report any cases of corruption. Your information will be confidential.',
                        ],
                        'contacts_title' => [
                            'ru' => 'Контакты для сообщений',
                            'kk' => 'Хабарламалар үшін байланыстар',
                            'en' => 'Contacts for reports',
                        ],
                        'email_label' => [
                            'ru' => 'Электронная почта:',
                            'kk' => 'Электрондық пошта:',
                            'en' => 'Email:',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон:',
                            'kk' => 'Телефон:',
                            'en' => 'Phone:',
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
                    Log::info("Создана многоязычная Anticorruption секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Anticorruption: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Противодействие коррупции' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n⚖️ Разделы страницы 'Противодействие коррупции':");
                $this->command->info("   👑 Герой-заголовок страницы");
                $this->command->info("   📋 Информационные материалы");
                $this->command->info("   📄 Документы (с кнопками загрузки)");
                $this->command->info("   ℹ️ Публикуемая информация");
                $this->command->info("   📌 Боковое навигационное меню");
                $this->command->info("   🔗 Навигационные кнопки");
                $this->command->info("   ⚠️ Важная информация и контакты");
                $this->command->info("   🔍 SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}