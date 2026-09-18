<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;

class StateSymbolsPageSeeder extends Seeder
{
    public function run(): void
    {
        try {
            Log::info('Начинаю сидирование многоязычной страницы Государственные символы...');
            
            // Удаляем старые записи для страницы state_symbols
            $deleted = PageSection::where('page_key', 'state_symbols')->delete();
            Log::info("Удалено старых записей State Symbols: {$deleted}");
            
            $sections = [
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'metadata',
                    'title' => 'Метаданные страницы',
                    'description' => 'SEO и общие настройки страницы',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 1,
                    'content' => [
                        'title' => [
                            'ru' => 'Государственные символы',
                            'kk' => 'Мемлекеттік рәміздер',
                            'en' => 'State Symbols',
                        ],
                        'meta_title' => [
                            'ru' => 'Государственные символы Казахстана | Официальные символы РК',
                            'kk' => 'Қазақстанның мемлекеттік рәміздері | РК ресми рәміздері',
                            'en' => 'State Symbols of Kazakhstan | Official Symbols of RK',
                        ],
                        'meta_description' => [
                            'ru' => 'Официальные государственные символы Республики Казахстан: флаг, герб, гимн. История создания, значение и правовая основа.',
                            'kk' => 'Қазақстан Республикасының ресми мемлекеттік рәміздері: ту, елтаңба, әнұран. Жасалу тарихы, мағынасы және құқықтық негізі.',
                            'en' => 'Official state symbols of the Republic of Kazakhstan: flag, coat of arms, anthem. History of creation, meaning and legal basis.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'header',
                    'title' => 'Заголовок страницы',
                    'description' => 'Основной заголовок и описание',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 2,
                    'content' => [
                        'main_title' => [
                            'ru' => 'Государственные символы',
                            'kk' => 'Мемлекеттік рәміздер',
                            'en' => 'State Symbols',
                        ],
                        'subtitle' => [
                            'ru' => 'Республики Казахстан',
                            'kk' => 'Қазақстан Республикасы',
                            'en' => 'of the Republic of Kazakhstan',
                        ],
                        'description' => [
                            'ru' => 'Официальные государственные символы, отражающие суверенитет и национальные ценности',
                            'kk' => 'Егемендік пен ұлттық құндылықтарды көрсететін ресми мемлекеттік рәміздер',
                            'en' => 'Official state symbols reflecting sovereignty and national values',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'flag',
                    'title' => 'Государственный флаг',
                    'description' => 'Информация о государственном флаге',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 3,
                    'content' => [
                        'title' => [
                            'ru' => 'Государственный флаг',
                            'kk' => 'Мемлекеттік ту',
                            'en' => 'State Flag',
                        ],
                        'image_url' => [
                            'ru' => 'images/flagrk.png',
                            'kk' => 'images/flagrk.png',
                            'en' => 'images/flagrk.png',
                        ],
                        'image_alt' => [
                            'ru' => 'Государственный флаг Казахстана',
                            'kk' => 'Қазақстанның мемлекеттік туы',
                            'en' => 'State flag of Kazakhstan',
                        ],
                        'download_url' => [
                            'ru' => 'images/flagrk.png',
                            'kk' => 'images/flagrk.png',
                            'en' => 'images/flagrk.png',
                        ],
                        'download_text' => [
                            'ru' => 'Скачать флаг',
                            'kk' => 'Туды жүктеу',
                            'en' => 'Download flag',
                        ],
                        'dimensions' => [
                            'ru' => 'Соотношение сторон: 1:2',
                            'kk' => 'Қатынасы: 1:2',
                            'en' => 'Aspect ratio: 1:2',
                        ],
                        'description_1' => [
                            'ru' => 'Флаг – это один из главных символов государства, олицетворяющий его суверенитет и идентичность. Термин «флаг» происходит от нидерландского слова «vlag». Флаг - это прикрепленное к древку или шнуру полотнище установленных размеров и цветов, обычно с изображением на нем герба или эмблемы.',
                            'kk' => 'Ту – мемлекеттің егемендігі мен сәйкестігін білдіретін негізгі рәміздердің бірі. «Ту» термині нидерланд тіліндегі «vlag» сөзінен шыққан. Ту – белгіленген өлшемдері мен түстері бар, әдетте оның үстіне елтаңба немесе эмблема салынған, сабына немесе бауға бекітілген мата.',
                            'en' => 'The flag is one of the main symbols of the state, embodying its sovereignty and identity. The term "flag" comes from the Dutch word "vlag". A flag is a piece of fabric of established dimensions and colors, usually with a coat of arms or emblem depicted on it, attached to a pole or cord.',
                        ],
                        'description_2' => [
                            'ru' => 'Государственный флаг независимого Казахстана был официально принят в 1992 году. Его автором является художник Шакен Ниязбеков.',
                            'kk' => 'Тәуелсіз Қазақстанның мемлекеттік туы 1992 жылы ресми түрде қабылданды. Оның авторы – суретші Шәкен Ниязбеков.',
                            'en' => 'The state flag of independent Kazakhstan was officially adopted in 1992. Its author is the artist Shaken Niyazbekov.',
                        ],
                        'description_3' => [
                            'ru' => 'Государственный флаг Республики Казахстан представляет собой прямоугольное полотнище небесно-голубого цвета с изображением в центре солнца с лучами, под которым – парящий орел (беркут). У древка – вертикальная полоса с национальным орнаментом. Изображение солнца, его лучей, орла и национального орнамента – цвета золота. Соотношение ширины флага к его длине – 1: 2.',
                            'kk' => 'Қазақстан Республикасының мемлекеттік туы – ортасында сәулелері бар күн бейнеленген, оның астында – қаршыға (бүркіт) ұшып жүрген көк түсті тік төртбұрышты мата. Сабында – ұлттық ою-өрнекті тік жолақ бар. Күннің, оның сәулелерінің, қаршығаның және ұлттық ою-өрнектің бейнесі – алтын түсті. Ту енінің ұзындығына қатынасы – 1:2.',
                            'en' => 'The state flag of the Republic of Kazakhstan is a rectangular cloth of sky-blue color with an image of the sun with rays in the center, under which is a soaring eagle (berkut). At the staff there is a vertical strip with a national ornament. The image of the sun, its rays, the eagle and the national ornament are golden in color. The ratio of the flag width to its length is 1:2.',
                        ],
                        'description_4' => [
                            'ru' => 'В традициях геральдики каждый цвет символизирует определенное понятие. Так, небесно-голубой цвет символизирует честность, верность и безупречность. Кроме того, небесно-голубой цвет имеет глубокое символическое значение в тюркской культуре.',
                            'kk' => 'Геральдика дәстүрлерінде әр түс белгілі бір ұғымды білдіреді. Мысалы, көк түс шынайылықты, адалдықты және кемшіліксіздікті білдіреді. Сонымен қатар, көк түс түркі мәдениетінде терең символдық мағынаға ие.',
                            'en' => 'In heraldic traditions, each color symbolizes a certain concept. Thus, sky blue symbolizes honesty, loyalty and impeccability. In addition, sky blue has deep symbolic meaning in Turkic culture.',
                        ],
                        'description_5' => [
                            'ru' => 'Исходя из геральдических канонов, солнце символизирует богатство и изобилие, жизнь и энергию. Поэтому лучи солнца на флаге страны имеют форму зерна – символа достатка и благополучия.',
                            'kk' => 'Геральдикалық қағидаттарға сәйкес, күн байлық пен молшылықты, өмір мен энергияны білдіреді. Сондықтан ел туындағы күн сәулелері молшылық пен әл-ауқаттың белгісі – дәннің пішінінде.',
                            'en' => 'According to heraldic canons, the sun symbolizes wealth and abundance, life and energy. Therefore, the rays of the sun on the country\'s flag have the shape of a grain - a symbol of prosperity and well-being.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'coat_of_arms',
                    'title' => 'Государственный герб',
                    'description' => 'Информация о государственном гербе',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 4,
                    'content' => [
                        'title' => [
                            'ru' => 'Государственный герб',
                            'kk' => 'Мемлекеттік елтаңба',
                            'en' => 'State Emblem',
                        ],
                        'image_url' => [
                            'ru' => 'images/gerb.png',
                            'kk' => 'images/gerb.png',
                            'en' => 'images/gerb.png',
                        ],
                        'image_alt' => [
                            'ru' => 'Государственный герб Казахстана',
                            'kk' => 'Қазақстанның мемлекеттік елтаңбасы',
                            'en' => 'State emblem of Kazakhstan',
                        ],
                        'download_url' => [
                            'ru' => 'images/gerb.png',
                            'kk' => 'images/gerb.png',
                            'en' => 'images/gerb.png',
                        ],
                        'download_text' => [
                            'ru' => 'Скачать герб',
                            'kk' => 'Елтаңбаны жүктеу',
                            'en' => 'Download emblem',
                        ],
                        'colors' => [
                            'ru' => 'Цвета: золотой и голубой',
                            'kk' => 'Түстері: алтын және көк',
                            'en' => 'Colors: gold and blue',
                        ],
                        'description_1' => [
                            'ru' => 'Герб – один из главных символов государства. Термин «герб» происходит от немецкого слова «erbe» (наследство) и означает наследственный отличительный знак – сочетание фигур и предметов, которым придается символическое значение.',
                            'kk' => 'Елтаңба – мемлекеттің негізгі рәміздерінің бірі. «Елтаңба» термині неміс тіліндегі «erbe» (мура) сөзінен шыққан және символдық мағына берілген фигуралар мен заттардың бірігуі – мұрагерлік ерекше белгісін білдіреді.',
                            'en' => 'The emblem is one of the main symbols of the state. The term "emblem" comes from the German word "erbe" (inheritance) and means a hereditary distinctive sign - a combination of figures and objects that are given symbolic meaning.',
                        ],
                        'description_2' => [
                            'ru' => 'История свидетельствует, что еще кочевники эпохи бронзы, проживавшие на территории современного Казахстана, идентифицировали себя с особым символом – тотемом, графическое выражение которого впоследствии получило наименование «тамга».',
                            'kk' => 'Тарих куәлік етеді, қазіргі Қазақстан аумағында тұрған кола дәуірінің көшпенділері өздерін арнайы символмен – тотеммен сәйкестендірген, оның графикалық өрнегі кейіннен «таңба» деп аталған.',
                            'en' => 'History testifies that even the nomads of the Bronze Age who lived on the territory of modern Kazakhstan identified themselves with a special symbol - a totem, the graphic expression of which later received the name "tamga".',
                        ],
                        'description_3' => [
                            'ru' => 'Герб суверенного Казахстана был официально принят в 1992 году. Его авторами являются известные архитекторы Жандарбек Малибеков и Шот-Аман Уалиханов.',
                            'kk' => 'Егеменді Қазақстанның елтаңбасы 1992 жылы ресми түрде қабылданды. Оның авторы – белгілі сәулетшілер Жәндәрбек Мәлібеков пен Шот-Аман Уәлиханов.',
                            'en' => 'The emblem of sovereign Kazakhstan was officially adopted in 1992. Its authors are famous architects Zhandarbek Malibekov and Shot-Aman Ualikhanov.',
                        ],
                        'description_4' => [
                            'ru' => 'Государственный герб Республики Казахстан имеет форму круга (колеса) – это символ жизни и вечности, который пользовался особым почетом среди кочевников Великой степи.',
                            'kk' => 'Қазақстан Республикасының мемлекеттік елтаңбасы шеңбер (дөңгелек) пішінінде – бұл Ұлы дала көшпенділері арасында ерекше құрметке ие болған өмір мен мәңгілік символы.',
                            'en' => 'The state emblem of the Republic of Kazakhstan has the shape of a circle (wheel) - this is a symbol of life and eternity, which was especially honored among the nomads of the Great Steppe.',
                        ],
                        'description_5' => [
                            'ru' => 'Центральным геральдическим элементом в государственном гербе является изображение шанырака (верхняя сводчатая часть юрты) на голубом фоне, от которого во все стороны в виде солнечных лучей расходы уыки (опоры). Справа и слева от шанырака расположены изображения мифических крылатых коней.',
                            'kk' => 'Мемлекеттік елтаңбадағы орталық геральдикалық элемент – көк фондағы шаңырақтың (киіз үйдің жоғарғы күмбезді бөлігі) бейнесі, одан күн сәулелері тәрізді барлық бағытта уықтар (тіректер) таралады. Шаңырақтың оң және сол жағында мифтік қанатты аттардың бейнелері орналасқан.',
                            'en' => 'The central heraldic element in the state emblem is the image of a shanyrak (the upper vaulted part of the yurt) on a blue background, from which uyks (supports) diverge in all directions in the form of sun rays. To the right and left of the shanyrak are images of mythical winged horses.',
                        ],
                        'description_6' => [
                            'ru' => 'Шанырақ – это главная системообразующая часть юрты, по форме напоминающая небесный купол и являющаяся одним из ключевых элементов жизнеустройства в традиционной культуре евразийских кочевников.',
                            'kk' => 'Шаңырақ – киіз үйдің негізгі жүйе құраушы бөлігі, пішіні аспан күмбезіне ұқсайды және Еуразия көшпенділерінің дәстүрлі мәдениетіндегі өмір сүру тәртібінің негізгі элементтерінің бірі.',
                            'en' => 'Shanyrak is the main system-forming part of the yurt, shaped like a celestial dome and is one of the key elements of life in the traditional culture of Eurasian nomads.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'anthem',
                    'title' => 'Государственный гимн',
                    'description' => 'Информация о государственном гимне',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 5,
                    'content' => [
                        'title' => [
                            'ru' => 'Государственный гимн',
                            'kk' => 'Мемлекеттік әнұран',
                            'en' => 'State Anthem',
                        ],
                        'image_url' => [
                            'ru' => 'images/gimn.png',
                            'kk' => 'images/gimn.png',
                            'en' => 'images/gimn.png',
                        ],
                        'image_alt' => [
                            'ru' => 'Государственный гимн Казахстана',
                            'kk' => 'Қазақстанның мемлекеттік әнұраны',
                            'en' => 'State anthem of Kazakhstan',
                        ],
                        'audio_url' => [
                            'ru' => 'audio/National_Anthem.mp4',
                            'kk' => 'audio/National_Anthem.mp4',
                            'en' => 'audio/National_Anthem.mp4',
                        ],
                        'audio_button' => [
                            'ru' => 'Скачать MP3',
                            'kk' => 'MP3 жүктеу',
                            'en' => 'Download MP3',
                        ],
                        'sheet_music_url' => [
                            'ru' => 'documents/Anthem_Score.pdf',
                            'kk' => 'documents/Anthem_Score.pdf',
                            'en' => 'documents/Anthem_Score.pdf',
                        ],
                        'sheet_music_button' => [
                            'ru' => 'Скачать ноты (PDF)',
                            'kk' => 'Ноталарды жүктеу (PDF)',
                            'en' => 'Download sheet music (PDF)',
                        ],
                        'adopted_label' => [
                            'ru' => 'Принят:',
                            'kk' => 'Қабылданды:',
                            'en' => 'Adopted:',
                        ],
                        'adopted_date' => [
                            'ru' => '7 января 2006 года',
                            'kk' => '2006 жылдың 7 қаңтары',
                            'en' => 'January 7, 2006',
                        ],
                        'authors_label' => [
                            'ru' => 'Авторы текста:',
                            'kk' => 'Мәтінінің авторы:',
                            'en' => 'Lyrics by:',
                        ],
                        'authors' => [
                            'ru' => 'Жумекен Нажимеденов, Нурсултан Назарбаев',
                            'kk' => 'Жүмекен Нәжімеденов, Нұрсұлтан Назарбаев',
                            'en' => 'Zhumeken Nazhimedenov, Nursultan Nazarbayev',
                        ],
                        'composer_label' => [
                            'ru' => 'Автор музыки:',
                            'kk' => 'Әуенінің авторы:',
                            'en' => 'Music by:',
                        ],
                        'composer' => [
                            'ru' => 'Шамши Калдаяков',
                            'kk' => 'Шәмші Қалдаяқов',
                            'en' => 'Shamshi Kaldayakov',
                        ],
                        'audio_fallback' => [
                            'ru' => 'Ваш браузер не поддерживает аудио элемент.',
                            'kk' => 'Сіздің браузеріңіз аудио элементін қолдамайды.',
                            'en' => 'Your browser does not support the audio element.',
                        ],
                        'description_1' => [
                            'ru' => 'Государственный гимн Республики Казахстан - один из главных официальных символов государства наряду с флагом и гербом.',
                            'kk' => 'Қазақстан Республикасының мемлекеттік әнұраны – ту мен елтаңбамен қатар мемлекеттің негізгі ресми рәміздерінің бірі.',
                            'en' => 'The state anthem of the Republic of Kazakhstan is one of the main official symbols of the state along with the flag and emblem.',
                        ],
                        'description_2' => [
                            'ru' => 'Гимн – это один из главных символов государства. Сам термин «гимн» происходит от греческого слова «gimneo» и означает «торжественная песня».',
                            'kk' => 'Әнұран – мемлекеттің негізгі рәміздерінің бірі. «Әнұран» терминінің өзі грек тіліндегі «gimneo» сөзінен шыққан және «салтанатты ән» дегенді білдіреді.',
                            'en' => 'The anthem is one of the main symbols of the state. The very term "anthem" comes from the Greek word "gimneo" and means "solemn song".',
                        ],
                        'description_3' => [
                            'ru' => 'В истории независимого Казахстана государственный гимн страны утверждался дважды – в 1992 и в 2006 годах.',
                            'kk' => 'Тәуелсіз Қазақстан тарихында мемлекеттік әнұран екі рет бекітілді – 1992 және 2006 жылдары.',
                            'en' => 'In the history of independent Kazakhstan, the state anthem was approved twice - in 1992 and 2006.',
                        ],
                        'description_4' => [
                            'ru' => 'В целях популяризации звуковой символики страны в 2006 году был принят новый государственный гимн. Его основой стала популярная в народе патриотическая песня «Менiң Қазақстаным».',
                            'kk' => 'Елдің дыбыстық рәміздерін насихаттау мақсатында 2006 жылы жаңа мемлекеттік әнұран қабылданды. Оның негізі халық арасында танымал отаншылдық ән «Менің Қазақстаным» болды.',
                            'en' => 'In order to popularize the country\'s sound symbols, a new state anthem was adopted in 2006. Its basis was the popular patriotic song "Menin Kazakhstanym".',
                        ],
                        'description_5' => [
                            'ru' => 'Парламент Казахстана на совместном заседании палат 6 января 2006 года внес соответствующие поправки в Указ «О государственных символах» и утвердил новый государственный гимн страны.',
                            'kk' => 'Қазақстан Парламенті 2006 жылдың 6 қаңтарында палаталардың бірлескен отырысында «Мемлекеттік рәміздер туралы» Жарғыға сәйкес өзгерістер енгізіп, елдің жаңа мемлекеттік әнұранын бекітті.',
                            'en' => 'The Parliament of Kazakhstan, at a joint meeting of the chambers on January 6, 2006, made appropriate amendments to the Decree "On State Symbols" and approved the country\'s new state anthem.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'flag_symbolism',
                    'title' => 'Символика флага',
                    'description' => 'Дополнительная символика флага',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 6,
                    'content' => [
                        'title' => [
                            'ru' => 'Символика флага',
                            'kk' => 'Ту рәміздері',
                            'en' => 'Flag Symbolism',
                        ],
                        'paragraph_1' => [
                            'ru' => 'Образ орла (беркута) является одним из главных геральдических атрибутов, издавна применяемых в гербах и флагах многих народов. Этот образ обычно воспринимается как символ власти, прозорливости и великодушия.',
                            'kk' => 'Қаршыға (бүркіт) бейнесі көптеген халықтардың елтаңбалары мен туларында ғасырлар бойы қолданылып келе жатқан негізгі геральдикалық атрибуттардың бірі. Бұл бейне әдетте билік, алғырлық және мейірімділік символы ретінде қабылданады.',
                            'en' => 'The image of an eagle (berkut) is one of the main heraldic attributes used for centuries in the coats of arms and flags of many peoples. This image is usually perceived as a symbol of power, foresight and generosity.',
                        ],
                        'paragraph_2' => [
                            'ru' => 'Парящий под солнцем беркут олицетворяет собой силу государства, его суверенитет и независимость, стремление к высоким целям и устойчивому будущему.',
                            'kk' => 'Күн астында ұшып жүрген бүркіт мемлекет күшін, оның егемендігі мен тәуелсіздігін, жоғары мақсаттар мен тұрақты болашаққа ұмтылуды білдіреді.',
                            'en' => 'An eagle soaring under the sun embodies the strength of the state, its sovereignty and independence, the desire for high goals and a sustainable future.',
                        ],
                        'paragraph_3' => [
                            'ru' => 'Особое место занимает образ беркута в мировоззрении евразийских кочевников. Он ассоциируется у них с такими понятиями как свобода и верность, чувство достоинства и мужество, мощь и чистота помыслов.',
                            'kk' => 'Еуразия көшпенділерінің дүниетанымында бүркіт бейнесі ерекше орын алады. Ол оларда еркіндік пен адалдық, абырой сезімі мен батылдық, күш және ойдың тазалығы сияқты ұғымдармен байланыстырылады.',
                            'en' => 'The image of an eagle occupies a special place in the worldview of Eurasian nomads. It is associated with them with such concepts as freedom and loyalty, a sense of dignity and courage, power and purity of thoughts.',
                        ],
                        'paragraph_4' => [
                            'ru' => 'Стилизованный силуэт золотого беркута отражает стремление молодого суверенного государства к высотам мировой цивилизации.',
                            'kk' => 'Алтын бүркіттің стильденген силуэті жас егеменді мемлекеттің әлем цивилизациясының биіктіктеріне ұмтылуын көрсетеді.',
                            'en' => 'The stylized silhouette of a golden eagle reflects the desire of a young sovereign state to reach the heights of world civilization.',
                        ],
                        'paragraph_5' => [
                            'ru' => 'Важным элементом государственного флага является расположенная у его древка вертикальная полоса с национальным орнаментом.',
                            'kk' => 'Мемлекеттік тудағы маңызды элемент – оның сабында орналасқан ұлттық ою-өрнекті тік жолақ.',
                            'en' => 'An important element of the state flag is the vertical strip with a national ornament located at its staff.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'coat_of_arms_symbolism',
                    'title' => 'Символика герба',
                    'description' => 'Дополнительная символика герба',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 7,
                    'content' => [
                        'title' => [
                            'ru' => 'Символика герба',
                            'kk' => 'Елтаңба рәміздері',
                            'en' => 'Emblem Symbolism',
                        ],
                        'paragraph_1' => [
                            'ru' => 'Крылатые мифические кони – тулпары в государственном гербе являются ключевым геральдическим элементом. Образ коня с незапамятных времен олицетворяет такие понятия, как храбрость, верность и силу.',
                            'kk' => 'Қанатты мифтік аттар – тулпарлар мемлекеттік елтаңбада негізгі геральдикалық элемент болып табылады. Ат бейнесі ерте заманнан бері батылдық, адалдық және күш сияқты ұғымдарды білдіреді.',
                            'en' => 'Winged mythical horses - tulpars in the state emblem are a key heraldic element. The image of a horse from time immemorial personifies such concepts as courage, loyalty and strength.',
                        ],
                        'paragraph_2' => [
                            'ru' => 'Крылья символизируют многовековую мечту многонационального народа Казахстана о построении сильного и процветающего государства.',
                            'kk' => 'Қанаттар көп ұлтты қазақстан халқының күшті және гүлденген мемлекет құру туралы ғасырларлық арманын білдіреді.',
                            'en' => 'Wings symbolize the centuries-old dream of the multinational people of Kazakhstan to build a strong and prosperous state.',
                        ],
                        'paragraph_3' => [
                            'ru' => 'Золотые крылья скакунов напоминают также золотые колосья и олицетворяют собой трудолюбие казахстанцев и материальное благополучие страны.',
                            'kk' => 'Жылқылардың алтын қанаттары алтын дәнді дақылдарды еске түсіреді және қазақстандықтардың еңбекқорлығын және елдің материалдық әл-ауқатын білдіреді.',
                            'en' => 'The golden wings of the horses also resemble golden ears of grain and personify the hard work of Kazakhstanis and the material well-being of the country.',
                        ],
                        'paragraph_4' => [
                            'ru' => 'Еще одна деталь в государственном гербе республики – пятиконечная звезда. Данный символ используется человечеством с давних времен и олицетворяет постоянное стремление людей к свету истины, ко всему возвышенному и вечному.',
                            'kk' => 'Республиканың мемлекеттік елтаңбасындағы тағы бір деталь – бес ұшты жұлдыз. Бұл символ адамзат тарапынан ежелден қолданылып келеді және адамдардың ақиқат жарығына, барлық жоғары және мәңгілікке үнемі ұмтылуын білдіреді.',
                            'en' => 'Another detail in the state emblem of the republic is the five-pointed star. This symbol has been used by mankind since ancient times and personifies the constant desire of people for the light of truth, for everything sublime and eternal.',
                        ],
                        'paragraph_5' => [
                            'ru' => 'Основным цветом, используемым в государственном гербе, является цвет золота, который служит символом богатства, справедливости и великодушия.',
                            'kk' => 'Мемлекеттік елтаңбада қолданылатын негізгі түс – алтын түсі, ол байлықтың, әділеттіліктің және мейірімділіктің символы болып табылады.',
                            'en' => 'The main color used in the state emblem is the color of gold, which serves as a symbol of wealth, justice and generosity.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'anthem_text',
                    'title' => 'Текст гимна',
                    'description' => 'Полный текст государственного гимна',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 8,
                    'content' => [
                        'title' => [
                            'ru' => 'Текст государственного гимна',
                            'kk' => 'Мемлекеттік әнұран мәтіні',
                            'en' => 'State Anthem Text',
                        ],
                        'subtitle_kz' => [
                            'ru' => 'На казахском языке',
                            'kk' => 'Қазақ тілінде',
                            'en' => 'In Kazakh language',
                        ],
                        'chorus_label_kz' => [
                            'ru' => 'Припев:',
                            'kk' => 'Қайырмасы:',
                            'en' => 'Chorus:',
                        ],
                        'verse_1_kz' => [
                            'ru' => 'Алтын күн аспаны,
Алтын дән даласы,
Ерліктің дастаны,
Еліме қарашы!',
                            'kk' => 'Алтын күн аспаны,
Алтын дән даласы,
Ерліктің дастаны,
Еліме қарашы!',
                            'en' => 'Golden sun in the sky,
Golden grain on the steppe,
The saga of courage -
Look at my country!',
                        ],
                        'verse_2_kz' => [
                            'ru' => 'Ежелден ер деген,
Даңқымыз шықты ғой,
Намысын бермеген,
Қазағым мықты ғой!',
                            'kk' => 'Ежелден ер деген,
Даңқымыз шықты ғой,
Намысын бермеген,
Қазағым мықты ғой!',
                            'en' => 'From ancient times
Our glory emerged,
Our honor never surrendered,
My Kazakh people are strong!',
                        ],
                        'verse_3_kz' => [
                            'ru' => 'Менің елім, менің елім,
Гүлің болып егілемін,
Жырың болып төгілемін, елім!
Туған жерім менің — Қазақстаным!',
                            'kk' => 'Менің елім, менің елім,
Гүлің болып егілемін,
Жырың болып төгілемін, елім!
Туған жерім менің — Қазақстаным!',
                            'en' => 'My country, my country,
As your flower I will be planted,
As your song I will stream, my country!
My native land – My Kazakhstan!',
                        ],
                        'verse_4_kz' => [
                            'ru' => 'Жарқын боп, көк жайық,
Жырлайды озады,
Дәні менің, байлығым,
Кең далада жатқанда!',
                            'kk' => 'Жарқын боп, көк жайық,
Жырлайды озады,
Дәні менің, байлығым,
Кең далада жатқанда!',
                            'en' => 'As a land of brave people,
My country became free,
My people\'s treasure and pride,
On the wide steppe it\'s laid!',
                        ],
                        'verse_5_kz' => [
                            'ru' => 'Жердің де сұлуы — елім,
Гүлдерге толы баурайым,
Жырға қосып жүр бүгінгі заман,
Тілім менің — тілім менің!',
                            'kk' => 'Жердің де сұлуы — елім,
Гүлдерге толы баурайым,
Жырға қосып жүр бүгінгі заман,
Тілім менің — тілім менің!',
                            'en' => 'The beauty of the land is my country,
Full of flowers my native land,
Today\'s age adds to your song,
My language – my language!',
                        ],
                        'chorus_kz' => [
                            'ru' => 'Менің елім, менің елім,
Гүлің болып егілемін,
Жырың болып төгілемін, елім!
Туған жерім менің — Қазақстаным!',
                            'kk' => 'Менің елім, менің елім,
Гүлің болып егілемін,
Жырың болып төгілемін, елім!
Туған жерім менің — Қазақстаным!',
                            'en' => 'My country, my country,
As your flower I will be planted,
As your song I will stream, my country!
My native land – My Kazakhstan!',
                        ],
                        'description_1' => [
                            'ru' => 'Песня «Менiң Қазақстаным» была написана в 1956 году Шамши Калдаяковым на стихи Жумекена Нажимеденова.',
                            'kk' => '«Менің Қазақстаным» әні 1956 жылы Шәмші Қалдаяқовтың Жүмекен Нәжімеденовтің өлеңіне жазған.',
                            'en' => 'The song "Menin Kazakhstanym" was written in 1956 by Shamshi Kaldayakov to the poems of Zhumeken Nazhimedenov.',
                        ],
                        'description_2' => [
                            'ru' => 'Для придания песне высокого статуса государственного гимна и более торжественного звучания Первый Президент Казахстана Нурсултан Назарбаев доработал первоначальный текст.',
                            'kk' => 'Әнді мемлекеттік әнұранның жоғары мәртебесін беру және одан да салтанатты дыбысталуы үшін Қазақстанның Тұңғыш Президенті Нұрсұлтан Назарбаев бастапқы мәтінде өзгерістер енгізді.',
                            'en' => 'To give the song the high status of the state anthem and a more solemn sound, the First President of Kazakhstan, Nursultan Nazarbayev, finalized the original text.',
                        ],
                        'description_3' => [
                            'ru' => 'Парламент Казахстана на совместном заседании палат 6 января 2006 года внес соответствующие поправки в Указ «О государственных символах» и утвердил новый государственный гимн страны.',
                            'kk' => 'Қазақстан Парламенті 2006 жылдың 6 қаңтарында палаталардың бірлескен отырысында «Мемлекеттік рәміздер туралы» Жарғыға сәйкес өзгерістер енгізіп, елдің жаңа мемлекеттік әнұранын бекітті.',
                            'en' => 'The Parliament of Kazakhstan, at a joint meeting of the chambers on January 6, 2006, made appropriate amendments to the Decree "On State Symbols" and approved the country\'s new state anthem.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
                    'section_key' => 'legal_basis',
                    'title' => 'Правовая основа',
                    'description' => 'Правовые основы государственных символов',
                    'is_active' => true,
                    'is_multilang' => true,
                    'sort_order' => 9,
                    'content' => [
                        'title' => [
                            'ru' => 'Правовая основа',
                            'kk' => 'Құқықтық негіз',
                            'en' => 'Legal Basis',
                        ],
                        'description' => [
                            'ru' => 'Государственные символы Республики Казахстан установлены Конституционным законом "О государственных символах Республики Казахстан".',
                            'kk' => 'Қазақстан Республикасының мемлекеттік рәміздері «Қазақстан Республикасының мемлекеттік рәміздері туралы» Конституциялық Заңымен белгіленген.',
                            'en' => 'The state symbols of the Republic of Kazakhstan are established by the Constitutional Law "On State Symbols of the Republic of Kazakhstan".',
                        ],
                        'symbol_1' => [
                            'ru' => 'Государственный флаг – принят 4 июня 1992 года',
                            'kk' => 'Мемлекеттік ту – 1992 жылдың 4 маусымында қабылданды',
                            'en' => 'State Flag - adopted on June 4, 1992',
                        ],
                        'symbol_2' => [
                            'ru' => 'Государственный герб – принят 4 июня 1992 года',
                            'kk' => 'Мемлекеттік елтаңба – 1992 жылдың 4 маусымында қабылданды',
                            'en' => 'State Emblem - adopted on June 4, 1992',
                        ],
                        'symbol_3' => [
                            'ru' => 'Государственный гимн – принят 7 января 2006 года',
                            'kk' => 'Мемлекеттік әнұран – 2006 жылдың 7 қаңтарында қабылданды',
                            'en' => 'State Anthem - adopted on January 7, 2006',
                        ],
                        'important_label' => [
                            'ru' => 'Важно:',
                            'kk' => 'Маңызды:',
                            'en' => 'Important:',
                        ],
                        'important_text' => [
                            'ru' => 'Государственные символы охраняются законом. Неуважительное отношение к государственным символам преследуется по закону.',
                            'kk' => 'Мемлекеттік рәміздер заңмен қорғалады. Мемлекеттік рәміздерге құрметсіздік заң бойынша жауапқа тартылады.',
                            'en' => 'State symbols are protected by law. Disrespect for state symbols is punishable by law.',
                        ],
                    ],
                ],
                [
                    'page_key' => 'state_symbols',
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
                    ],
                ],
            ];
            
            $createdCount = 0;
            $errors = [];
            
            foreach ($sections as $section) {
                try {
                    PageSection::create($section);
                    $createdCount++;
                    Log::info("Создана многоязычная State Symbols секция: {$section['section_key']}");
                    
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
            
            Log::info("✅ Создано многоязычных секций State Symbols: {$createdCount} из " . count($sections));
            $this->command->info("✅ Многоязычная страница 'Государственные символы' успешно создана!");
            $this->command->info("   📊 Создано секций: {$createdCount}");
            $this->command->info("   🌐 Языки: 🇷🇺 Русский, 🇰🇿 Қазақша, 🇬🇧 English");
            $this->command->info("   🎯 Формат: Многоязычный Repeater");
            
            if ($createdCount > 0) {
                $this->command->info("\n📋 Созданные секции:");
                foreach ($sections as $section) {
                    $langIcon = '🌍';
                    $this->command->info("   {$langIcon} {$section['title']} ({$section['section_key']}) - {$section['sort_order']} порядок");
                }
                
                $this->command->info("\n🎌 Государственные символы:");
                $this->command->info("   🇰🇿 Флаг Казахстана (с переводами)");
                $this->command->info("   ⚜️ Герб Казахстана (с переводами)");
                $this->command->info("   🎵 Гимн Казахстана (текст на 3 языках)");
                $this->command->info("   ⚖️ Правовая основа (мультиязычная)");
            }
            
        } catch (\Exception $e) {
            Log::error("Критическая ошибка: {$e->getMessage()}");
            $this->command->error("❌ Ошибка: {$e->getMessage()}");
            throw $e;
        }
    }
}