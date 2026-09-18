<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class TradeUnionPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $pageKey = 'trade-union';
            Log::info('Начинаю сидирование многоязычной страницы профсоюза...');
            $this->command->info("🔄 Начинаем сидинг страницы профсоюза ({$pageKey})");
            
            // Удаляем старые записи для этой страницы
            $deleted = PageSection::where('page_key', $pageKey)->delete();
            Log::info("Удалено старых записей Trade Union: {$deleted}");
            $this->command->info("🗑️ Удалено {$deleted} старых записей для страницы {$pageKey}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => $pageKey,
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы профсоюза',
                    'description' => 'SEO и общие настройки страницы профсоюзной организации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Профсоюзная организация',
                            'kk' => 'Кәсіподақ ұйымы',
                            'en' => 'Trade union organization',
                        ],
                        'meta_title' => [
                            'ru' => 'Профсоюз колледжа | Защита прав сотрудников',
                            'kk' => 'Колледж кәсіподағы | Қызметкерлердің құқықтарын қорғау',
                            'en' => 'College trade union | Protection of employees\' rights',
                        ],
                        'meta_description' => [
                            'ru' => 'Профсоюзная организация колледжа. Защита социально-трудовых прав сотрудников, коллективные переговоры, правовая поддержка.',
                            'kk' => 'Колледждің кәсіподақ ұйымы. Қызметкерлердің әлеуметтік-еңбек құқықтарын қорғау, ұжымдық келіссөздер, құқықтық қолдау.',
                            'en' => 'College trade union organization. Protection of social and labor rights of employees, collective bargaining, legal support.',
                        ],
                    ],
                ],

                // Герой секция - Профсоюз
                [
                    'page_key' => $pageKey,
                    'section_key' => 'hero',
                    'title' => 'Герой секция - Профсоюз',
                    'description' => 'Главный заголовок и подзаголовок страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title_1' => [
                            'ru' => 'Профсоюзная',
                            'kk' => 'Кәсіподақтық',
                            'en' => 'Trade union',
                        ],
                        'main_title_2' => [
                            'ru' => 'организация',
                            'kk' => 'ұйым',
                            'en' => 'organization',
                        ],
                        'subtitle' => [
                            'ru' => 'Защита прав и интересов сотрудников колледжа, развитие социального партнерства',
                            'kk' => 'Колледж қызметкерлерінің құқықтары мен мүдделерін қорғау, әлеуметтік серіктестікті дамыту',
                            'en' => 'Protection of the rights and interests of college employees, development of social partnership',
                        ],
                        'join_button' => [
                            'ru' => 'Вступить в профсоюз',
                            'kk' => 'Кәсіподаққа кіру',
                            'en' => 'Join the trade union',
                        ],
                        'contact_button' => [
                            'ru' => 'Связаться с профкомом',
                            'kk' => 'Кәсіподақ комитетімен байланысу',
                            'en' => 'Contact the trade union committee',
                        ],
                    ],
                ],

                // О профсоюзной организации
                [
                    'page_key' => $pageKey,
                    'section_key' => 'about',
                    'title' => 'О профсоюзной организации',
                    'description' => 'Описание профсоюзной организации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'О профсоюзной организации',
                            'kk' => 'Кәсіподақ ұйымы туралы',
                            'en' => 'About the trade union organization',
                        ],
                        'description_1' => [
                            'ru' => 'Профсоюзная организация колледжа является добровольным общественным объединением работников, созданным для представительства и защиты их социально-трудовых прав и интересов.',
                            'kk' => 'Колледждің кәсіподақ ұйымы қызметкерлердің әлеуметтік-еңбек құқықтары мен мүдделерін өкілдік ету және қорғау үшін құрылған ерікті қоғамдық бірлестік болып табылады.',
                            'en' => 'The college trade union organization is a voluntary public association of employees created to represent and protect their social and labor rights and interests.',
                        ],
                        'description_2' => [
                            'ru' => 'Основные задачи профсоюза включают ведение коллективных переговоров, заключение коллективных договоров, контроль за соблюдением трудового законодательства, участие в урегулировании коллективных трудовых споров.',
                            'kk' => 'Кәсіподақтың негізгі міндеттеріне ұжымдық келіссөздер жүргізу, ұжымдық шарттарды жасасу, еңбек заңнамасын сақтауды бақылау, ұжымдық еңбек дауларын реттеуге қатысу жатады.',
                            'en' => 'The main tasks of the trade union include conducting collective bargaining, concluding collective agreements, monitoring compliance with labor legislation, participating in the settlement of collective labor disputes.',
                        ],
                        'mission_title' => [
                            'ru' => 'Наша миссия',
                            'kk' => 'Біздің миссиямыз',
                            'en' => 'Our mission',
                        ],
                        'mission_text' => [
                            'ru' => 'Создание условий для достойного труда, социальной защищенности и профессионального развития сотрудников колледжа.',
                            'kk' => 'Колледж қызметкерлерінің лайықты еңбек жағдайларын, әлеуметтік қорғалғандығын және кәсіби дамуын қамтамасыз ету.',
                            'en' => 'Creating conditions for decent work, social security and professional development of college employees.',
                        ],
                    ],
                ],

                // Направления деятельности
                [
                    'page_key' => $pageKey,
                    'section_key' => 'activities',
                    'title' => 'Направления деятельности',
                    'description' => 'Список основных направлений работы профсоюза',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'section_title' => [
                            'ru' => 'Деятельность',
                            'kk' => 'Қызмет',
                            'en' => 'Activities',
                        ],
                        'section_subtitle' => [
                            'ru' => 'Основные направления работы профсоюзной организации',
                            'kk' => 'Кәсіподақ ұйымының негізгі жұмыс бағыттары',
                            'en' => 'Main directions of work of the trade union organization',
                        ],
                        
                        // Направление 1: Правовая служба
                        'item_1_title' => [
                            'ru' => 'Правовая служба',
                            'kk' => 'Құқықтық қызмет',
                            'en' => 'Legal service',
                        ],
                        'item_1_description' => [
                            'ru' => 'Юридическая консультация и защита трудовых прав',
                            'kk' => 'Заңдық кеңес және еңбек құқықтарын қорғау',
                            'en' => 'Legal advice and protection of labor rights',
                        ],
                        'item_1_icon' => [
                            'ru' => 'fas fa-balance-scale',
                            'kk' => 'fas fa-balance-scale',
                            'en' => 'fas fa-balance-scale',
                        ],
                        'item_1_route' => [
                            'ru' => 'normative-documents',
                            'kk' => 'normative-documents',
                            'en' => 'normative-documents',
                        ],
                        'item_1_is_external' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        
                        // Направление 2: Охрана труда
                        'item_2_title' => [
                            'ru' => 'Охрана труда',
                            'kk' => 'Еңбек қорғау',
                            'en' => 'Labor protection',
                        ],
                        'item_2_description' => [
                            'ru' => 'Контроль за условиями труда и безопасностью',
                            'kk' => 'Еңбек жағдайлары мен қауіпсіздігін бақылау',
                            'en' => 'Monitoring of working conditions and safety',
                        ],
                        'item_2_icon' => [
                            'ru' => 'fas fa-shield-alt',
                            'kk' => 'fas fa-shield-alt',
                            'en' => 'fas fa-shield-alt',
                        ],
                        'item_2_route' => [
                            'ru' => 'labor-protection',
                            'kk' => 'labor-protection',
                            'en' => 'labor-protection',
                        ],
                        'item_2_is_external' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        
                        // Направление 3: Профсоюзное обучение
                        'item_3_title' => [
                            'ru' => 'Профсоюзное обучение',
                            'kk' => 'Кәсіподақтық оқыту',
                            'en' => 'Trade union training',
                        ],
                        'item_3_description' => [
                            'ru' => 'Повышение квалификации профсоюзных активистов',
                            'kk' => 'Кәсіподақ белсенділерінің біліктілігін арттыру',
                            'en' => 'Professional development of trade union activists',
                        ],
                        'item_3_icon' => [
                            'ru' => 'fas fa-graduation-cap',
                            'kk' => 'fas fa-graduation-cap',
                            'en' => 'fas fa-graduation-cap',
                        ],
                        'item_3_route' => [
                            'ru' => 'union-education',
                            'kk' => 'union-education',
                            'en' => 'union-education',
                        ],
                        'item_3_is_external' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        
                        // Направление 4: Информация о деятельности
                        'item_4_title' => [
                            'ru' => 'Информация о деятельности',
                            'kk' => 'Қызмет туралы ақпарат',
                            'en' => 'Information about activities',
                        ],
                        'item_4_description' => [
                            'ru' => 'Отчеты и новости о работе профсоюза',
                            'kk' => 'Кәсіподақ жұмысы туралы есептер мен жаңалықтар',
                            'en' => 'Reports and news about the work of the trade union',
                        ],
                        'item_4_icon' => [
                            'ru' => 'fas fa-chart-line',
                            'kk' => 'fas fa-chart-line',
                            'en' => 'fas fa-chart-line',
                        ],
                        'item_4_route' => [
                            'ru' => 'https://edu-kasipodaq-pvl.kz/',
                            'kk' => 'https://edu-kasipodaq-pvl.kz/',
                            'en' => 'https://edu-kasipodaq-pvl.kz/',
                        ],
                        'item_4_is_external' => [
                            'ru' => '1',
                            'kk' => '1',
                            'en' => '1',
                        ],
                    ],
                ],

                // Как вступить в профсоюз
                [
                    'page_key' => $pageKey,
                    'section_key' => 'join_info',
                    'title' => 'Как вступить в профсоюз',
                    'description' => 'Информация о вступлении в профсоюз',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Как вступить в профсоюз?',
                            'kk' => 'Кәсіподаққа қалай кіруге болады?',
                            'en' => 'How to join the trade union?',
                        ],
                        'description' => [
                            'ru' => 'Для вступления в профсоюзную организацию необходимо подать заявление в профсоюзный комитет. Членство в профсоюзе дает право на юридическую защиту, социальную поддержку и участие в коллективных переговорах.',
                            'kk' => 'Кәсіподақ ұйымына кіру үшін кәсіподақ комитетіне өтініш беру қажет. Кәсіподақ мүшелігі заңдық қорғауға, әлеуметтік қолдауға және ұжумдық келіссөздерге қатысуға құқық береді.',
                            'en' => 'To join the trade union organization, you must submit an application to the trade union committee. Trade union membership gives the right to legal protection, social support and participation in collective bargaining.',
                        ],
                        'steps_title' => [
                            'ru' => 'Шаги для вступления',
                            'kk' => 'Кіру қадамдары',
                            'en' => 'Steps to join',
                        ],
                        'step_1' => [
                            'ru' => 'Написать заявление по установленной форме',
                            'kk' => 'Белгіленген нысан бойынша өтініш жазу',
                            'en' => 'Write an application in the established form',
                        ],
                        'step_2' => [
                            'ru' => 'Предоставить копию паспорта и ИИН',
                            'kk' => 'Туралық куәлік пен ЖСН көшірмелерін ұсыну',
                            'en' => 'Provide copies of passport and IIN',
                        ],
                        'step_3' => [
                            'ru' => 'Оплатить вступительный взнос',
                            'kk' => 'Кіру жарнасын төлеу',
                            'en' => 'Pay the entrance fee',
                        ],
                        'step_4' => [
                            'ru' => 'Получить профсоюзный билет',
                            'kk' => 'Кәсіподақ билетін алу',
                            'en' => 'Receive a trade union card',
                        ],
                        'contact_info' => [
                            'ru' => 'Обращайтесь в кабинет 205 (главный корпус)',
                            'kk' => '205-кабинетке (негізгі корпус) хабарласыңыз',
                            'en' => 'Contact office 205 (main building)',
                        ],
                        'contact_phone' => [
                            'ru' => 'Тел.: +7 (701) 490-05-80',
                            'kk' => 'Тел.: +7 (701) 490-05-80',
                            'en' => 'Phone: +7 (701) 490-05-80',
                        ],
                        'contact_email' => [
                            'ru' => 'Email: trade-union@college.edu.kz',
                            'kk' => 'Email: trade-union@college.edu.kz',
                            'en' => 'Email: trade-union@college.edu.kz',
                        ],
                    ],
                ],

                // Профсоюзный комитет
                [
                    'page_key' => $pageKey,
                    'section_key' => 'committee',
                    'title' => 'Профсоюзный комитет',
                    'description' => 'Информация о составе профсоюзного комитета',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Профсоюзный комитет',
                            'kk' => 'Кәсіподақ комитеті',
                            'en' => 'Trade union committee',
                        ],
                        'subtitle' => [
                            'ru' => 'Руководящий орган профсоюзной организации',
                            'kk' => 'Кәсіподақ ұйымының басқару органы',
                            'en' => 'Governing body of the trade union organization',
                        ],
                        'chairman_title' => [
                            'ru' => 'Председатель',
                            'kk' => 'Төраға',
                            'en' => 'Chairman',
                        ],
                        'vice_chairman_title' => [
                            'ru' => 'Заместитель председателя',
                            'kk' => 'Төрағаның орынбасары',
                            'en' => 'Deputy chairman',
                        ],
                        'secretary_title' => [
                            'ru' => 'Секретарь',
                            'kk' => 'Хатшы',
                            'en' => 'Secretary',
                        ],
                        'members_title' => [
                            'ru' => 'Члены комитета',
                            'kk' => 'Комитет мүшелері',
                            'en' => 'Committee members',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => $pageKey,
                    'section_key' => 'navigation',
                    'title' => 'Навигация профсоюза',
                    'description' => 'Навигационные элементы на странице профсоюза',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад к главной',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'documents_button' => [
                            'ru' => 'Документы профсоюза',
                            'kk' => 'Кәсіподақ құжаттары',
                            'en' => 'Trade union documents',
                        ],
                        'news_button' => [
                            'ru' => 'Новости профсоюза',
                            'kk' => 'Кәсіподақ жаңалықтары',
                            'en' => 'Trade union news',
                        ],
                        'meetings_button' => [
                            'ru' => 'Заседания профкома',
                            'kk' => 'Кәсіподақ комитетінің отырыстары',
                            'en' => 'Trade union committee meetings',
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
                    Log::info("Создана многоязычная Trade Union секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания Trade Union секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания Trade Union секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Trade Union были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Trade Union были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных Trade Union секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Профсоюз' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные Trade Union секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🤝 Разделы страницы 'Профсоюз':");
                $this->command->info("   👑 Герой-секция с заголовками и кнопками");
                $this->command->info("   ℹ️ Информация о профсоюзной организации");
                $this->command->info("   🎯 4 направлений деятельности профсоюза");
                $this->command->info("   📝 Информация о вступлении в профсоюз (4 шага)");
                $this->command->info("   👥 Структура профсоюзного комитета");
                $this->command->info("   🧭 Навигационные элементы");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
            Log::info("TradeUnionPageSeeder: Успешно создано {$createdCount} секций для страницы {$pageKey}");
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании страницы профсоюза: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании страницы профсоюза: {$e->getMessage()}");
            throw $e;
        }
    }
}