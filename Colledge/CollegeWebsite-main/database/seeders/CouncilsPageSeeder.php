<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class CouncilsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Советы при колледже...');
            
            $pageKey = 'councils';
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', $pageKey)->delete();
            Log::info("Удалено старых записей Councils: {$deleted}");
            
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
                            'ru' => 'Советы при колледже',
                            'kk' => 'Колледждегі кеңестер',
                            'en' => 'College Councils',
                        ],
                        'meta_title' => [
                            'ru' => 'Советы при колледже | Колледж современных технологий',
                            'kk' => 'Колледждегі кеңестер | Заманауи технологиялар колледжі',
                            'en' => 'College Councils | College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Советы и комиссии при колледже. Структурные подразделения, обеспечивающие развитие образовательного процесса.',
                            'kk' => 'Колледждегі кеңестер мен комиссиялар. Білім беру процесінің дамуын қамтамасыз ететін құрылымдық бөлімшелер.',
                            'en' => 'Councils and commissions at the college. Structural units ensuring the development of the educational process.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'hero',
                    'title' => 'Герой секция - Советы при колледже',
                    'description' => 'Заголовок и подзаголовок страницы советов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_1' => [
                            'ru' => 'Советы при',
                            'kk' => 'Колледждегі',
                            'en' => 'Councils at',
                        ],
                        'main_title_2' => [
                            'ru' => 'колледже',
                            'kk' => 'кеңестер',
                            'en' => 'the College',
                        ],
                        'subtitle' => [
                            'ru' => 'Структурные подразделения колледжа, обеспечивающие развитие образовательного процесса',
                            'kk' => 'Білім беру процесінің дамуын қамтамасыз ететін колледждің құрылымдық бөлімшелері',
                            'en' => 'Structural units of the college ensuring the development of the educational process',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'categories',
                    'title' => 'Категории советов',
                    'description' => 'Фильтры категорий на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'all_label' => [
                            'ru' => 'Все советы',
                            'kk' => 'Барлық кеңестер',
                            'en' => 'All councils',
                        ],
                        'academic_label' => [
                            'ru' => 'Учебные',
                            'kk' => 'Оқу',
                            'en' => 'Academic',
                        ],
                        'methodological_label' => [
                            'ru' => 'Методические',
                            'kk' => 'Әдістемелік',
                            'en' => 'Methodological',
                        ],
                        'administrative_label' => [
                            'ru' => 'Административные',
                            'kk' => 'Әкімшілік',
                            'en' => 'Administrative',
                        ],
                        'student_label' => [
                            'ru' => 'Студенческие',
                            'kk' => 'Студенттік',
                            'en' => 'Student',
                        ],
                        'filter_label' => [
                            'ru' => 'Фильтр по категориям:',
                            'kk' => 'Санаттар бойынша сүзгі:',
                            'en' => 'Filter by category:',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'council_card',
                    'title' => 'Карточка совета',
                    'description' => 'Элементы карточки совета',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'category_label' => [
                            'ru' => 'Категория:',
                            'kk' => 'Санаты:',
                            'en' => 'Category:',
                        ],
                        'members_label' => [
                            'ru' => 'Состав:',
                            'kk' => 'Құрамы:',
                            'en' => 'Members:',
                        ],
                        'documents_label' => [
                            'ru' => 'Документы:',
                            'kk' => 'Құжаттар:',
                            'en' => 'Documents:',
                        ],
                        'view_button' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'View details',
                        ],
                        'no_documents' => [
                            'ru' => 'Нет документов',
                            'kk' => 'Құжаттар жоқ',
                            'en' => 'No documents',
                        ],
                        'members_count' => [
                            'ru' => 'участников',
                            'kk' => 'қатысушы',
                            'en' => 'members',
                        ],
                        'documents_count' => [
                            'ru' => 'документов',
                            'kk' => 'құжат',
                            'en' => 'documents',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'empty_state',
                    'title' => 'Состояние пустого списка',
                    'description' => 'Текст когда нет доступных советов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Советы не найдены',
                            'kk' => 'Кеңестер табылмады',
                            'en' => 'No councils found',
                        ],
                        'message' => [
                            'ru' => 'Информация о советах при колледже скоро будет добавлена',
                            'kk' => 'Колледждегі кеңестер туралы ақпарат жақында қосылады',
                            'en' => 'Information about college councils will be added soon',
                        ],
                        'refresh_button' => [
                            'ru' => 'Обновить',
                            'kk' => 'Жаңарту',
                            'en' => 'Refresh',
                        ],
                        'back_button' => [
                            'ru' => 'Вернуться назад',
                            'kk' => 'Артқа қайту',
                            'en' => 'Go back',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'modal',
                    'title' => 'Тексты модального окна',
                    'description' => 'Тексты для модального окна совета',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'close_button' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'documents_title' => [
                            'ru' => 'Документы совета',
                            'kk' => 'Кеңестің құжаттары',
                            'en' => 'Council documents',
                        ],
                        'preview_button' => [
                            'ru' => 'Просмотреть',
                            'kk' => 'Қарап шығу',
                            'en' => 'Preview',
                        ],
                        'download_button' => [
                            'ru' => 'Скачать',
                            'kk' => 'Жүктеу',
                            'en' => 'Download',
                        ],
                        'work_period_label' => [
                            'ru' => 'Период работы',
                            'kk' => 'Жұмыс мерзімі',
                            'en' => 'Working period',
                        ],
                        'chairman_label' => [
                            'ru' => 'Председатель',
                            'kk' => 'Төраға',
                            'en' => 'Chairman',
                        ],
                        'secretary_label' => [
                            'ru' => 'Секретарь',
                            'kk' => 'Хатшы',
                            'en' => 'Secretary',
                        ],
                        'meetings_label' => [
                            'ru' => 'Заседания',
                            'kk' => 'Отырыстар',
                            'en' => 'Meetings',
                        ],
                        'email_label' => [
                            'ru' => 'Email для связи',
                            'kk' => 'Хабарласу үшін Email',
                            'en' => 'Contact email',
                        ],
                        'contact_button' => [
                            'ru' => 'Связаться с советом',
                            'kk' => 'Кеңес хатшылығымен байланысу',
                            'en' => 'Contact the council',
                        ],
                        'members_title' => [
                            'ru' => 'Состав совета',
                            'kk' => 'Кеңестің құрамы',
                            'en' => 'Council members',
                        ],
                        'goals_title' => [
                            'ru' => 'Основные задачи',
                            'kk' => 'Негізгі міндеттер',
                            'en' => 'Main tasks',
                        ],
                        'tasks_title' => [
                            'ru' => 'Функции и полномочия',
                            'kk' => 'Функциялар мен өкілеттіктер',
                            'en' => 'Functions and powers',
                        ],
                    ],
                ],
                
                [
                    'page_key' => $pageKey,
                    'section_key' => 'pdf_viewer',
                    'title' => 'Тексты PDF просмотрщика',
                    'description' => 'Тексты для окна просмотра PDF',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Просмотр документа',
                            'kk' => 'Құжатты қарап шығу',
                            'en' => 'Document preview',
                        ],
                        'close_button' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'zoom_out' => [
                            'ru' => 'Уменьшить',
                            'kk' => 'Кішірейту',
                            'en' => 'Zoom out',
                        ],
                        'normal_size' => [
                            'ru' => 'Нормальный размер',
                            'kk' => 'Қалыпты өлшем',
                            'en' => 'Normal size',
                        ],
                        'zoom_in' => [
                            'ru' => 'Увеличить',
                            'kk' => 'Үлкейту',
                            'en' => 'Zoom in',
                        ],
                        'download' => [
                            'ru' => 'Скачать PDF',
                            'kk' => 'PDF жүктеу',
                            'en' => 'Download PDF',
                        ],
                        'download_text' => [
                            'ru' => 'Скачать',
                            'kk' => 'Жүктеу',
                            'en' => 'Download',
                        ],
                        'print' => [
                            'ru' => 'Печать',
                            'kk' => 'Басып шығару',
                            'en' => 'Print',
                        ],
                        'print_text' => [
                            'ru' => 'Печать',
                            'kk' => 'Басып шығару',
                            'en' => 'Print',
                        ],
                        'loading_text' => [
                            'ru' => 'Загрузка документа...',
                            'kk' => 'Құжат жүктелуде...',
                            'en' => 'Loading document...',
                        ],
                        'error_text' => [
                            'ru' => 'Не удалось загрузить документ',
                            'kk' => 'Құжатты жүктеу мүмкін болмады',
                            'en' => 'Failed to load document',
                        ],
                        'file_size' => [
                            'ru' => 'Размер файла:',
                            'kk' => 'Файл өлшемі:',
                            'en' => 'File size:',
                        ],
                    ],
                ],

                [
                    'page_key' => $pageKey,
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'search_placeholder' => [
                            'ru' => 'Поиск советов...',
                            'kk' => 'Кеңестерді іздеу...',
                            'en' => 'Search councils...',
                        ],
                    ],
                ],

                [
                    'page_key' => $pageKey,
                    'section_key' => 'contacts',
                    'title' => 'Контактная информация',
                    'description' => 'Контактные данные для связи с советами',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'title' => [
                            'ru' => 'Контакты советов',
                            'kk' => 'Кеңестердің байланыстары',
                            'en' => 'Council contacts',
                        ],
                        'general_email_label' => [
                            'ru' => 'Общий email:',
                            'kk' => 'Жалпы email:',
                            'en' => 'General email:',
                        ],
                        'general_email' => [
                            'ru' => 'councils@college.edu',
                            'kk' => 'councils@college.edu',
                            'en' => 'councils@college.edu',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон:',
                            'kk' => 'Телефон:',
                            'en' => 'Phone:',
                        ],
                        'phone' => [
                            'ru' => '+7 701 123-45-67',
                            'kk' => '+7 701 123-45-67',
                            'en' => '+7 701 123-45-67',
                        ],
                        'address_label' => [
                            'ru' => 'Адрес:',
                            'kk' => 'Мекенжай:',
                            'en' => 'Address:',
                        ],
                        'address' => [
                            'ru' => 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2, каб. 310',
                            'kk' => 'Павлодар қ., Жүсіпбек Аймауытұлы к-сі, 2, 310 каб.',
                            'en' => 'Pavlodar, Zhusipbek Aimautuly St., 2, room 310',
                        ],
                        'working_hours_label' => [
                            'ru' => 'Часы работы:',
                            'kk' => 'Жұмыс уақыты:',
                            'en' => 'Working hours:',
                        ],
                        'working_hours' => [
                            'ru' => 'Пн-Пт: 9:00-18:00',
                            'kk' => 'Дб-Жм: 9:00-18:00',
                            'en' => 'Mon-Fri: 9:00-18:00',
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
                    Log::info("Создана многоязычная Councils секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Councils: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Советы при колледже' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🏛️ Разделы страницы 'Советы при колледже':");
                $this->command->info("   🔍 SEO метаданные");
                $this->command->info("   👑 Герой-заголовок страницы");
                $this->command->info("   🏷️ Категории советов (5 категорий)");
                $this->command->info("   🗂️ Элементы карточки совета");
                $this->command->info("   📭 Состояние пустого списка");
                $this->command->info("   🪟 Модальное окно с деталями совета");
                $this->command->info("   📄 PDF просмотрщик документов");
                $this->command->info("   🧭 Навигация и поиск");
                $this->command->info("   📞 Контактная информация");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}