<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class BlogPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование страницы Блог руководителя...');
            
            $deleted = PageSection::where('page_key', 'blog')->delete();
            Log::info("Удалено старых записей Blog: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'blog',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Блог',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'page_title' => [
                            'ru' => 'Блог руководителя',
                            'kk' => 'Басшының блогы',
                            'en' => 'Director\'s Blog',
                        ],
                        'meta_title' => [
                            'ru' => 'Блог руководителя | Технический колледж современных технологий',
                            'kk' => 'Басшының блогы | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Director\'s Blog | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Официальный блог руководителя колледжа. Новости, мысли, ответы на вопросы студентов и родителей.',
                            'kk' => 'Колледж басшысының ресми блогы. Жаңалықтар, ойлар, студенттер мен ата-аналардың сұрақтарына жауаптар.',
                            'en' => 'Official blog of the college director. News, thoughts, answers to questions from students and parents.',
                        ],
                    ],
                ],
                
                [
                    'page_key' => 'blog',
                    'section_key' => 'header',
                    'title' => 'Заголовок страницы',
                    'description' => 'Основной заголовок блога',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'БЛОГ РУКОВОДИТЕЛЯ',
                            'kk' => 'БАСШЫНЫҢ БЛОГЫ',
                            'en' => 'DIRECTOR\'S BLOG',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'tabs',
                    'title' => 'Вкладки навигации',
                    'description' => 'Названия вкладок блога',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'tab_1_label' => [
                            'ru' => 'ПРИВЕТСТВИЕ',
                            'kk' => 'СӘЛЕМДЕМЕ',
                            'en' => 'WELCOME',
                        ],
                        'tab_2_label' => [
                            'ru' => 'ВОПРОС — ОТВЕТ',
                            'kk' => 'СҰРАҚ — ЖАУАП',
                            'en' => 'Q&A',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'social_links',
                    'title' => 'Социальные сети',
                    'description' => 'Ссылки на социальные сети',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'instagram_url' => [
                            'ru' => 'https://www.instagram.com/vkeik_kz/?hl=ru',
                            'kk' => 'https://www.instagram.com/vkeik_kz/?hl=ru',
                            'en' => 'https://www.instagram.com/vkeik_kz/?hl=ru',
                        ],
                        'youtube_url' => [
                            'ru' => 'https://www.youtube.com/@КолледжВКЭиК',
                            'kk' => 'https://www.youtube.com/@КолледжВКЭиК',
                            'en' => 'https://www.youtube.com/@КолледжВКЭиК',
                        ],
                        'telegram_url' => [
                            'ru' => 'https://t.me/vkeik_kz',
                            'kk' => 'https://t.me/vkeik_kz',
                            'en' => 'https://t.me/vkeik_kz',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'contact_info',
                    'title' => 'Контактная информация',
                    'description' => 'Телефон, адрес, email руководителя',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'phone' => [
                            'ru' => '+7 701490-05-66',
                            'kk' => '+7 701490-05-66',
                            'en' => '+7 701490-05-66',
                        ],
                        'whatsapp_number' => [
                            'ru' => '77014900566',
                            'kk' => '77014900566',
                            'en' => '77014900566',
                        ],
                        'address' => [
                            'ru' => 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2',
                            'kk' => 'Павлодар қ., Жүсіпбек Аймауытұлы көш., 2',
                            'en' => 'Pavlodar, Zhusipbek Aimautuly st., 2',
                        ],
                        'email' => [
                            'ru' => 'director@college.edu',
                            'kk' => 'director@college.edu',
                            'en' => 'director@college.edu',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'buttons',
                    'title' => 'Текст кнопок',
                    'description' => 'Тексты всех кнопок на странице',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'ask_question_button' => [
                            'ru' => 'Задать вопрос руководителю',
                            'kk' => 'Басшыға сұрақ қою',
                            'en' => 'Ask the director a question',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'greeting',
                    'title' => 'Приветственная речь',
                    'description' => 'Текст приветствия руководителя',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Добро пожаловать в блог руководителя',
                            'kk' => 'Басшының блогына қош келдіңіз',
                            'en' => 'Welcome to the director\'s blog',
                        ],
                        'paragraph_1' => [
                            'ru' => 'Уважаемые студенты, родители, коллеги и партнеры! Рад приветствовать вас на странице моего блога. Этот блог создан для открытого диалога и общения с вами. Здесь я буду делиться своими мыслями о развитии нашего колледжа, образовательных инновациях и важных событиях.',
                            'kk' => 'Құрметті студенттер, ата-аналар, әріптестер және серіктестер! Менің блогымның бетіне қош келдіңіз. Бұл блог сізбен ашық диалог және қарым-қатынас үшін құрылды. Мұнда мен біздің колледжіміздің дамуы, білім беру инновациялары және маңызды оқиғалар туралы ойларымды бөлісемін.',
                            'en' => 'Dear students, parents, colleagues and partners! I am pleased to welcome you to my blog page. This blog was created for open dialogue and communication with you. Here I will share my thoughts on the development of our college, educational innovations and important events.',
                        ],
                        'paragraph_2' => [
                            'ru' => 'Образование — это непрерывный процесс, требующий постоянного развития и адаптации к современным реалиям. Наш колледж стремится быть на передовой технологического прогресса, готовя специалистов, востребованных на рынке труда.',
                            'kk' => 'Білім беру - бұрқан етпес процес, ол үнемі дамуды және заманауи шындыққа бейімделуді талап етеді. Біздің колледж нарықта сұранысқа ие мамандарды дайындай отырып, технологиялық прогресс үшін алдыңғы қатарда болуға ұмтылады.',
                            'en' => 'Education is a continuous process that requires constant development and adaptation to modern realities. Our college strives to be at the forefront of technological progress, training specialists in demand in the labor market.',
                        ],
                        'paragraph_3' => [
                            'ru' => 'Я верю в силу образования и его способность менять жизни. Каждый студент для нас — это уникальная личность с огромным потенциалом. Наша задача — помочь раскрыть этот потенциал и дать все необходимые знания и навыки для успешной карьеры.',
                            'kk' => 'Мен білімнің күшіне және оның өмірді өзгерту қабілетіне сенемін. Біз үшін әрбір студент - бұл үлкен әлеуеті бар бірегей тұлға. Біздің міндетіміз - бұл әлеуетті ашуға көмектесу және табысты мансап үшін қажетті барлық білім мен дағдыларды беру.',
                            'en' => 'I believe in the power of education and its ability to change lives. For us, every student is a unique personality with great potential. Our task is to help reveal this potential and provide all the necessary knowledge and skills for a successful career.',
                        ],
                        'paragraph_4' => [
                            'ru' => 'В этом блоге вы можете задавать вопросы, делиться мнениями и предложениями. Я всегда открыт для конструктивного диалога и готов рассмотреть любые идеи, которые помогут нам стать лучше. Вместе мы можем сделать наш колледж еще более современным и комфортным местом для обучения.',
                            'kk' => 'Бұл блогда сіз сұрақтар қоя аласыз, пікірлер мен ұсыныстармен бөлісе аласыз. Мен әрқашан құрылымдық диалогқа ашықпын және бізді жақсартуға көмектесетін кез келген идеяларды қарастыруға дайынбын. Бірге біз біздің колледжімізді оқу үшін одан да заманауи және ыңғайлы орынға айналдыра аламыз.',
                            'en' => 'In this blog you can ask questions, share opinions and suggestions. I am always open to constructive dialogue and ready to consider any ideas that will help us become better. Together we can make our college an even more modern and comfortable place to study.',
                        ],
                        'signature' => [
                            'ru' => 'С уважением,<br><strong>Ныгметов Марат Жанатович</strong><br><span class="text-gray-400">Руководитель колледжа</span>',
                            'kk' => 'Құрметпен,<br><strong>Нығметов Марат Жанатұлы</strong><br><span class="text-gray-400">Колледж басшысы</span>',
                            'en' => 'Sincerely,<br><strong>Nygmetov Marat Zhanatovich</strong><br><span class="text-gray-400">College Director</span>',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'faq_section',
                    'title' => 'Раздел Вопрос-Ответ',
                    'description' => 'Тексты раздела часто задаваемых вопросов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'title' => [
                            'ru' => 'Вопросы и ответы',
                            'kk' => 'Сұрақтар мен жауаптар',
                            'en' => 'Questions and Answers',
                        ],
                        'answer_signature' => [
                            'ru' => 'Руководитель колледжа',
                            'kk' => 'Колледж басшысы',
                            'en' => 'College Director',
                        ],
                        'no_questions_text' => [
                            'ru' => 'Пока нет опубликованных вопросов. Будьте первым, кто задаст вопрос!',
                            'kk' => 'Әзірше жарияланған сұрақтар жоқ. Сұрақ қойған бірінші болыңыз!',
                            'en' => 'No published questions yet. Be the first to ask a question!',
                        ],
                        'ask_first_button' => [
                            'ru' => 'Задать вопрос',
                            'kk' => 'Сұрақ қою',
                            'en' => 'Ask a question',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'modal',
                    'title' => 'Модальное окно',
                    'description' => 'Тексты в модальном окне вопроса',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'title' => [
                            'ru' => 'Задать вопрос',
                            'kk' => 'Сұрақ қою',
                            'en' => 'Ask a question',
                        ],
                        'name_label' => [
                            'ru' => 'Ваше имя *',
                            'kk' => 'Сіздің атыңыз *',
                            'en' => 'Your name *',
                        ],
                        'name_placeholder' => [
                            'ru' => 'Введите ваше имя',
                            'kk' => 'Атыңызды енгізіңіз',
                            'en' => 'Enter your name',
                        ],
                        'email_label' => [
                            'ru' => 'Email *',
                            'kk' => 'Email *',
                            'en' => 'Email *',
                        ],
                        'email_placeholder' => [
                            'ru' => 'Введите ваш email',
                            'kk' => 'Email-іңізді енгізіңіз',
                            'en' => 'Enter your email',
                        ],
                        'question_label' => [
                            'ru' => 'Ваш вопрос *',
                            'kk' => 'Сіздің сұрағыңыз *',
                            'en' => 'Your question *',
                        ],
                        'question_placeholder' => [
                            'ru' => 'Напишите ваш вопрос...',
                            'kk' => 'Сұрағыңызды жазыңыз...',
                            'en' => 'Write your question...',
                        ],
                        'submit_button' => [
                            'ru' => 'Отправить вопрос',
                            'kk' => 'Сұрақты жіберу',
                            'en' => 'Send question',
                        ],
                        'cancel_button' => [
                            'ru' => 'Отмена',
                            'kk' => 'Болдырмау',
                            'en' => 'Cancel',
                        ],
                    ],
                ],

                [
                    'page_key' => 'blog',
                    'section_key' => 'messages',
                    'title' => 'Системные сообщения',
                    'description' => 'Различные системные сообщения',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'success_message' => [
                            'ru' => 'Ваш вопрос успешно отправлен! Спасибо за ваш интерес.',
                            'kk' => 'Сіздің сұрағыңыз сәтті жіберілді! Қызығушылығыңыз үшін рахмет.',
                            'en' => 'Your question has been sent successfully! Thank you for your interest.',
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
                    Log::info("Создана многоязычная Blog секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций Blog: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Блог руководителя' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n📝 Особенности страницы 'Блог руководителя':");
                $this->command->info("   💬 2 вкладки: Приветствие и Вопрос-Ответ");
                $this->command->info("   📱 Социальные сети руководителя");
                $this->command->info("   📞 Контактная информация");
                $this->command->info("   ❓ Система вопросов с модальным окном");
                $this->command->info("   💭 Развернутое приветствие (4 параграфа)");
                $this->command->info("   📝 Подпись руководителя с форматом HTML");
                $this->command->info("   🔄 Переключение вкладок с сохранением состояния");
                
                $this->command->info("\n📊 Разделы страницы:");
                $this->command->info("   1. Метаданные (SEO)");
                $this->command->info("   2. Заголовок страницы");
                $this->command->info("   3. Вкладки навигации");
                $this->command->info("   4. Социальные сети");
                $this->command->info("   5. Контактная информация");
                $this->command->info("   6. Тексты кнопок");
                $this->command->info("   7. Приветственная речь");
                $this->command->info("   8. Раздел Вопрос-Ответ");
                $this->command->info("   9. Модальное окно");
                $this->command->info("   10. Системные сообщения");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}