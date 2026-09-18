<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class YouthMovementPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Молодёжный движ...');
            
            // Удаляем старые записи для страницы youth_movement
            $deleted = PageSection::where('page_key', 'youth_movement')->delete();
            Log::info("Удалено старых записей Youth Movement: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Молодёжный движ',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'page_title' => [
                            'ru' => 'Молодёжный движ',
                            'kk' => 'Жастар қозғалысы',
                            'en' => 'Youth Movement',
                        ],
                        'meta_title' => [
                            'ru' => 'Молодёжный движ | Технический колледж современных технологий',
                            'kk' => 'Жастар қозғалысы | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'Youth Movement | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'События, клубы, объявления и активность для молодёжи. Присоединяйтесь к движению, которое меняет будущее!',
                            'kk' => 'Оқиғалар, клубтар, хабарландырулар және жастарға арналған белсенділік. Болашақты өзгертетін қозғалысқа қосылыңыз!',
                            'en' => 'Events, clubs, announcements and activities for youth. Join the movement that changes the future!',
                        ],
                    ],
                ],
                
                // Герой-секция
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'hero_header',
                    'title' => 'Герой-секция',
                    'description' => 'Верхний баннер с заголовком и описанием',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'hero_line_1' => [
                            'ru' => 'Молодежная политика',
                            'kk' => 'Жастар саясаты',
                            'en' => 'Youth Policy',
                        ],
                        'hero_line_2' => [
                            'ru' => 'Ивенты в колледже',
                            'kk' => 'Колледждегі іс-шаралар',
                            'en' => 'Events at College',
                        ],
                        'hero_badge_text' => [
                            'ru' => 'ГОД АКТИВНОСТИ',
                            'kk' => 'БЕЛСЕНДІЛІК ЖЫЛЫ',
                            'en' => 'YEAR OF ACTIVITY',
                        ],
                        'hero_main_title_line_1' => [
                            'ru' => 'Молодёжный',
                            'kk' => 'Жастар',
                            'en' => 'Youth',
                        ],
                        'hero_main_title_line_2' => [
                            'ru' => 'ДВИЖ',
                            'kk' => 'ҚОЗҒАЛЫС',
                            'en' => 'MOVEMENT',
                        ],
                        'hero_subtitle_start' => [
                            'ru' => 'Где рождаются',
                            'kk' => 'Қайда туындайды',
                            'en' => 'Where are born',
                        ],
                        'hero_highlight_1' => [
                            'ru' => 'инновации',
                            'kk' => 'инновациялар',
                            'en' => 'innovations',
                        ],
                        'hero_subtitle_middle' => [
                            'ru' => ', создаются',
                            'kk' => ', жасалады',
                            'en' => ', created',
                        ],
                        'hero_highlight_2' => [
                            'ru' => 'проекты',
                            'kk' => 'жобалар',
                            'en' => 'projects',
                        ],
                        'hero_subtitle_end' => [
                            'ru' => ' и меняется',
                            'kk' => ' және өзгереді',
                            'en' => ' and changes',
                        ],
                        'hero_highlight_3' => [
                            'ru' => 'будущее',
                            'kk' => 'болашақ',
                            'en' => 'future',
                        ],
                        'hero_button_text' => [
                            'ru' => 'Начать движение',
                            'kk' => 'Қозғалысты бастау',
                            'en' => 'Start movement',
                        ],
                    ],
                ],
                
                // Карусель событий
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'carousel_events',
                    'title' => 'Карусель событий',
                    'description' => 'Тексты для карусели и событий',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'carousel_badge_week' => [
                            'ru' => 'СОБЫТИЕ НЕДЕЛИ',
                            'kk' => 'АПТАНЫҢ ОҚИҒАСЫ',
                            'en' => 'EVENT OF THE WEEK',
                        ],
                        'carousel_badge_upcoming' => [
                            'ru' => 'БЛИЖАЙШЕЕ',
                            'kk' => 'ЖАҚЫНДАҒЫ',
                            'en' => 'UPCOMING',
                        ],
                        'carousel_badge_hot' => [
                            'ru' => 'ГОРЯЧЕЕ',
                            'kk' => 'ЫСТЫҚ',
                            'en' => 'HOT',
                        ],
                        'carousel_nav_prev' => [
                            'ru' => 'Предыдущее',
                            'kk' => 'Алдыңғы',
                            'en' => 'Previous',
                        ],
                        'carousel_nav_next' => [
                            'ru' => 'Следующее',
                            'kk' => 'Келесі',
                            'en' => 'Next',
                        ],
                        'event_location_default' => [
                            'ru' => 'Актовый зал',
                            'kk' => 'Актовый зал',
                            'en' => 'Assembly Hall',
                        ],
                        'event_place_unknown' => [
                            'ru' => 'Место уточняется',
                            'kk' => 'Орын нақтыланбады',
                            'en' => 'Venue TBD',
                        ],
                        'event_date_unknown' => [
                            'ru' => 'Дата уточняется',
                            'kk' => 'Күні нақтыланбады',
                            'en' => 'Date TBD',
                        ],
                    ],
                ],
                
                // Главное событие
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'featured_event',
                    'title' => 'Главное событие',
                    'description' => 'Тексты для главного события баннера',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'featured_badge' => [
                            'ru' => 'СОБЫТИЕ',
                            'kk' => 'ОҚИҒА',
                            'en' => 'EVENT',
                        ],
                        'timer_days_label' => [
                            'ru' => 'дней',
                            'kk' => 'күн',
                            'en' => 'days',
                        ],
                        'timer_hours_label' => [
                            'ru' => 'часов',
                            'kk' => 'сағат',
                            'en' => 'hours',
                        ],
                        'timer_minutes_label' => [
                            'ru' => 'минут',
                            'kk' => 'минут',
                            'en' => 'minutes',
                        ],
                        'event_button_text' => [
                            'ru' => 'Подробнее о событии',
                            'kk' => 'Оқиға туралы толығырақ',
                            'en' => 'More about event',
                        ],
                        'default_event_title' => [
                            'ru' => 'НОЧЬ НАУКИ',
                            'kk' => 'ҒЫЛЫМ ТҮНІ',
                            'en' => 'NIGHT OF SCIENCE',
                        ],
                        'default_event_description' => [
                            'ru' => 'Главное научное событие 2025 года! Эксперименты, лекции от ведущих ученых, интерактивные зоны и научные батлы. Стань частью технологической революции!',
                            'kk' => '2025 жылдың басты ғылыми оқиғасы! Эксперименттер, жетекші ғалымдардың дәрістері, интерактивті аймақтар және ғылыми батлдар. Технологиялық төңкерістің бөлігі бол!',
                            'en' => 'The main scientific event of 2025! Experiments, lectures from leading scientists, interactive zones and scientific battles. Become part of the technological revolution!',
                        ],
                    ],
                ],
                
                // Календарь событий
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'calendar',
                    'title' => 'Календарь событий',
                    'description' => 'Тексты для календаря и дней недели',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'calendar_title' => [
                            'ru' => 'Календарь событий',
                            'kk' => 'Оқиғалар күнтізбесі',
                            'en' => 'Events Calendar',
                        ],
                        'month_names' => [
                            'ru' => 'Январь,Февраль,Март,Апрель,Май,Июнь,Июль,Август,Сентябрь,Октябрь,Ноябрь,Декабрь',
                            'kk' => 'Қаңтар,Ақпан,Наурыз,Сәуір,Мамыр,Маусым,Шілде,Тамыз,Қыркүйек,Қазан,Қараша,Желтоқсан',
                            'en' => 'January,February,March,April,May,June,July,August,September,October,November,December',
                        ],
                        'weekdays' => [
                            'ru' => 'Пн,Вт,Ср,Чт,Пт,Сб,Вс',
                            'kk' => 'Дс,Сс,Ср,Бс,Жм,Сн,Жс',
                            'en' => 'Mon,Tue,Wed,Thu,Fri,Sat,Sun',
                        ],
                        'calendar_badge_text' => [
                            'ru' => 'Перейти к календарю',
                            'kk' => 'Күнтізбеге өту',
                            'en' => 'Go to calendar',
                        ],
                        'no_events_message' => [
                            'ru' => 'На выбранную дату событий не запланировано',
                            'kk' => 'Таңдалған күнге оқиғалар жоспарланбаған',
                            'en' => 'No events scheduled for selected date',
                        ],
                        'multiple_events_title' => [
                            'ru' => 'События на',
                            'kk' => 'Оқиғалар',
                            'en' => 'Events on',
                        ],
                        'multiple_events_desc' => [
                            'ru' => 'На этот день запланировано',
                            'kk' => 'Бұл күнге жоспарланған',
                            'en' => 'Scheduled for this day',
                        ],
                        'multiple_events_suffix' => [
                            'ru' => 'событий',
                            'kk' => 'оқиға',
                            'en' => 'events',
                        ],
                    ],
                ],
                
                // Объявления
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'announcements',
                    'title' => 'Объявления',
                    'description' => 'Тексты для раздела объявлений',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'announcements_title' => [
                            'ru' => 'Объявления',
                            'kk' => 'Хабарландырулар',
                            'en' => 'Announcements',
                        ],
                        'announcements_count_suffix' => [
                            'ru' => 'активных',
                            'kk' => 'белсенді',
                            'en' => 'active',
                        ],
                        'announcement_type_info' => [
                            'ru' => 'ИНФОРМАЦИЯ',
                            'kk' => 'АҚПАРАТ',
                            'en' => 'INFORMATION',
                        ],
                        'announcement_type_warning' => [
                            'ru' => 'ВНИМАНИЕ',
                            'kk' => 'НАЗАР АУДАРЫҢЫЗ',
                            'en' => 'WARNING',
                        ],
                        'announcement_type_success' => [
                            'ru' => 'УСПЕХ',
                            'kk' => 'СӘТТІЛІК',
                            'en' => 'SUCCESS',
                        ],
                        'announcement_type_danger' => [
                            'ru' => 'ВАЖНО',
                            'kk' => 'МАҢЫЗДЫ',
                            'en' => 'IMPORTANT',
                        ],
                        'announcement_type_default' => [
                            'ru' => 'ОБЪЯВЛЕНИЕ',
                            'kk' => 'ХАБАРЛАНДЫРУ',
                            'en' => 'ANNOUNCEMENT',
                        ],
                        'default_announcement_title' => [
                            'ru' => 'Нет активных объявлений',
                            'kk' => 'Белсенді хабарландырулар жоқ',
                            'en' => 'No active announcements',
                        ],
                        'default_announcement_content' => [
                            'ru' => 'Здесь будут появляться важные объявления для студентов.',
                            'kk' => 'Мұнда студенттерге арналған маңызды хабарландырулар пайда болады.',
                            'en' => 'Important announcements for students will appear here.',
                        ],
                        'add_announcement_title' => [
                            'ru' => 'Добавьте первое объявление',
                            'kk' => 'Бірінші хабарландыруды қосыңыз',
                            'en' => 'Add first announcement',
                        ],
                        'add_announcement_content' => [
                            'ru' => 'Используйте админ-панель для создания объявлений.',
                            'kk' => 'Хабарландырулар жасау үшін әкімші панелін пайдаланыңыз.',
                            'en' => 'Use admin panel to create announcements.',
                        ],
                    ],
                ],
                
                // Ближайшие события
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'upcoming_events',
                    'title' => 'Ближайшие события',
                    'description' => 'Тексты для раздела ближайших событий',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'upcoming_title' => [
                            'ru' => 'Ближайшие события',
                            'kk' => 'Жақындағы оқиғалар',
                            'en' => 'Upcoming Events',
                        ],
                        'month_names_short' => [
                            'ru' => 'Янв,Фев,Мар,Апр,Май,Июн,Июл,Авг,Сен,Окт,Ноя,Дек',
                            'kk' => 'Қан,Ақп,Нау,Сәу,Мам,Мау,Шіл,Там,Қыр,Қаз,Қар,Жел',
                            'en' => 'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
                        ],
                        'status_waiting' => [
                            'ru' => 'ОЖИДАЕТСЯ',
                            'kk' => 'КҮТІЛГЕН',
                            'en' => 'WAITING',
                        ],
                        'status_registration' => [
                            'ru' => 'РЕГИСТРАЦИЯ',
                            'kk' => 'ТІРКЕЛУ',
                            'en' => 'REGISTRATION',
                        ],
                        'status_hot' => [
                            'ru' => 'ГОРЯЧЕЕ',
                            'kk' => 'ЫСТЫҚ',
                            'en' => 'HOT',
                        ],
                        'status_active' => [
                            'ru' => 'АКТИВНО',
                            'kk' => 'БЕЛСЕНДІ',
                            'en' => 'ACTIVE',
                        ],
                        'demo_event_1_title' => [
                            'ru' => 'Киберспортивный турнир',
                            'kk' => 'Киберспорттық турнир',
                            'en' => 'Esports Tournament',
                        ],
                        'demo_event_1_time' => [
                            'ru' => '18:00',
                            'kk' => '18:00',
                            'en' => '18:00',
                        ],
                        'demo_event_1_location' => [
                            'ru' => 'Компьютерный класс',
                            'kk' => 'Компьютерлік сынып',
                            'en' => 'Computer Class',
                        ],
                        'demo_event_2_title' => [
                            'ru' => 'Театральный вечер',
                            'kk' => 'Театр кеші',
                            'en' => 'Theater Evening',
                        ],
                        'demo_event_2_time' => [
                            'ru' => '19:00',
                            'kk' => '19:00',
                            'en' => '19:00',
                        ],
                        'demo_event_2_location' => [
                            'ru' => 'Актовый зал',
                            'kk' => 'Актовый зал',
                            'en' => 'Assembly Hall',
                        ],
                        'demo_event_3_title' => [
                            'ru' => 'Ночь науки',
                            'kk' => 'Ғылым түні',
                            'en' => 'Night of Science',
                        ],
                        'demo_event_3_time' => [
                            'ru' => '18:00',
                            'kk' => '18:00',
                            'en' => '18:00',
                        ],
                        'demo_event_3_location' => [
                            'ru' => 'Главный корпус',
                            'kk' => 'Негізгі ғимарат',
                            'en' => 'Main Building',
                        ],
                        'demo_event_4_title' => [
                            'ru' => 'AI Хакатон',
                            'kk' => 'AI Хакатон',
                            'en' => 'AI Hackathon',
                        ],
                        'demo_event_4_time' => [
                            'ru' => '16:00',
                            'kk' => '16:00',
                            'en' => '16:00',
                        ],
                        'demo_event_4_location' => [
                            'ru' => 'IT-центр',
                            'kk' => 'IT-орталық',
                            'en' => 'IT Center',
                        ],
                    ],
                ],
                
                // Направления и клубы
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'clubs_directions',
                    'title' => 'Направления и клубы',
                    'description' => 'Тексты для раздела направлений и поиска',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'directions_title' => [
                            'ru' => 'Направления',
                            'kk' => 'Бағыттар',
                            'en' => 'Directions',
                        ],
                        'search_placeholder' => [
                            'ru' => 'Найти направление...',
                            'kk' => 'Бағыт табу...',
                            'en' => 'Find direction...',
                        ],
                        'category_all' => [
                            'ru' => 'Все',
                            'kk' => 'Барлығы',
                            'en' => 'All',
                        ],
                        'category_technology' => [
                            'ru' => 'Технологии',
                            'kk' => 'Технологиялар',
                            'en' => 'Technology',
                        ],
                        'category_art' => [
                            'ru' => 'Творчество',
                            'kk' => 'Шығармашылық',
                            'en' => 'Creativity',
                        ],
                        'category_sport' => [
                            'ru' => 'Спорт',
                            'kk' => 'Спорт',
                            'en' => 'Sport',
                        ],
                        'category_science' => [
                            'ru' => 'Наука',
                            'kk' => 'Ғылым',
                            'en' => 'Science',
                        ],
                        'category_music' => [
                            'ru' => 'Музыка',
                            'kk' => 'Музыка',
                            'en' => 'Music',
                        ],
                        'badge_recruiting' => [
                            'ru' => 'НАБОР',
                            'kk' => 'ҚАБЫЛДАУ',
                            'en' => 'RECRUITING',
                        ],
                        'badge_active' => [
                            'ru' => 'АКТИВНО',
                            'kk' => 'БЕЛСЕНДІ',
                            'en' => 'ACTIVE',
                        ],
                        'club_info_participants' => [
                            'ru' => 'Участников',
                            'kk' => 'Қатысушылар',
                            'en' => 'Participants',
                        ],
                        'club_info_schedule' => [
                            'ru' => 'Расписание',
                            'kk' => 'Кесте',
                            'en' => 'Schedule',
                        ],
                        'club_info_price' => [
                            'ru' => 'Стоимость',
                            'kk' => 'Бағасы',
                            'en' => 'Price',
                        ],
                        'club_button_text' => [
                            'ru' => 'Подробнее',
                            'kk' => 'Толығырақ',
                            'en' => 'More details',
                        ],
                        'club_free_price' => [
                            'ru' => 'Бесплатно',
                            'kk' => 'Тегін',
                            'en' => 'Free',
                        ],
                        'demo_club_1_title' => [
                            'ru' => 'AI Лаборатория',
                            'kk' => 'AI Зертханасы',
                            'en' => 'AI Laboratory',
                        ],
                        'demo_club_1_desc' => [
                            'ru' => 'Исследования в области искусственного интеллекта, машинного обучения и нейросетей.',
                            'kk' => 'Жасанды интеллект, машиналық оқыту және нейрондық желілер саласындағы зерттеулер.',
                            'en' => 'Research in artificial intelligence, machine learning and neural networks.',
                        ],
                        'demo_club_1_schedule' => [
                            'ru' => 'Пн/Ср 19:00',
                            'kk' => 'Дс/Ср 19:00',
                            'en' => 'Mon/Wed 19:00',
                        ],
                        'demo_club_2_title' => [
                            'ru' => 'Медиастудия',
                            'kk' => 'Медиа студиясы',
                            'en' => 'Media Studio',
                        ],
                        'demo_club_2_desc' => [
                            'ru' => 'Создание контента, видеопроизводство, блогинг и SMM для социальных сетей.',
                            'kk' => 'Контент жасау, видео өндірісі, блогерлік және әлеуметтік желілер үшін SMM.',
                            'en' => 'Content creation, video production, blogging and SMM for social networks.',
                        ],
                        'demo_club_2_schedule' => [
                            'ru' => 'Вт/Чт 18:00',
                            'kk' => 'Сс/Бс 18:00',
                            'en' => 'Tue/Thu 18:00',
                        ],
                        'demo_club_3_title' => [
                            'ru' => 'Уличные виды',
                            'kk' => 'Көше түрлері',
                            'en' => 'Street Sports',
                        ],
                        'demo_club_3_desc' => [
                            'ru' => 'Воркаут, скейтбординг, баскетбол и другие уличные спортивные направления.',
                            'kk' => 'Воркаут, скейтбординг, баскетбол және басқа көше спорт түрлері.',
                            'en' => 'Workout, skateboarding, basketball and other street sports.',
                        ],
                        'demo_club_3_schedule' => [
                            'ru' => 'Ежедневно',
                            'kk' => 'Күн сайын',
                            'en' => 'Daily',
                        ],
                        'demo_club_4_title' => [
                            'ru' => 'Исследовательский клуб',
                            'kk' => 'Зерттеушілер клубы',
                            'en' => 'Research Club',
                        ],
                        'demo_club_4_desc' => [
                            'ru' => 'Научные проекты, публикации и участие в конференциях по различным дисциплинам.',
                            'kk' => 'Әртүрлі пәндер бойынша ғылыми жобалар, жарияланымдар және конференцияларға қатысу.',
                            'en' => 'Scientific projects, publications and participation in conferences in various disciplines.',
                        ],
                        'demo_club_4_schedule' => [
                            'ru' => 'Пн/Пт 17:00',
                            'kk' => 'Дс/Жм 17:00',
                            'en' => 'Mon/Fri 17:00',
                        ],
                    ],
                ],
                
                // Модальные окна
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'modal_windows',
                    'title' => 'Модальные окна',
                    'description' => 'Тексты для всех модальных окон',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'modal_event_title' => [
                            'ru' => 'Детали события',
                            'kk' => 'Оқиға туралы мәліметтер',
                            'en' => 'Event Details',
                        ],
                        'modal_club_title' => [
                            'ru' => 'Детали направления',
                            'kk' => 'Бағыт туралы мәліметтер',
                            'en' => 'Direction Details',
                        ],
                        'modal_announcement_title' => [
                            'ru' => 'Объявление',
                            'kk' => 'Хабарландыру',
                            'en' => 'Announcement',
                        ],
                        'modal_close_title' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'modal_stat_participants' => [
                            'ru' => 'участников',
                            'kk' => 'қатысушы',
                            'en' => 'participants',
                        ],
                        'modal_stat_time' => [
                            'ru' => 'время',
                            'kk' => 'уақыт',
                            'en' => 'time',
                        ],
                        'modal_info_location' => [
                            'ru' => 'Место',
                            'kk' => 'Орын',
                            'en' => 'Location',
                        ],
                        'modal_info_organizer' => [
                            'ru' => 'Организатор',
                            'kk' => 'Ұйымдастырушы',
                            'en' => 'Organizer',
                        ],
                        'modal_info_type' => [
                            'ru' => 'Тип',
                            'kk' => 'Түрі',
                            'en' => 'Type',
                        ],
                        'modal_section_description' => [
                            'ru' => 'Описание события',
                            'kk' => 'Оқиға сипаттамасы',
                            'en' => 'Event Description',
                        ],
                        'modal_section_location' => [
                            'ru' => 'Место проведения',
                            'kk' => 'Өткізілетін орын',
                            'en' => 'Venue',
                        ],
                        'modal_section_instructor' => [
                            'ru' => 'Руководитель',
                            'kk' => 'Жетекші',
                            'en' => 'Instructor',
                        ],
                        'modal_section_content' => [
                            'ru' => 'Содержание',
                            'kk' => 'Мазмұны',
                            'en' => 'Content',
                        ],
                        'modal_button_register' => [
                            'ru' => 'Зарегистрироваться',
                            'kk' => 'Тіркелу',
                            'en' => 'Register',
                        ],
                        'modal_button_close' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'modal_not_found_title' => [
                            'ru' => 'Событие не найдено',
                            'kk' => 'Оқиға табылмады',
                            'en' => 'Event not found',
                        ],
                        'modal_not_found_message' => [
                            'ru' => 'Событие с указанным ID не найдено в загруженных данных.',
                            'kk' => 'Көрсетілген ID бар оқиға жүктелген деректерден табылмады.',
                            'en' => 'Event with specified ID not found in loaded data.',
                        ],
                        'demo_event_title' => [
                            'ru' => 'Ночь науки 2025',
                            'kk' => 'Ғылым түні 2025',
                            'en' => 'Night of Science 2025',
                        ],
                        'demo_event_description' => [
                            'ru' => 'Главное научное событие 2025 года! Эксперименты, лекции от ведущих ученых, интерактивные зоны и научные батлы. Стань частью технологической революции!',
                            'kk' => '2025 жылдың басты ғылыми оқиғасы! Эксперименттер, жетекші ғалымдардың дәрістері, интерактивті аймақтар және ғылыми батлдар. Технологиялық төңкерістің бөлігі бол!',
                            'en' => 'The main scientific event of 2025! Experiments, lectures from leading scientists, interactive zones and scientific battles. Become part of the technological revolution!',
                        ],
                        'demo_event_location' => [
                            'ru' => 'Актовый зал',
                            'kk' => 'Актовый зал',
                            'en' => 'Assembly Hall',
                        ],
                        'demo_event_organizer' => [
                            'ru' => 'Оргкомитет',
                            'kk' => 'Ұйымдастыру комитеті',
                            'en' => 'Organizing Committee',
                        ],
                        'demo_event_type' => [
                            'ru' => 'Главное событие',
                            'kk' => 'Негізгі оқиға',
                            'en' => 'Main Event',
                        ],
                        'demo_event_type_default' => [
                            'ru' => 'Событие',
                            'kk' => 'Оқиға',
                            'en' => 'Event',
                        ],
                    ],
                ],
                
                // Иконки и символы
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'icons_symbols',
                    'title' => 'Иконки и символы',
                    'description' => 'Названия иконок для доступности',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'icon_rocket' => [
                            'ru' => 'Ракета',
                            'kk' => 'Зымыран',
                            'en' => 'Rocket',
                        ],
                        'icon_play' => [
                            'ru' => 'Воспроизведение',
                            'kk' => 'Ойнау',
                            'en' => 'Play',
                        ],
                        'icon_fire' => [
                            'ru' => 'Огонь',
                            'kk' => 'От',
                            'en' => 'Fire',
                        ],
                        'icon_calendar' => [
                            'ru' => 'Календарь',
                            'kk' => 'Күнтізбе',
                            'en' => 'Calendar',
                        ],
                        'icon_map_marker' => [
                            'ru' => 'Метка на карте',
                            'kk' => 'Картадағы белгі',
                            'en' => 'Map Marker',
                        ],
                        'icon_users' => [
                            'ru' => 'Пользователи',
                            'kk' => 'Пайдаланушылар',
                            'en' => 'Users',
                        ],
                        'icon_user' => [
                            'ru' => 'Пользователь',
                            'kk' => 'Пайдаланушы',
                            'en' => 'User',
                        ],
                        'icon_info' => [
                            'ru' => 'Информация',
                            'kk' => 'Ақпарат',
                            'en' => 'Information',
                        ],
                        'icon_bullhorn' => [
                            'ru' => 'Громкоговоритель',
                            'kk' => 'Дыбыс күшейткіш',
                            'en' => 'Bullhorn',
                        ],
                        'icon_exclamation' => [
                            'ru' => 'Восклицание',
                            'kk' => 'Үндеу',
                            'en' => 'Exclamation',
                        ],
                        'icon_check' => [
                            'ru' => 'Галочка',
                            'kk' => 'Белгі',
                            'en' => 'Check',
                        ],
                        'icon_chevron_left' => [
                            'ru' => 'Стрелка влево',
                            'kk' => 'Солға бағытталған жебе',
                            'en' => 'Chevron Left',
                        ],
                        'icon_chevron_right' => [
                            'ru' => 'Стрелка вправо',
                            'kk' => 'Оңға бағытталған жебе',
                            'en' => 'Chevron Right',
                        ],
                        'icon_search' => [
                            'ru' => 'Поиск',
                            'kk' => 'Іздеу',
                            'en' => 'Search',
                        ],
                        'icon_arrow_right' => [
                            'ru' => 'Стрелка вправо',
                            'kk' => 'Оңға бағытталған жебе',
                            'en' => 'Arrow Right',
                        ],
                        'icon_times' => [
                            'ru' => 'Закрыть',
                            'kk' => 'Жабу',
                            'en' => 'Close',
                        ],
                        'icon_calendar_check' => [
                            'ru' => 'Календарь с галочкой',
                            'kk' => 'Белгімен күнтізбе',
                            'en' => 'Calendar with check',
                        ],
                    ],
                ],
                
                // Демо данные (fallback)
                [
                    'page_key' => 'youth_movement',
                    'section_key' => 'demo_fallback',
                    'title' => 'Демо данные и fallback',
                    'description' => 'Резервные данные для отображения при отсутствии реальных',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'demo_carousel_title_1' => [
                            'ru' => 'Ночь науки 2025',
                            'kk' => 'Ғылым түні 2025',
                            'en' => 'Night of Science 2025',
                        ],
                        'demo_carousel_desc_1' => [
                            'ru' => '25 ноября • 18:00 • Актовый зал',
                            'kk' => '25 Қараша • 18:00 • Актовый зал',
                            'en' => '25 November • 18:00 • Assembly Hall',
                        ],
                        'demo_carousel_title_2' => [
                            'ru' => 'Кибертурнир CS:GO',
                            'kk' => 'Кибертурнир CS:GO',
                            'en' => 'CS:GO Tournament',
                        ],
                        'demo_carousel_desc_2' => [
                            'ru' => '14 ноября • 18:00 • Компьютерный класс',
                            'kk' => '14 Қараша • 18:00 • Компьютерлік сынып',
                            'en' => '14 November • 18:00 • Computer Class',
                        ],
                        'demo_carousel_title_3' => [
                            'ru' => 'Театральный вечер',
                            'kk' => 'Театр кеші',
                            'en' => 'Theater Evening',
                        ],
                        'demo_carousel_desc_3' => [
                            'ru' => '20 ноября • 19:00 • Актовый зал',
                            'kk' => '20 Қараша • 19:00 • Актовый зал',
                            'en' => '20 November • 19:00 • Assembly Hall',
                        ],
                        'demo_featured_title' => [
                            'ru' => 'НОЧЬ НАУКИ 2025',
                            'kk' => 'ҒЫЛЫМ ТҮНІ 2025',
                            'en' => 'NIGHT OF SCIENCE 2025',
                        ],
                        'demo_featured_participants' => [
                            'ru' => '156',
                            'kk' => '156',
                            'en' => '156',
                        ],
                        'demo_event_title_cyber' => [
                            'ru' => 'Кибертурнир',
                            'kk' => 'Кибертурнир',
                            'en' => 'Esports Tournament',
                        ],
                        'demo_event_title_theater' => [
                            'ru' => 'Театральный вечер',
                            'kk' => 'Театр кеші',
                            'en' => 'Theater Evening',
                        ],
                        'demo_calendar_event_1' => [
                            'ru' => '25 ноября: Ночь науки',
                            'kk' => '25 Қараша: Ғылым түні',
                            'en' => '25 November: Night of Science',
                        ],
                        'demo_calendar_event_2' => [
                            'ru' => '14 ноября: Кибертурнир',
                            'kk' => '14 Қараша: Кибертурнир',
                            'en' => '14 November: Esports Tournament',
                        ],
                        'demo_calendar_event_3' => [
                            'ru' => '20 ноября: Театральный вечер',
                            'kk' => '20 Қараша: Театр кеші',
                            'en' => '20 November: Theater Evening',
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
                    Log::info("Создана многоязычная Youth Movement секция: {$section['section_key']}");
                    
                    $fieldsCount = count($section['content']);
                    Log::info("  - 🌍 {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании Youth Movement были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании Youth Movement были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано многоязычных секций Youth Movement: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Молодёжный движ' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🎉 Разделы страницы 'Молодёжный движ':");
                $this->command->info("   👑 Герой-секция с заголовком");
                $this->command->info("   🎬 Карусель событий");
                $this->command->info("   ⭐ Главное событие баннера");
                $this->command->info("   📅 Календарь событий");
                $this->command->info("   📢 Объявления");
                $this->command->info("   🗓️ Ближайшие события");
                $this->command->info("   🏆 Направления и клубы");
                $this->command->info("   💬 Модальные окна");
                $this->command->info("   🎨 Иконки и символы");
                $this->command->info("   🎭 Демо данные");
                $this->command->info("   ⚖️ SEO метаданные");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка Youth Movement: {$e->getMessage()}");
            $this->command->error("❌ Ошибка Youth Movement: {$e->getMessage()}");
            throw $e;
        }
    }
}