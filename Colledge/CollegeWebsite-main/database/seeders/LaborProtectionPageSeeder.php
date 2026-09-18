<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class LaborProtectionPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Охрана труда...');
            
            $deleted = PageSection::where('page_key', 'labor_protection')->delete();
            Log::info("Удалено старых записей Labor Protection: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'labor_protection',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Охрана труда',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Охрана труда',
                            'kk' => 'Еңбек қорғау',
                            'en' => 'Labor Protection',
                        ],
                        'meta_title' => [
                            'ru' => 'Охрана труда | Технический колледж современных технологий',
                            'kk' => 'Еңбек қорғау | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Labor Protection | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Нормативные документы по охране труда и технике безопасности колледжа. Просмотр и скачивание инструкций по безопасности в формате PDF.',
                            'kk' => 'Колледждің еңбек қорғау және техникалық қауіпсіздік бойынша нормативтік құжаттары. Қауіпсіздік бойынша нұсқаулықтарды PDF форматында қарау және жүктеу.',
                            'en' => 'Regulatory documents on labor protection and safety at the college. View and download safety instructions in PDF format.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'labor_protection',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Охрана труда',
                            'kk' => 'Еңбек қорғау',
                            'en' => 'Labor Protection',
                        ],
                        'main_description' => [
                            'ru' => 'Нормативные документы по охране труда и технике безопасности. Все документы представлены в формате PDF для просмотра и скачивания.',
                            'kk' => 'Еңбек қорғау және техникалық қауіпсіздік бойынша нормативтік құжаттар. Барлық құжаттар қарау және жүктеу үшін PDF форматында ұсынылған.',
                            'en' => 'Regulatory documents on labor protection and safety. All documents are presented in PDF format for viewing and downloading.',
                        ],
                    ],
                ],

                [
                    'page_key' => 'labor_protection',
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
                    'page_key' => 'labor_protection',
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
                    'page_key' => 'labor_protection',
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
                    'page_key' => 'labor_protection',
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
                    'page_key' => 'labor_protection',
                    'section_key' => 'info_block',
                    'title' => 'Информационный блок',
                    'description' => 'Блок с информацией о важности охраны труда',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Важность охраны труда',
                            'kk' => 'Еңбек қорғаудың маңыздылығы',
                            'en' => 'Importance of Labor Protection',
                        ],
                        'description' => [
                            'ru' => 'Охрана труда является важнейшим направлением деятельности любой организации. Нормативные документы по охране труда обеспечивают безопасные условия работы, предотвращают производственные травмы и заболевания, способствуют сохранению здоровья работников. Регулярное изучение и соблюдение требований охраны труда является обязательным для всех сотрудников и руководителей.',
                            'kk' => 'Еңбек қорғау кез келген ұйым қызметінің маңызды бағыты болып табылады. Еңбек қорғау бойынша нормативтік құжаттар жұмыстың қауіпсіз жағдайларын қамтамасыз етеді, өндірістік жарақаттар мен аурулардың алдын алады, жұмысшылардың денсаулығын сақтауға ықпал етеді. Еңбек қорғау талаптарын үнемі оқу және сақтау барлық қызметкерлер мен басшылар үшін міндетті болып табылады.',
                            'en' => 'Labor protection is the most important area of activity of any organization. Regulatory documents on labor protection ensure safe working conditions, prevent industrial injuries and diseases, and contribute to the preservation of workers health. Regular study and compliance with labor protection requirements is mandatory for all employees and managers.',
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
                    Log::info("Создана секция Labor Protection: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано секций Labor Protection: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница 'Охрана труда' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🛡️ Структура страницы 'Охрана труда':");
                $this->command->info("   🛡️ Заголовок и описание охраны труда");
                $this->command->info("   📋 Навигационная панель с документами");
                $this->command->info("   📄 Заголовки нормативных документов");
                $this->command->info("   👁️ PDF просмотрщик с управлением");
                $this->command->info("   ⬇️ Кнопки скачивания документов");
                $this->command->info("   ℹ️ Информационный блок о важности охраны труда");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}