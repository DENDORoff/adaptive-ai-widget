<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class NormativeDocumentsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Нормативные документы...');
            
            $deleted = PageSection::where('page_key', 'normative')->delete();
            Log::info("Удалено старых записей Normative: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'normative',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Нормативные документы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Нормативно-правовые документы',
                            'kk' => 'Нормативтік-құқықтық құжаттар',
                            'en' => 'Regulatory Documents',
                        ],
                        'meta_title' => [
                            'ru' => 'Нормативно-правовые документы | Технический колледж современных технологий',
                            'kk' => 'Нормативтік-құқықтық құжаттар | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Regulatory Documents | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Официальные нормативно-правовые документы колледжа: устав, лицензии, аккредитация, локальные акты. Просмотр и скачивание в формате PDF.',
                            'kk' => 'Колледждің ресми нормативтік-құқықтық құжаттары: жарғы, лицензиялар, аккредитация, жергілікті актілер. PDF форматында көру және жүктеу.',
                            'en' => 'Official regulatory documents of the college: charter, licenses, accreditation, local acts. View and download in PDF format.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'normative',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Нормативно-правовые документы',
                            'kk' => 'Нормативтік-құқықтық құжаттар',
                            'en' => 'Regulatory Documents',
                        ],
                        'main_description' => [
                            'ru' => 'Официальные документы, регулирующие деятельность образовательного учреждения. Все документы представлены в формате PDF для просмотра и скачивания.',
                            'kk' => 'Білім беру мекемесінің қызметін реттейтін ресми құжаттар. Барлық құжаттар қарау және жүктеу үшін PDF форматында ұсынылған.',
                            'en' => 'Official documents regulating the activities of the educational institution. All documents are presented in PDF format for viewing and downloading.',
                        ],
                    ],
                ],

                [
                    'page_key' => 'normative',
                    'section_key' => 'navigation',
                    'title' => 'Навигация по документам',
                    'description' => 'Левая панель навигации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'documents_list_title' => [
                            'ru' => 'Список документов',
                            'kk' => 'Құжаттар тізімі',
                            'en' => 'Documents List',
                        ],
                        'documents_list_subtitle' => [
                            'ru' => 'Выберите документ для просмотра',
                            'kk' => 'Қарау үшін құжатты таңдаңыз',
                            'en' => 'Select a document to view',
                        ],
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                    ],
                ],

                [
                    'page_key' => 'normative',
                    'section_key' => 'pdf_viewer',
                    'title' => 'PDF просмотрщик',
                    'description' => 'Элементы управления PDF просмотрщиком',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'pages_label' => [
                            'ru' => 'стр.',
                            'kk' => 'бет',
                            'en' => 'p.',
                        ],
                        'zoom_out_title' => [
                            'ru' => 'Уменьшить',
                            'kk' => 'Кішірейту',
                            'en' => 'Zoom Out',
                        ],
                        'zoom_in_title' => [
                            'ru' => 'Увеличить',
                            'kk' => 'Үлкейту',
                            'en' => 'Zoom In',
                        ],
                        'page_label' => [
                            'ru' => 'Страница',
                            'kk' => 'Бет',
                            'en' => 'Page',
                        ],
                        'of_label' => [
                            'ru' => 'из',
                            'kk' => '',
                            'en' => 'of',
                        ],
                        'prev_button' => [
                            'ru' => 'Предыдущая',
                            'kk' => 'Алдыңғы',
                            'en' => 'Previous',
                        ],
                        'next_button' => [
                            'ru' => 'Следующая',
                            'kk' => 'Келесі',
                            'en' => 'Next',
                        ],
                        'open_new_tab_title' => [
                            'ru' => 'Открыть в новой вкладке',
                            'kk' => 'Жаңа қойындыда ашу',
                            'en' => 'Open in new tab',
                        ],
                    ],
                ],

                [
                    'page_key' => 'normative',
                    'section_key' => 'download',
                    'title' => 'Скачивание документов',
                    'description' => 'Кнопки и текст для скачивания',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'download_button' => [
                            'ru' => 'Скачать документ',
                            'kk' => 'Құжатты жүктеу',
                            'en' => 'Download document',
                        ],
                        'download_with_size' => [
                            'ru' => 'Скачать документ',
                            'kk' => 'Құжатты жүктеу',
                            'en' => 'Download document',
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
                    Log::info("Создана секция Normative: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано секций Normative: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница 'Нормативные документы' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📄 Структура страницы 'Нормативные документы':");
                $this->command->info("   📑 Заголовок и описание страницы");
                $this->command->info("   📋 Навигационная панель с документами");
                $this->command->info("   👁️ PDF просмотрщик с управлением");
                $this->command->info("   ⬇️ Кнопки скачивания документов");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}