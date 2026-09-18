<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class CollaborationsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Партнёрства...');
            
            // Удаляем старые записи
            $deleted = PageSection::where('page_key', 'collaborations')->delete();
            Log::info("Удалено старых записей Collaborations: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Партнёрства',
                            'kk' => 'Серіктестік',
                            'en' => 'Collaborations',
                        ],
                        'meta_title' => [
                            'ru' => 'Партнёрства | Колледж современных технологий',
                            'kk' => 'Серіктестік | Заманауи технологиялар колледжі',
                            'en' => 'Collaborations | College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Стратегические партнёрства колледжа с ведущими компаниями. Совместные проекты, дуальное обучение и практика.',
                            'kk' => 'Колледждің жетекші компаниялармен стратегиялық серіктестіктері. Бірлескен жобалар, дуалды оқыту және тәжірибе.',
                            'en' => 'Strategic partnerships of the college with leading companies. Joint projects, dual education and practice.',
                        ],
                    ],
                ],
                
                // HERO SECTION
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'hero',
                    'title' => 'Главная секция партнёрств',
                    'description' => 'Герой-секция с заголовком и статистикой',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'badge_text' => [
                            'ru' => 'Партнёрские отношения',
                            'kk' => 'Серіктестік қарым-қатынас',
                            'en' => 'Partnerships',
                        ],
                        'title_line1' => [
                            'ru' => 'Мост между',
                            'kk' => 'Ортадағы көпір',
                            'en' => 'Bridge between',
                        ],
                        'title_line2' => [
                            'ru' => 'образованием и индустрией',
                            'kk' => 'білім беру мен индустрия',
                            'en' => 'education and industry',
                        ],
                        'description' => [
                            'ru' => 'Создаём экосистему взаимовыгодного сотрудничества, где студенты получают практический опыт, а компании — доступ к талантливым специалистам',
                            'kk' => 'Студенттер практикалық тәжірибе алатын, ал компаниялар дарынды мамандарға қол жетімділікке ие болатын өзара тиімді ынтымақтастық экожүйесін құрамыз',
                            'en' => 'Creating an ecosystem of mutually beneficial cooperation where students gain practical experience and companies get access to talented specialists',
                        ],
                        'button_text' => [
                            'ru' => 'Смотреть партнёров',
                            'kk' => 'Серіктестерді қарау',
                            'en' => 'View partners',
                        ],
                        'stat_1_value' => [
                            'ru' => '200',
                            'kk' => '200',
                            'en' => '200',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Компаний-партнёров',
                            'kk' => 'Серіктес компаниялар',
                            'en' => 'Partner companies',
                        ],
                        'stat_2_value' => [
                            'ru' => '85',
                            'kk' => '85',
                            'en' => '85',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Трудоустройство',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'stat_2_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        'feature_1_text' => [
                            'ru' => 'Дуальное обучение',
                            'kk' => 'Дуалды оқыту',
                            'en' => 'Dual education',
                        ],
                        'feature_1_number' => [
                            'ru' => '50+ программ',
                            'kk' => '50+ бағдарлама',
                            'en' => '50+ programs',
                        ],
                        'feature_2_text' => [
                            'ru' => 'Совместные проекты',
                            'kk' => 'Бірлескен жобалар',
                            'en' => 'Joint projects',
                        ],
                        'feature_2_number' => [
                            'ru' => '150+ реализовано',
                            'kk' => '150+ іске асырылды',
                            'en' => '150+ implemented',
                        ],
                        'scroll_text' => [
                            'ru' => 'Исследуйте партнёрства',
                            'kk' => 'Серіктестіктерді зерттеңіз',
                            'en' => 'Explore partnerships',
                        ],
                    ],
                ],
                
                // PARTNERS HEADER
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'partners_header',
                    'title' => 'Заголовок раздела партнёров',
                    'description' => 'Раздел с партнёрскими организациями',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'badge_text' => [
                            'ru' => 'Партнёрские организации',
                            'kk' => 'Серіктестік ұйымдар',
                            'en' => 'Partner organizations',
                        ],
                        'title' => [
                            'ru' => 'Наши стратегические партнёры',
                            'kk' => 'Біздің стратегиялық серіктестеріміз',
                            'en' => 'Our strategic partners',
                        ],
                        'description' => [
                            'ru' => 'Мы сотрудничаем с лидерами индустрии, чтобы обеспечить наших студентов доступом к современным технологиям и практическому опыту',
                            'kk' => 'Біз студенттерімізге заманауи технологияларға және практикалық тәжірибеге қол жетімділікті қамтамасыз ету үшін индустрия көшбасшыларымен ынтымақтасамыз',
                            'en' => 'We collaborate with industry leaders to provide our students with access to modern technologies and practical experience',
                        ],
                    ],
                ],
                
                // PARTNERS LIST (8 партнёров)
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'partners_list',
                    'title' => 'Список партнёров',
                    'description' => 'Карточки партнёрских организаций',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'partner_1_name' => [
                            'ru' => 'Технологическая компания 1',
                            'kk' => 'Технологиялық компания 1',
                            'en' => 'Technology Company 1',
                        ],
                        'partner_1_category' => [
                            'ru' => 'Технологическая компания',
                            'kk' => 'Технологиялық компания',
                            'en' => 'Technology Company',
                        ],
                        'partner_1_logo' => [
                            'ru' => '/storage/partners/partner1.png',
                            'kk' => '/storage/partners/partner1.png',
                            'en' => '/storage/partners/partner1.png',
                        ],
                        
                        'partner_2_name' => [
                            'ru' => 'ИТ-консалтинг',
                            'kk' => 'Ақпараттық технологиялар кеңесі',
                            'en' => 'IT Consulting',
                        ],
                        'partner_2_category' => [
                            'ru' => 'ИТ-консалтинг',
                            'kk' => 'Ақпараттық технологиялар кеңесі',
                            'en' => 'IT Consulting',
                        ],
                        'partner_2_logo' => [
                            'ru' => '/storage/partners/partner2.png',
                            'kk' => '/storage/partners/partner2.png',
                            'en' => '/storage/partners/partner2.png',
                        ],
                        
                        'partner_3_name' => [
                            'ru' => 'Финтех компания',
                            'kk' => 'Финтех компаниясы',
                            'en' => 'FinTech Company',
                        ],
                        'partner_3_category' => [
                            'ru' => 'Финтех',
                            'kk' => 'Финтех',
                            'en' => 'FinTech',
                        ],
                        'partner_3_logo' => [
                            'ru' => '/storage/partners/partner3.png',
                            'kk' => '/storage/partners/partner3.png',
                            'en' => '/storage/partners/partner3.png',
                        ],
                        
                        'partner_4_name' => [
                            'ru' => 'Телеком оператор',
                            'kk' => 'Телеком операторы',
                            'en' => 'Telecom Operator',
                        ],
                        'partner_4_category' => [
                            'ru' => 'Телекоммуникации',
                            'kk' => 'Телекоммуникация',
                            'en' => 'Telecommunications',
                        ],
                        'partner_4_logo' => [
                            'ru' => '/storage/partners/partner4.png',
                            'kk' => '/storage/partners/partner4.png',
                            'en' => '/storage/partners/partner4.png',
                        ],
                        
                        'partner_5_name' => [
                            'ru' => 'Кибербезопасность',
                            'kk' => 'Киберқауіпсіздік',
                            'en' => 'Cybersecurity',
                        ],
                        'partner_5_category' => [
                            'ru' => 'Кибербезопасность',
                            'kk' => 'Киберқауіпсіздік',
                            'en' => 'Cybersecurity',
                        ],
                        'partner_5_logo' => [
                            'ru' => '/storage/partners/partner5.png',
                            'kk' => '/storage/partners/partner5.png',
                            'en' => '/storage/partners/partner5.png',
                        ],
                        
                        'partner_6_name' => [
                            'ru' => 'Образовательные технологии',
                            'kk' => 'Білім беру технологиялары',
                            'en' => 'Educational Technologies',
                        ],
                        'partner_6_category' => [
                            'ru' => 'Образовательные технологии',
                            'kk' => 'Білім беру технологиялары',
                            'en' => 'Educational Technologies',
                        ],
                        'partner_6_logo' => [
                            'ru' => '/storage/partners/partner6.png',
                            'kk' => '/storage/partners/partner6.png',
                            'en' => '/storage/partners/partner6.png',
                        ],
                        
                        'partner_7_name' => [
                            'ru' => 'Разработка ПО',
                            'kk' => 'Багаждарлық қамтамасыз етуді әзірлеу',
                            'en' => 'Software Development',
                        ],
                        'partner_7_category' => [
                            'ru' => 'Разработка ПО',
                            'kk' => 'Багаждарлық қамтамасыз етуді әзірлеу',
                            'en' => 'Software Development',
                        ],
                        'partner_7_logo' => [
                            'ru' => '/storage/partners/partner7.png',
                            'kk' => '/storage/partners/partner7.png',
                            'en' => '/storage/partners/partner7.png',
                        ],
                        
                        'partner_8_name' => [
                            'ru' => 'Искусственный интеллект',
                            'kk' => 'Жасанды интеллект',
                            'en' => 'Artificial Intelligence',
                        ],
                        'partner_8_category' => [
                            'ru' => 'Искусственный интеллект',
                            'kk' => 'Жасанды интеллект',
                            'en' => 'Artificial Intelligence',
                        ],
                        'partner_8_logo' => [
                            'ru' => '/storage/partners/partner8.png',
                            'kk' => '/storage/partners/partner8.png',
                            'en' => '/storage/partners/partner8.png',
                        ],
                    ],
                ],
                
                // PROJECTS HEADER
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'projects_header',
                    'title' => 'Заголовок раздела проектов',
                    'description' => 'Раздел с совместными проектами',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'badge_text' => [
                            'ru' => 'Совместные проекты',
                            'kk' => 'Бірлескен жобалар',
                            'en' => 'Joint projects',
                        ],
                        'title' => [
                            'ru' => 'Реализованные проекты с партнёрами',
                            'kk' => 'Серіктестермен іске асырылған жобалар',
                            'en' => 'Projects implemented with partners',
                        ],
                        'main_title' => [
                            'ru' => 'Реализованные проекты с партнёрами',
                            'kk' => 'Серіктестермен іске асырылған жобалар',
                            'en' => 'Projects implemented with partners',
                        ],
                        'stats_title' => [
                            'ru' => 'Завершённых проектов',
                            'kk' => 'Аяқталған жобалар',
                            'en' => 'Completed projects',
                        ],
                        'stats_subtitle' => [
                            'ru' => 'в 2024 году',
                            'kk' => '2024 жылы',
                            'en' => 'in 2024',
                        ],
                        'stats_web_label' => [
                            'ru' => 'Веб-разработка',
                            'kk' => 'Веб-әзірлеу',
                            'en' => 'Web Development',
                        ],
                        'stats_web_value' => [
                            'ru' => '24 проекта',
                            'kk' => '24 жоба',
                            'en' => '24 projects',
                        ],
                        'stats_mobile_label' => [
                            'ru' => 'Мобильные приложения',
                            'kk' => 'Мобильді қосымшалар',
                            'en' => 'Mobile Applications',
                        ],
                        'stats_mobile_value' => [
                            'ru' => '18 проектов',
                            'kk' => '18 жоба',
                            'en' => '18 projects',
                        ],
                        'stats_data_label' => [
                            'ru' => 'Data Science',
                            'kk' => 'Data Science',
                            'en' => 'Data Science',
                        ],
                        'stats_data_value' => [
                            'ru' => '8 проектов',
                            'kk' => '8 жоба',
                            'en' => '8 projects',
                        ],
                    ],
                ],
                
                // PROJECTS LIST
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'projects_list',
                    'title' => 'Список проектов',
                    'description' => 'Примеры реализованных проектов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'project_1_title' => [
                            'ru' => 'Разработка CRM-системы',
                            'kk' => 'CRM-жүйесін әзірлеу',
                            'en' => 'CRM System Development',
                        ],
                        'project_1_description' => [
                            'ru' => 'Совместный проект с ведущей IT-компанией по созданию системы управления клиентами',
                            'kk' => 'Тұтынушыларды басқару жүйесін құру бойынша жетекші IT-компаниямен бірлескен жоба',
                            'en' => 'Joint project with a leading IT company to create a customer management system',
                        ],
                        
                        'project_2_title' => [
                            'ru' => 'Умный кампус',
                            'kk' => 'Ақылды кампус',
                            'en' => 'Smart Campus',
                        ],
                        'project_2_description' => [
                            'ru' => 'Внедрение IoT-решений для автоматизации процессов в учебном заведении',
                            'kk' => 'Оқу орнындағы процестерді автоматтандыру үшін IoT шешімдерін енгізу',
                            'en' => 'Implementation of IoT solutions for process automation in an educational institution',
                        ],
                        
                        'project_3_title' => [
                            'ru' => 'Система кибербезопасности',
                            'kk' => 'Киберқауіпсіздік жүйесі',
                            'en' => 'Cybersecurity System',
                        ],
                        'project_3_description' => [
                            'ru' => 'Разработка и внедрение комплексной системы защиты данных',
                            'kk' => 'Деректерді қорғау жүйесін әзірлеу және енгізу',
                            'en' => 'Development and implementation of a comprehensive data protection system',
                        ],
                    ],
                ],
                
                // DUAL EDUCATION HEADER
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'dual_education_header',
                    'title' => 'Заголовок дуального обучения',
                    'description' => 'Раздел дуального образования',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'badge_text' => [
                            'ru' => 'Дуальное обучение и практика',
                            'kk' => 'Дуалды оқыту және тәжірибе',
                            'en' => 'Dual education and practice',
                        ],
                        'title' => [
                            'ru' => 'Обучение на рабочем месте',
                            'kk' => 'Жұмыс орнында оқыту',
                            'en' => 'Workplace training',
                        ],
                        'description' => [
                            'ru' => 'Сочетание теоретического обучения в колледже с практической работой на предприятиях-партнёрах',
                            'kk' => 'Колледждегі теориялық оқытуды серіктес кәсіпорындардағы практикалық жұмыспен біріктіру',
                            'en' => 'Combining theoretical training at college with practical work at partner enterprises',
                        ],
                        'stats_title' => [
                            'ru' => 'Статистика дуального обучения',
                            'kk' => 'Дуалды оқыту статистикасы',
                            'en' => 'Dual education statistics',
                        ],
                        'stats_description' => [
                            'ru' => 'Наши студенты проходят практику в ведущих компаниях страны и получают ценный опыт работы',
                            'kk' => 'Біздің студенттер елдің жетекші компанияларында тәжірибеден өтіп, бағалы жұмыс тәжірибесін алады',
                            'en' => 'Our students undergo internships at leading companies in the country and gain valuable work experience',
                        ],
                        'stat_1_value' => [
                            'ru' => '1200',
                            'kk' => '1200',
                            'en' => '1200',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Студентов на дуальном обучении',
                            'kk' => 'Дуалды оқытудағы студент',
                            'en' => 'Students in dual education',
                        ],
                        'stat_1_suffix' => [
                            'ru' => '+',
                            'kk' => '+',
                            'en' => '+',
                        ],
                        'stat_2_value' => [
                            'ru' => '85',
                            'kk' => '85',
                            'en' => '85',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Успешное трудоустройство',
                            'kk' => 'Сәтті жұмыспен қамту',
                            'en' => 'Successful employment',
                        ],
                        'stat_2_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                    ],
                ],
                
                // DUAL EDUCATION CARDS
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'dual_cards',
                    'title' => 'Карточки дуального обучения',
                    'description' => 'Преимущества дуального образования',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'card_1_title' => [
                            'ru' => 'Теория + Практика',
                            'kk' => 'Теория + Тәжірибе',
                            'en' => 'Theory + Practice',
                        ],
                        'card_1_description' => [
                            'ru' => '40% времени - обучение в колледже, 60% - практика на предприятии под руководством опытных наставников',
                            'kk' => '40% уақыт - колледжде оқу, 60% - тәжірибелі наставниктердің жетекшілігімен кәсіпорында тәжірибе',
                            'en' => '40% of time - study at college, 60% - practice at the enterprise under the guidance of experienced mentors',
                        ],
                        
                        'card_2_title' => [
                            'ru' => 'Наставничество',
                            'kk' => 'Наставниктік',
                            'en' => 'Mentoring',
                        ],
                        'card_2_description' => [
                            'ru' => 'Каждый студент получает персонального наставника от предприятия-партнёра',
                            'kk' => 'Әрбір студент серіктес кәсіпорыннан жеке наставник алады',
                            'en' => 'Each student receives a personal mentor from the partner enterprise',
                        ],
                        
                        'card_3_title' => [
                            'ru' => 'Трудоустройство',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'card_3_description' => [
                            'ru' => '90% выпускников программ дуального обучения трудоустраиваются сразу после окончания',
                            'kk' => 'Дуалды оқыту бағдарламаларының түлектерінің 90% бітіргеннен кейін бірден жұмыспен қамтылады',
                            'en' => '90% of dual education program graduates get employed immediately after graduation',
                        ],
                    ],
                ],
                
                // PROJECTS STATISTICS
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'projects_stats',
                    'title' => 'Статистика проектов',
                    'description' => 'Процентное распределение проектов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'web_progress' => [
                            'ru' => '80',
                            'kk' => '80',
                            'en' => '80',
                        ],
                        'web_label' => [
                            'ru' => 'Веб-разработка',
                            'kk' => 'Веб-әзірлеу',
                            'en' => 'Web Development',
                        ],
                        'mobile_progress' => [
                            'ru' => '65',
                            'kk' => '65',
                            'en' => '65',
                        ],
                        'mobile_label' => [
                            'ru' => 'Мобильные приложения',
                            'kk' => 'Мобильді қосымшалар',
                            'en' => 'Mobile Apps',
                        ],
                        'data_progress' => [
                            'ru' => '30',
                            'kk' => '30',
                            'en' => '30',
                        ],
                        'data_label' => [
                            'ru' => 'Data Science',
                            'kk' => 'Data Science',
                            'en' => 'Data Science',
                        ],
                        'progress_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'collaborations',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
                        ],
                        'view_button' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'Learn more',
                        ],
                        'contact_button' => [
                            'ru' => 'Стать партнёром',
                            'kk' => 'Серіктес болу',
                            'en' => 'Become a partner',
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
                    Log::info("Создана многоязычная Collaborations секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Collaborations: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Партнёрства' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🤝 Разделы страницы 'Партнёрства':");
                $this->command->info("   🔍 SEO метаданные");
                $this->command->info("   👑 Герой-секция с основным заголовком");
                $this->command->info("   🏢 Заголовок раздела партнёров");
                $this->command->info("   📊 Список партнёров (8 компаний)");
                $this->command->info("   🏆 Заголовок раздела проектов");
                $this->command->info("   📋 Список реализованных проектов");
                $this->command->info("   🎓 Заголовок дуального обучения");
                $this->command->info("   📝 Карточки дуального обучения");
                $this->command->info("   📈 Статистика проектов (проценты)");
                $this->command->info("   🧭 Навигационные кнопки");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}