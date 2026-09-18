<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class DocumentsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Документы по противодействию коррупции...');
            
            $deleted = PageSection::where('page_key', 'documents')->delete();
            Log::info("Удалено старых записей Documents: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'documents',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Документы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'page_title' => [
                            'ru' => 'Все документы по противодействию коррупции',
                            'kk' => 'Коррупцияға қарсы құжаттардың толық жинағы',
                            'en' => 'All anti-corruption documents',
                        ],
                        'meta_title' => [
                            'ru' => 'Документы по противодействию коррупции | Технический колледж современных технологий',
                            'kk' => 'Коррупцияға қарсы құжаттар | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Anti-corruption documents | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Полный архив официальных документов, нормативных актов и отчетов по противодействию коррупции в Техническом колледже современных технологий.',
                            'kk' => 'Заманауи технологиялардың техникалық колледжінде коррупцияға қарсы ресми құжаттар, нормативтік актілер және есептердің толық мұрағаты.',
                            'en' => 'Complete archive of official documents, regulations and reports on anti-corruption at the Technical College of Modern Technologies.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'documents',
                    'section_key' => 'header',
                    'title' => 'Заголовок страницы',
                    'description' => 'Основной заголовок и подзаголовок',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_part_1' => [
                            'ru' => 'Все документы по',
                            'kk' => 'Барлық құжаттар',
                            'en' => 'All documents on',
                        ],
                        'main_title_part_2' => [
                            'ru' => 'противодействию коррупции',
                            'kk' => 'коррупцияға қарсы',
                            'en' => 'anti-corruption',
                        ],
                        'subtitle' => [
                            'ru' => 'Полный архив официальных документов, нормативных актов и отчетов по противодействию коррупции',
                            'kk' => 'Коррупцияға қарсы ресми құжаттар, нормативтік актілер және есептердің толық мұрағаты',
                            'en' => 'Complete archive of official documents, regulations and reports on anti-corruption',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'filters',
                    'title' => 'Фильтры и заголовки',
                    'description' => 'Названия фильтров и заголовки раздела',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'archive_title' => [
                            'ru' => 'Архив документов',
                            'kk' => 'Құжаттар мұрағаты',
                            'en' => 'Document archive',
                        ],
                        'found_documents' => [
                            'ru' => 'Найдено документов:',
                            'kk' => 'Табылған құжаттар:',
                            'en' => 'Found documents:',
                        ],
                        'all_documents' => [
                            'ru' => 'Все документы',
                            'kk' => 'Барлық құжаттар',
                            'en' => 'All documents',
                        ],
                        'regulatory_acts' => [
                            'ru' => 'Нормативные акты',
                            'kk' => 'Нормативтік актілер',
                            'en' => 'Regulatory acts',
                        ],
                        'reports' => [
                            'ru' => 'Отчеты',
                            'kk' => 'Есептер',
                            'en' => 'Reports',
                        ],
                        'information_lists' => [
                            'ru' => 'Перечни сведений',
                            'kk' => 'Ақпарат тізімдері',
                            'en' => 'Information lists',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'stats',
                    'title' => 'Статистика документов',
                    'description' => 'Подписи для статистических карточек',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'total_documents_label' => [
                            'ru' => 'Документов',
                            'kk' => 'Құжаттар',
                            'en' => 'Documents',
                        ],
                        'law_documents_label' => [
                            'ru' => 'Нормативные акты',
                            'kk' => 'Нормативтік актілер',
                            'en' => 'Regulatory acts',
                        ],
                        'reports_label' => [
                            'ru' => 'Отчеты',
                            'kk' => 'Есептер',
                            'en' => 'Reports',
                        ],
                        'information_lists_label' => [
                            'ru' => 'Перечни сведений',
                            'kk' => 'Ақпарат тізімдері',
                            'en' => 'Information lists',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'table',
                    'title' => 'Заголовки таблицы',
                    'description' => 'Названия колонок таблицы документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title_column' => [
                            'ru' => 'Название документа',
                            'kk' => 'Құжат атауы',
                            'en' => 'Document title',
                        ],
                        'type_column' => [
                            'ru' => 'Тип',
                            'kk' => 'Түрі',
                            'en' => 'Type',
                        ],
                        'category_column' => [
                            'ru' => 'Категория',
                            'kk' => 'Санат',
                            'en' => 'Category',
                        ],
                        'date_column' => [
                            'ru' => 'Дата',
                            'kk' => 'Күні',
                            'en' => 'Date',
                        ],
                        'size_column' => [
                            'ru' => 'Размер',
                            'kk' => 'Өлшемі',
                            'en' => 'Size',
                        ],
                        'actions_column' => [
                            'ru' => 'Действия',
                            'kk' => 'Әрекеттер',
                            'en' => 'Actions',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'buttons',
                    'title' => 'Текст кнопок',
                    'description' => 'Тексты для кнопок действий',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'view_button_title' => [
                            'ru' => 'Просмотреть PDF',
                            'kk' => 'PDF қарау',
                            'en' => 'View PDF',
                        ],
                        'download_button_title' => [
                            'ru' => 'Скачать PDF',
                            'kk' => 'PDF жүктеу',
                            'en' => 'Download PDF',
                        ],
                        'info_button_title' => [
                            'ru' => 'Информация о документе',
                            'kk' => 'Құжат туралы ақпарат',
                            'en' => 'Document information',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'messages',
                    'title' => 'Системные сообщения',
                    'description' => 'Сообщения при отсутствии данных',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'no_documents_title' => [
                            'ru' => 'Документы не найдены',
                            'kk' => 'Құжаттар табылмады',
                            'en' => 'No documents found',
                        ],
                        'no_documents_text' => [
                            'ru' => 'Документы будут добавлены позже',
                            'kk' => 'Құжаттар кейінірек қосылады',
                            'en' => 'Documents will be added later',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'pagination',
                    'title' => 'Текст пагинации',
                    'description' => 'Тексты для пагинации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'showing_text' => [
                            'ru' => 'Показано',
                            'kk' => 'Көрсетілген',
                            'en' => 'Showing',
                        ],
                        'of_text' => [
                            'ru' => 'из',
                            'kk' => 'барлығы',
                            'en' => 'of',
                        ],
                        'documents_text' => [
                            'ru' => 'документов',
                            'kk' => 'құжаттар',
                            'en' => 'documents',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'modal',
                    'title' => 'Модальное окно документа',
                    'description' => 'Тексты в модальном окне информации о документе',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'type_label' => [
                            'ru' => 'Тип документа',
                            'kk' => 'Құжат түрі',
                            'en' => 'Document type',
                        ],
                        'category_label' => [
                            'ru' => 'Категория',
                            'kk' => 'Санат',
                            'en' => 'Category',
                        ],
                        'date_label' => [
                            'ru' => 'Дата документа',
                            'kk' => 'Құжат күні',
                            'en' => 'Document date',
                        ],
                        'size_label' => [
                            'ru' => 'Размер файла',
                            'kk' => 'Файл өлшемі',
                            'en' => 'File size',
                        ],
                        'description_label' => [
                            'ru' => 'Описание',
                            'kk' => 'Сипаттама',
                            'en' => 'Description',
                        ],
                        'view_button' => [
                            'ru' => 'Просмотреть PDF',
                            'kk' => 'PDF қарау',
                            'en' => 'View PDF',
                        ],
                        'download_button' => [
                            'ru' => 'Скачать документ',
                            'kk' => 'Құжатты жүктеу',
                            'en' => 'Download document',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'document_types',
                    'title' => 'Типы документов',
                    'description' => 'Переводы типов документов для фильтров и таблицы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'нормативный акт' => [
                            'ru' => 'Нормативный акт',
                            'kk' => 'Нормативтік акт',
                            'en' => 'Regulatory act',
                        ],
                        'отчет' => [
                            'ru' => 'Отчет',
                            'kk' => 'Есеп',
                            'en' => 'Report',
                        ],
                        'перечень сведений' => [
                            'ru' => 'Перечень сведений',
                            'kk' => 'Ақпарат тізімі',
                            'en' => 'Information list',
                        ],
                        'приказ' => [
                            'ru' => 'Приказ',
                            'kk' => 'Бұйрық',
                            'en' => 'Order',
                        ],
                        'положение' => [
                            'ru' => 'Положение',
                            'kk' => 'Ереже',
                            'en' => 'Regulation',
                        ],
                        'регламент' => [
                            'ru' => 'Регламент',
                            'kk' => 'Регламент',
                            'en' => 'Regulation',
                        ],
                        'инструкция' => [
                            'ru' => 'Инструкция',
                            'kk' => 'Нұсқаулық',
                            'en' => 'Instruction',
                        ],
                        'план' => [
                            'ru' => 'План',
                            'kk' => 'Жоспар',
                            'en' => 'Plan',
                        ],
                        'справка' => [
                            'ru' => 'Справка',
                            'kk' => 'Анықтама',
                            'en' => 'Certificate',
                        ],
                        'протокол' => [
                            'ru' => 'Протокол',
                            'kk' => 'Хаттама',
                            'en' => 'Protocol',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'document_categories',
                    'title' => 'Категории документов',
                    'description' => 'Переводы категорий документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'антикоррупционная политика' => [
                            'ru' => 'Антикоррупционная политика',
                            'kk' => 'Коррупцияға қарсы саясат',
                            'en' => 'Anti-corruption policy',
                        ],
                        'нормативные документы' => [
                            'ru' => 'Нормативные документы',
                            'kk' => 'Нормативтік құжаттар',
                            'en' => 'Regulatory documents',
                        ],
                        'отчетность' => [
                            'ru' => 'Отчетность',
                            'kk' => 'Есептілік',
                            'en' => 'Reporting',
                        ],
                        'планы и программы' => [
                            'ru' => 'Планы и программы',
                            'kk' => 'Жоспарлар мен бағдарламалар',
                            'en' => 'Plans and programs',
                        ],
                        'методические материалы' => [
                            'ru' => 'Методические материалы',
                            'kk' => 'Әдістемелік материалдар',
                            'en' => 'Methodological materials',
                        ],
                        'организационные документы' => [
                            'ru' => 'Организационные документы',
                            'kk' => 'Ұйымдастырушылық құжаттар',
                            'en' => 'Organizational documents',
                        ],
                        'информационные материалы' => [
                            'ru' => 'Информационные материалы',
                            'kk' => 'Ақпараттық материалдар',
                            'en' => 'Information materials',
                        ],
                        'финансовые документы' => [
                            'ru' => 'Финансовые документы',
                            'kk' => 'Қаржылық құжаттар',
                            'en' => 'Financial documents',
                        ],
                        'кадровые документы' => [
                            'ru' => 'Кадровые документы',
                            'kk' => 'Кадрлық құжаттар',
                            'en' => 'Personnel documents',
                        ],
                        'прочие документы' => [
                            'ru' => 'Прочие документы',
                            'kk' => 'Басқа құжаттар',
                            'en' => 'Other documents',
                        ],
                    ],
                ],

                [
                    'page_key' => 'documents',
                    'section_key' => 'sorting',
                    'title' => 'Сортировка документов',
                    'description' => 'Параметры сортировки для таблицы документов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 12,
                    'content' => [
                        'sort_by_date' => [
                            'ru' => 'Сортировка по дате',
                            'kk' => 'Күні бойынша сұрыптау',
                            'en' => 'Sort by date',
                        ],
                        'sort_by_name' => [
                            'ru' => 'Сортировка по названию',
                            'kk' => 'Атауы бойынша сұрыптау',
                            'en' => 'Sort by name',
                        ],
                        'sort_by_type' => [
                            'ru' => 'Сортировка по типу',
                            'kk' => 'Түрі бойынша сұрыптау',
                            'en' => 'Sort by type',
                        ],
                        'sort_by_category' => [
                            'ru' => 'Сортировка по категории',
                            'kk' => 'Санаты бойынша сұрыптау',
                            'en' => 'Sort by category',
                        ],
                        'ascending' => [
                            'ru' => 'По возрастанию',
                            'kk' => 'Өсу ретімен',
                            'en' => 'Ascending',
                        ],
                        'descending' => [
                            'ru' => 'По убыванию',
                            'kk' => 'Кему ретімен',
                            'en' => 'Descending',
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
                    Log::info("Создана многоязычная Documents секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Documents: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Документы по противодействию коррупции' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📑 Особенности страницы 'Документы':");
                $this->command->info("   📊 Полная таблица документов с сортировкой");
                $this->command->info("   🔍 4 фильтра для категорий документов");
                $this->command->info("   📈 Статистика по типам документов");
                $this->command->info("   👁️ Действия: просмотр, скачивание, информация");
                $this->command->info("   🪟 Детальное модальное окно для каждого документа");
                $this->command->info("   📱 Полностью адаптивный дизайн");
                $this->command->info("   🔄 Анимации и плавные переходы");
                
                $this->command->info("\n📄 Разделы страницы:");
                $this->command->info("   1. Метаданные (SEO)");
                $this->command->info("   2. Заголовок страницы");
                $this->command->info("   3. Фильтры и заголовки");
                $this->command->info("   4. Статистика документов");
                $this->command->info("   5. Заголовки таблицы");
                $this->command->info("   6. Текст кнопок");
                $this->command->info("   7. Системные сообщения");
                $this->command->info("   8. Текст пагинации");
                $this->command->info("   9. Модальное окно документа");
                $this->command->info("   10. Типы документов (12 типов)");
                $this->command->info("   11. Категории документов (10 категорий)");
                $this->command->info("   12. Параметры сортировки");
                
                $this->command->info("\n📝 Типы документов:");
                $this->command->info("   • Нормативный акт");
                $this->command->info("   • Отчет");
                $this->command->info("   • Перечень сведений");
                $this->command->info("   • Приказ");
                $this->command->info("   • Положение");
                $this->command->info("   • Регламент");
                $this->command->info("   • Инструкция");
                $this->command->info("   • План");
                $this->command->info("   • Справка");
                $this->command->info("   • Протокол");
                
                $this->command->info("\n📂 Категории документов:");
                $this->command->info("   • Антикоррупционная политика");
                $this->command->info("   • Нормативные документы");
                $this->command->info("   • Отчетность");
                $this->command->info("   • Планы и программы");
                $this->command->info("   • Методические материалы");
                $this->command->info("   • Организационные документы");
                $this->command->info("   • Информационные материалы");
                $this->command->info("   • Финансовые документы");
                $this->command->info("   • Кадровые документы");
                $this->command->info("   • Прочие документы");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}