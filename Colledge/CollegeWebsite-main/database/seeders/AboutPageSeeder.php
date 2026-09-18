<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы О колледже...');
            
            $deleted = PageSection::where('page_key', 'about')->delete();
            Log::info("Удалено старых записей About: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'about',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы О колледже',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'О колледже',
                            'kk' => 'Колледж туралы',
                            'en' => 'About the College',
                        ],
                        'meta_title' => [
                            'ru' => 'О колледже | Технический колледж современных технологий',
                            'kk' => 'Колледж туралы | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'About the College | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'История, миссия, ценности и достижения Технического колледжа современных технологий. 45 лет подготовки специалистов в IT и телекоммуникациях.',
                            'kk' => 'Заманауи технологиялардың техникалық колледжінің тарихы, миссиясы, құндылықтары және жетістіктері. 45 жыл бойы IT және телекоммуникация саласында мамандар даярлау.',
                            'en' => 'History, mission, values and achievements of the Technical College of Modern Technologies. 45 years of training specialists in IT and telecommunications.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'about',
                    'section_key' => 'hero',
                    'title' => 'Главная герой-секция',
                    'description' => 'Верхний баннер с заголовком и лентой миссии, цели, видения',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => '45 лет создаём',
                            'kk' => '45 жыл бойы құрамыз',
                            'en' => '45 years creating',
                        ],
                        'subtitle' => [
                            'ru' => 'будущее технологий',
                            'kk' => 'технологиялардың болашағы',
                            'en' => 'the future of technology',
                        ],
                        'mission_title' => [
                            'ru' => 'МИССИЯ',
                            'kk' => 'МИССИЯ',
                            'en' => 'MISSION',
                        ],
                        'mission_text' => [
                            'ru' => 'Осуществление качественной образовательной деятельности, способствующей профессиональному и социальному становлению личности обучающихся в области железнодорожного транспорта, телекоммуникаций и информационных технологий.',
                            'kk' => 'Теміржол көлігі, телекоммуникация және ақпараттық технологиялар саласында оқушылардың кәсіби және әлеуметтік қалыптасуына ықпал ететін сапалы білім беру қызметін жүзеге асыру.',
                            'en' => 'Implementation of high-quality educational activities that contribute to the professional and social development of students in the field of railway transport, telecommunications and information technology.',
                        ],
                        'goal_title' => [
                            'ru' => 'ЦЕЛЬ',
                            'kk' => 'МАҚСАТ',
                            'en' => 'GOAL',
                        ],
                        'goal_text' => [
                            'ru' => 'Создание модели учебного заведения, осуществляющего ступенчатую подготовку специалистов по уровням: начальное профессиональное образование, среднее профессиональное образование, начальное высшее образование для железнодорожной отрасли, телекоммуникаций и IT-сферы.',
                            'kk' => 'Теміржол саласы, телекоммуникация және IT саласы үшін бастапқы кәсіби білім, орта кәсіби білім, бастапқы жоғары білім деңгейлері бойынша сатылап мамандар даярлайтын оқу орны үлгісін құру.',
                            'en' => 'Creating a model of an educational institution that provides step-by-step training of specialists at the levels: initial vocational education, secondary vocational education, initial higher education for the railway industry, telecommunications and IT sphere.',
                        ],
                        'vision_title' => [
                            'ru' => 'ВИДЕНИЕ',
                            'kk' => 'БОЛАШАҚ БЕЙНЕСІ',
                            'en' => 'VISION',
                        ],
                        'vision_text' => [
                            'ru' => 'Эффективная подготовка специалистов через модернизацию обучения, развитие инновационной деятельности, производственной практики, партнёрства и поддержку профориентации и креативного потенциала студентов в ключевых технологических направлениях.',
                            'kk' => 'Негізгі технологиялық бағыттарда оқытуды жаңғырту, инновациялық қызметті дамыту, өндірістік тәжірибе, серіктестік және кәсіптік бағдар беру мен студенттердің шығармашылық әлеуетін қолдау арқылы мамандарды тиімді даярлау.',
                            'en' => 'Effective training of specialists through modernization of education, development of innovative activities, industrial practice, partnership and support of vocational guidance and creative potential of students in key technological areas.',
                        ],
                        'scroll_down' => [
                            'ru' => 'Прокрутите вниз',
                            'kk' => 'Төменге айналдырыңыз',
                            'en' => 'Scroll down',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
                    'section_key' => 'stats_top',
                    'title' => 'Верхняя статистика',
                    'description' => 'Цифры и показатели в герое',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'stat_1_value' => [
                            'ru' => '45',
                            'kk' => '45',
                            'en' => '45',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Лет опыта',
                            'kk' => 'Жыл тәжірибе',
                            'en' => 'Years of experience',
                        ],
                        'stat_1_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'stat_2_value' => [
                            'ru' => '956',
                            'kk' => '956',
                            'en' => '956',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Студентов',
                            'kk' => 'Студент',
                            'en' => 'Students',
                        ],
                        'stat_2_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'stat_3_value' => [
                            'ru' => '100',
                            'kk' => '100',
                            'en' => '100',
                        ],
                        'stat_3_label' => [
                            'ru' => 'Трудоустройство и занятость',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'stat_3_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        
                        'stat_4_value' => [
                            'ru' => '71',
                            'kk' => '71',
                            'en' => '71',
                        ],
                        'stat_4_label' => [
                            'ru' => 'Преподаватель',
                            'kk' => 'Оқытушы',
                            'en' => 'Teachers',
                        ],
                        'stat_4_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
                    'section_key' => 'description',
                    'title' => 'Описание колледжа',
                    'description' => 'Раздел с описанием и фактами о колледже',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Колледж современных технологий',
                            'kk' => 'Заманауи технологиялар колледжі',
                            'en' => 'College of Modern Technologies',
                        ],
                        'paragraph_1' => [
                            'ru' => 'Основанный в 1981 году, наш колледж прошёл путь от профессионально-технического училища до ведущего образовательного учреждения в сфере информационных технологий.',
                            'kk' => '1981 жылы құрылған біздің колледж кәсіптік-техникалық училищеден ақпараттық технологиялар саласындағы жетекші білім беру мекемесіне дейінгі жолды өтті.',
                            'en' => 'Founded in 1981, our college has evolved from a vocational school to a leading educational institution in the field of information technology.',
                        ],
                        'paragraph_2' => [
                            'ru' => 'Сегодня мы предлагаем современные образовательные программы, сочетающие фундаментальные знания с практическими навыками, востребованными на рынке труда.',
                            'kk' => 'Бүгінде біз нарықта сұранысқа ие практикалық дағдылармен біріктірілген негізгі білімдерді қамтитын заманауи білім беру бағдарламаларын ұсынамыз.',
                            'en' => 'Today we offer modern educational programs that combine fundamental knowledge with practical skills in demand in the labor market.',
                        ],
                        'paragraph_3' => [
                            'ru' => 'Наша миссия — подготовка высококвалифицированных специалистов, способных решать сложные технологические задачи и вносить вклад в цифровую трансформацию общества.',
                            'kk' => 'Біздің миссиямыз – күрделі технологиялық мәселелерді шеше алатын және қоғамның цифрлық трансформациясына үлес қоса алатын жоғары білікті мамандарды даярлау.',
                            'en' => 'Our mission is to train highly qualified specialists capable of solving complex technological problems and contributing to the digital transformation of society.',
                        ],
                        
                        'fact_1_value' => [
                            'ru' => '9',
                            'kk' => '9',
                            'en' => '9',
                        ],
                        'fact_1_label' => [
                            'ru' => 'Специальностей',
                            'kk' => 'Мамандық',
                            'en' => 'Specialties',
                        ],
                        'fact_1_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'fact_2_value' => [
                            'ru' => '25',
                            'kk' => '25',
                            'en' => '25',
                        ],
                        'fact_2_label' => [
                            'ru' => 'Лабораторий',
                            'kk' => 'Зертхана',
                            'en' => 'Laboratories',
                        ],
                        'fact_2_suffix' => [
                            'ru' => '+',
                            'kk' => '+',
                            'en' => '+',
                        ],
                        
                        'fact_3_value' => [
                            'ru' => '95',
                            'kk' => '95',
                            'en' => '95',
                        ],
                        'fact_3_label' => [
                            'ru' => 'Выпускников',
                            'kk' => 'Түлек',
                            'en' => 'Graduates',
                        ],
                        'fact_3_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        
                        'fact_4_value' => [
                            'ru' => '200',
                            'kk' => '200',
                            'en' => '200',
                        ],
                        'fact_4_label' => [
                            'ru' => 'Компьютеров',
                            'kk' => 'Компьютер',
                            'en' => 'Computers',
                        ],
                        'fact_4_suffix' => [
                            'ru' => '+',
                            'kk' => '+',
                            'en' => '+',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
                    'section_key' => 'history_header',
                    'title' => 'Заголовок истории',
                    'description' => 'Заголовок раздела истории',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Наша история',
                            'kk' => 'Біздің тарихымыз',
                            'en' => 'Our History',
                        ],
                        'description' => [
                            'ru' => 'От скромного начала до лидера в техническом и профессиональном, послесреднем образовании',
                            'kk' => 'Қарапайым бастаудан техникалық және кәсіптік, орта білімнен кейінгі білім берудегі көшбасшыға дейін',
                            'en' => 'From humble beginnings to a leader in technical and vocational, post-secondary education',
                        ],
                        'empty_message' => [
                            'ru' => 'Исторические события скоро появятся...',
                            'kk' => 'Тарихи оқиғалар жақында пайда болады...',
                            'en' => 'Historical events will appear soon...',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
                    'section_key' => 'values',
                    'title' => 'Ценности колледжа',
                    'description' => 'Карточки с ценностями колледжа',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Наши ценности',
                            'kk' => 'Біздің құндылықтарымыз',
                            'en' => 'Our Values',
                        ],
                        'description' => [
                            'ru' => 'Принципы, которыми мы руководствуемся каждый день',
                            'kk' => 'Біз күн сайын ұстанатын қағидаттар',
                            'en' => 'Principles we follow every day',
                        ],
                        
                        'value_1_title' => [
                            'ru' => 'Качество образования',
                            'kk' => 'Білім беру сапасы',
                            'en' => 'Education Quality',
                        ],
                        'value_1_description' => [
                            'ru' => 'Актуальные программы обучения, соответствующие мировым стандартам и требованиям индустрии',
                            'kk' => 'Әлемдік стандарттарға және индустрия талаптарына сәйкес келетін өзекті оқу бағдарламалары',
                            'en' => 'Relevant training programs that meet international standards and industry requirements',
                        ],
                        'value_1_icon' => [
                            'ru' => 'book',
                            'kk' => 'book',
                            'en' => 'book',
                        ],
                        
                        'value_2_title' => [
                            'ru' => 'Индивидуальный подход',
                            'kk' => 'Жеке тұлғаға деген көзқарас',
                            'en' => 'Individual Approach',
                        ],
                        'value_2_description' => [
                            'ru' => 'Персональное внимание к каждому студенту, развитие уникальных талантов и способностей',
                            'kk' => 'Әрбір студентке жеке көңіл бөлу, бірегей таланттар мен қабілеттерді дамыту',
                            'en' => 'Personal attention to each student, development of unique talents and abilities',
                        ],
                        'value_2_icon' => [
                            'ru' => 'users',
                            'kk' => 'users',
                            'en' => 'users',
                        ],
                        
                        'value_3_title' => [
                            'ru' => 'Практика и опыт',
                            'kk' => 'Тәжірибе және тәжірибе',
                            'en' => 'Practice and Experience',
                        ],
                        'value_3_description' => [
                            'ru' => 'Реальные проекты, стажировки в крупных компаниях и работа с современными технологиями',
                            'kk' => 'Нақты жобалар, ірі компаниялардағы стажировка және заманауи технологиялармен жұмыс',
                            'en' => 'Real projects, internships in large companies and work with modern technologies',
                        ],
                        'value_3_icon' => [
                            'ru' => 'briefcase',
                            'kk' => 'briefcase',
                            'en' => 'briefcase',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
                    'section_key' => 'stats_bottom',
                    'title' => 'Нижняя статистика',
                    'description' => 'Впечатляющие результаты внизу страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Впечатляющие результаты',
                            'kk' => 'Таңғажайып нәтижелер',
                            'en' => 'Impressive Results',
                        ],
                        'description' => [
                            'ru' => 'Цифры, которые говорят сами за себя',
                            'kk' => 'Өздері сөйлейтін сандар',
                            'en' => 'Numbers that speak for themselves',
                        ],
                        
                        'stat_1_value' => [
                            'ru' => '15000',
                            'kk' => '15000',
                            'en' => '15000',
                        ],
                        'stat_1_label' => [
                            'ru' => 'Выпускников за все время',
                            'kk' => 'Барлық уақыттағы түлектер',
                            'en' => 'Graduates overall',
                        ],
                        'stat_1_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                        
                        'stat_2_value' => [
                            'ru' => '100',
                            'kk' => '100',
                            'en' => '100',
                        ],
                        'stat_2_label' => [
                            'ru' => 'Трудоустройство и занятость',
                            'kk' => 'Жұмыспен қамту',
                            'en' => 'Employment',
                        ],
                        'stat_2_suffix' => [
                            'ru' => '%',
                            'kk' => '%',
                            'en' => '%',
                        ],
                        
                        'stat_3_value' => [
                            'ru' => '200',
                            'kk' => '200',
                            'en' => '200',
                        ],
                        'stat_3_label' => [
                            'ru' => 'Компаний-партнёров',
                            'kk' => 'Серіктес компаниялар',
                            'en' => 'Partner companies',
                        ],
                        'stat_3_suffix' => [
                            'ru' => '+',
                            'kk' => '+',
                            'en' => '+',
                        ],
                        
                        'stat_4_value' => [
                            'ru' => '9',
                            'kk' => '9',
                            'en' => '9',
                        ],
                        'stat_4_label' => [
                            'ru' => 'Специальностей',
                            'kk' => 'Мамандық',
                            'en' => 'Specialties',
                        ],
                        'stat_4_suffix' => [
                            'ru' => '',
                            'kk' => '',
                            'en' => '',
                        ],
                    ],
                ],

                [
                    'page_key' => 'about',
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
                        'scroll_down' => [
                            'ru' => 'Прокрутите вниз',
                            'kk' => 'Төменге айналдырыңыз',
                            'en' => 'Scroll down',
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
                    Log::info("Создана многоязычная About секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций About: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'О колледже' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🏫 Разделы страницы 'О колледже':");
                $this->command->info("   👑 Герой-секция с миссией и видением");
                $this->command->info("   📊 Верхняя статистика (4 показателя)");
                $this->command->info("   🏛️ Описание колледжа и факты");
                $this->command->info("   📜 Заголовок раздела истории");
                $this->command->info("   💎 Ценности колледжа (3 карточки)");
                $this->command->info("   📈 Нижняя статистика достижений");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}