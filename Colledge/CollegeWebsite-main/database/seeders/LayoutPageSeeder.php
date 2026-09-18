<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class LayoutPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование глобальных и навигационных секций шаблона...');
            
            // Очищаем существующие записи для глобальных и навигационных секций
            $deleted = PageSection::whereIn('page_key', ['global', 'header', 'navigation', 'modals', 'chat', 'weather', 'notifications', 'search', 'cookies', 'bug_report'])
                ->delete();
            Log::info("Удалено старых записей: {$deleted}");
            
            $sections = [
                // ============================
                // ГЛОБАЛЬНЫЕ НАСТРОЙКИ
                // ============================
                [
                    'page_key' => 'global',
                    'section_key' => 'metadata',
                    'title' => 'Глобальные метаданные сайта',
                    'description' => 'SEO и основные настройки сайта',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'site_name' => [
                            'ru' => 'ВКЭиК',
                            'kk' => 'ВКЭиК',
                            'en' => 'VKEiK',
                        ],
                        'description' => [
                            'ru' => 'Высший колледж ВКЭиК - качественное образование в Павлодаре',
                            'kk' => 'ВКЭиК Жоғары колледжі - Павлодардағы сапалы білім',
                            'en' => 'VKEiK Higher College - quality education in Pavlodar',
                        ],
                        'keywords' => [
                            'ru' => 'колледж, образование, Павлодар, ВКЭиК, железнодорожный транспорт, телекоммуникации, IT',
                            'kk' => 'колледж, білім, Павлодар, ВКЭиК, теміржол көлігі, телекоммуникация, IT',
                            'en' => 'college, education, Pavlodar, VKEiK, railway transport, telecommunications, IT',
                        ],
                    ],
                ],

                // ============================
                // ШАПКА САЙТА (HEADER)
                // ============================
                [
                    'page_key' => 'header',
                    'section_key' => 'logo',
                    'title' => 'Логотипы и изображения',
                    'description' => 'Логотипы и изображения для шапки сайта',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'home_label' => [
                            'ru' => 'На главную страницу',
                            'kk' => 'Басты бетке өту',
                            'en' => 'Go to home page',
                        ],
                        'logo1_url' => [
                            'ru' => 'images/new45.png',
                            'kk' => 'images/new45.png',
                            'en' => 'images/new45.png',
                        ],
                        'logo1_alt' => [
                            'ru' => 'Логотип колледжа 45 лет',
                            'kk' => '45 жылдық колледж логотипі',
                            'en' => 'College 45 years logo',
                        ],
                        'logo1_fallback' => [
                            'ru' => 'П',
                            'kk' => 'П',
                            'en' => 'P',
                        ],
                        'logo2_url' => [
                            'ru' => 'images/college-logo.png',
                            'kk' => 'images/college-logo.png',
                            'en' => 'images/college-logo.png',
                        ],
                        'logo2_alt' => [
                            'ru' => 'Логотип колледжа',
                            'kk' => 'Колледж логотипі',
                            'en' => 'College logo',
                        ],
                        'logo2_fallback' => [
                            'ru' => 'Л',
                            'kk' => 'Л',
                            'en' => 'L',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'top_menu',
                    'title' => 'Верхнее меню',
                    'description' => 'Кнопки в верхней синей полосе',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'call_center_label' => [
                            'ru' => 'Колл-центр',
                            'kk' => 'Колл-орталық',
                            'en' => 'Call Center',
                        ],
                        'reception_schedule_label' => [
                            'ru' => 'График приёма',
                            'kk' => 'Қабылдау кестесі',
                            'en' => 'Reception schedule',
                        ],
                        'blog_label' => [
                            'ru' => 'Блог руководителя',
                            'kk' => 'Басшының блогы',
                            'en' => 'Director\'s blog',
                        ],
                        'support_label' => [
                            'ru' => 'Служба поддержки',
                            'kk' => 'Қолдау қызметі',
                            'en' => 'Support service',
                        ],
                        'bvi_label' => [
                            'ru' => 'Версия для слабовидящих',
                            'kk' => 'Нашар көретіндерге арналған нұсқа',
                            'en' => 'Version for visually impaired',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'social',
                    'title' => 'Социальные сети',
                    'description' => 'Ссылки на социальные сети',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'find_us_label' => [
                            'ru' => 'Найди нас:',
                            'kk' => 'Бізді тап:',
                            'en' => 'Find us:',
                        ],
                        'youtube_url' => [
                            'ru' => 'https://www.youtube.com/@КолледжВКЭиК',
                            'kk' => 'https://www.youtube.com/@КолледжВКЭиК',
                            'en' => 'https://www.youtube.com/@VKEiKCollege',
                        ],
                        'telegram_url' => [
                            'ru' => 'https://t.me/vkeik_kz',
                            'kk' => 'https://t.me/vkeik_kz',
                            'en' => 'https://t.me/vkeik_kz',
                        ],
                        'instagram_url' => [
                            'ru' => 'https://www.instagram.com/vkeik_kz/?hl=ru',
                            'kk' => 'https://www.instagram.com/vkeik_kz/?hl=ru',
                            'en' => 'https://www.instagram.com/vkeik_kz/',
                        ],
                        'whatsapp_url' => [
                            'ru' => 'https://wa.me/77014900566',
                            'kk' => 'https://wa.me/77014900566',
                            'en' => 'https://wa.me/77014900566',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'languages',
                    'title' => 'Языковые кнопки',
                    'description' => 'Кнопки переключения языков',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'kaz_label' => [
                            'ru' => 'ҚАЗ',
                            'kk' => 'ҚАЗ',
                            'en' => 'KAZ',
                        ],
                        'rus_label' => [
                            'ru' => 'РУС',
                            'kk' => 'РУС',
                            'en' => 'RUS',
                        ],
                        'eng_label' => [
                            'ru' => 'ENG',
                            'kk' => 'ENG',
                            'en' => 'ENG',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'burger_menu',
                    'title' => 'Бургер меню',
                    'description' => 'Элементы бургер меню',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'open_label' => [
                            'ru' => 'Открыть меню',
                            'kk' => 'Мәзірді ашу',
                            'en' => 'Open menu',
                        ],
                        'close_label' => [
                            'ru' => 'Закрыть меню',
                            'kk' => 'Мәзірді жабу',
                            'en' => 'Close menu',
                        ],
                        'title' => [
                            'ru' => 'Дополнительное меню',
                            'kk' => 'Қосымша мәзір',
                            'en' => 'Additional menu',
                        ],
                        'situation_center_label' => [
                            'ru' => 'Ситуационный центр',
                            'kk' => 'Жағдай орталығы',
                            'en' => 'Situation center',
                        ],
                        'state_symbols_label' => [
                            'ru' => 'Государственные символы',
                            'kk' => 'Мемлекеттік рәміздер',
                            'en' => 'State symbols',
                        ],
                        'vacancies_label' => [
                            'ru' => 'Вакансии педагогов',
                            'kk' => 'Педагогтардың бос орындары',
                            'en' => 'Teacher vacancies',
                        ],
                        'anti_corruption_label' => [
                            'ru' => 'Противодействие коррупции',
                            'kk' => 'Сатып алуға қарсы күрес',
                            'en' => 'Anti-corruption',
                        ],
                        'government_services_label' => [
                            'ru' => 'Государственные услуги',
                            'kk' => 'Мемлекеттік қызметтер',
                            'en' => 'Government services',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'mobile_menu',
                    'title' => 'Мобильное меню',
                    'description' => 'Элементы мобильного меню',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'open_label' => [
                            'ru' => 'Открыть меню',
                            'kk' => 'Мәзірді ашу',
                            'en' => 'Open menu',
                        ],
                        'close_label' => [
                            'ru' => 'Закрыть меню',
                            'kk' => 'Мәзірді жабу',
                            'en' => 'Close menu',
                        ],
                    ],
                ],

                [
                    'page_key' => 'header',
                    'section_key' => 'search',
                    'title' => 'Поиск по сайту',
                    'description' => 'Настройки поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'placeholder' => [
                            'ru' => 'Поиск по сайту...',
                            'kk' => 'Сайт бойынша іздеу...',
                            'en' => 'Search the site...',
                        ],
                    ],
                ],

                // ============================
                // НАВИГАЦИЯ (MAIN NAVIGATION)
                // ============================
                [
                    'page_key' => 'navigation',
                    'section_key' => 'menu',
                    'title' => 'Главное меню навигации',
                    'description' => 'Основные пункты меню навигации',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'home_label' => [
                            'ru' => 'Главная',
                            'kk' => 'Басты бет',
                            'en' => 'Home',
                        ],
                        'about_label' => [
                            'ru' => 'О колледже',
                            'kk' => 'Колледж туралы',
                            'en' => 'About',
                        ],
                        'applicants_label' => [
                            'ru' => 'Поступающим',
                            'kk' => 'Түсетіндерге',
                            'en' => 'For applicants',
                        ],
                        'students_label' => [
                            'ru' => 'Студентам',
                            'kk' => 'Студенттерге',
                            'en' => 'For students',
                        ],
                        'schedule_label' => [
                            'ru' => 'Расписание',
                            'kk' => 'Кесте',
                            'en' => 'Schedule',
                        ],
                        'news_label' => [
                            'ru' => 'Новости',
                            'kk' => 'Жаңалықтар',
                            'en' => 'News',
                        ],
                        'contacts_label' => [
                            'ru' => 'Контакты',
                            'kk' => 'Байланыстар',
                            'en' => 'Contacts',
                        ],
                    ],
                ],

                [
                    'page_key' => 'navigation',
                    'section_key' => 'submenu',
                    'title' => 'Подменю навигации',
                    'description' => 'Подпункты выпадающих меню',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'about_us_label' => [
                            'ru' => 'О нас',
                            'kk' => 'Біз туралы',
                            'en' => 'About us',
                        ],
                        'charter_label' => [
                            'ru' => 'Устав колледжа',
                            'kk' => 'Колледж ережесі',
                            'en' => 'College charter',
                        ],
                        'license_label' => [
                            'ru' => 'Лицензия на образовательную деятельность',
                            'kk' => 'Білім беру қызметіне лицензия',
                            'en' => 'Educational activity license',
                        ],
                        'achievements_label' => [
                            'ru' => 'Достижения колледжа',
                            'kk' => 'Колледж жетістіктері',
                            'en' => 'College achievements',
                        ],
                        'graduates_label' => [
                            'ru' => 'Наши выпускники',
                            'kk' => 'Біздің түлектер',
                            'en' => 'Our graduates',
                        ],
                        'staff_label' => [
                            'ru' => 'Администрация и преподаватели',
                            'kk' => 'Әкімшілік және оқытушылар',
                            'en' => 'Administration and teachers',
                        ],
                        'trade_union_label' => [
                            'ru' => 'Профсоюз',
                            'kk' => 'Кәсіподақ',
                            'en' => 'Trade union',
                        ],
                        'council_label' => [
                            'ru' => 'Советы при колледже',
                            'kk' => 'Колледждің кеңестері',
                            'en' => 'College councils',
                        ],
                        'consultation_label' => [
                            'ru' => 'Консультация приемной комиссии',
                            'kk' => 'Қабылдау комиссиясының кеңесі',
                            'en' => 'Admission commission consultation',
                        ],
                        'virtual_tour_label' => [
                            'ru' => 'Виртуальный тур',
                            'kk' => 'Виртуалды тур',
                            'en' => 'Virtual tour',
                        ],
                        'faq_label' => [
                            'ru' => 'Частые вопросы',
                            'kk' => 'Жиі қойылатын сұрақтар',
                            'en' => 'Frequently asked questions',
                        ],
                        'blog_label' => [
                            'ru' => 'Блог руководителя',
                            'kk' => 'Басшының блогы',
                            'en' => 'Director\'s blog',
                        ],
                        'youth_movement_label' => [
                            'ru' => 'Молодежный движ',
                            'kk' => 'Жастар қозғалысы',
                            'en' => 'Youth movement',
                        ],
                        'collaboration_label' => [
                            'ru' => 'Коллаборация',
                            'kk' => 'Ынтымақтастық',
                            'en' => 'Collaboration',
                        ],
                        'curators_label' => [
                            'ru' => 'Кураторы групп',
                            'kk' => 'Топ кураторлары',
                            'en' => 'Group curators',
                        ],
                        'contacts_label' => [
                            'ru' => 'Телефонный справочник',
                            'kk' => 'Телефон анықтамасы',
                            'en' => 'Phone directory',
                        ],
                        'library_label' => [
                            'ru' => 'Библиотека',
                            'kk' => 'Кітапхана',
                            'en' => 'Library',
                        ],
                        'rules_label' => [
                            'ru' => 'Правила внутреннего распорядка',
                            'kk' => 'Ішкі ережелер',
                            'en' => 'Internal rules',
                        ],
                        'lessons_schedule_label' => [
                            'ru' => 'Расписание занятий',
                            'kk' => 'Сабақ кестесі',
                            'en' => 'Lessons schedule',
                        ],
                        'bells_schedule_label' => [
                            'ru' => 'Расписание звонков',
                            'kk' => 'Қоңырау кестесі',
                            'en' => 'Bells schedule',
                        ],
                    ],
                ],

                // ============================
                // МОДАЛЬНЫЕ ОКНА (MODALS)
                // ============================
                [
                    'page_key' => 'modals',
                    'section_key' => 'pdf',
                    'title' => 'PDF модальное окно',
                    'description' => 'Настройки PDF модального окна',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Документ',
                            'kk' => 'Құжат',
                            'en' => 'Document',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'reception',
                    'title' => 'Модальное окно графика приема',
                    'description' => 'Настройки окна графика приема граждан',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'График приема граждан',
                            'kk' => 'Азаматтарды қабылдау кестесі',
                            'en' => 'Citizens reception schedule',
                        ],
                        'image_url' => [
                            'ru' => 'images/reception-schedule.jpg',
                            'kk' => 'images/reception-schedule.jpg',
                            'en' => 'images/reception-schedule.jpg',
                        ],
                        'image_alt' => [
                            'ru' => 'График приема граждан',
                            'kk' => 'Азаматтарды қабылдау кестесі',
                            'en' => 'Citizens reception schedule',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'call_center',
                    'title' => 'Модальное окно Call-центра',
                    'description' => 'Настройки окна Call-центра',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'CALL-ЦЕНТР',
                            'kk' => 'CALL-Орталық',
                            'en' => 'CALL-CENTER',
                        ],
                        'mobile_phone_label' => [
                            'ru' => 'Сотовый телефон',
                            'kk' => 'Ұялы телефон',
                            'en' => 'Mobile phone',
                        ],
                        'mobile_phone_number' => [
                            'ru' => '+7 701 490 05 66',
                            'kk' => '+7 701 490 05 66',
                            'en' => '+7 701 490 05 66',
                        ],
                        'work_phone_label' => [
                            'ru' => 'Рабочий телефон',
                            'kk' => 'Жұмыс телефоны',
                            'en' => 'Work phone',
                        ],
                        'work_phone_number' => [
                            'ru' => '+7 (7182) 33-87-33',
                            'kk' => '+7 (7182) 33-87-33',
                            'en' => '+7 (7182) 33-87-33',
                        ],
                        'schedule_label' => [
                            'ru' => 'График работы',
                            'kk' => 'Жұмыс кестесі',
                            'en' => 'Working hours',
                        ],
                        'schedule_text' => [
                            'ru' => 'Пн-Пт: 8:00 - 17:00<br>Сб,Вс: выходной',
                            'kk' => 'Дс-Жм: 8:00 - 17:00<br>Сб,Жс: демалыс',
                            'en' => 'Mon-Fri: 8:00 AM - 5:00 PM<br>Sat,Sun: day off',
                        ],
                        'description' => [
                            'ru' => 'Наш CALL-ЦЕНТР готов ответить на все ваши вопросы, касающиеся поступления, обучения, расписания и других аспектов работы колледжа.',
                            'kk' => 'Біздің CALL-орталық колледж жұмысының барлық аспектілеріне қатысты сұрақтарыңызға жауап беруге дайын: түсу, оқу, кесте және т.б.',
                            'en' => 'Our CALL-CENTER is ready to answer all your questions regarding admission, education, schedule and other aspects of the college work.',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'support',
                    'title' => 'Модальное окно службы поддержки',
                    'description' => 'Настройки формы обращения в службу поддержки',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Форма обращения',
                            'kk' => 'Өтініш нысаны',
                            'en' => 'Appeal form',
                        ],
                        'success_message' => [
                            'ru' => 'Ваше обращение успешно отправлено!',
                            'kk' => 'Сіздің өтінішіңіз сәтті жіберілді!',
                            'en' => 'Your appeal has been sent successfully!',
                        ],
                        'error_message' => [
                            'ru' => 'Произошла ошибка при отправке обращения',
                            'kk' => 'Өтініш жіберу кезінде қате орын алды',
                            'en' => 'An error occurred while sending the appeal',
                        ],
                        'network_error' => [
                            'ru' => 'Произошла ошибка сети. Попробуйте позже.',
                            'kk' => 'Желі қатесі орын алды. Кейінірек қайталаңыз.',
                            'en' => 'Network error occurred. Please try again later.',
                        ],
                        'address_label' => [
                            'ru' => 'Адресат обращения',
                            'kk' => 'Өтініштің адресаты',
                            'en' => 'Appeal addressee',
                        ],
                        'address_default' => [
                            'ru' => 'Администрация колледжа',
                            'kk' => 'Колледж әкімшілігі',
                            'en' => 'College administration',
                        ],
                        'email_label' => [
                            'ru' => 'E-mail',
                            'kk' => 'E-mail',
                            'en' => 'E-mail',
                        ],
                        'full_name_label' => [
                            'ru' => 'Ваше ФИО',
                            'kk' => 'Сіздің аты-жөніңіз',
                            'en' => 'Your full name',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'type_label' => [
                            'ru' => 'Тип обращения',
                            'kk' => 'Өтініш түрі',
                            'en' => 'Appeal type',
                        ],
                        'type_select' => [
                            'ru' => 'Выберите тип',
                            'kk' => 'Түрін таңдаңыз',
                            'en' => 'Select type',
                        ],
                        'type_complaint' => [
                            'ru' => 'Жалоба',
                            'kk' => 'Шағым',
                            'en' => 'Complaint',
                        ],
                        'type_other' => [
                            'ru' => 'Другое',
                            'kk' => 'Басқа',
                            'en' => 'Other',
                        ],
                        'message_label' => [
                            'ru' => 'Сообщение',
                            'kk' => 'Хабарлама',
                            'en' => 'Message',
                        ],
                        'file_label' => [
                            'ru' => 'Добавить файл',
                            'kk' => 'Файл қосу',
                            'en' => 'Add file',
                        ],
                        'file_requirements' => [
                            'ru' => 'Допустимые форматы: PDF, DOC, DOCX, JPG, PNG. Максимальный размер: 5MB',
                            'kk' => 'Рұқсат етілген форматтар: PDF, DOC, DOCX, JPG, PNG. Ең үлкен өлшемі: 5MB',
                            'en' => 'Allowed formats: PDF, DOC, DOCX, JPG, PNG. Maximum size: 5MB',
                        ],
                        'consent_text' => [
                            'ru' => 'Я предупрежден об уголовной ответственности за подачу заведомо ложных сведений',
                            'kk' => 'Мен жалған ақпарат беру үшін қылмыстық жауапкершілік туралы хабардармын',
                            'en' => 'I am warned about criminal liability for submitting knowingly false information',
                        ],
                        'article_419' => [
                            'ru' => 'Статья 419.',
                            'kk' => '419-бап.',
                            'en' => 'Article 419.',
                        ],
                        'article_title' => [
                            'ru' => 'Заведомо ложный донос',
                            'kk' => 'Біліп тұрып жалған шағым жасау',
                            'en' => 'Knowingly false denunciation',
                        ],
                        'paragraph_1' => [
                            'ru' => 'Заведомо ложный донос о совершении уголовного проступка - наказывается штрафом в размере до двухсот месячных расчетных показателей либо исправительными работами в том же размере, либо привлечением к общественным работам на срок до двухсот часов.',
                            'kk' => 'Біліп тұрып қылмыстық құқық бұзушылық жайлы жалған шағым жасау - екі жүз айлық есептік көрсеткішке дейін айыппұлмен немесе сол мөлшерде түзету жұмыстарымен немесе екі жүз сағатқа дейін қоғамдық жұмыстармен жазаланады.',
                            'en' => 'Knowingly false denunciation about committing a criminal offense - shall be punished with a fine of up to two hundred monthly calculation indices, or corrective works in the same amount, or community service for up to two hundred hours.',
                        ],
                        'paragraph_2' => [
                            'ru' => 'Заведомо ложный донос о совершении преступления - наказывается штрафом в размере до четырех тысяч месячных расчетных показателей либо исправительными работами в том же размере, либо привлечением к общественных работ на срок до одной тысячи часов, либо ограничением свободы на срок до пяти лет, либо лишением свободы на тот же срок.',
                            'kk' => 'Біліп тұрып қылмыстық іс жайлы жалған шағым жасау - төрт мың айлық есептік көрсеткішке дейін айыппұлмен немесе сол мөлшерде түзету жұмыстарымен немесе бір мың сағатқа дейін қоғамдық жұмыстармен немесе бес жылға дейін еркіндікті шектеумен немесе сол мерзімге бас бостандығынан айырумен жазаланады.',
                            'en' => 'Knowingly false denunciation about committing a crime - shall be punished with a fine of up to four thousand monthly calculation indices, or corrective works in the same amount, or community service for up to one thousand hours, or restriction of freedom for up to five years, or imprisonment for the same term.',
                        ],
                        'paragraph_3' => [
                            'ru' => 'Деяние, предусмотренное частью второй настоящей статьи, соединенное с обвинением лица в совершении коррупционного, тяжкого или особо тяжкого преступления либо совершенное из корыстных побуждений, - наказывается лишением свободы на срок от трех до восьми лет.',
                            'kk' => 'Осы баптың екінші бөлігінде көзделген іс-әрекет, онымен қатар адамды сатып алу, ауыр немесе ерекше ауыр қылмыс жасады деп айыптаумен бірге немесе пайда үшін жасалған болса, - үш жылдан сегіз жылға дейінгі мерзімге бас бостандығынан айырумен жазаланады.',
                            'en' => 'An act provided for in the second part of this article, combined with accusing a person of committing a corruption, grave or particularly grave crime, or committed for selfish motives, - shall be punished with imprisonment for a term of three to eight years.',
                        ],
                        'paragraph_4' => [
                            'ru' => 'Деяния, предусмотренные частями второй или третьей настоящей статьи, совершенные в интересах преступной группы, - наказываются лишением свободы на срок от пяти до двенадцати лет.',
                            'kk' => 'Осы баптың екінші немесе үшінші бөліктерінде көзделген іс-әрекеттер, қылмыстық топтың мүддесі үшін жасалған болса, - бес жылдан он екі жылға дейінгі мерзімге бас бостандығынан айырумен жазаланады.',
                            'en' => 'Acts provided for in the second or third parts of this article, committed in the interests of a criminal group, - shall be punished with imprisonment for a term of five to twelve years.',
                        ],
                        'submit_button' => [
                            'ru' => 'Отправить',
                            'kk' => 'Жіберу',
                            'en' => 'Send',
                        ],
                        'cancel_button' => [
                            'ru' => 'Отмена',
                            'kk' => 'Бас тарту',
                            'en' => 'Cancel',
                        ],
                        'sending_text' => [
                            'ru' => 'Отправка...',
                            'kk' => 'Жіберілуде...',
                            'en' => 'Sending...',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'consultation',
                    'title' => 'Модальное окно консультации',
                    'description' => 'Настройки формы консультации приемной комиссии',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Консультация с приемной комиссией',
                            'kk' => 'Қабылдау комиссиясымен кеңес',
                            'en' => 'Consultation with admission commission',
                        ],
                        'form_title' => [
                            'ru' => 'Заявка на консультацию',
                            'kk' => 'Кеңес үшін өтініш',
                            'en' => 'Consultation request',
                        ],
                        'form_subtitle' => [
                            'ru' => 'Заполните форму и мы свяжемся с вами в ближайшее время',
                            'kk' => 'Пішінді толтырыңыз, біз сізбен жақын арада байланысамыз',
                            'en' => 'Fill out the form and we will contact you soon',
                        ],
                        'success_message' => [
                            'ru' => 'Ваша заявка успешно отправлена!',
                            'kk' => 'Сіздің өтінішіңіз сәтті жіберілді!',
                            'en' => 'Your request has been sent successfully!',
                        ],
                        'error_message' => [
                            'ru' => 'Произошла ошибка при отправке заявки',
                            'kk' => 'Өтініш жіберу кезінде қате орын алды',
                            'en' => 'An error occurred while sending the request',
                        ],
                        'network_error' => [
                            'ru' => 'Произошла ошибка сети. Попробуйте позже.',
                            'kk' => 'Желі қатесі орын алды. Кейінірек қайталаңыз.',
                            'en' => 'Network error occurred. Please try again later.',
                        ],
                        'name_label' => [
                            'ru' => 'ФИО',
                            'kk' => 'Аты-жөні',
                            'en' => 'Full name',
                        ],
                        'name_placeholder' => [
                            'ru' => 'Введите ваше полное имя',
                            'kk' => 'Толық атыңызды енгізіңіз',
                            'en' => 'Enter your full name',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'phone_placeholder' => [
                            'ru' => '+7 (XXX) XXX-XX-XX',
                            'kk' => '+7 (XXX) XXX-XX-XX',
                            'en' => '+7 (XXX) XXX-XX-XX',
                        ],
                        'email_label' => [
                            'ru' => 'Email',
                            'kk' => 'Email',
                            'en' => 'Email',
                        ],
                        'email_placeholder' => [
                            'ru' => 'example@email.com',
                            'kk' => 'example@email.com',
                            'en' => 'example@email.com',
                        ],
                        'info_text' => [
                            'ru' => 'Наш специалист свяжется с вами в течение 24 часов для консультации по вопросам поступления.',
                            'kk' => 'Біздің маманымыз түсу мәселелері бойынша кеңес беру үшін 24 сағат ішінде сізбен байланысады.',
                            'en' => 'Our specialist will contact you within 24 hours to consult on admission issues.',
                        ],
                        'submit_button' => [
                            'ru' => 'Отправить заявку на консультацию',
                            'kk' => 'Кеңес үшін өтініш жіберу',
                            'en' => 'Send consultation request',
                        ],
                        'sending_text' => [
                            'ru' => 'Отправка...',
                            'kk' => 'Жіберілуде...',
                            'en' => 'Sending...',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'contacts',
                    'title' => 'Модальное окно контактов',
                    'description' => 'Настройки окна контактов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Контакты',
                            'kk' => 'Байланыстар',
                            'en' => 'Contacts',
                        ],
                        'college_name' => [
                            'ru' => 'Высший колледж ВКЭиК',
                            'kk' => 'ВКЭиК Жоғары колледжі',
                            'en' => 'VKEiK Higher College',
                        ],
                        'address_label' => [
                            'ru' => 'Адрес',
                            'kk' => 'Мекенжай',
                            'en' => 'Address',
                        ],
                        'address_text' => [
                            'ru' => 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2',
                            'kk' => 'Павлодар қ., Жүсіпбек Аймауытұлы көш., 2',
                            'en' => 'Pavlodar, Zhusipbek Aymauytuly street, 2',
                        ],
                        'phones_label' => [
                            'ru' => 'Телефоны',
                            'kk' => 'Телефондар',
                            'en' => 'Phones',
                        ],
                        'phone1_number' => [
                            'ru' => '+77182338733',
                            'kk' => '+77182338733',
                            'en' => '+77182338733',
                        ],
                        'phone1_text' => [
                            'ru' => '(7182) 33-87-33',
                            'kk' => '(7182) 33-87-33',
                            'en' => '(7182) 33-87-33',
                        ],
                        'phone2_number' => [
                            'ru' => '+77182338440',
                            'kk' => '+77182338440',
                            'en' => '+77182338440',
                        ],
                        'phone2_text' => [
                            'ru' => '(7182) 33-84-40',
                            'kk' => '(7182) 33-84-40',
                            'en' => '(7182) 33-84-40',
                        ],
                        'email_label' => [
                            'ru' => 'E-mail',
                            'kk' => 'E-mail',
                            'en' => 'E-mail',
                        ],
                        'email_address' => [
                            'ru' => 'vkeik@edu.kz',
                            'kk' => 'vkeik@edu.kz',
                            'en' => 'vkeik@edu.kz',
                        ],
                        'fax_label' => [
                            'ru' => 'Факс',
                            'kk' => 'Факс',
                            'en' => 'Fax',
                        ],
                        'fax_text' => [
                            'ru' => '(7182) 33-87-33',
                            'kk' => '(7182) 33-87-33',
                            'en' => '(7182) 33-87-33',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'admission',
                    'title' => 'Модальное окно приемной комиссии',
                    'description' => 'Резервное окно приемной комиссии',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Приемная комиссия',
                            'kk' => 'Қабылдау комиссиясы',
                            'en' => 'Admission commission',
                        ],
                        'email_address' => [
                            'ru' => 'admission@vkeik.edu.kz',
                            'kk' => 'admission@vkeik.edu.kz',
                            'en' => 'admission@vkeik.edu.kz',
                        ],
                        'schedule_label' => [
                            'ru' => 'График работы',
                            'kk' => 'Жұмыс кестесі',
                            'en' => 'Working hours',
                        ],
                        'schedule_text' => [
                            'ru' => 'Пн-Пт: 9:00 - 18:00<br>Сб: 9:00 - 14:00<br>Вс: выходной',
                            'kk' => 'Дс-Жм: 9:00 - 18:00<br>Сб: 9:00 - 14:00<br>Жс: демалыс',
                            'en' => 'Mon-Fri: 9:00 AM - 6:00 PM<br>Sat: 9:00 AM - 2:00 PM<br>Sun: day off',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'staff',
                    'title' => 'Модальное окно сотрудников',
                    'description' => 'Настройки окна информации о сотрудниках',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'title' => [
                            'ru' => 'Информация о сотруднике',
                            'kk' => 'Қызметкер туралы ақпарат',
                            'en' => 'Staff information',
                        ],
                        'error_message' => [
                            'ru' => 'Ошибка загрузки данных сотрудника',
                            'kk' => 'Қызметкер мәліметтерін жүктеу қатесі',
                            'en' => 'Error loading staff data',
                        ],
                        'position_label' => [
                            'ru' => 'Должность',
                            'kk' => 'Лауазым',
                            'en' => 'Position',
                        ],
                        'department_label' => [
                            'ru' => 'Отдел',
                            'kk' => 'Бөлім',
                            'en' => 'Department',
                        ],
                        'email_label' => [
                            'ru' => 'Email',
                            'kk' => 'Email',
                            'en' => 'Email',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'bio_label' => [
                            'ru' => 'О сотруднике',
                            'kk' => 'Қызметкер туралы',
                            'en' => 'About staff',
                        ],
                    ],
                ],

                [
                    'page_key' => 'modals',
                    'section_key' => 'situation_center',
                    'title' => 'Модальное окно ситуационного центра',
                    'description' => 'Настройки окна ситуационного центра',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'title' => [
                            'ru' => 'Ситуационный центр',
                            'kk' => 'Жағдай орталығы',
                            'en' => 'Situation center',
                        ],
                        'control_label' => [
                            'ru' => 'Оперативный контроль',
                            'kk' => 'Оперативтік бақылау',
                            'en' => 'Operational control',
                        ],
                        'control_text' => [
                            'ru' => 'Мониторинг и управление образовательным процессом в реальном времени',
                            'kk' => 'Білім беру үрдісін нақты уақыт режимінде бақылау және басқару',
                            'en' => 'Monitoring and management of the educational process in real time',
                        ],
                        'security_label' => [
                            'ru' => 'Безопасность',
                            'kk' => 'Қауіпсіздік',
                            'en' => 'Security',
                        ],
                        'security_text' => [
                            'ru' => 'Система видеонаблюдения и контроля доступа',
                            'kk' => 'Бейнебақылау және кіруді бақылау жүйесі',
                            'en' => 'Video surveillance and access control system',
                        ],
                        'response_label' => [
                            'ru' => 'Быстрое реагирование',
                            'kk' => 'Жылдам жауап беру',
                            'en' => 'Quick response',
                        ],
                        'response_text' => [
                            'ru' => 'Решение оперативных вопросов и инцидентов',
                            'kk' => 'Оперативтік мәселелер мен оқиғаларды шешу',
                            'en' => 'Solving operational issues and incidents',
                        ],
                        'description' => [
                            'ru' => 'Ситуационный центр обеспечивает оперативное управление, мониторинг и безопасность образовательного процесса в колледже.',
                            'kk' => 'Жағдай орталығы колледждегі білім беру үрдісінің оперативтік басқаруын, мониторингін және қауіпсіздігін қамтамасыз етеді.',
                            'en' => 'The situation center provides operational management, monitoring and security of the educational process in the college.',
                        ],
                    ],
                ],

                // ============================
                // ЧАТ (CHAT ASSISTANT)
                // ============================
                [
                    'page_key' => 'chat',
                    'section_key' => 'assistant',
                    'title' => 'Чат-ассистент',
                    'description' => 'Настройки чат-ассистента (робота)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'robot_image_url' => [
                            'ru' => 'images/robot-assistant.png',
                            'kk' => 'images/robot-assistant.png',
                            'en' => 'images/robot-assistant.png',
                        ],
                        'icon_image_url' => [
                            'ru' => 'images/gpt1.png',
                            'kk' => 'images/gpt1.png',
                            'en' => 'images/gpt1.png',
                        ],
                        'icon_alt' => [
                            'ru' => 'Иконка',
                            'kk' => 'Белгіше',
                            'en' => 'Icon',
                        ],
                    ],
                ],

                [
                    'page_key' => 'chat',
                    'section_key' => 'window',
                    'title' => 'Окно чата',
                    'description' => 'Настройки окна чата',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'Чат-поддержка',
                            'kk' => 'Чат-қолдау',
                            'en' => 'Chat support',
                        ],
                        'subtitle' => [
                            'ru' => 'Обычно отвечаем в течение дня',
                            'kk' => 'Әдетте күн ішінде жауап береміз',
                            'en' => 'We usually respond within a day',
                        ],
                        'close_label' => [
                            'ru' => 'Закрыть чат',
                            'kk' => 'Чатты жабу',
                            'en' => 'Close chat',
                        ],
                    ],
                ],

                [
                    'page_key' => 'chat',
                    'section_key' => 'welcome',
                    'title' => 'Приветствие в чате',
                    'description' => 'Настройки приветственного сообщения в чате',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'Добро пожаловать в поддержку!',
                            'kk' => 'Қолдау қызметіне қош келдіңіз!',
                            'en' => 'Welcome to support!',
                        ],
                        'description' => [
                            'ru' => 'Задайте свой вопрос, и мы ответим вам в ближайшее время.',
                            'kk' => 'Өз сұрағыңызды қойыңыз, біз сізге жақын арада жауап береміз.',
                            'en' => 'Ask your question and we will respond to you as soon as possible.',
                        ],
                        'notice' => [
                            'ru' => 'Ответ будет предоставлен в срок, установленный законодательством Республики Казахстан',
                            'kk' => 'Жауап Қазақстан Республикасының заңнамасымен белгіленген мерзімде беріледі',
                            'en' => 'The response will be provided within the timeframe established by the legislation of the Republic of Kazakhstan',
                        ],
                    ],
                ],

                [
                    'page_key' => 'chat',
                    'section_key' => 'input',
                    'title' => 'Поле ввода чата',
                    'description' => 'Настройки поля ввода сообщений',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'placeholder' => [
                            'ru' => 'Введите сообщение...',
                            'kk' => 'Хабарлама енгізіңіз...',
                            'en' => 'Enter message...',
                        ],
                        'send_label' => [
                            'ru' => 'Отправить сообщение',
                            'kk' => 'Хабарлама жіберу',
                            'en' => 'Send message',
                        ],
                    ],
                ],

                [
                    'page_key' => 'chat',
                    'section_key' => 'messages',
                    'title' => 'Сообщения чата',
                    'description' => 'Тексты сообщений в чате',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'send_error' => [
                            'ru' => 'Ошибка отправки сообщения. Попробуйте позже.',
                            'kk' => 'Хабарлама жіберу қатесі. Кейінірек қайталаңыз.',
                            'en' => 'Message sending error. Please try again later.',
                        ],
                    ],
                ],

                // ============================
                // ПОГОДА (WEATHER)
                // ============================
                [
                    'page_key' => 'weather',
                    'section_key' => 'widget',
                    'title' => 'Виджет погоды',
                    'description' => 'Настройки виджета погоды',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'alt_text' => [
                            'ru' => 'Погода',
                            'kk' => 'Ауа райы',
                            'en' => 'Weather',
                        ],
                        'city' => [
                            'ru' => 'Павлодар',
                            'kk' => 'Павлодар',
                            'en' => 'Pavlodar',
                        ],
                        'error_message' => [
                            'ru' => 'Не удалось загрузить данные о погоде',
                            'kk' => 'Ауа райы деректерін жүктеу мүмкін болмады',
                            'en' => 'Failed to load weather data',
                        ],
                    ],
                ],

                // ============================
                // УВЕДОМЛЕНИЯ (NOTIFICATIONS)
                // ============================
                [
                    'page_key' => 'notifications',
                    'section_key' => 'offline',
                    'title' => 'Офлайн уведомление',
                    'description' => 'Уведомление об отсутствии интернета',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Нет подключения к интернету',
                            'kk' => 'Интернет байланысы жоқ',
                            'en' => 'No internet connection',
                        ],
                    ],
                ],

                // ============================
                // ПОИСК (SEARCH)
                // ============================
                [
                    'page_key' => 'search',
                    'section_key' => 'results',
                    'title' => 'Результаты поиска',
                    'description' => 'Настройки результатов поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'no_results' => [
                            'ru' => 'По вашему запросу ничего не найдено',
                            'kk' => 'Сіздің сұранысыңыз бойынша ештеңе табылмады',
                            'en' => 'Nothing found for your query',
                        ],
                        'default_badge' => [
                            'ru' => 'Результат',
                            'kk' => 'Нәтиже',
                            'en' => 'Result',
                        ],
                        'news_badge' => [
                            'ru' => 'Новость',
                            'kk' => 'Жаңалық',
                            'en' => 'News',
                        ],
                        'blog_badge' => [
                            'ru' => 'Блог',
                            'kk' => 'Блог',
                            'en' => 'Blog',
                        ],
                        'staff_badge' => [
                            'ru' => 'Сотрудник',
                            'kk' => 'Қызметкер',
                            'en' => 'Staff',
                        ],
                        'vacancy_badge' => [
                            'ru' => 'Вакансия',
                            'kk' => 'Бос орын',
                            'en' => 'Vacancy',
                        ],
                        'page_badge' => [
                            'ru' => 'Страница',
                            'kk' => 'Бет',
                            'en' => 'Page',
                        ],
                        'error_message' => [
                            'ru' => 'Ошибка при выполнении поиска',
                            'kk' => 'Іздеуді орындау кезіндегі қате',
                            'en' => 'Search execution error',
                        ],
                        'show_all' => [
                            'ru' => 'Показать все результаты',
                            'kk' => 'Барлық нәтижелерді көрсету',
                            'en' => 'Show all results',
                        ],
                    ],
                ],

                // ============================
                // COOKIES
                // ============================
                [
                    'page_key' => 'cookies',
                    'section_key' => 'banner',
                    'title' => 'Баннер cookies',
                    'description' => 'Настройки баннера согласия на cookies',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'text' => [
                            'ru' => 'Данный сайт использует файлы cookie, которые помогают его функционированию и помогают нам понять, как пользователи взаимодействуют с ним. Мы используем эти файлы cookie, чтобы предоставить вам улучшенный и индивидуальный пользовательский интерфейс. Если Вы продолжаете пользоваться сайтом, мы предполагаем, что Вы согласны с этим.',
                            'kk' => 'Бұл сайт оның жұмысына көмектесетін және пайдаланушылар онымен қалай өзара әрекеттесетінін түсінуге көмектесетін cookie файлдарын пайдаланады. Біз сізге жақсартылған және жекелендірілген пайдаланушы интерфейсін ұсыну үшін осы cookie файлдарын пайдаланамыз. Егер сіз сайтты пайдалануды жалғастыратын болсаңыз, біз сіздің келісіміңіз бар деп есептейміз.',
                            'en' => 'This site uses cookies that help its functioning and help us understand how users interact with it. We use these cookies to provide you with an improved and personalized user interface. If you continue to use the site, we assume that you agree to this.',
                        ],
                        'button_text' => [
                            'ru' => 'Принять',
                            'kk' => 'Қабылдау',
                            'en' => 'Accept',
                        ],
                    ],
                ],

                // ============================
                // СООБЩЕНИЕ ОБ ОШИБКАХ (BUG REPORT)
                // ============================
                [
                    'page_key' => 'bug_report',
                    'section_key' => 'modal',
                    'title' => 'Модальное окно сообщения об ошибках',
                    'description' => 'Настройки модального окна для сообщения об ошибках',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Сообщить об ошибке на сайте',
                            'kk' => 'Сайттағы қате туралы хабарлау',
                            'en' => 'Report a bug on the site',
                        ],
                    ],
                ],

                [
                    'page_key' => 'bug_report',
                    'section_key' => 'form',
                    'title' => 'Форма сообщения об ошибках',
                    'description' => 'Настройки формы сообщения об ошибках',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'full_name_label' => [
                            'ru' => 'Ваше ФИО',
                            'kk' => 'Сіздің аты-жөніңіз',
                            'en' => 'Your full name',
                        ],
                        'email_label' => [
                            'ru' => 'E-mail',
                            'kk' => 'E-mail',
                            'en' => 'E-mail',
                        ],
                        'phone_label' => [
                            'ru' => 'Телефон',
                            'kk' => 'Телефон',
                            'en' => 'Phone',
                        ],
                        'page_url_label' => [
                            'ru' => 'URL страницы с ошибкой',
                            'kk' => 'Қате бар беттің URL мекенжайы',
                            'en' => 'URL of the page with error',
                        ],
                        'title_label' => [
                            'ru' => 'Краткое описание ошибки',
                            'kk' => 'Қатенің қысқаша сипаттамасы',
                            'en' => 'Brief error description',
                        ],
                        'title_placeholder' => [
                            'ru' => 'Например: "Не открывается страница контактов" или "Ошибка в форме отправки"',
                            'kk' => 'Мысалы: "Байланыс парағы ашылмайды" немесе "Жіберу формасында қате"',
                            'en' => 'For example: "Contact page does not open" or "Error in submission form"',
                        ],
                        'description_label' => [
                            'ru' => 'Подробное описание ошибки',
                            'kk' => 'Қатенің егжей-тегжейлі сипаттамасы',
                            'en' => 'Detailed error description',
                        ],
                        'description_placeholder' => [
                            'ru' => 'Опишите ошибку максимально подробно. Что вы делали, когда возникла ошибка? Что ожидали увидеть и что увидели вместо этого?',
                            'kk' => 'Қатені мүмкіндігінше егжей-тегжейлі сипаттаңыз. Қате пайда болған кезде не істедіңіз? Нені күттіңіз және оның орнына не көрдіңіз?',
                            'en' => 'Describe the error in as much detail as possible. What were you doing when the error occurred? What did you expect to see and what did you see instead?',
                        ],
                        'expected_result_label' => [
                            'ru' => 'Ожидаемый результат',
                            'kk' => 'Күтілетін нәтиже',
                            'en' => 'Expected result',
                        ],
                        'expected_result_placeholder' => [
                            'ru' => 'Что должно было произойти?',
                            'kk' => 'Не болуы керек еді?',
                            'en' => 'What should have happened?',
                        ],
                        'actual_result_label' => [
                            'ru' => 'Фактический результат',
                            'kk' => 'Нақты нәтиже',
                            'en' => 'Actual result',
                        ],
                        'actual_result_placeholder' => [
                            'ru' => 'Что произошло на самом деле?',
                            'kk' => 'Шын мәнінде не болды?',
                            'en' => 'What actually happened?',
                        ],
                        'steps_label' => [
                            'ru' => 'Шаги для воспроизведения ошибки',
                            'kk' => 'Қатені қайталау үшін қадамдар',
                            'en' => 'Steps to reproduce the error',
                        ],
                        'add_step_button' => [
                            'ru' => 'Добавить шаг',
                            'kk' => 'Қадам қосу',
                            'en' => 'Add step',
                        ],
                        'step_placeholder' => [
                            'ru' => 'Опишите шаг...',
                            'kk' => 'Қадамды сипаттаңыз...',
                            'en' => 'Describe the step...',
                        ],
                        'priority_label' => [
                            'ru' => 'Приоритет ошибки',
                            'kk' => 'Қатенің басымдылығы',
                            'en' => 'Error priority',
                        ],
                        'priority_medium' => [
                            'ru' => 'Средний (функционал работает, но есть проблемы)',
                            'kk' => 'Орташа (функционал жұмыс істейді, бірақ проблемалар бар)',
                            'en' => 'Medium (functionality works but has problems)',
                        ],
                        'priority_high' => [
                            'ru' => 'Высокий (серьезная проблема, мешающая использованию)',
                            'kk' => 'Жоғары (пайдалануға кедергі келтіретін басты мәселе)',
                            'en' => 'High (serious problem preventing usage)',
                        ],
                        'priority_critical' => [
                            'ru' => 'Критический (сайт не работает)',
                            'kk' => 'Сыни (сайт жұмыс істемейді)',
                            'en' => 'Critical (site does not work)',
                        ],
                        'priority_low' => [
                            'ru' => 'Низкий (косметическая проблема)',
                            'kk' => 'Төмен (косметикалық мәселе)',
                            'en' => 'Low (cosmetic problem)',
                        ],
                        'tech_info_title' => [
                            'ru' => 'Техническая информация (собирается автоматически)',
                            'kk' => 'Техникалық ақпарат (автоматты түрде жинақталады)',
                            'en' => 'Technical information (collected automatically)',
                        ],
                        'browser_label' => [
                            'ru' => 'Браузер:',
                            'kk' => 'Браузер:',
                            'en' => 'Browser:',
                        ],
                        'os_label' => [
                            'ru' => 'ОС:',
                            'kk' => 'ЖҚ:',
                            'en' => 'OS:',
                        ],
                        'device_label' => [
                            'ru' => 'Устройство:',
                            'kk' => 'Құрылғы:',
                            'en' => 'Device:',
                        ],
                        'detecting_text' => [
                            'ru' => 'Определяется...',
                            'kk' => 'Анықталуда...',
                            'en' => 'Detecting...',
                        ],
                        'time_label' => [
                            'ru' => 'Время:',
                            'kk' => 'Уақыт:',
                            'en' => 'Time:',
                        ],
                        'device_mobile' => [
                            'ru' => 'Мобильное',
                            'kk' => 'Мобильді',
                            'en' => 'Mobile',
                        ],
                        'device_tablet' => [
                            'ru' => 'Планшет',
                            'kk' => 'Планшет',
                            'en' => 'Tablet',
                        ],
                        'device_desktop' => [
                            'ru' => 'Компьютер',
                            'kk' => 'Компьютер',
                            'en' => 'Computer',
                        ],
                        'unknown_browser' => [
                            'ru' => 'Неизвестный браузер',
                            'kk' => 'Белгісіз браузер',
                            'en' => 'Unknown browser',
                        ],
                        'unknown_os' => [
                            'ru' => 'Неизвестная ОС',
                            'kk' => 'Белгісіз ЖҚ',
                            'en' => 'Unknown OS',
                        ],
                        'submit_button' => [
                            'ru' => 'Отправить отчет',
                            'kk' => 'Есеп жіберу',
                            'en' => 'Send report',
                        ],
                        'sending_text' => [
                            'ru' => 'Отправка...',
                            'kk' => 'Жіберілуде...',
                            'en' => 'Sending...',
                        ],
                        'cancel_button' => [
                            'ru' => 'Отмена',
                            'kk' => 'Бас тарту',
                            'en' => 'Cancel',
                        ],
                    ],
                ],

                [
                    'page_key' => 'bug_report',
                    'section_key' => 'messages',
                    'title' => 'Сообщения формы ошибок',
                    'description' => 'Сообщения для формы сообщения об ошибках',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'success' => [
                            'ru' => 'Спасибо за ваш отчет! Мы рассмотрим его в ближайшее время.',
                            'kk' => 'Есепіңіз үшін рахмет! Біз оны жақын арада қарастырамыз.',
                            'en' => 'Thank you for your report! We will review it as soon as possible.',
                        ],
                        'generic_error' => [
                            'ru' => 'Произошла ошибка при отправке отчета',
                            'kk' => 'Есеп жіберу кезінде қате орын алды',
                            'en' => 'An error occurred while sending the report',
                        ],
                        'network_error' => [
                            'ru' => 'Произошла ошибка сети. Попробуйте позже.',
                            'kk' => 'Желі қатесі орын алды. Кейінірек қайталаңыз.',
                            'en' => 'Network error occurred. Please try again later.',
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
                    Log::info("Создана многоязычная секция: {$section['page_key']}.{$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    $multilangIcon = $section['is_multilang'] ? '🌍' : '📝';
                    
                    Log::info("  - {$multilangIcon} {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания секции {$section['page_key']}.{$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания секции {$section['page_key']}.{$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных секций: {$createdCount} из " . count($sections));
            $this->command->info("✅ Глобальные и навигационные секции шаблона успешно созданы!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Основные разделы:");
                
                // Группируем по page_key для красивого вывода
                $groupedSections = [];
                foreach ($sections as $section) {
                    $groupedSections[$section['page_key']][] = $section;
                }
                
                foreach ($groupedSections as $pageKey => $pageSections) {
                    $pageName = match($pageKey) {
                        'global' => '🌐 Глобальные настройки',
                        'header' => '🚀 Шапка сайта',
                        'navigation' => '📍 Навигация',
                        'modals' => '📱 Модальные окна',
                        'chat' => '💬 Чат-поддержка',
                        'weather' => '🌤️ Погода',
                        'notifications' => '🔔 Уведомления',
                        'search' => '🔍 Поиск',
                        'cookies' => '🍪 Cookies',
                        'bug_report' => '🐛 Сообщения об ошибках',
                        default => $pageKey
                    };
                    
                    $this->command->info("   {$pageName}:");
                    foreach ($pageSections as $section) {
                        $langIcon = $section['is_multilang'] ? '🌍' : '📝';
                        $this->command->info("     {$langIcon} {$section['title']} ({$section['section_key']})");
                    }
                }
                
                $this->command->info("\n🏗️ Структура секций:");
                $this->command->info("   🚀 Шапка сайта: Логотипы, меню, соцсети, языки");
                $this->command->info("   📍 Навигация: Главное меню, подменю, разделы");
                $this->command->info("   📱 Модальные окна: PDF, Call-центр, консультации, контакты");
                $this->command->info("   💬 Чат: Робот-ассистент, окно чата, сообщения");
                $this->command->info("   🌤️ Погода: Виджет погоды");
                $this->command->info("   🔔 Уведомления: Офлайн уведомления");
                $this->command->info("   🔍 Поиск: Результаты поиска");
                $this->command->info("   🍪 Cookies: Баннер согласия");
                $this->command->info("   🐛 Ошибки: Форма сообщения об ошибках");
                $this->command->info("   🌐 Глобальные: Метаданные сайта");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}