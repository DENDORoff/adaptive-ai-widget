<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование текстовых контентов для ситуационного центра...');
            
            $deleted = PageSection::where('page_key', 'dashboard')->delete();
            Log::info("Удалено старых записей Dashboard: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы ситуационного центра',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'СИТУАЦИОННЫЙ ЦЕНТР VKEIK COLLEGE',
                            'kk' => 'VKEIK COLLEGE СИТУАЦИЯЛЫҚ ОРТАЛЫҒЫ',
                            'en' => 'VKEIK COLLEGE SITUATIONAL CENTER',
                        ],
                        'meta_title' => [
                            'ru' => 'СИТУАЦИОННЫЙ ЦЕНТР VKEIK COLLEGE',
                            'kk' => 'VKEIK COLLEGE СИТУАЦИЯЛЫҚ ОРТАЛЫҒЫ',
                            'en' => 'VKEIK COLLEGE SITUATIONAL CENTER',
                        ],
                        'meta_description' => [
                            'ru' => 'Панель мониторинга и аналитики колледжа VKEIK. Академическая, идеологическая, административная деятельность и IT-кластер в реальном времени.',
                            'kk' => 'VKEIK колледжінің мониторинг және аналитика панелі. Академиялық, идеологиялық, әкімшілік қызмет және IT-кластер нақты уақыт режимінде.',
                            'en' => 'VKEIK College monitoring and analytics dashboard. Academic, ideological, administrative activities and IT cluster in real time.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'header',
                    'title' => 'Заголовок хедера',
                    'description' => 'Название ситуационного центра в хедере',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'СИТУАЦИОННЫЙ ЦЕНТР',
                            'kk' => 'СИТУАЦИЯЛЫҚ ОРТАЛЫҚ',
                            'en' => 'SITUATIONAL CENTER',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'tabs',
                    'title' => 'Вкладки навигации',
                    'description' => 'Названия вкладок на панели',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'academic' => [
                            'ru' => 'АКАДЕМИЧЕСКАЯ ДЕЯТЕЛЬНОСТЬ',
                            'kk' => 'АКАДЕМИЯЛЫҚ ҚЫЗМЕТ',
                            'en' => 'ACADEMIC ACTIVITIES',
                        ],
                        'ideology' => [
                            'ru' => 'ИДЕОЛОГИЧЕСКАЯ ДЕЯТЕЛЬНОСТЬ',
                            'kk' => 'ИДЕОЛОГИЯЛЫҚ ҚЫЗМЕТ',
                            'en' => 'IDEOLOGICAL ACTIVITIES',
                        ],
                        'admin' => [
                            'ru' => 'АДМИНИСТРАТИВНАЯ ДЕЯТЕЛЬНОСТЬ',
                            'kk' => 'ӘКІМШІЛІК ҚЫЗМЕТ',
                            'en' => 'ADMINISTRATIVE ACTIVITIES',
                        ],
                        'it_cluster' => [
                            'ru' => 'IT CLUSTER',
                            'kk' => 'IT КЛАСТЕРІ',
                            'en' => 'IT CLUSTER',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'academic',
                    'title' => 'Академическая деятельность',
                    'description' => 'Текстовые описания для академической деятельности',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'contingent_title' => [
                            'ru' => 'Контингент (ГЗ / ЦГЗ / платно)',
                            'kk' => 'Контингент (ГЗ / ЦГЗ / ақылы)',
                            'en' => 'Contingent (State Order / Paid Order / Paid)',
                        ],
                        'admission_title' => [
                            'ru' => 'Новый прием (ГЗ / ЦГЗ / платно)',
                            'kk' => 'Жаңа қабылдау (ГЗ / ЦГЗ / ақылы)',
                            'en' => 'New Admission (State Order / Paid Order / Paid)',
                        ],
                        'departments_title' => [
                            'ru' => 'Студенты по отделениям и уровням',
                            'kk' => 'Бөлімшелер бойынша студенттер және деңгейлер',
                            'en' => 'Students by Departments and Levels',
                        ],
                        'employment_title' => [
                            'ru' => 'Трудоустройство выпускников',
                            'kk' => 'Түлектерді жұмыспен қамту',
                            'en' => 'Graduates Employment',
                        ],
                        'ipr_title' => [
                            'ru' => 'Качественный состав ИПР',
                            'kk' => 'МҰҚ құрамының сапалық құрамы',
                            'en' => 'Teaching Staff Quality Composition',
                        ],
                        'contests_title' => [
                            'ru' => 'Конкурсы профмастерства',
                            'kk' => 'Кәсіби шеберлік байқаулары',
                            'en' => 'Professional Skills Competitions',
                        ],
                        
                        'gz_label' => [
                            'ru' => 'ГЗ',
                            'kk' => 'ГЗ',
                            'en' => 'SO',
                        ],
                        'gz_cgz_label' => [
                            'ru' => 'ГЗ+ЦГЗ',
                            'kk' => 'ГЗ+ЦГЗ',
                            'en' => 'SO+PO',
                        ],
                        'cgz_label' => [
                            'ru' => 'ЦГЗ',
                            'kk' => 'ЦГЗ',
                            'en' => 'PO',
                        ],
                        'paid_label' => [
                            'ru' => 'Платно',
                            'kk' => 'Ақылы',
                            'en' => 'Paid',
                        ],
                        
                        'department_op' => [
                            'ru' => 'ОП, АТ и С',
                            'kk' => 'ОП, АТ және С',
                            'en' => 'OP, AT and S',
                        ],
                        'department_vh' => [
                            'ru' => 'ВХ и ПХ, АД',
                            'kk' => 'ВХ және ПХ, АД',
                            'en' => 'VH and PH, AD',
                        ],
                        'department_it' => [
                            'ru' => 'IT-отделение',
                            'kk' => 'IT-бөлімше',
                            'en' => 'IT Department',
                        ],
                        'department_ozo' => [
                            'ru' => 'ОЗО',
                            'kk' => 'ОЗО',
                            'en' => 'OZO',
                        ],
                        
                        'work_qualification_label' => [
                            'ru' => 'Рабочая квалификация',
                            'kk' => 'Жұмыс біліктілігі',
                            'en' => 'Work Qualification',
                        ],
                        'mid_specialist_label' => [
                            'ru' => 'Специалист среднего звена',
                            'kk' => 'Орта буын маманы',
                            'en' => 'Middle-Level Specialist',
                        ],
                        'applied_bachelor_label' => [
                            'ru' => 'Прикладной бакалавр',
                            'kk' => 'Қолданбалы бакалавр',
                            'en' => 'Applied Bachelor',
                        ],
                        
                        'students_label' => [
                            'ru' => 'обучающихся',
                            'kk' => 'оқушы',
                            'en' => 'students',
                        ],
                        
                        'gold_label' => [
                            'ru' => 'Золото',
                            'kk' => 'Алтын',
                            'en' => 'Gold',
                        ],
                        'silver_label' => [
                            'ru' => 'Серебро',
                            'kk' => 'Күміс',
                            'en' => 'Silver',
                        ],
                        'bronze_label' => [
                            'ru' => 'Бронза',
                            'kk' => 'Қола',
                            'en' => 'Bronze',
                        ],
                        'medallions_label' => [
                            'ru' => 'Медальоны',
                            'kk' => 'Медальондар',
                            'en' => 'Medallions',
                        ],
                        
                        'employed_label' => [
                            'ru' => 'Трудоустроены',
                            'kk' => 'Жұмыспен қамтылған',
                            'en' => 'Employed',
                        ],
                        'studying_label' => [
                            'ru' => 'Учёба / декрет / армия',
                            'kk' => 'Оқу / декрет / әскери қызмет',
                            'en' => 'Studying / Maternity / Military',
                        ],
                        'unemployed_label' => [
                            'ru' => 'Не трудоустроены',
                            'kk' => 'Жұмыспен қамтылмаған',
                            'en' => 'Unemployed',
                        ],
                        
                        'total_ipr_label' => [
                            'ru' => 'Всего ИПР:',
                            'kk' => 'Барлығы МҰҚ:',
                            'en' => 'Total Teaching Staff:',
                        ],
                        
                        'researcher_label' => [
                            'ru' => 'Педагог-исследователь',
                            'kk' => 'Педагог-зерттеуші',
                            'en' => 'Teacher-Researcher',
                        ],
                        'expert_label' => [
                            'ru' => 'Педагог-эксперт',
                            'kk' => 'Педагог-сарапшы',
                            'en' => 'Teacher-Expert',
                        ],
                        'moderator_label' => [
                            'ru' => 'Педагог-модератор',
                            'kk' => 'Педагог-модератор',
                            'en' => 'Teacher-Moderator',
                        ],
                        
                        'dual_learning_label' => [
                            'ru' => 'Охват дуальным обучением от ГЗ',
                            'kk' => 'ГЗ бойынша дуалды оқытумен қамтылу',
                            'en' => 'Dual Learning Coverage from State Order',
                        ],
                        'teachers_training_label' => [
                            'ru' => 'Количество преподавателей, прошедших повышение квалификации',
                            'kk' => 'Біліктілігін арттырған оқытушылар саны',
                            'en' => 'Number of Teachers Who Completed Advanced Training',
                        ],
                        'labs_label' => [
                            'ru' => 'Количество учебных кабинетов и лабораторий',
                            'kk' => 'Оқу кабинеттері мен зертханалар саны',
                            'en' => 'Number of Classrooms and Laboratories',
                        ],
                        'foreign_teachers_label' => [
                            'ru' => 'Преподаватели, владеющие иностранными языками',
                            'kk' => 'Шетел тілдерін білетін оқытушылар',
                            'en' => 'Teachers Proficient in Foreign Languages',
                        ],
                        
                        'specialties_label' => [
                            'ru' => 'Специальности',
                            'kk' => 'Мамандықтар',
                            'en' => 'Specialties',
                        ],
                        'distance_learning_label' => [
                            'ru' => 'Поступившие на дистанционное обучение',
                            'kk' => 'Қашықтықтан оқуға түскендер',
                            'en' => 'Enrolled in Distance Learning',
                        ],
                        'foreign_students_label' => [
                            'ru' => 'Обучающиеся иностранные граждане',
                            'kk' => 'Шетелдік азаматтар оқиды',
                            'en' => 'Foreign Students Studying',
                        ],
                        'honors_diplomas_label' => [
                            'ru' => 'Окончившие колледж с дипломом с отличием',
                            'kk' => 'Колледжді артықшылықпен бітіргендер',
                            'en' => 'College Graduates with Honors Diploma',
                        ],
                        
                        'contingent_label' => [
                            'ru' => 'Контингент',
                            'kk' => 'Контингент',
                            'en' => 'Contingent',
                        ],
                        'admission_label' => [
                            'ru' => 'Новый прием',
                            'kk' => 'Жаңа қабылдау',
                            'en' => 'New Admission',
                        ],
                        
                        'specialties_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'distance_learning_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'foreign_students_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'honors_diplomas_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'work_qualification_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'mid_specialist_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'applied_bachelor_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'gold_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'silver_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'bronze_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'medallions_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'dual_learning_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'teachers_training_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'labs_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'foreign_teachers_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'total_ipr_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'ideology',
                    'title' => 'Идеологическая деятельность',
                    'description' => 'Текстовые описания для идеологической деятельности',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'social_title' => [
                            'ru' => 'Количество подписчиков в соцсетях колледжа',
                            'kk' => 'Колледждің әлеуметтік желілердегі жазылушылар саны',
                            'en' => 'Number of Followers in College Social Networks',
                        ],
                        'social_distribution_title' => [
                            'ru' => 'Распределение подписчиков по соцсетям',
                            'kk' => 'Әлеуметтік желілер бойынша жазылушылардың таралуы',
                            'en' => 'Distribution of Followers by Social Networks',
                        ],
                        'portal_title' => [
                            'ru' => 'Посещения сайта',
                            'kk' => 'Сайтқа кірулер',
                            'en' => 'Website Visits',
                        ],
                        
                        'telegram_label' => [
                            'ru' => 'TELEGRAM',
                            'kk' => 'TELEGRAM',
                            'en' => 'TELEGRAM',
                        ],
                        'instagram_label' => [
                            'ru' => 'Instagram',
                            'kk' => 'Instagram',
                            'en' => 'Instagram',
                        ],
                        'youtube_label' => [
                            'ru' => 'YOUTUBE',
                            'kk' => 'YOUTUBE',
                            'en' => 'YOUTUBE',
                        ],
                        
                        'month_visitors_label' => [
                            'ru' => 'За месяц',
                            'kk' => 'Айына',
                            'en' => 'Per Month',
                        ],
                        'views_label' => [
                            'ru' => 'Просмотры',
                            'kk' => 'Қаралымдар',
                            'en' => 'Views',
                        ],
                        'today_visits_label' => [
                            'ru' => 'За сегодня',
                            'kk' => 'Бүгін',
                            'en' => 'Today',
                        ],
                        
                        'visitors_label' => [
                            'ru' => 'посетителей',
                            'kk' => 'қонақ',
                            'en' => 'visitors',
                        ],
                        'per_month_label' => [
                            'ru' => 'за месяц',
                            'kk' => 'айына',
                            'en' => 'per month',
                        ],
                        
                        'sports_sections_label' => [
                            'ru' => 'Спортивные секции колледжа',
                            'kk' => 'Колледждің спорттық секциялары',
                            'en' => 'College Sports Sections',
                        ],
                        'sports_students_label' => [
                            'ru' => 'Студенты в спортивных секциях',
                            'kk' => 'Спорттық секциялардағы студенттер',
                            'en' => 'Students in Sports Sections',
                        ],
                        'winners_label' => [
                            'ru' => 'Призеры городских, областных и республиканских соревнований и спортивных олимпиад среди студентов',
                            'kk' => 'Қалалық, облыстық және республикалық жарыстар мен студенттер арасындағы спорт олимпиадаларының жеңімпаздары',
                            'en' => 'Winners of City, Regional and Republican Competitions and Sports Olympiads Among Students',
                        ],
                        'dormitory_label' => [
                            'ru' => 'Студенты в общежитии колледжа',
                            'kk' => 'Колледж жатақханасындағы студенттер',
                            'en' => 'Students in College Dormitory',
                        ],
                        
                        'telegram_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'instagram_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'youtube_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'month_visitors_value' => [
                            'ru' => '5',
                            'kk' => '5',
                            'en' => '5',
                        ],
                        'views_value' => [
                            'ru' => '9',
                            'kk' => '9',
                            'en' => '9',
                        ],
                        'today_visits_value' => [
                            'ru' => '5',
                            'kk' => '5',
                            'en' => '5',
                        ],
                        'sports_sections_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'sports_students_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'winners_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'dormitory_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'admin',
                    'title' => 'Административная деятельность',
                    'description' => 'Текстовые описания для административной деятельности',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'average_age_label' => [
                            'ru' => 'Средний возраст ИПР',
                            'kk' => 'МҰҚ орташа жасы',
                            'en' => 'Average Age of Teaching Staff',
                        ],
                        'library_label' => [
                            'ru' => 'Фонд электронной библиотеки',
                            'kk' => 'Электронды кітапхана қоры',
                            'en' => 'Electronic Library Fund',
                        ],
                        'portal_visits_label' => [
                            'ru' => 'Посещения сайта за сегодня',
                            'kk' => 'Сайтқа бүгін кірулер',
                            'en' => 'Website Visits Today',
                        ],
                        'cos_appeals_label' => [
                            'ru' => 'Обращений в ЦОС за месяц',
                            'kk' => 'ООО айына шағымдары',
                            'en' => 'Appeals to COS per Month',
                        ],
                        'blog_appeals_label' => [
                            'ru' => 'Обращений в блог руководителя',
                            'kk' => 'Басшы блогына шағымдар',
                            'en' => 'Appeals to Director\'s Blog',
                        ],
                        'teachers_title' => [
                            'ru' => 'Количество педагогов предметных и цикловых комиссий колледжа',
                            'kk' => 'Колледждің пәндік және циклдық комиссияларындағы педагогтар саны',
                            'en' => 'Number of Teachers in Subject and Cyclic Commissions of the College',
                        ],
                        
                        'teachers_transport_label' => [
                            'ru' => 'Транспорт',
                            'kk' => 'Көлік',
                            'en' => 'Transport',
                        ],
                        'teachers_computers_label' => [
                            'ru' => 'Вычислительная техника',
                            'kk' => 'Есептеу техникасы',
                            'en' => 'Computing Technology',
                        ],
                        'teachers_automation_label' => [
                            'ru' => 'Автоматика и связь',
                            'kk' => 'Автоматика және байланыс',
                            'en' => 'Automation and Communication',
                        ],
                        'teachers_sports_label' => [
                            'ru' => 'Физическая культура',
                            'kk' => 'Дене шынықтыру',
                            'en' => 'Physical Education',
                        ],
                        'teachers_general_label' => [
                            'ru' => 'Общеобразовательные',
                            'kk' => 'Жалпы білім беретін',
                            'en' => 'General Education',
                        ],
                        
                        'average_age_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'library_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'portal_visits_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'cos_appeals_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'blog_appeals_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'teachers_transport_value' => [
                            'ru' => '15',
                            'kk' => '15',
                            'en' => '15',
                        ],
                        'teachers_computers_value' => [
                            'ru' => '7',
                            'kk' => '7',
                            'en' => '7',
                        ],
                        'teachers_automation_value' => [
                            'ru' => '17',
                            'kk' => '17',
                            'en' => '17',
                        ],
                        'teachers_sports_value' => [
                            'ru' => '5',
                            'kk' => '5',
                            'en' => '5',
                        ],
                        'teachers_general_value' => [
                            'ru' => '13',
                            'kk' => '13',
                            'en' => '13',
                        ],
                        
                        'teachers_label' => [
                            'ru' => 'Количество педагогов',
                            'kk' => 'Педагогтар саны',
                            'en' => 'Number of Teachers',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'it_cluster',
                    'title' => 'IT Кластер',
                    'description' => 'Текстовые описания для IT кластера',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'digital_resources_title' => [
                            'ru' => 'Электронные учебные ресурсы',
                            'kk' => 'Электронды оқу ресурстары',
                            'en' => 'Electronic Educational Resources',
                        ],
                        'personal_accounts_title' => [
                            'ru' => 'Личные кабинеты',
                            'kk' => 'Жеке кабинеттер',
                            'en' => 'Personal Accounts',
                        ],
                        'building_title' => [
                            'ru' => 'Люди в здании колледжа по данным СКУД',
                            'kk' => 'ҚҚДД деректері бойынша колледж ғимаратындағы адамдар',
                            'en' => 'People in College Building According to ACS Data',
                        ],
                        
                        'video_lectures_label' => [
                            'ru' => 'Видеолекции',
                            'kk' => 'Бейнелекциялар',
                            'en' => 'Video Lectures',
                        ],
                        'educational_publications_label' => [
                            'ru' => 'Учебные издания',
                            'kk' => 'Оқу басылымдары',
                            'en' => 'Educational Publications',
                        ],
                        'mobile_resources_label' => [
                            'ru' => 'Мобильные ресурсы',
                            'kk' => 'Мобильді ресурстар',
                            'en' => 'Mobile Resources',
                        ],
                        
                        'students_label' => [
                            'ru' => 'Студенты',
                            'kk' => 'Студенттер',
                            'en' => 'Students',
                        ],
                        'teachers_label' => [
                            'ru' => 'Преподаватели',
                            'kk' => 'Оқытушылар',
                            'en' => 'Teachers',
                        ],
                        'staff_label' => [
                            'ru' => 'Сотрудники',
                            'kk' => 'Қызметкерлер',
                            'en' => 'Staff',
                        ],
                        
                        'total_active_label' => [
                            'ru' => 'Всего активных',
                            'kk' => 'Барлығы белсенді',
                            'en' => 'Total Active',
                        ],
                        'total_in_building_label' => [
                            'ru' => 'Всего в здании:',
                            'kk' => 'Ғимаратта барлығы:',
                            'en' => 'Total in Building:',
                        ],
                        
                        'growth_label' => [
                            'ru' => '+0% за месяц',
                            'kk' => '+0% айына',
                            'en' => '+0% per month',
                        ],
                        'coverage_label' => [
                            'ru' => '0% покрытие',
                            'kk' => '0% қамту',
                            'en' => '0% coverage',
                        ],
                        
                        'modern_it_label' => [
                            'ru' => 'Доля современной IT-техники',
                            'kk' => 'Заманауи IT-техникасының үлесі',
                            'en' => 'Share of Modern IT Equipment',
                        ],
                        'pc_label' => [
                            'ru' => 'ПК в учебном процессе',
                            'kk' => 'Оқу үдерісіндегі ДК',
                            'en' => 'PCs in Educational Process',
                        ],
                        'computer_classes_label' => [
                            'ru' => 'Компьютерные классы',
                            'kk' => 'Компьютерлік сыныптар',
                            'en' => 'Computer Classes',
                        ],
                        'wifi_points_label' => [
                            'ru' => 'WiFi точки',
                            'kk' => 'WiFi нүктелері',
                            'en' => 'WiFi Points',
                        ],
                        'internet_speed_label' => [
                            'ru' => 'Скорость интернета',
                            'kk' => 'Интернет жылдамдығы',
                            'en' => 'Internet Speed',
                        ],
                        
                        'percent_label' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        'gbit_label' => [
                            'ru' => 'Gbit/s',
                            'kk' => 'Gbit/s',
                            'en' => 'Gbit/s',
                        ],
                        
                        'video_lectures_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'educational_publications_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'mobile_resources_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'students_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'teachers_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'total_active_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'total_in_building_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'building_students_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'building_teachers_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'building_staff_value' => [
                            'ru' => '0',
                            'kk' => '0',
                            'en' => '0',
                        ],
                        'modern_it_value' => [
                            'ru' => '70',
                            'kk' => '70',
                            'en' => '70',
                        ],
                        'pc_value' => [
                            'ru' => '265',
                            'kk' => '265',
                            'en' => '265',
                        ],
                        'computer_classes_value' => [
                            'ru' => '19',
                            'kk' => '19',
                            'en' => '19',
                        ],
                        'wifi_points_value' => [
                            'ru' => '73',
                            'kk' => '73',
                            'en' => '73',
                        ],
                        'internet_speed_value' => [
                            'ru' => '1',
                            'kk' => '1',
                            'en' => '1',
                        ],
                        
                        'digital_resources_label' => [
                            'ru' => 'Электронные ресурсы',
                            'kk' => 'Электронды ресурстар',
                            'en' => 'Digital Resources',
                        ],
                        'personal_accounts_label' => [
                            'ru' => 'Личные кабинеты',
                            'kk' => 'Жеке кабинеттер',
                            'en' => 'Personal Accounts',
                        ],
                        'building_people_label' => [
                            'ru' => 'Люди в здании',
                            'kk' => 'Ғимараттағы адамдар',
                            'en' => 'People in Building',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'weather',
                    'title' => 'Погода',
                    'description' => 'Температура погоды в футере',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'temperature' => [
                            'ru' => '-7°C',
                            'kk' => '-7°C',
                            'en' => '-7°C',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'charts',
                    'title' => 'Графики и легенды',
                    'description' => 'Текстовые метки для графиков и их легенд',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'contingent_chart_label' => [
                            'ru' => 'Контингент',
                            'kk' => 'Контингент',
                            'en' => 'Contingent',
                        ],
                        'admission_chart_label' => [
                            'ru' => 'Новый прием',
                            'kk' => 'Жаңа қабылдау',
                            'en' => 'New Admission',
                        ],
                        'employment_chart_label' => [
                            'ru' => 'Трудоустройство',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'ipr_chart_label' => [
                            'ru' => 'Состав ИПР',
                            'kk' => 'МҰҚ құрамы',
                            'en' => 'Teaching Staff Composition',
                        ],
                        'departments_chart_label' => [
                            'ru' => 'Студенты по отделениям',
                            'kk' => 'Бөлімшелер бойынша студенттер',
                            'en' => 'Students by Departments',
                        ],
                        'social_chart_label' => [
                            'ru' => 'Соцсети',
                            'kk' => 'Әлеуметтік желілер',
                            'en' => 'Social Networks',
                        ],
                        'portal_chart_label' => [
                            'ru' => 'Посещения сайта',
                            'kk' => 'Сайтқа кірулер',
                            'en' => 'Website Visits',
                        ],
                        'resources_chart_label' => [
                            'ru' => 'Электронные ресурсы',
                            'kk' => 'Электронды ресурстар',
                            'en' => 'Digital Resources',
                        ],
                        'building_chart_label' => [
                            'ru' => 'Люди в здании',
                            'kk' => 'Ғимараттағы адамдар',
                            'en' => 'People in Building',
                        ],
                        'teachers_chart_label' => [
                            'ru' => 'Педагоги',
                            'kk' => 'Педагогтар',
                            'en' => 'Teachers',
                        ],
                        
                        'gz_cgz_legend' => [
                            'ru' => 'ГЗ+ЦГЗ',
                            'kk' => 'ГЗ+ЦГЗ',
                            'en' => 'SO+PO',
                        ],
                        'paid_legend' => [
                            'ru' => 'Платно',
                            'kk' => 'Ақылы',
                            'en' => 'Paid',
                        ],
                        'telegram_legend' => [
                            'ru' => 'TELEGRAM',
                            'kk' => 'TELEGRAM',
                            'en' => 'TELEGRAM',
                        ],
                        'instagram_legend' => [
                            'ru' => 'Instagram',
                            'kk' => 'Instagram',
                            'en' => 'Instagram',
                        ],
                        'youtube_legend' => [
                            'ru' => 'YOUTUBE',
                            'kk' => 'YOUTUBE',
                            'en' => 'YOUTUBE',
                        ],
                        'video_lectures_legend' => [
                            'ru' => 'Видеолекции',
                            'kk' => 'Бейнелекциялар',
                            'en' => 'Video Lectures',
                        ],
                        'educational_publications_legend' => [
                            'ru' => 'Учебные издания',
                            'kk' => 'Оқу басылымдары',
                            'en' => 'Educational Publications',
                        ],
                        'mobile_legend' => [
                            'ru' => 'Мобильные',
                            'kk' => 'Мобильді',
                            'en' => 'Mobile',
                        ],
                        'students_legend' => [
                            'ru' => 'Студенты',
                            'kk' => 'Студенттер',
                            'en' => 'Students',
                        ],
                        'teachers_legend' => [
                            'ru' => 'Преподаватели',
                            'kk' => 'Оқытушылар',
                            'en' => 'Teachers',
                        ],
                        'staff_legend' => [
                            'ru' => 'Сотрудники',
                            'kk' => 'Қызметкерлер',
                            'en' => 'Staff',
                        ],
                        'work_qualification_legend' => [
                            'ru' => 'Рабочая квалификация',
                            'kk' => 'Жұмыс біліктілігі',
                            'en' => 'Work Qualification',
                        ],
                        'mid_specialist_legend' => [
                            'ru' => 'Специалист среднего звена',
                            'kk' => 'Орта буын маманы',
                            'en' => 'Middle-Level Specialist',
                        ],
                        'applied_bachelor_legend' => [
                            'ru' => 'Прикладной бакалавр',
                            'kk' => 'Қолданбалы бакалавр',
                            'en' => 'Applied Bachelor',
                        ],
                        'researcher_legend' => [
                            'ru' => 'Педагог-исследователь',
                            'kk' => 'Педагог-зерттеуші',
                            'en' => 'Teacher-Researcher',
                        ],
                        'expert_legend' => [
                            'ru' => 'Педагог-эксперт',
                            'kk' => 'Педагог-сарапшы',
                            'en' => 'Teacher-Expert',
                        ],
                        'moderator_legend' => [
                            'ru' => 'Педагог-модератор',
                            'kk' => 'Педагог-модератор',
                            'en' => 'Teacher-Moderator',
                        ],
                        'employed_legend' => [
                            'ru' => 'Трудоустроены',
                            'kk' => 'Жұмыспен қамтылған',
                            'en' => 'Employed',
                        ],
                        'studying_legend' => [
                            'ru' => 'Учёба / декрет / армия',
                            'kk' => 'Оқу / декрет / әскери қызмет',
                            'en' => 'Studying / Maternity / Military',
                        ],
                        'unemployed_legend' => [
                            'ru' => 'Не трудоустроены',
                            'kk' => 'Жұмыспен қамтылмаған',
                            'en' => 'Unemployed',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'months',
                    'title' => 'Месяцы',
                    'description' => 'Названия месяцев для графиков',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'january' => [
                            'ru' => 'Январь',
                            'kk' => 'Қаңтар',
                            'en' => 'January',
                        ],
                        'february' => [
                            'ru' => 'Февраль',
                            'kk' => 'Ақпан',
                            'en' => 'February',
                        ],
                        'march' => [
                            'ru' => 'Март',
                            'kk' => 'Наурыз',
                            'en' => 'March',
                        ],
                        'april' => [
                            'ru' => 'Апрель',
                            'kk' => 'Сәуір',
                            'en' => 'April',
                        ],
                        'may' => [
                            'ru' => 'Май',
                            'kk' => 'Мамыр',
                            'en' => 'May',
                        ],
                        'june' => [
                            'ru' => 'Июнь',
                            'kk' => 'Маусым',
                            'en' => 'June',
                        ],
                        'july' => [
                            'ru' => 'Июль',
                            'kk' => 'Шілде',
                            'en' => 'July',
                        ],
                        'august' => [
                            'ru' => 'Август',
                            'kk' => 'Тамыз',
                            'en' => 'August',
                        ],
                        'september' => [
                            'ru' => 'Сентябрь',
                            'kk' => 'Қыркүйек',
                            'en' => 'September',
                        ],
                        'october' => [
                            'ru' => 'Октябрь',
                            'kk' => 'Қазан',
                            'en' => 'October',
                        ],
                        'november' => [
                            'ru' => 'Ноябрь',
                            'kk' => 'Қараша',
                            'en' => 'November',
                        ],
                        'december' => [
                            'ru' => 'Декабрь',
                            'kk' => 'Желтоқсан',
                            'en' => 'December',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'dashboard',
                    'section_key' => 'chart_tooltips',
                    'title' => 'Переводы тултипов графиков',
                    'description' => 'Переводы для всплывающих подсказок графиков',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'contingent_chart_label' => [
                            'ru' => 'Контингент',
                            'kk' => 'Контингент',
                            'en' => 'Contingent',
                        ],
                        'admission_chart_label' => [
                            'ru' => 'Новый прием',
                            'kk' => 'Жаңа қабылдау',
                            'en' => 'New Admission',
                        ],
                        'employment_chart_label' => [
                            'ru' => 'Трудоустройство',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'ipr_chart_label' => [
                            'ru' => 'Состав ИПР',
                            'kk' => 'МҰҚ құрамы',
                            'en' => 'Teaching Staff Composition',
                        ],
                        'departments_chart_label' => [
                            'ru' => 'Студенты по отделениям',
                            'kk' => 'Бөлімшелер бойынша студенттер',
                            'en' => 'Students by Departments',
                        ],
                        'social_chart_label' => [
                            'ru' => 'Соцсети',
                            'kk' => 'Әлеуметтік желілер',
                            'en' => 'Social Networks',
                        ],
                        'portal_chart_label' => [
                            'ru' => 'Посещения сайта',
                            'kk' => 'Сайтқа кірулер',
                            'en' => 'Website Visits',
                        ],
                        'resources_chart_label' => [
                            'ru' => 'Электронные ресурсы',
                            'kk' => 'Электронды ресурстар',
                            'en' => 'Digital Resources',
                        ],
                        'building_chart_label' => [
                            'ru' => 'Люди в здании',
                            'kk' => 'Ғимараттағы адамдар',
                            'en' => 'People in Building',
                        ],
                        'teachers_chart_label' => [
                            'ru' => 'Педагоги',
                            'kk' => 'Педагогтар',
                            'en' => 'Teachers',
                        ],
                        
                        'gz_cgz_legend' => [
                            'ru' => 'ГЗ+ЦГЗ',
                            'kk' => 'ГЗ+ЦГЗ',
                            'en' => 'SO+PO',
                        ],
                        'paid_legend' => [
                            'ru' => 'Платно',
                            'kk' => 'Ақылы',
                            'en' => 'Paid',
                        ],
                        'telegram_legend' => [
                            'ru' => 'TELEGRAM',
                            'kk' => 'TELEGRAM',
                            'en' => 'TELEGRAM',
                        ],
                        'instagram_legend' => [
                            'ru' => 'Instagram',
                            'kk' => 'Instagram',
                            'en' => 'Instagram',
                        ],
                        'youtube_legend' => [
                            'ru' => 'YOUTUBE',
                            'kk' => 'YOUTUBE',
                            'en' => 'YOUTUBE',
                        ],
                        'video_lectures_legend' => [
                            'ru' => 'Видеолекции',
                            'kk' => 'Бейнелекциялар',
                            'en' => 'Video Lectures',
                        ],
                        'educational_publications_legend' => [
                            'ru' => 'Учебные издания',
                            'kk' => 'Оқу басылымдары',
                            'en' => 'Educational Publications',
                        ],
                        'mobile_legend' => [
                            'ru' => 'Мобильные',
                            'kk' => 'Мобильді',
                            'en' => 'Mobile',
                        ],
                        'students_legend' => [
                            'ru' => 'Студенты',
                            'kk' => 'Студенттер',
                            'en' => 'Students',
                        ],
                        'teachers_legend' => [
                            'ru' => 'Преподаватели',
                            'kk' => 'Оқытушылар',
                            'en' => 'Teachers',
                        ],
                        'staff_legend' => [
                            'ru' => 'Сотрудники',
                            'kk' => 'Қызметкерлер',
                            'en' => 'Staff',
                        ],
                        'work_qualification_legend' => [
                            'ru' => 'Рабочая квалификация',
                            'kk' => 'Жұмыс біліктілігі',
                            'en' => 'Work Qualification',
                        ],
                        'mid_specialist_legend' => [
                            'ru' => 'Специалист среднего звена',
                            'kk' => 'Орта буын маманы',
                            'en' => 'Middle-Level Specialist',
                        ],
                        'applied_bachelor_legend' => [
                            'ru' => 'Прикладной бакалавр',
                            'kk' => 'Қолданбалы бакалавр',
                            'en' => 'Applied Bachelor',
                        ],
                        'researcher_legend' => [
                            'ru' => 'Педагог-исследователь',
                            'kk' => 'Педагог-зерттеуші',
                            'en' => 'Teacher-Researcher',
                        ],
                        'expert_legend' => [
                            'ru' => 'Педагог-эксперт',
                            'kk' => 'Педагог-сарапшы',
                            'en' => 'Teacher-Expert',
                        ],
                        'moderator_legend' => [
                            'ru' => 'Педагог-модератор',
                            'kk' => 'Педагог-модератор',
                            'en' => 'Teacher-Moderator',
                        ],
                        'employed_legend' => [
                            'ru' => 'Трудоустроены',
                            'kk' => 'Жұмыспен қамтылған',
                            'en' => 'Employed',
                        ],
                        'studying_legend' => [
                            'ru' => 'Учёба / декрет / армия',
                            'kk' => 'Оқу / декрет / әскери қызмет',
                            'en' => 'Studying / Maternity / Military',
                        ],
                        'unemployed_legend' => [
                            'ru' => 'Не трудоустроены',
                            'kk' => 'Жұмыспен қамтылмаған',
                            'en' => 'Unemployed',
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
                    Log::info("Создана PageSection секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано PageSection секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Текстовые контенты для 'Ситуационного центра' успешно созданы!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - сортировка {$section['sort_order']}");
                }
                
                $this->command->info("\n🏢 Структура контента:");
                $this->command->info("   📱 Метаданные (SEO, заголовки)");
                $this->command->info("   🎯 Заголовок в хедере");
                $this->command->info("   🗂️ Названия вкладок навигации");
                $this->command->info("   🎓 Академическая деятельность (текстовые метки + значения)");
                $this->command->info("   🤝 Идеологическая деятельность (текстовые метки + значения)");
                $this->command->info("   📝 Административная деятельность (текстовые метки + значения)");
                $this->command->info("   💻 IT Кластер (текстовые метки + значения)");
                $this->command->info("   🌤️ Погода в футере");
                $this->command->info("   📊 Графики и легенды (переводы для графиков)");
                $this->command->info("   📅 Месяцы (для графиков временных рядов)");
                $this->command->info("   💬 Переводы тултипов графиков (всплывающие подсказки)");
                
                $this->command->info("\n📊 Использование в шаблоне:");
                $this->command->info("   • Тексты подставляются через \App\Models\PageSection::getValue()");
                $this->command->info("   • Статистика остается в DashboardStatistic");
                $this->command->info("   • Автоматическое определение языка");
                $this->command->info("   • Поддержка многоязычных переводов для всех элементов интерфейса");
                $this->command->info("   • Поддержка переводов для графиков Chart.js через JavaScript функцию getTranslation()");
                $this->command->info("   • 📈 Переводы тултипов при наведении на графики");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}