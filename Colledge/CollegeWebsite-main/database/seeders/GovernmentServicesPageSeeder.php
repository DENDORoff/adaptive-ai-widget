<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class GovernmentServicesPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы государственных услуг...');
            
            // Удаляем старые записи для страницы государственных услуг
            $deleted = PageSection::where('page_key', 'government_services')->delete();
            Log::info("Удалено старых записей Government Services: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'government_services',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы государственных услуг',
                    'description' => 'SEO и общие настройки страницы государственных услуг',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Государственные услуги',
                            'kk' => 'Мемлекеттік қызметтер',
                            'en' => 'Government services',
                        ],
                        'meta_title' => [
                            'ru' => 'Государственные услуги колледжа | Официальный перечень услуг',
                            'kk' => 'Колледждің мемлекеттік қызметтері | Ресми қызметтер тізімі',
                            'en' => 'College government services | Official list of services',
                        ],
                        'meta_description' => [
                            'ru' => 'Полный перечень государственных услуг, предоставляемых колледжем. Условия получения, необходимые документы, сроки исполнения.',
                            'kk' => 'Колледж ұсынатын мемлекеттік қызметтердің толық тізімі. Алу шарттары, қажетті құжаттар, орындау мерзімдері.',
                            'en' => 'A complete list of government services provided by the college. Terms of receipt, required documents, execution deadlines.',
                        ],
                    ],
                ],

                // HERO SECTION
                [
                    'page_key' => 'government_services',
                    'section_key' => 'hero',
                    'title' => 'Заглавная секция',
                    'description' => 'Главный заголовок страницы услуг',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_line1' => [
                            'ru' => 'Государственные',
                            'kk' => 'Мемлекеттік',
                            'en' => 'Government',
                        ],
                        'main_title_line2' => [
                            'ru' => 'услуги',
                            'kk' => 'қызметтер',
                            'en' => 'services',
                        ],
                        'description' => [
                            'ru' => 'Полный перечень государственных услуг, предоставляемых колледжем',
                            'kk' => 'Колледж ұсынатын мемлекеттік қызметтердің толық тізімі',
                            'en' => 'Complete list of government services provided by the college',
                        ],
                    ],
                ],
                
                // EMPTY STATE
                [
                    'page_key' => 'government_services',
                    'section_key' => 'empty_state',
                    'title' => 'Сообщение пустого состояния',
                    'description' => 'Текст когда нет услуг',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'Услуги не найдены',
                            'kk' => 'Қызметтер табылмады',
                            'en' => 'Services not found',
                        ],
                        'description' => [
                            'ru' => 'Информация о государственных услугах скоро будет добавлена',
                            'kk' => 'Мемлекеттік қызметтер туралы ақпарат жақында қосылады',
                            'en' => 'Information about government services will be added soon',
                        ],
                    ],
                ],
                
                // MODAL LABELS
                [
                    'page_key' => 'government_services',
                    'section_key' => 'modal_labels',
                    'title' => 'Надписи в модальном окне',
                    'description' => 'Тексты секций модального окна услуги',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'description_title' => [
                            'ru' => 'Описание услуги',
                            'kk' => 'Қызметтің сипаттамасы',
                            'en' => 'Service description',
                        ],
                        'execution_time_title' => [
                            'ru' => 'Срок выполнения',
                            'kk' => 'Орындау мерзімі',
                            'en' => 'Execution time',
                        ],
                        'responsible_department_title' => [
                            'ru' => 'Ответственный отдел',
                            'kk' => 'Жауапты бөлім',
                            'en' => 'Responsible department',
                        ],
                        'documents_count_title' => [
                            'ru' => 'Документов',
                            'kk' => 'Құжаттар',
                            'en' => 'Documents',
                        ],
                        'required_documents_title' => [
                            'ru' => 'Необходимые документы',
                            'kk' => 'Қажетті құжаттар',
                            'en' => 'Required documents',
                        ],
                        'download_documents_title' => [
                            'ru' => 'Документы для скачивания',
                            'kk' => 'Жүктеп алуға арналған құжаттар',
                            'en' => 'Documents for download',
                        ],
                        'form_badge' => [
                            'ru' => 'Есть бланк',
                            'kk' => 'Үлгі бар',
                            'en' => 'Form available',
                        ],
                        'documents_badge' => [
                            'ru' => 'документов',
                            'kk' => 'құжаттар',
                            'en' => 'documents',
                        ],
                        'download_btn' => [
                            'ru' => 'Скачать',
                            'kk' => 'Жүктеп алу',
                            'en' => 'Download',
                        ],
                        'download_form_btn' => [
                            'ru' => 'Скачать бланк заявления',
                            'kk' => 'Өтініш үлгісін жүктеп алу',
                            'en' => 'Download application form',
                        ],
                        'ask_question_btn' => [
                            'ru' => 'Задать вопрос',
                            'kk' => 'Сұрақ қою',
                            'en' => 'Ask a question',
                        ],
                        'more_info_btn' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'More details',
                        ],
                    ],
                ],
                
                // BADGE LABELS
                [
                    'page_key' => 'government_services',
                    'section_key' => 'badge_labels',
                    'title' => 'Тексты бейджей',
                    'description' => 'Надписи на бейджах документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'document_label' => [
                            'ru' => 'документ',
                            'kk' => 'құжат',
                            'en' => 'document',
                        ],
                        'document_label_2_4' => [
                            'ru' => 'документа',
                            'kk' => 'құжат',
                            'en' => 'documents',
                        ],
                        'document_label_5_plus' => [
                            'ru' => 'документов',
                            'kk' => 'құжаттар',
                            'en' => 'documents',
                        ],
                        'files_label' => [
                            'ru' => 'файлов',
                            'kk' => 'файлдар',
                            'en' => 'files',
                        ],
                    ],
                ],
                
                // BUTTON LABELS
                [
                    'page_key' => 'government_services',
                    'section_key' => 'button_labels',
                    'title' => 'Тексты кнопок',
                    'description' => 'Надписи на кнопках интерфейса',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'close_btn' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'apply_filter_btn' => [
                            'ru' => 'Применить фильтр',
                            'kk' => 'Сүзгіні қолдану',
                            'en' => 'Apply filter',
                        ],
                        'reset_filter_btn' => [
                            'ru' => 'Сбросить фильтр',
                            'kk' => 'Сүзгіні қалпына келтіру',
                            'en' => 'Reset filter',
                        ],
                        'view_all_btn' => [
                            'ru' => 'Посмотреть все услуги',
                            'kk' => 'Барлық қызметтерді қарау',
                            'en' => 'View all services',
                        ],
                    ],
                ],
                
                // DOCUMENT TYPES
                [
                    'page_key' => 'government_services',
                    'section_key' => 'document_types',
                    'title' => 'Типы документов',
                    'description' => 'Названия типов документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'info_document' => [
                            'ru' => 'Информационный документ',
                            'kk' => 'Ақпараттық құжат',
                            'en' => 'Information document',
                        ],
                        'form_document' => [
                            'ru' => 'Форма/Бланк',
                            'kk' => 'Үлгі/Бланк',
                            'en' => 'Form/Blank',
                        ],
                        'regulation_document' => [
                            'ru' => 'Регламент',
                            'kk' => 'Ереже',
                            'en' => 'Regulation',
                        ],
                        'instruction_document' => [
                            'ru' => 'Инструкция',
                            'kk' => 'Нұсқаулық',
                            'en' => 'Instruction',
                        ],
                        'default_document' => [
                            'ru' => 'Документ',
                            'kk' => 'Құжат',
                            'en' => 'Document',
                        ],
                    ],
                ],

                // FILTER LABELS
                [
                    'page_key' => 'government_services',
                    'section_key' => 'filter_labels',
                    'title' => 'Надписи фильтров',
                    'description' => 'Тексты для фильтров и поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'search_placeholder' => [
                            'ru' => 'Поиск услуг...',
                            'kk' => 'Қызметтерді іздеу...',
                            'en' => 'Search services...',
                        ],
                        'category_all' => [
                            'ru' => 'Все категории',
                            'kk' => 'Барлық санаттар',
                            'en' => 'All categories',
                        ],
                        'sort_by' => [
                            'ru' => 'Сортировать по:',
                            'kk' => 'Сұрыптау:',
                            'en' => 'Sort by:',
                        ],
                        'sort_name' => [
                            'ru' => 'Названию',
                            'kk' => 'Атауы бойынша',
                            'en' => 'Name',
                        ],
                        'sort_date' => [
                            'ru' => 'Дате',
                            'kk' => 'Күні бойынша',
                            'en' => 'Date',
                        ],
                        'sort_popularity' => [
                            'ru' => 'Популярности',
                            'kk' => 'Танымалдылығы бойынша',
                            'en' => 'Popularity',
                        ],
                    ],
                ],

                // SERVICE STATUS LABELS
                [
                    'page_key' => 'government_services',
                    'section_key' => 'service_status',
                    'title' => 'Статусы услуг',
                    'description' => 'Тексты для статусов государственных услуг',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'status_active' => [
                            'ru' => 'Активная',
                            'kk' => 'Белсенді',
                            'en' => 'Active',
                        ],
                        'status_suspended' => [
                            'ru' => 'Приостановлена',
                            'kk' => 'Тоқтатылған',
                            'en' => 'Suspended',
                        ],
                        'status_planned' => [
                            'ru' => 'Запланирована',
                            'kk' => 'Жоспарланған',
                            'en' => 'Planned',
                        ],
                        'status_free' => [
                            'ru' => 'Бесплатная',
                            'kk' => 'Тегін',
                            'en' => 'Free',
                        ],
                        'status_paid' => [
                            'ru' => 'Платная',
                            'kk' => 'Ақылы',
                            'en' => 'Paid',
                        ],
                    ],
                ],

                // NAVIGATION
                [
                    'page_key' => 'government_services',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад к услугам',
                            'kk' => 'Қызметтерге оралу',
                            'en' => 'Back to services',
                        ],
                        'breadcrumb_home' => [
                            'ru' => 'Главная',
                            'kk' => 'Басты бет',
                            'en' => 'Home',
                        ],
                        'breadcrumb_services' => [
                            'ru' => 'Государственные услуги',
                            'kk' => 'Мемлекеттік қызметтер',
                            'en' => 'Government services',
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
                    Log::info("Создана многоязычная Government Services секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Government Services секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Government Services секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Government Services были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Government Services были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных Government Services секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Государственные услуги' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Government Services секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🏛️ Разделы страницы 'Государственные услуги':");
                $this->command->info("   👑 Герой-секция с заголовком");
                $this->command->info("   📝 Надписи в модальном окне (15 элементов)");
                $this->command->info("   🏷️ Тексты бейджей для документов");
                $this->command->info("   🎛️ Тексты кнопок интерфейса");
                $this->command->info("   📄 Типы документов (5 категорий)");
                $this->command->info("   🔍 Фильтры и поиск (7 элементов)");
                $this->command->info("   📊 Статусы услуг (5 статусов)");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании страницы Government Services: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании страницы Government Services: {$e->getMessage()}");
            throw $e;
        }
    }
}