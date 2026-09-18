<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class PhonebookPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы телефонного справочника...');
            $this->command->info('🔄 Начало сидинга страницы телефонного справочника');
            
            // Удаляем старые записи
            $deleted = PageSection::where('page_key', 'phonebook')->delete();
            Log::info("Удалено старых записей Phonebook: {$deleted}");
            $this->command->info("🗑️ Удалено старых записей: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'phonebook',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные телефонного справочника',
                    'description' => 'SEO и общие настройки страницы телефонного справочника',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Телефонный справочник',
                            'kk' => 'Телефондық анықтамалық',
                            'en' => 'Phone directory',
                        ],
                        'meta_title' => [
                            'ru' => 'Телефонный справочник колледжа | Контакты отделов',
                            'kk' => 'Колледждің телефондық анықтамалығы | Бөлімдердің байланыстары',
                            'en' => 'College phone directory | Department contacts',
                        ],
                        'meta_description' => [
                            'ru' => 'Телефонный справочник колледжа. Контактные телефоны приемной директора, учебной части, бухгалтерии, библиотеки, отдела кадров и IT-отдела.',
                            'kk' => 'Колледждің телефондық анықтамалығы. Директор қабылдауының, оқу бөлімінің, есепшіліктің, кітапхананың, кадр бөлімінің және IT-бөлімінің байланыс телефондары.',
                            'en' => 'College phone directory. Contact phones of the director\'s office, educational department, accounting, library, personnel department and IT department.',
                        ],
                    ],
                ],

                // Главный заголовок
                [
                    'page_key' => 'phonebook',
                    'section_key' => 'hero',
                    'title' => 'Главный заголовок',
                    'description' => 'Заглавная секция телефонного справочника',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_part1' => [
                            'ru' => 'Телефонный',
                            'kk' => 'Телефондық',
                            'en' => 'Phone',
                        ],
                        'main_title_part2' => [
                            'ru' => 'справочник',
                            'kk' => 'анықтамалық',
                            'en' => 'directory',
                        ],
                        'description' => [
                            'ru' => 'Контактные телефоны отделов и служб колледжа',
                            'kk' => 'Колледж бөлімдері мен қызметтерінің байланыс телефондары',
                            'en' => 'Contact phones of college departments and services',
                        ],
                        'working_hours_title' => [
                            'ru' => 'Часы работы',
                            'kk' => 'Жұмыс сағаттары',
                            'en' => 'Working hours',
                        ],
                        'working_hours_text' => [
                            'ru' => 'Пн-Пт: 9:00 - 18:00',
                            'kk' => 'Дүйсен-Жұма: 9:00 - 18:00',
                            'en' => 'Mon-Fri: 9:00 - 18:00',
                        ],
                        'emergency_contact' => [
                            'ru' => 'Экстренная связь: +7 (701) 490-05-66',
                            'kk' => 'Шиелі байланыс: +7 (701) 490-05-66',
                            'en' => 'Emergency contact: +7 (701) 490-05-66',
                        ],
                    ],
                ],

                // Список отделов
                [
                    'page_key' => 'phonebook',
                    'section_key' => 'departments',
                    'title' => 'Список отделов',
                    'description' => 'Телефонные номера отделов колледжа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Отделы колледжа',
                            'kk' => 'Колледж бөлімдері',
                            'en' => 'College departments',
                        ],
                        'section_subtitle' => [
                            'ru' => 'Свяжитесь с нужным отделом',
                            'kk' => 'Қажетті бөліммен байланысыңыз',
                            'en' => 'Contact the department you need',
                        ],

                        // Отдел 1: Приемная директора
                        'department_1_name' => [
                            'ru' => 'Приемная директора',
                            'kk' => 'Директор қабылдауы',
                            'en' => 'Director\'s office',
                        ],
                        'department_1_description' => [
                            'ru' => 'Вопросы руководства, стратегического развития',
                            'kk' => 'Басшылық, стратегиялық даму мәселелері',
                            'en' => 'Management issues, strategic development',
                        ],
                        'department_1_phone' => [
                            'ru' => '+7 (701) 490-05-66',
                            'kk' => '+7 (701) 490-05-66',
                            'en' => '+7 (701) 490-05-66',
                        ],
                        'department_1_email' => [
                            'ru' => 'director@college.edu.kz',
                            'kk' => 'director@college.edu.kz',
                            'en' => 'director@college.edu.kz',
                        ],
                        'department_1_icon_path' => [
                            'ru' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                            'kk' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                            'en' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                        ],

                        // Отдел 2: Учебная часть
                        'department_2_name' => [
                            'ru' => 'Учебная часть',
                            'kk' => 'Оқу бөлімі',
                            'en' => 'Educational department',
                        ],
                        'department_2_description' => [
                            'ru' => 'Расписание, учебный процесс, методическая работа',
                            'kk' => 'Кесте, оқу процесі, әдістемелік жұмыс',
                            'en' => 'Schedule, educational process, methodological work',
                        ],
                        'department_2_phone' => [
                            'ru' => '+7 (701) 490-05-67',
                            'kk' => '+7 (701) 490-05-67',
                            'en' => '+7 (701) 490-05-67',
                        ],
                        'department_2_email' => [
                            'ru' => 'education@college.edu.kz',
                            'kk' => 'education@college.edu.kz',
                            'en' => 'education@college.edu.kz',
                        ],
                        'department_2_icon_path' => [
                            'ru' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
                            'kk' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
                            'en' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
                        ],

                        // Отдел 3: Бухгалтерия
                        'department_3_name' => [
                            'ru' => 'Бухгалтерия',
                            'kk' => 'Есепшілік',
                            'en' => 'Accounting',
                        ],
                        'department_3_description' => [
                            'ru' => 'Финансовые вопросы, оплата обучения, зарплата',
                            'kk' => 'Қаржылық мәселелер, оқу төлемі, жалақы',
                            'en' => 'Financial issues, tuition fees, salary',
                        ],
                        'department_3_phone' => [
                            'ru' => '+7 (701) 490-05-68',
                            'kk' => '+7 (701) 490-05-68',
                            'en' => '+7 (701) 490-05-68',
                        ],
                        'department_3_email' => [
                            'ru' => 'accounting@college.edu.kz',
                            'kk' => 'accounting@college.edu.kz',
                            'en' => 'accounting@college.edu.kz',
                        ],
                        'department_3_icon_path' => [
                            'ru' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            'kk' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            'en' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                        ],

                        // Отдел 4: Библиотека
                        'department_4_name' => [
                            'ru' => 'Библиотека',
                            'kk' => 'Кітапхана',
                            'en' => 'Library',
                        ],
                        'department_4_description' => [
                            'ru' => 'Литература, учебники, электронные ресурсы',
                            'kk' => 'Әдебиет, оқулықтар, электрондық ресурстар',
                            'en' => 'Literature, textbooks, electronic resources',
                        ],
                        'department_4_phone' => [
                            'ru' => '+7 (701) 490-05-69',
                            'kk' => '+7 (701) 490-05-69',
                            'en' => '+7 (701) 490-05-69',
                        ],
                        'department_4_email' => [
                            'ru' => 'library@college.edu.kz',
                            'kk' => 'library@college.edu.kz',
                            'en' => 'library@college.edu.kz',
                        ],
                        'department_4_icon_path' => [
                            'ru' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'kk' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'en' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                        ],

                        // Отдел 5: Отдел кадров
                        'department_5_name' => [
                            'ru' => 'Отдел кадров',
                            'kk' => 'Кадр бөлімі',
                            'en' => 'Personnel department',
                        ],
                        'department_5_description' => [
                            'ru' => 'Трудоустройство, вакансии, кадровые вопросы',
                            'kk' => 'Жұмысқа орналасу, бос орындар, кадрлық мәселелер',
                            'en' => 'Employment, vacancies, personnel issues',
                        ],
                        'department_5_phone' => [
                            'ru' => '+7 (701) 490-05-70',
                            'kk' => '+7 (701) 490-05-70',
                            'en' => '+7 (701) 490-05-70',
                        ],
                        'department_5_email' => [
                            'ru' => 'hr@college.edu.kz',
                            'kk' => 'hr@college.edu.kz',
                            'en' => 'hr@college.edu.kz',
                        ],
                        'department_5_icon_path' => [
                            'ru' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'kk' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'en' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        ],

                        // Отдел 6: IT-отдел
                        'department_6_name' => [
                            'ru' => 'IT-отдел',
                            'kk' => 'IT-бөлімі',
                            'en' => 'IT department',
                        ],
                        'department_6_description' => [
                            'ru' => 'Техническая поддержка, компьютеры, интернет',
                            'kk' => 'Техникалық қолдау, компьютерлер, интернет',
                            'en' => 'Technical support, computers, internet',
                        ],
                        'department_6_phone' => [
                            'ru' => '+7 (701) 490-05-71',
                            'kk' => '+7 (701) 490-05-71',
                            'en' => '+7 (701) 490-05-71',
                        ],
                        'department_6_email' => [
                            'ru' => 'it@college.edu.kz',
                            'kk' => 'it@college.edu.kz',
                            'en' => 'it@college.edu.kz',
                        ],
                        'department_6_icon_path' => [
                            'ru' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                            'kk' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                            'en' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                        ],
                    ],
                ],

                // Дополнительные контакты
                [
                    'page_key' => 'phonebook',
                    'section_key' => 'additional_contacts',
                    'title' => 'Дополнительные контакты',
                    'description' => 'Другие важные телефоны и службы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Другие контакты',
                            'kk' => 'Басқа байланыстар',
                            'en' => 'Other contacts',
                        ],
                        'reception_title' => [
                            'ru' => 'Общая приемная',
                            'kk' => 'Жалпы қабылдау',
                            'en' => 'General reception',
                        ],
                        'reception_phone' => [
                            'ru' => '+7 (701) 490-05-00',
                            'kk' => '+7 (701) 490-05-00',
                            'en' => '+7 (701) 490-05-00',
                        ],
                        'security_title' => [
                            'ru' => 'Охрана и безопасность',
                            'kk' => 'Қорғаныс және қауіпсіздік',
                            'en' => 'Security and safety',
                        ],
                        'security_phone' => [
                            'ru' => '+7 (701) 490-05-99',
                            'kk' => '+7 (701) 490-05-99',
                            'en' => '+7 (701) 490-05-99',
                        ],
                        'emergency_title' => [
                            'ru' => 'Экстренная служба',
                            'kk' => 'Шиелі қызмет',
                            'en' => 'Emergency service',
                        ],
                        'emergency_phone' => [
                            'ru' => '+7 (701) 490-05-66',
                            'kk' => '+7 (701) 490-05-66',
                            'en' => '+7 (701) 490-05-66',
                        ],
                        'fax_title' => [
                            'ru' => 'Факс',
                            'kk' => 'Факс',
                            'en' => 'Fax',
                        ],
                        'fax_number' => [
                            'ru' => '+7 (7182) 32-10-20',
                            'kk' => '+7 (7182) 32-10-20',
                            'en' => '+7 (7182) 32-10-20',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'phonebook',
                    'section_key' => 'navigation',
                    'title' => 'Навигация телефонного справочника',
                    'description' => 'Навигационные элементы на странице телефонного справочника',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад к главной',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'print_button' => [
                            'ru' => 'Распечатать справочник',
                            'kk' => 'Анықтамалықты басып шығару',
                            'en' => 'Print directory',
                        ],
                        'save_button' => [
                            'ru' => 'Сохранить контакты',
                            'kk' => 'Байланыстарды сақтау',
                            'en' => 'Save contacts',
                        ],
                        'update_info' => [
                            'ru' => 'Информация актуальна на: ' . date('d.m.Y'),
                            'kk' => 'Ақпарат өзекті болған күн: ' . date('d.m.Y'),
                            'en' => 'Information updated on: ' . date('d.m.Y'),
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
                    Log::info("Создана многоязычная Phonebook секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Phonebook секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Phonebook секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Phonebook были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Phonebook были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных Phonebook секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Телефонный справочник' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Phonebook секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📞 Разделы страницы 'Телефонный справочник':");
                $this->command->info("   👑 Заглавная секция с часами работы");
                $this->command->info("   🏢 6 основных отделов колледжа с описанием");
                $this->command->info("   📱 Дополнительные контакты (приемная, охрана, экстренная служба)");
                $this->command->info("   🧭 Навигационные элементы (печать, сохранение)");
                $this->command->info("   ⚖️ SEO метаданные");
                $this->command->info("\n📱 Контактные номера:");
                $this->command->info("   📞 Директор: +7 (701) 490-05-66");
                $this->command->info("   📞 Учебная часть: +7 (701) 490-05-67");
                $this->command->info("   📞 Бухгалтерия: +7 (701) 490-05-68");
                $this->command->info("   📞 Библиотека: +7 (701) 490-05-69");
                $this->command->info("   📞 Отдел кадров: +7 (701) 490-05-70");
                $this->command->info("   📞 IT-отдел: +7 (701) 490-05-71");
                $this->command->info("   🚨 Экстренная служба: +7 (701) 490-05-66");
            }
            
            \Log::info("Сидинг завершен. Создано секций: {$createdCount}");
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании телефонного справочника: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании телефонного справочника: {$e->getMessage()}");
            throw $e;
        }
    }
}