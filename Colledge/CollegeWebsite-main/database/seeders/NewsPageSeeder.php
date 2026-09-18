<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class NewsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Новостей...');
            
            // Удаляем старые записи для страницы news
            $deleted = PageSection::where('page_key', 'news')->delete();
            Log::info("Удалено старых записей News: {$deleted}");
            
            $sections = [
                // Метаданные страницы
                [
                    'page_key' => 'news',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы Новости',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Новости',
                            'kk' => 'Жаңалықтар',
                            'en' => 'News',
                        ],
                        'meta_title' => [
                            'ru' => 'Новости колледжа | Технический колледж современных технологий',
                            'kk' => 'Колледж жаңалықтары | Заманауи технологиялардың техникалық колледжі',
                            'en' => 'College News | Technical College of Modern Technologies',
                        ],
                        'meta_description' => [
                            'ru' => 'Актуальные новости и события Технического колледжа современных технологий. Следите за обновлениями, мероприятиями и достижениями студентов.',
                            'kk' => 'Заманауи технологиялардың техникалық колледжінің өзекті жаңалықтары мен оқиғалары. Жаңартулар, іс-шаралар және студенттердің жетістіктеріне куә болыңыз.',
                            'en' => 'Current news and events of the Technical College of Modern Technologies. Stay updated with events, activities and student achievements.',
                        ],
                    ],
                ],
                
                // Заголовок секции
                [
                    'page_key' => 'news',
                    'section_key' => 'header',
                    'title' => 'Заголовок секции',
                    'description' => 'Основной заголовок и описание новостей',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'title' => [
                            'ru' => 'News',
                            'kk' => 'Жаңалықтар',
                            'en' => 'News',
                        ],
                        'subtitle' => [
                            'ru' => 'Коммуникационный центр',
                            'kk' => 'Коммуникациялық орталық',
                            'en' => 'Communication Center',
                        ],
                        'description' => [
                            'ru' => 'Последняя, ознакомьтесь с новостной рассылкой и не пропустите важные обновления',
                            'kk' => 'Соңғы, жаңалықтарға жазылыңыз және маңызды жаңартуларды жіберіп алмаңыз',
                            'en' => 'Latest, subscribe to our news and don\'t miss important updates',
                        ],
                        'link_text' => [
                            'ru' => 'Читать все новости',
                            'kk' => 'Барлық жаңалықтарды оқу',
                            'en' => 'Read all news',
                        ],
                    ],
                ],
                
                // Фоновое изображение
                [
                    'page_key' => 'news',
                    'section_key' => 'background',
                    'title' => 'Фоновое изображение',
                    'description' => 'Фоновая картинка для секции новостей',
                    'is_active' => true,
                    'is_multilang' => false,
                    'sort_order' => 3,
                    'content' => [
                        'image_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop',
                        'image_alt' => 'Background',
                    ],
                ],
                
                // Главная новость (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'featured',
                    'title' => 'Главная новость',
                    'description' => 'Настройки для главной новости (десктоп версия)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'tag_text' => [
                            'ru' => 'INFO | TODAY',
                            'kk' => 'АҚПАРАТ | БҮГІН',
                            'en' => 'INFO | TODAY',
                        ],
                        'button_text' => [
                            'ru' => 'Читать',
                            'kk' => 'Оқу',
                            'en' => 'Read',
                        ],
                        'fallback_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                        ],
                    ],
                ],
                
                // Маленькие карточки новостей (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'small_cards',
                    'title' => 'Маленькие карточки новостей',
                    'description' => 'Настройки для маленьких карточек новостей (десктоп)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'tag_text' => [
                            'ru' => 'INFO',
                            'kk' => 'АҚПАРАТ',
                            'en' => 'INFO',
                        ],
                        'button_text' => [
                            'ru' => 'Читать',
                            'kk' => 'Оқу',
                            'en' => 'Read',
                        ],
                        'fallback_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                        ],
                    ],
                ],
                
                // Пустое состояние маленьких карточек (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'small_cards_empty',
                    'title' => 'Пустое состояние маленьких карточек',
                    'description' => 'Текст при отсутствии новостей в маленьких карточках',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'no_news_text' => [
                            'ru' => 'Нет новости',
                            'kk' => 'Жаңалық жоқ',
                            'en' => 'No news',
                        ],
                    ],
                ],
                
                // Календарь новостей (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar',
                    'title' => 'Календарь новостей',
                    'description' => 'Настройки календаря новостей (десктоп)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Календарь новостей',
                            'kk' => 'Жаңалықтар күнтізбесі',
                            'en' => 'News Calendar',
                        ],
                        'subtitle' => [
                            'ru' => 'Выберите месяц для просмотра',
                            'kk' => 'Көру үшін айды таңдаңыз',
                            'en' => 'Select month to view',
                        ],
                        'prev_button_label' => [
                            'ru' => 'Предыдущий месяц',
                            'kk' => 'Алдыңғы ай',
                            'en' => 'Previous month',
                        ],
                        'next_button_label' => [
                            'ru' => 'Следующий месяц',
                            'kk' => 'Келесі ай',
                            'en' => 'Next month',
                        ],
                    ],
                ],
                
                // Дни недели для календаря (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar_days',
                    'title' => 'Дни недели календаря',
                    'description' => 'Названия дней недели для календаря (десктоп)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'пн' => [
                            'ru' => 'Пн',
                            'kk' => 'Дс',
                            'en' => 'Mo',
                        ],
                        'вт' => [
                            'ru' => 'Вт',
                            'kk' => 'Сс',
                            'en' => 'Tu',
                        ],
                        'ср' => [
                            'ru' => 'Ср',
                            'kk' => 'Ср',
                            'en' => 'We',
                        ],
                        'чт' => [
                            'ru' => 'Чт',
                            'kk' => 'Бс',
                            'en' => 'Th',
                        ],
                        'пт' => [
                            'ru' => 'Пт',
                            'kk' => 'Жм',
                            'en' => 'Fr',
                        ],
                        'сб' => [
                            'ru' => 'Сб',
                            'kk' => 'Сб',
                            'en' => 'Sa',
                        ],
                        'вс' => [
                            'ru' => 'Вс',
                            'kk' => 'Жс',
                            'en' => 'Su',
                        ],
                    ],
                ],
                
                // Названия месяцев для календаря
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar_months',
                    'title' => 'Названия месяцев',
                    'description' => 'Названия месяцев для табов календаря',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'январь' => [
                            'ru' => 'Январь',
                            'kk' => 'Қаңтар',
                            'en' => 'January',
                        ],
                        'февраль' => [
                            'ru' => 'Февраль',
                            'kk' => 'Ақпан',
                            'en' => 'February',
                        ],
                        'март' => [
                            'ru' => 'Март',
                            'kk' => 'Наурыз',
                            'en' => 'March',
                        ],
                        'апрель' => [
                            'ru' => 'Апрель',
                            'kk' => 'Сәуір',
                            'en' => 'April',
                        ],
                        'май' => [
                            'ru' => 'Май',
                            'kk' => 'Мамыр',
                            'en' => 'May',
                        ],
                        'июнь' => [
                            'ru' => 'Июнь',
                            'kk' => 'Маусым',
                            'en' => 'June',
                        ],
                        'июль' => [
                            'ru' => 'Июль',
                            'kk' => 'Шілде',
                            'en' => 'July',
                        ],
                        'август' => [
                            'ru' => 'Август',
                            'kk' => 'Тамыз',
                            'en' => 'August',
                        ],
                        'сентябрь' => [
                            'ru' => 'Сентябрь',
                            'kk' => 'Қыркүйек',
                            'en' => 'September',
                        ],
                        'октябрь' => [
                            'ru' => 'Октябрь',
                            'kk' => 'Қазан',
                            'en' => 'October',
                        ],
                        'ноябрь' => [
                            'ru' => 'Ноябрь',
                            'kk' => 'Қараша',
                            'en' => 'November',
                        ],
                        'декабрь' => [
                            'ru' => 'Декабрь',
                            'kk' => 'Желтоқсан',
                            'en' => 'December',
                        ],
                    ],
                ],
                
                // Новости дня в календаре (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar_news',
                    'title' => 'Новости дня в календаре',
                    'description' => 'Настройки блока новостей дня (десктоп)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 10,
                    'content' => [
                        'daily_news_title' => [
                            'ru' => 'Новости дня',
                            'kk' => 'Күннің жаңалықтары',
                            'en' => 'Daily News',
                        ],
                        'select_date_text' => [
                            'ru' => 'Выберите дату в календаре',
                            'kk' => 'Күнтізбеде күнді таңдаңыз',
                            'en' => 'Select date in calendar',
                        ],
                        'fallback' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                        ],
                    ],
                ],
                
                // Текст "нет новостей" в календаре
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar_no_news',
                    'title' => 'Текст "нет новостей" в календаре',
                    'description' => 'Текст при отсутствии новостей на выбранную дату',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 11,
                    'content' => [
                        'text' => [
                            'ru' => 'На эту дату новостей нет',
                            'kk' => 'Бұл күнде жаңалықтар жоқ',
                            'en' => 'No news for this date',
                        ],
                    ],
                ],
                
                // Статистика в календаре (десктоп)
                [
                    'page_key' => 'news',
                    'section_key' => 'calendar_stats',
                    'title' => 'Статистика в календаре',
                    'description' => 'Статистика и ссылки в календаре (десктоп)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 12,
                    'content' => [
                        'total_news_text' => [
                            'ru' => 'новостей всего',
                            'kk' => 'барлығы жаңалық',
                            'en' => 'total news',
                        ],
                        'all_link_text' => [
                            'ru' => 'Все',
                            'kk' => 'Барлығы',
                            'en' => 'All',
                        ],
                        'archive_button_text' => [
                            'ru' => 'Весь архив',
                            'kk' => 'Бүкіл мұрағат',
                            'en' => 'Full Archive',
                        ],
                    ],
                ],
                
                // Главная новость (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_featured',
                    'title' => 'Главная новость (мобильная)',
                    'description' => 'Настройки для главной новости (мобильная версия)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 13,
                    'content' => [
                        'tag_text' => [
                            'ru' => 'INFO | TODAY',
                            'kk' => 'АҚПАРАТ | БҮГІН',
                            'en' => 'INFO | TODAY',
                        ],
                        'button_text' => [
                            'ru' => 'Читать',
                            'kk' => 'Оқу',
                            'en' => 'Read',
                        ],
                        'fallback_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                        ],
                    ],
                ],
                
                // Маленькие карточки новостей (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_small_cards',
                    'title' => 'Маленькие карточки новостей (мобильная)',
                    'description' => 'Настройки для маленьких карточек новостей (мобильная)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 14,
                    'content' => [
                        'tag_text' => [
                            'ru' => 'INFO',
                            'kk' => 'АҚПАРАТ',
                            'en' => 'INFO',
                        ],
                        'button_text' => [
                            'ru' => 'Читать',
                            'kk' => 'Оқу',
                            'en' => 'Read',
                        ],
                        'fallback_image' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
                        ],
                    ],
                ],
                
                // Пустое состояние маленьких карточек (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_small_cards_empty',
                    'title' => 'Пустое состояние маленьких карточек (мобильная)',
                    'description' => 'Текст при отсутствии новостей в маленьких карточках (мобильная)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 15,
                    'content' => [
                        'no_news_text' => [
                            'ru' => 'Нет новости',
                            'kk' => 'Жаңалық жоқ',
                            'en' => 'No news',
                        ],
                    ],
                ],
                
                // Календарь новостей (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_calendar',
                    'title' => 'Календарь новостей (мобильная)',
                    'description' => 'Настройки календаря новостей (мобильная версия)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 16,
                    'content' => [
                        'title' => [
                            'ru' => 'Календарь новостей',
                            'kk' => 'Жаңалықтар күнтізбесі',
                            'en' => 'News Calendar',
                        ],
                        'subtitle' => [
                            'ru' => 'Выберите месяц для просмотра',
                            'kk' => 'Көру үшін айды таңдаңыз',
                            'en' => 'Select month to view',
                        ],
                        'prev_button_label' => [
                            'ru' => 'Предыдущий месяц',
                            'kk' => 'Алдыңғы ай',
                            'en' => 'Previous month',
                        ],
                        'next_button_label' => [
                            'ru' => 'Следующий месяц',
                            'kk' => 'Келесі ай',
                            'en' => 'Next month',
                        ],
                    ],
                ],
                
                // Дни недели для календаря (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_calendar_days',
                    'title' => 'Дни недели календаря (мобильная)',
                    'description' => 'Названия дней недели для календаря (мобильная)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 17,
                    'content' => [
                        'пн' => [
                            'ru' => 'Пн',
                            'kk' => 'Дс',
                            'en' => 'Mo',
                        ],
                        'вт' => [
                            'ru' => 'Вт',
                            'kk' => 'Сс',
                            'en' => 'Tu',
                        ],
                        'ср' => [
                            'ru' => 'Ср',
                            'kk' => 'Ср',
                            'en' => 'We',
                        ],
                        'чт' => [
                            'ru' => 'Чт',
                            'kk' => 'Бс',
                            'en' => 'Th',
                        ],
                        'пт' => [
                            'ru' => 'Пт',
                            'kk' => 'Жм',
                            'en' => 'Fr',
                        ],
                        'сб' => [
                            'ru' => 'Сб',
                            'kk' => 'Сб',
                            'en' => 'Sa',
                        ],
                        'вс' => [
                            'ru' => 'Вс',
                            'kk' => 'Жс',
                            'en' => 'Su',
                        ],
                    ],
                ],
                
                // Новости дня в календаре (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_calendar_news',
                    'title' => 'Новости дня в календаре (мобильная)',
                    'description' => 'Настройки блока новостей дня (мобильная версия)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 18,
                    'content' => [
                        'daily_news_title' => [
                            'ru' => 'Новости дня',
                            'kk' => 'Күннің жаңалықтары',
                            'en' => 'Daily News',
                        ],
                        'select_date_text' => [
                            'ru' => 'Выберите дату в календаре',
                            'kk' => 'Күнтізбеде күнді таңдаңыз',
                            'en' => 'Select date in calendar',
                        ],
                        'fallback' => [
                            'ru' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                            'kk' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                            'en' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop',
                        ],
                    ],
                ],
                
                // Текст "нет новостей" в календаре (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_calendar_no_news',
                    'title' => 'Текст "нет новостей" в календаре (мобильная)',
                    'description' => 'Текст при отсутствии новостей на выбранную дату (мобильная)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 19,
                    'content' => [
                        'text' => [
                            'ru' => 'На эту дату новостей нет',
                            'kk' => 'Бұл күнде жаңалықтар жоқ',
                            'en' => 'No news for this date',
                        ],
                    ],
                ],
                
                // Статистика в календаре (мобильная)
                [
                    'page_key' => 'news',
                    'section_key' => 'mobile_calendar_stats',
                    'title' => 'Статистика в календаре (мобильная)',
                    'description' => 'Статистика и ссылки в календаре (мобильная версия)',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 20,
                    'content' => [
                        'total_news_text' => [
                            'ru' => 'новостей всего',
                            'kk' => 'барлығы жаңалық',
                            'en' => 'total news',
                        ],
                        'all_link_text' => [
                            'ru' => 'Все',
                            'kk' => 'Барлығы',
                            'en' => 'All',
                        ],
                        'archive_button_text' => [
                            'ru' => 'Весь архив',
                            'kk' => 'Бүкіл мұрағат',
                            'en' => 'Full Archive',
                        ],
                    ],
                ],
                
                // Общее пустое состояние
                [
                    'page_key' => 'news',
                    'section_key' => 'empty_state',
                    'title' => 'Общее пустое состояние',
                    'description' => 'Текст когда нет новостей вообще',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 21,
                    'content' => [
                        'no_news_all_text' => [
                            'ru' => 'Новостей пока нет',
                            'kk' => 'Әзірше жаңалықтар жоқ',
                            'en' => 'No news yet',
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
                    Log::info("Создана News секция: {$section['section_key']}");
                    
                    $isMultilang = $section['is_multilang'] ? '🌍' : '📄';
                    $fieldsCount = count($section['content']);
                    Log::info("  - {$isMultilang} {$fieldsCount} полей, сортировка: {$section['sort_order']}");
                    
                } catch (\Exception $e) {
                    $errors[] = "Ошибка создания секции {$section['section_key']}: {$e->getMessage()}";
                    Log::error("Ошибка создания секции {$section['section_key']}: {$e->getMessage()}");
                }
            }
            
            if (!empty($errors)) {
                Log::warning('При сидировании News были ошибки:', $errors);
                $this->command->warn('⚠️  При сидировании News были ошибки:');
                foreach ($errors as $error) {
                    $this->command->warn("  - {$error}");
                }
            }
            
            Log::info("✅ Создано секций News: {$createdCount} из " . count($sections));
            $this->command->info("✅ Страница 'Новости' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Основные настройки:");
                $this->command->info("   🖼️  Фоновое изображение с эффектами");
                $this->command->info("   🗞️  Главная новость + 2 маленьких карточки");
                $this->command->info("   📅 Интерактивный календарь новостей");
                $this->command->info("   📱 Адаптивная мобильная версия");
                
                $this->command->info("\n📅 Функционал календаря:");
                $this->command->info("   📆 Навигация по месяцам и дням");
                $this->command->info("   📰 Просмотр новостей на выбранную дату");
                $this->command->info("   📊 Отображение статистики");
                
                $this->command->info("\n🎨 Особенности:");
                $this->command->info("   ✨ Анимированные эффекты");
                $this->command->info("   📱 Отзывчивый дизайн");
                $this->command->info("   ⚡ Оптимизированная производительность");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка сидирования News: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}