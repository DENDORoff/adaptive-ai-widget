<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class FaqPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы FAQ...');
            
            // Удаляем старые записи для страницы FAQ
            $deleted = PageSection::where('page_key', 'faq')->delete();
            Log::info("Удалено старых записей FAQ: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'faq',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы FAQ',
                    'description' => 'SEO и общие настройки страницы часто задаваемых вопросов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Часто задаваемые вопросы',
                            'kk' => 'Жиі қойылатын сұрақтар',
                            'en' => 'Frequently Asked Questions',
                        ],
                        'meta_title' => [
                            'ru' => 'FAQ | Часто задаваемые вопросы - Технический колледж современных технологий',
                            'kk' => 'FAQ | Жиі қойылатын сұрақтар - Заманауи технологиялардың техникалық колледжі',
                            'en' => 'FAQ | Frequently Asked Questions - Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Ответы на часто задаваемые вопросы о поступлении, обучении, стоимости, специальностях и других аспектах учебного процесса в колледже.',
                            'kk' => 'Колледжке түсу, оқу, құны, мамандықтар және оқу процесінің басқа аспектілері туралы жиі қойылатын сұрақтарға жауаптар.',
                            'en' => 'Answers to frequently asked questions about admission, training, cost, specialties and other aspects of the educational process at the college.',
                        ],
                    ],
                ],

                // Заголовок секции FAQ
                [
                    'page_key' => 'faq',
                    'section_key' => 'header',
                    'title' => 'Заголовок секции FAQ',
                    'description' => 'Заголовок и подзаголовок секции часто задаваемых вопросов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'Часто задаваемые вопросы',
                            'kk' => 'Жиі қойылатын сұрақтар',
                            'en' => 'Frequently Asked Questions',
                        ],
                        'subtitle' => [
                            'ru' => 'Ответы на популярные вопросы о колледже, поступлении и обучении',
                            'kk' => 'Колледж, түсу және оқу туралы танымал сұрақтарға жауаптар',
                            'en' => 'Answers to popular questions about the college, admission and training',
                        ],
                    ],
                ],

                // Вопрос 1: Специальности
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_1',
                    'title' => 'FAQ: Специальности в колледже',
                    'description' => 'Вопрос о доступных специальностях',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'Какие специальности доступны в колледже?',
                            'kk' => 'Колледжде қандай мамандықтар бар?',
                            'en' => 'What specialties are available at the college?',
                        ],
                        'item_1' => [
                            'ru' => 'Информационные системы и программирование',
                            'kk' => 'Ақпараттық жүйелер және бағдарламалау',
                            'en' => 'Information systems and programming',
                        ],
                        'item_2' => [
                            'ru' => 'Сетевое и системное администрирование',
                            'kk' => 'Желілік және жүйелік әкімшілік',
                            'en' => 'Network and system administration',
                        ],
                        'item_3' => [
                            'ru' => 'Электроника и телекоммуникации',
                            'kk' => 'Электроника және телекоммуникация',
                            'en' => 'Electronics and telecommunications',
                        ],
                        'item_4' => [
                            'ru' => 'Киберзащита информационных систем',
                            'kk' => 'Ақпараттық жүйелерді киберқорғау',
                            'en' => 'Cybersecurity of information systems',
                        ],
                        'item_5' => [
                            'ru' => 'Разработка мобильных приложений',
                            'kk' => 'Мобильді қосымшаларды әзірлеу',
                            'en' => 'Mobile application development',
                        ],
                    ],
                ],

                // Вопрос 2: Документы для поступления
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_2',
                    'title' => 'FAQ: Документы для поступления',
                    'description' => 'Вопрос о необходимых документах',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Какие документы нужны для поступления?',
                            'kk' => 'Түсу үшін қандай құжаттар қажет?',
                            'en' => 'What documents are required for admission?',
                        ],
                        'item_1' => [
                            'ru' => 'Заявление о приеме (заполняется в колледже)',
                            'kk' => 'Қабылдау туралы өтініш (колледжде толтырылады)',
                            'en' => 'Application for admission (filled out at the college)',
                        ],
                        'item_2' => [
                            'ru' => 'Аттестат об основном общем образовании',
                            'kk' => 'Негізгі жалпы білім туралы аттестат',
                            'en' => 'Certificate of basic general education',
                        ],
                        'item_3' => [
                            'ru' => '6 фотографий 3×4 см',
                            'kk' => '3×4 см өлшемді 6 фотосурет',
                            'en' => '6 photos 3×4 cm',
                        ],
                        'item_4' => [
                            'ru' => 'Копия удостоверения личности',
                            'kk' => 'Жеке куәліктің көшірмесі',
                            'en' => 'Copy of identity card',
                        ],
                        'item_5' => [
                            'ru' => 'Медицинская справка формы 086/у',
                            'kk' => '086/у нысанындағы медициналық анықтама',
                            'en' => 'Medical certificate form 086/у',
                        ],
                        'item_6' => [
                            'ru' => 'Сертификат о прививках (форма 063)',
                            'kk' => 'Емдеу туралы сертификат (063 нысаны)',
                            'en' => 'Vaccination certificate (form 063)',
                        ],
                    ],
                ],

                // Вопрос 3: Стоимость обучения
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_3',
                    'title' => 'FAQ: Стоимость обучения',
                    'description' => 'Вопрос о стоимости обучения',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Какова стоимость обучения?',
                            'kk' => 'Оқу құны қанша?',
                            'en' => 'What is the cost of training?',
                        ],
                        'item_1' => [
                            'ru' => 'Программирование и IT: 350 000 тг/год',
                            'kk' => 'Бағдарламалау және IT: 350 000 тг/жыл',
                            'en' => 'Programming and IT: 350,000 KZT/year',
                        ],
                        'item_2' => [
                            'ru' => 'Электроника: 320 000 тг/год',
                            'kk' => 'Электроника: 320 000 тг/жыл',
                            'en' => 'Electronics: 320,000 KZT/year',
                        ],
                        'item_3' => [
                            'ru' => 'Телекоммуникации: 300 000 тг/год',
                            'kk' => 'Телекоммуникация: 300 000 тг/жыл',
                            'en' => 'Telecommunications: 300,000 KZT/year',
                        ],
                        'additional_info' => [
                            'ru' => 'Также доступно государственное финансирование (грант) для отличников.',
                            'kk' => 'Сондай-ақ үздік оқушылар үшін мемлекеттік қаржыландыру (грант) бар.',
                            'en' => 'State funding (grant) is also available for excellent students.',
                        ],
                    ],
                ],

                // Вопрос 4: Общежитие
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_4',
                    'title' => 'FAQ: Общежитие для студентов',
                    'description' => 'Вопрос об общежитии для иногородних',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Есть ли общежитие для иногородних студентов?',
                            'kk' => 'Басқа қалалардан келген студенттерге жатақхана бар ма?',
                            'en' => 'Is there a dormitory for non-resident students?',
                        ],
                        'intro' => [
                            'ru' => 'Да, наш колледж предоставляет общежитие:',
                            'kk' => 'Ия, біздің колледж жатақхана ұсынады:',
                            'en' => 'Yes, our college provides a dormitory:',
                        ],
                        'item_1' => [
                            'ru' => 'Комнаты на 2-3 человека',
                            'kk' => '2-3 адамға арналған бөлмелер',
                            'en' => 'Rooms for 2-3 people',
                        ],
                        'item_2' => [
                            'ru' => 'Wi-Fi на всей территории',
                            'kk' => 'Барлық аумақ бойынша Wi-Fi',
                            'en' => 'Wi-Fi throughout the territory',
                        ],
                        'item_3' => [
                            'ru' => 'Кухня и столовая',
                            'kk' => 'Ас үй және асхана',
                            'en' => 'Kitchen and dining room',
                        ],
                        'item_4' => [
                            'ru' => 'Прачечная',
                            'kk' => 'Кір жуу бөлмесі',
                            'en' => 'Laundry',
                        ],
                        'item_5' => [
                            'ru' => 'Охрана 24/7',
                            'kk' => 'Қорғаныс 24/7',
                            'en' => 'Security 24/7',
                        ],
                        'price_info' => [
                            'ru' => 'Стоимость: 25 000 тг/месяц',
                            'kk' => 'Құны: 25 000 тг/ай',
                            'en' => 'Cost: 25,000 KZT/month',
                        ],
                    ],
                ],

                // Вопрос 5: Длительность обучения
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_5',
                    'title' => 'FAQ: Длительность обучения',
                    'description' => 'Вопрос о продолжительности обучения',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Сколько длится обучение?',
                            'kk' => 'Оқу қанша уақытқа созылады?',
                            'en' => 'How long does the training last?',
                        ],
                        'item_1' => [
                            'ru' => 'На базе 9 классов: 3 года 10 месяцев',
                            'kk' => '9 сынып негізінде: 3 жыл 10 ай',
                            'en' => 'Based on 9th grade: 3 years 10 months',
                        ],
                        'item_2' => [
                            'ru' => 'На базе 11 классов: 2 года 10 месяцев',
                            'kk' => '11 сынып негізінде: 2 жыл 10 ай',
                            'en' => 'Based on 11th grade: 2 years 10 months',
                        ],
                    ],
                ],

                // Вопрос 6: Помощь с трудоустройством
                [
                    'page_key' => 'faq',
                    'section_key' => 'question_6',
                    'title' => 'FAQ: Помощь с трудоустройством',
                    'description' => 'Вопрос о помощи в трудоустройстве',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'title' => [
                            'ru' => 'Предоставляется ли помощь с трудоустройством?',
                            'kk' => 'Жұмысқа орналасуға көмек көрсетіледі ме?',
                            'en' => 'Is employment assistance provided?',
                        ],
                        'intro' => [
                            'ru' => 'Да, мы предоставляем:',
                            'kk' => 'Ия, біз ұсынамыз:',
                            'en' => 'Yes, we provide:',
                        ],
                        'item_1' => [
                            'ru' => 'Организацию производственной практики',
                            'kk' => 'Өндірістік тәжірибені ұйымдастыру',
                            'en' => 'Organization of industrial practice',
                        ],
                        'item_2' => [
                            'ru' => 'Участие в ярмарках вакансий',
                            'kk' => 'Бос жұмыс орындары көрмелеріне қатысу',
                            'en' => 'Participation in job fairs',
                        ],
                        'item_3' => [
                            'ru' => 'Консультации по составлению резюме',
                            'kk' => 'Резюме құру бойынша консультациялар',
                            'en' => 'Consultations on resume writing',
                        ],
                        'item_4' => [
                            'ru' => 'Тренинги по собеседованиям',
                            'kk' => 'Сұхбаттар бойынша тренингтер',
                            'en' => 'Interview training',
                        ],
                        'item_5' => [
                            'ru' => 'Помощь в поиске стажировок',
                            'kk' => 'Стажировка іздеуге көмек',
                            'en' => 'Assistance in finding internships',
                        ],
                        'statistic' => [
                            'ru' => 'Более 85% выпускников трудоустраиваются в течение 3 месяцев!',
                            'kk' => 'Түлектердің 85% -ы 3 ай ішінде жұмысқа орналасады!',
                            'en' => 'Over 85% of graduates get employed within 3 months!',
                        ],
                    ],
                ],

                // Футер FAQ
                [
                    'page_key' => 'faq',
                    'section_key' => 'footer',
                    'title' => 'Футер FAQ',
                    'description' => 'Текст и кнопка внизу секции FAQ',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'text' => [
                            'ru' => 'Не нашли ответ на свой вопрос?',
                            'kk' => 'Өз сұрағыңызға жауап таба алмадыңыз ба?',
                            'en' => 'Didn\'t find the answer to your question?',
                        ],
                        'button_text' => [
                            'ru' => 'Задать вопрос',
                            'kk' => 'Сұрақ қою',
                            'en' => 'Ask a question',
                        ],
                    ],
                ],

                // Навигация
                [
                    'page_key' => 'faq',
                    'section_key' => 'navigation',
                    'title' => 'Навигация',
                    'description' => 'Навигационные элементы на странице FAQ',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'back_button' => [
                            'ru' => 'Назад на главную',
                            'kk' => 'Басты бетке оралу',
                            'en' => 'Back to main page',
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
                    Log::info("Создана многоязычная FAQ секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания FAQ секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания FAQ секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании FAQ были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании FAQ были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных FAQ секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'FAQ' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные FAQ секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n❓ Основные разделы страницы 'FAQ':");
                $this->command->info("   📝 6 часто задаваемых вопросов с детальными ответами");
                $this->command->info("   📄 Документы для поступления (6 пунктов)");
                $this->command->info("   💰 Стоимость обучения по специальностям");
                $this->command->info("   🏢 Условия проживания в общежитии");
                $this->command->info("   ⏱️ Сроки обучения для разных баз");
                $this->command->info("   💼 Помощь в трудоустройстве выпускников");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка при сидировании страницы FAQ: {$e->getMessage()}");
            Log::error($e->getTraceAsString());
            $this->command->error("❌ Ошибка при сидировании страницы FAQ: {$e->getMessage()}");
            throw $e;
        }
    }
}