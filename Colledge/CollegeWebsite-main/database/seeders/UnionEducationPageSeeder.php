<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class UnionEducationPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Профсоюзное обучение...');
            
            $deleted = PageSection::where('page_key', 'union_education')->delete();
            Log::info("Удалено старых записей Union Education: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'union_education',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Профсоюзное обучение',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Профсоюзное обучение',
                            'kk' => 'Кәсіподақтық оқыту',
                            'en' => 'Union Education',
                        ],
                        'meta_title' => [
                            'ru' => 'Профсоюзное обучение | Технический колледж современных технологий',
                            'kk' => 'Кәсіподақтық оқыту | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Union Education | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Нормативные документы и учебные материалы для профсоюзных активистов. Просмотр и скачивание материалов по профсоюзной деятельности в формате PDF.',
                            'kk' => 'Кәсіподақ белсенділері үшін нормативтік құжаттар мен оқу материалдары. Кәсіподақ қызметі бойынша материалдарды PDF форматында қарау және жүктеу.',
                            'en' => 'Regulatory documents and training materials for trade union activists. View and download materials on trade union activities in PDF format.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'union_education',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Профсоюзное обучение',
                            'kk' => 'Кәсіподақтық оқыту',
                            'en' => 'Union Education',
                        ],
                        'main_description' => [
                            'ru' => 'Нормативные документы и учебные материалы для профсоюзных активистов. Все документы представлены в формате PDF для просмотра и скачивания.',
                            'kk' => 'Кәсіподақ белсенділері үшін нормативтік құжаттар мен оқу материалдары. Барлық құжаттар қарау және жүктеу үшін PDF форматында ұсынылған.',
                            'en' => 'Regulatory documents and training materials for trade union activists. All documents are presented in PDF format for viewing and downloading.',
                        ],
                    ],
                ],

                [
                    'page_key' => 'union_education',
                    'section_key' => 'navigation',
                    'title' => 'Навигация по документам',
                    'description' => 'Левая панель навигации с документами',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'documents_title' => [
                            'ru' => 'Нормативные документы',
                            'kk' => 'Нормативтік құжаттар',
                            'en' => 'Regulatory Documents',
                        ],
                        'documents_subtitle' => [
                            'ru' => 'Выберите документ для изучения',
                            'kk' => 'Зерттеу үшін құжатты таңдаңыз',
                            'en' => 'Select a document to study',
                        ],
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                    ],
                ],

                [
                    'page_key' => 'union_education',
                    'section_key' => 'document_header',
                    'title' => 'Заголовок документа',
                    'description' => 'Элементы заголовка каждого документа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'normative_label' => [
                            'ru' => 'НОРМАТИВНЫЙ ДОКУМЕНТ',
                            'kk' => 'НОРМАТИВТІК ҚҰЖАТ',
                            'en' => 'REGULATORY DOCUMENT',
                        ],
                    ],
                ],

                [
                    'page_key' => 'union_education',
                    'section_key' => 'pdf_viewer',
                    'title' => 'PDF просмотрщик',
                    'description' => 'Элементы управления PDF просмотрщиком',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
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
                    'page_key' => 'union_education',
                    'section_key' => 'download',
                    'title' => 'Скачивание документов',
                    'description' => 'Кнопки и текст для скачивания',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
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

                [
                    'page_key' => 'union_education',
                    'section_key' => 'info_block',
                    'title' => 'Информационный блок',
                    'description' => 'Блок с информацией о значении нормативных документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Значение нормативных документов',
                            'kk' => 'Нормативтік құжаттардың маңызы',
                            'en' => 'Importance of Regulatory Documents',
                        ],
                        'description' => [
                            'ru' => 'Нормативные документы являются основой для эффективной работы профсоюзных организаций. Они определяют права, обязанности и процедуры деятельности профсоюзных активистов, обеспечивают единый подход к организации профсоюзной работы и способствуют развитию профсоюзного движения. Регулярное изучение и применение этих документов является обязательным для всех членов профсоюзных организаций.',
                            'kk' => 'Нормативтік құжаттар кәсіподақ ұйымдарының тиімді жұмысының негізі болып табылады. Олар кәсіподақ белсенділерінің қызметінің құқықтарын, міндеттерін және процедураларын анықтайды, кәсіподақ жұмысын ұйымдастыруға бірыңғай көзқарасты қамтамасыз етеді және кәсіподақ қозғалысының дамуына ықпал етеді. Бұл құжаттарды үнемі оқу және қолдану барлық кәсіподақ ұйымдарының мүшелері үшін міндетті болып табылады.',
                            'en' => 'Regulatory documents are the basis for the effective work of trade union organizations. They define the rights, duties and procedures of trade union activists, ensure a unified approach to organizing trade union work and contribute to the development of the trade union movement. Regular study and application of these documents is mandatory for all members of trade union organizations.',
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
                    Log::info("Создана секция Union Education: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано секций Union Education: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница 'Профсоюзное обучение' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📚 Структура страницы 'Профсоюзное обучение':");
                $this->command->info("   🎓 Заголовок и описание профсоюзного обучения");
                $this->command->info("   📋 Навигационная панель с документами");
                $this->command->info("   📄 Заголовки нормативных документов");
                $this->command->info("   👁️ PDF просмотрщик с управлением");
                $this->command->info("   ⬇️ Кнопки скачивания документов");
                $this->command->info("   ℹ️ Информационный блок о значении документов");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}