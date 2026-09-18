@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('about', 'hero', 'main_title', '45 лет создаём'))

@section('content')

<section class="relative overflow-hidden bg-black" style="min-height: 65vh;" data-animate-section>
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-400 rounded-full filter blur-3xl opacity-10 animate-blob animation-delay-6000"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-10 md:py-12">
        <div class="max-w-5xl mx-auto text-center mt-12 md:mt-16">

            <h1 class="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight" data-animate="fade-down" data-delay="200" data-animate-repeat>
                {{ \App\Models\PageSection::getValue('about', 'hero', 'main_title', '45 лет создаём') }}
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500 mt-1" data-animate="fade-down" data-delay="400" data-animate-repeat>
                    {{ \App\Models\PageSection::getValue('about', 'hero', 'subtitle', 'будущее технологий') }}
                </span>
            </h1>

            <div class="mb-6 max-w-[1200px] mx-auto" data-animate="fade-up" data-delay="800" data-animate-repeat>
                <div class="space-y-5">
                    
                    <div class="relative group w-full" data-animate="fade-right" data-delay="600" data-animate-repeat>
                        <div class="absolute -top-3 left-0 bg-[#1e3a8a] px-4 py-1.5 z-30 rounded-lg" style="background-color: #1e3a8a !important; left: -8px !important; top: -8px !important;">
                            <span class="text-white font-bold uppercase text-xs tracking-wider">{{ \App\Models\PageSection::getValue('about', 'hero', 'mission_title', 'МИССИЯ') }}</span>
                        </div>
                        <div class="relative h-18 md:h-20 flex items-center pr-16 md:pr-20 ribbon-main w-full" style="background-color: #3b82f6 !important; clip-path: polygon(0% 0%, calc(100% - 50px) 0%, 100% 50%, calc(100% - 50px) 100%, 0% 100%);">
                            <div class="relative z-20 w-full flex items-center" style="padding-left: 80px; height: 100%;">
                                <p class="text-white text-sm md:text-base leading-relaxed pl-4 pr-3 font-medium">
                                    {{ \App\Models\PageSection::getValue('about', 'hero', 'mission_text', 'Осуществление качественной образовательной деятельности, способствующей профессиональному и социальному становлению личности обучающихся в области железнодорожного транспорта, телекоммуникаций и информационных технологий.') }}
                                </p>
                            </div>
                        </div>
                        <div class="absolute left-0 top-full mt-0 w-6 h-6 z-20" style="background-color: #1e3a8a !important; clip-path: polygon(100% 0%, 0% 0%, 100% 100%); margin-top: -1px;"></div>
                    </div>

                    <div class="relative group w-full" data-animate="fade-left" data-delay="800" data-animate-repeat>
                        <div class="absolute -top-3 right-0 bg-[#3b82f6] px-4 py-1.5 z-30 rounded-lg" style="background-color: #3b82f6 !important; right: -8px !important; top: -8px !important;">
                            <span class="text-white font-bold uppercase text-xs tracking-wider">{{ \App\Models\PageSection::getValue('about', 'hero', 'goal_title', 'ЦЕЛЬ') }}</span>
                        </div>
                        <div class="relative h-18 md:h-20 flex items-center pl-16 md:pl-20 ribbon-main w-full" style="background-color: #1e3a8a !important; clip-path: polygon(50px 0%, 100% 0%, 100% 100%, 50px 100%, 0% 50%);">
                            <div class="relative z-20 w-full text-right flex items-center justify-end" style="padding-right: 120px; height: 100%;">
                                <p class="text-white text-sm md:text-base leading-relaxed pr-8 pl-3 font-medium" style="margin-left: auto;">
                                    {{ \App\Models\PageSection::getValue('about', 'hero', 'goal_text', 'Создание модели учебного заведения, осуществляющего ступенчатую подготовку специалистов по уровням: начальное профессиональное образование, среднее профессиональное образование, начальное высшее образование для железнодорожной отрасли, телекоммуникаций и IT-сферы.') }}
                                </p>
                            </div>
                        </div>
                        <div class="absolute right-0 top-full mt-0 w-6 h-6 z-20" style="background-color: #1e3a8a !important; clip-path: polygon(0% 0%, 100% 0%, 0% 100%); margin-top: -1px;"></div>
                    </div>

                    <div class="relative group w-full" data-animate="fade-right" data-delay="1000" data-animate-repeat>
                        <div class="absolute -top-3 left-0 bg-[#1e3a8a] px-4 py-1.5 z-30 rounded-lg" style="background-color: #1e3a8a !important; left: -8px !important; top: -8px !important;">
                            <span class="text-white font-bold uppercase text-xs tracking-wider">{{ \App\Models\PageSection::getValue('about', 'hero', 'vision_title', 'ВИДЕНИЕ') }}</span>
                        </div>
                        <div class="relative h-18 md:h-20 flex items-center pr-16 md:pr-20 ribbon-main w-full" style="background-color: #3b82f6 !important; clip-path: polygon(0% 0%, calc(100% - 50px) 0%, 100% 50%, calc(100% - 50px) 100%, 0% 100%);">
                            <div class="relative z-20 w-full flex items-center" style="padding-left: 80px; height: 100%;">
                                <p class="text-white text-sm md:text-base leading-relaxed pl-4 pr-3 font-medium">
                                    {{ \App\Models\PageSection::getValue('about', 'hero', 'vision_text', 'Эффективная подготовка специалистов через модернизацию обучения, развитие инновационной деятельности, производственной практики, партнёрства и поддержку профориентации и креативного потенциала студентов в ключевых технологических направлениях.') }}
                                </p>
                            </div>
                        </div>
                        <div class="absolute left-0 top-full mt-0 w-6 h-6 z-20" style="background-color: #1e3a8a !important; clip-path: polygon(100% 0%, 0% 0%, 100% 100%); margin-top: -1px;"></div>
                    </div>
                    
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto mt-8">
                @php
                    $stat1 = \App\Models\PageSection::getValue('about', 'stats_top', 'stat_1_value', '45');
                    $stat2 = \App\Models\PageSection::getValue('about', 'stats_top', 'stat_2_value', '956');
                    $stat3 = \App\Models\PageSection::getValue('about', 'stats_top', 'stat_3_value', '100');
                    $stat4 = \App\Models\PageSection::getValue('about', 'stats_top', 'stat_4_value', '71');
                    $stat1_value = filter_var($stat1, FILTER_SANITIZE_NUMBER_INT);
                    $stat2_value = filter_var($stat2, FILTER_SANITIZE_NUMBER_INT);
                    $stat3_value = filter_var($stat3, FILTER_SANITIZE_NUMBER_INT);
                    $stat4_value = filter_var($stat4, FILTER_SANITIZE_NUMBER_INT);
                @endphp
                
                <div x-data="counter({ target: {{ $stat1_value ?: 45 }}, duration: 2000, delay: 1400 })" 
                     x-intersect.once="startCounting()"
                     x-intersect:leave="resetCounter()"
                     x-intersect:enter="restartCounting()"
                     class="floating-card group"
                     data-animate="fade-up" data-delay="1400" data-animate-repeat>
                    <div class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600 mb-2">
                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                    </div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider">{{ \App\Models\PageSection::getValue('about', 'stats_top', 'stat_1_label', 'Лет опыта') }}</div>
                </div>
                <div x-data="counter({ target: {{ $stat2_value ?: 956 }}, duration: 2000, delay: 1600 })" 
                     x-intersect.once="startCounting()"
                     x-intersect:leave="resetCounter()"
                     x-intersect:enter="restartCounting()"
                     class="floating-card group"
                     data-animate="fade-up" data-delay="1600" data-animate-repeat>
                    <div class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-blue-700 mb-2">
                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                    </div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider">{{ \App\Models\PageSection::getValue('about', 'stats_top', 'stat_2_label', 'Студентов') }}</div>
                </div>
                <div x-data="counter({ target: {{ $stat3_value ?: 100 }}, duration: 2000, delay: 1800, suffix: '{{ \App\Models\PageSection::getValue('about', 'stats_top', 'stat_3_suffix', '%') }}' })" 
                     x-intersect.once="startCounting()"
                     x-intersect:leave="resetCounter()"
                     x-intersect:enter="restartCounting()"
                     class="floating-card group"
                     data-animate="fade-up" data-delay="1800" data-animate-repeat>
                    <div class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-cyan-600 mb-2">
                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                    </div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider">{{ \App\Models\PageSection::getValue('about', 'stats_top', 'stat_3_label', 'Трудоустройство и занятость') }}</div>
                </div>
                <div x-data="counter({ target: {{ $stat4_value ?: 71 }}, duration: 2000, delay: 2000 })" 
                     x-intersect.once="startCounting()"
                     x-intersect:leave="resetCounter()"
                     x-intersect:enter="restartCounting()"
                     class="floating-card group"
                     data-animate="fade-up" data-delay="2000" data-animate-repeat>
                    <div class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-500 mb-2">
                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                    </div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider">{{ \App\Models\PageSection::getValue('about', 'stats_top', 'stat_4_label', 'Преподаватель') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 z-10" data-animate="fade-up" data-delay="2200" data-animate-repeat>
        <div class="flex flex-col items-center gap-1">
            <span class="text-gray-400 text-xs">{{ \App\Models\PageSection::getValue('about', 'navigation', 'scroll_down', 'Прокрутите вниз') }}</span>
            <svg class="w-5 h-5 text-blue-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6" data-animate="fade-right" data-animate-repeat>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" data-animate="fade-right" data-delay="200" data-animate-repeat>
                            {{ \App\Models\PageSection::getValue('about', 'description', 'title', 'Колледж современных технологий') }}
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mb-4" data-animate="width-grow" data-delay="400" data-animate-repeat></div>
                    </div>
                    
                    <div class="space-y-4 text-gray-300 text-base leading-relaxed">
                        <p data-animate="fade-up" data-delay="600" data-animate-repeat>
                            {{ \App\Models\PageSection::getValue('about', 'description', 'paragraph_1', 'Основанный в 1981 году, наш колледж прошёл путь от профессионально-технического училища до ведущего образовательного учреждения в сфере информационных технологий.') }}
                        </p>
                        <p data-animate="fade-up" data-delay="800" data-animate-repeat>
                            {{ \App\Models\PageSection::getValue('about', 'description', 'paragraph_2', 'Сегодня мы предлагаем современные образовательные программы, сочетающие фундаментальные знания с практическими навыками, востребованными на рынке труда.') }}
                        </p>
                        <p data-animate="fade-up" data-delay="1000" data-animate-repeat>
                            {{ \App\Models\PageSection::getValue('about', 'description', 'paragraph_3', 'Наша миссия — подготовка высококвалифицированных специалистов, способных решать сложные технологические задачи и вносить вклад в цифровую трансформацию общества.') }}
                        </p>
                    </div>
                </div>

                <div class="relative" data-animate="fade-left" data-animate-repeat>
                    <div class="relative rounded-xl overflow-hidden bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 p-6 backdrop-blur-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="bg-blue-500/20 rounded-lg p-3 text-center" data-animate="fade-up" data-delay="1200" data-animate-repeat>
                                    <div class="text-xl font-bold text-white">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_1_value', '9') }}</div>
                                    <div class="text-blue-300 text-xs">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_1_label', 'Специальностей') }}</div>
                                </div>
                                <div class="bg-cyan-500/20 rounded-lg p-3 text-center" data-animate="fade-up" data-delay="1400" data-animate-repeat>
                                    <div class="text-xl font-bold text-white">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_2_value', '25+') }}</div>
                                    <div class="text-cyan-300 text-xs">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_2_label', 'Лабораторий') }}</div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="bg-blue-600/20 rounded-lg p-3 text-center" data-animate="fade-up" data-delay="1600" data-animate-repeat>
                                    <div class="text-xl font-bold text-white">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_3_value', '95') }}{{ \App\Models\PageSection::getValue('about', 'description', 'fact_3_suffix', '%') }}</div>
                                    <div class="text-blue-300 text-xs">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_3_label', 'Выпускников') }}</div>
                                </div>
                                <div class="bg-cyan-600/20 rounded-lg p-3 text-center" data-animate="fade-up" data-delay="1800" data-animate-repeat>
                                    <div class="text-xl font-bold text-white">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_4_value', '200+') }}</div>
                                    <div class="text-cyan-300 text-xs">{{ \App\Models\PageSection::getValue('about', 'description', 'fact_4_label', 'Компьютеров') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-blue-400/50"></div>
                        <div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-cyan-400/50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-black via-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-animate="fade-down" data-animate-repeat>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ \App\Models\PageSection::getValue('about', 'history_header', 'title', 'Наша история') }}</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-4" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
            <p class="text-gray-400 text-base max-w-2xl mx-auto">
                {{ \App\Models\PageSection::getValue('about', 'history_header', 'description', 'От скромного начала до лидера в техническом и профессиональном, послесреднем образовании') }}
            </p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="relative">
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gradient-to-b from-blue-500 via-blue-600 to-cyan-500"></div>

                <div class="space-y-8">
                    @php
                        use App\Models\HistoryTimeline;
                        $timelineEvents = HistoryTimeline::where('is_active', true)
                            ->orderBy('order', 'asc')
                            ->get();
                        $iteration = 0;
                    @endphp
                    
                    @foreach($timelineEvents as $event)
                        @php
                            $delay = 400 + ($iteration * 200);
                            $isLeft = $event->position === 'left';
                            $animateDirection = $isLeft ? 'fade-right' : 'fade-left';
                            $timelineClass = $isLeft ? 'timeline-left' : 'timeline-right';
                        @endphp
                        
                        <div class="timeline-item {{ $timelineClass }}" 
                             data-animate="{{ $animateDirection }}" 
                             data-delay="{{ $delay }}" 
                             data-animate-repeat>
                            <div class="timeline-content">
                                <div class="timeline-year">{{ \Carbon\Carbon::parse($event->date)->format('Y') }}</div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $event->title }}</h3>
                                <div class="timeline-description">
                                    {!! $event->description !!}
                                </div>
                            </div>
                        </div>
                        
                        @php $iteration++ @endphp
                    @endforeach
                    
                    @if($timelineEvents->isEmpty())
                        <div class="text-center py-10">
                            <div class="inline-block p-4 bg-blue-500/10 rounded-lg">
                                <svg class="w-12 h-12 text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-400">{{ \App\Models\PageSection::getValue('about', 'history_header', 'empty_message', 'Исторические события скоро появятся...') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-black to-gray-900 relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-animate="fade-down" data-animate-repeat>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ \App\Models\PageSection::getValue('about', 'values', 'title', 'Наши ценности') }}</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-4" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
            <p class="text-gray-400 text-base max-w-2xl mx-auto">
                {{ \App\Models\PageSection::getValue('about', 'values', 'description', 'Принципы, которыми мы руководствуемся каждый день') }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @for($i = 1; $i <= 3; $i++)
                @php
                    $title = \App\Models\PageSection::getValue('about', 'values', "value_{$i}_title");
                    $description = \App\Models\PageSection::getValue('about', 'values', "value_{$i}_description");
                    $icon = \App\Models\PageSection::getValue('about', 'values', "value_{$i}_icon");
                @endphp
                
                @if($title && $description)
                    <div class="value-card group" data-animate="fade-up" data-delay="{{ 400 + ($i * 200) }}" data-animate-repeat>
                        <div class="value-icon-wrapper bg-gradient-to-br from-blue-500 to-blue-700">
                            @switch($icon)
                                @case('book')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    @break
                                @case('users')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    @break
                                @case('briefcase')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                            @endswitch
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">
                            {{ $title }}
                        </h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            {{ $description }}
                        </p>
                        <div class="value-card-glow bg-blue-500"></div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-cyan-500 rounded-full filter blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12" data-animate="fade-down" data-animate-repeat>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ \App\Models\PageSection::getValue('about', 'stats_bottom', 'title', 'Впечатляющие результаты') }}</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-4" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
            <p class="text-gray-400 text-base max-w-2xl mx-auto">
                {{ \App\Models\PageSection::getValue('about', 'stats_bottom', 'description', 'Цифры, которые говорят сами за себя') }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @php
                $stat1 = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_1_value');
                $stat2 = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_2_value');
                $stat3 = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_3_value');
                $stat4 = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_4_value');
                $stat1_value = filter_var($stat1, FILTER_SANITIZE_NUMBER_INT);
                $stat2_value = filter_var($stat2, FILTER_SANITIZE_NUMBER_INT);
                $stat3_value = filter_var($stat3, FILTER_SANITIZE_NUMBER_INT);
                $stat4_value = filter_var($stat4, FILTER_SANITIZE_NUMBER_INT);
                $stat1_label = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_1_label');
                $stat2_label = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_2_label');
                $stat3_label = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_3_label');
                $stat4_label = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_4_label');
                $stat1_suffix = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_1_suffix', '');
                $stat2_suffix = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_2_suffix', '');
                $stat3_suffix = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_3_suffix', '');
                $stat4_suffix = \App\Models\PageSection::getValue('about', 'stats_bottom', 'stat_4_suffix', '');
            @endphp
            
            @if($stat1_value || $stat1_label)
            <div x-data="counter({ target: {{ $stat1_value ?: 0 }}, duration: 2000, delay: 600, suffix: '{{ $stat1_suffix }}' })" 
                 x-intersect.once="startCounting()"
                 x-intersect:leave="resetCounter()"
                 x-intersect:enter="restartCounting()"
                 class="stat-card" 
                 data-animate="fade-up" 
                 data-delay="600" 
                 data-animate-repeat>
                <div class="stat-number">
                    <span x-text="Math.floor(currentValue).toLocaleString()"></span><span x-text="suffix"></span>
                </div>
                <div class="stat-label">{{ $stat1_label ?: 'Статистика 1' }}</div>
                <div class="stat-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
            </div>
            @endif
            
            @if($stat2_value || $stat2_label)
            <div x-data="counter({ target: {{ $stat2_value ?: 0 }}, duration: 2000, delay: 800, suffix: '{{ $stat2_suffix }}' })" 
                 x-intersect.once="startCounting()"
                 x-intersect:leave="resetCounter()"
                 x-intersect:enter="restartCounting()"
                 class="stat-card" 
                 data-animate="fade-up" 
                 data-delay="800" 
                 data-animate-repeat>
                <div class="stat-number">
                    <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                </div>
                <div class="stat-label">{{ $stat2_label ?: 'Статистика 2' }}</div>
                <div class="stat-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 a3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 a3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
            @endif
            
            @if($stat3_value || $stat3_label)
            <div x-data="counter({ target: {{ $stat3_value ?: 0 }}, duration: 2000, delay: 1000, suffix: '{{ $stat3_suffix }}' })" 
                 x-intersect.once="startCounting()"
                 x-intersect:leave="resetCounter()"
                 x-intersect:enter="restartCounting()"
                 class="stat-card" 
                 data-animate="fade-up" 
                 data-delay="1000" 
                 data-animate-repeat>
                <div class="stat-number">
                    <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                </div>
                <div class="stat-label">{{ $stat3_label ?: 'Статистика 3' }}</div>
                <div class="stat-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            @endif
            
            @if($stat4_value || $stat4_label)
            <div x-data="counter({ target: {{ $stat4_value ?: 0 }}, duration: 2000, delay: 1200, suffix: '{{ $stat4_suffix }}' })" 
                 x-intersect.once="startCounting()"
                 x-intersect:leave="resetCounter()"
                 x-intersect:enter="restartCounting()"
                 class="stat-card" 
                 data-animate="fade-up" 
                 data-delay="1200" 
                 data-animate-repeat>
                <div class="stat-number">
                    <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                </div>
                <div class="stat-label">{{ $stat4_label ?: 'Статистика 4' }}</div>
                <div class="stat-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<style>
[data-animate] {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s ease;
}

[data-animate].animated {
    opacity: 1;
    transform: translateY(0);
}

[data-animate="fade-up"].animated {
    transform: translateY(0);
}

[data-animate="fade-down"].animated {
    transform: translateY(0);
}

[data-animate="fade-left"].animated {
    transform: translateX(0);
}

[data-animate="fade-right"].animated {
    transform: translateX(0);
}

[data-animate="fade-left"] {
    transform: translateX(-50px);
}

[data-animate="fade-right"] {
    transform: translateX(50px);
}

[data-animate="width-grow"] {
    width: 0;
    opacity: 0;
    transition: all 1s ease;
}

[data-animate="width-grow"].animated {
    width: 5rem;
    opacity: 1;
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform:translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

.animate-blob {
    animation: blob 10s infinite ease-in-out;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animation-delay-6000 {
    animation-delay: 6s;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

.grid-animation {
    background-image:
        repeating-linear-gradient(0deg, #3b82f6 0px, transparent 1px, transparent 60px),
        repeating-linear-gradient(90deg, #3b82f6 0px, transparent 1px, transparent 60px);
    animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
    0% { transform: translate(0, 0); }
    100% { transform: translate(60px, 60px); }
}

.floating-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 0.75rem;
    padding: 1rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.floating-card:hover {
    transform: translateY(-6px);
    border-color: rgba(59, 130, 246, 0.6);
    box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
}

.floating-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.8), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.floating-card:hover::before {
    transform: translateX(100%);
}

.ribbon-main {
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 100%;
    position: relative;
}

.group:hover .ribbon-main {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.absolute.-top-3 {
    z-index: 30 !important;
    border-radius: 6px !important;
}

.absolute.-top-3.bg-\[\#1e3a8a\] {
    background-color: #1e3a8a !important;
}

.absolute.-top-3.bg-\[\#3b82f6\] {
    background-color: #3b82f6 !important;
}

.relative > .ribbon-main > .relative {
    position: relative;
    z-index: 20;
}

.relative > .ribbon-main[style*="clip-path: polygon(0%"] > .relative {
    padding-left: 80px !important;
}

.relative > .ribbon-main[style*="clip-path: polygon(50px"] > .relative {
    padding-right: 120px !important;
}

.relative > .ribbon-main p {
    position: relative;
    z-index: 25;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
    font-weight: 500 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.relative > .absolute[style*="clip-path: polygon(100% 0%, 0% 0%, 100% 100%)"],
.relative > .absolute[style*="clip-path: polygon(0% 0%, 100% 0%, 0% 100%)"] {
    z-index: 10 !important;
    width: 20px !important;
    height: 20px !important;
    margin-top: -1px !important;
}

.space-y-5 > .relative {
    margin-bottom: 6px !important;
}

.h-18 {
    height: 4.5rem;
}

@media (max-width: 768px) {
    section.relative {
        min-height: 450px !important;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    h1.text-3xl {
        font-size: 1.75rem !important;
        line-height: 2rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .mb-6.max-w-\[1200px\].mx-auto .space-y-5 > .relative {
        margin-bottom: 0.75rem !important;
    }
    
    .absolute.-top-3 {
        position: relative !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        border-radius: 6px 6px 0 0 !important;
        margin-bottom: 0 !important;
        padding: 6px 10px !important;
        z-index: 20 !important;
    }
    
    .absolute.-top-3 span {
        font-size: 11px !important;
    }
    
    .relative > .ribbon-main {
        height: auto !important;
        min-height: 90px !important;
        padding: 10px !important;
        clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%) !important;
    }
    
    .relative > .absolute[style*="clip-path: polygon"] {
        display: none !important;
    }
    
    .relative > .ribbon-main > .relative {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    .relative > .ribbon-main p {
        font-size: 0.75rem !important;
        text-align: center !important;
        line-height: 1.3 !important;
        font-weight: 500 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin: 0 !important;
    }
    
    .relative > .ribbon-main .text-right {
        text-align: center !important;
    }
    
    .pr-16, .md\:pr-20, .pl-16, .md\:pl-20 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    .grid.grid-cols-2.md\:grid-cols-4 {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.5rem !important;
    }
    
    .floating-card {
        padding: 0.75rem !important;
    }
    
    .text-2xl {
        font-size: 1.25rem !important;
    }
}

@media (max-width: 640px) {
    .grid.grid-cols-2.md\:grid-cols-4 {
        grid-template-columns: 1fr !important;
        max-width: 200px !important;
        margin: 0 auto !important;
    }
    
    .absolute.-top-3 {
        padding: 5px 8px !important;
    }
    
    .relative > .ribbon-main {
        min-height: 100px !important;
    }
    
    .relative > .ribbon-main p {
        font-size: 0.7rem !important;
    }
}

@media (max-width: 480px) {
    section.relative {
        min-height: 380px !important;
    }
    
    .relative > .ribbon-main {
        min-height: 110px !important;
    }
    
    .relative > .ribbon-main p {
        font-size: 0.7rem !important;
    }
}

.timeline-item {
    position: relative;
    padding: 1.5rem 0;
}

.timeline-left .timeline-content {
    margin-right: auto;
    margin-left: 0;
    max-width: 450px;
    padding-right: 2.5rem;
    text-align: right;
}

.timeline-right .timeline-content {
    margin-left: auto;
    margin-right: 0;
    max-width: 450px;
    padding-left: 2.5rem;
    text-align: left;
}

@media (max-width: 768px) {
    .timeline-left .timeline-content,
    .timeline-right .timeline-content {
        margin: 0;
        padding: 0 0 0 1.5rem;
        text-align: left;
    }
}

.timeline-content {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 0.75rem;
    padding: 1.5rem;
    position: relative;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}

.timeline-content:hover {
    border-color: rgba(59, 130, 246, 0.5);
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
}

.timeline-content::before {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    border: 2px solid #111827;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
}

.timeline-left .timeline-content::before {
    right: -2.5rem;
}

.timeline-right .timeline-content::before {
    left: -2.5rem;
}

@media (max-width: 768px) {
    .timeline-left .timeline-content::before,
    .timeline-right .timeline-content::before {
        left: -1.25rem;
    }
}

.timeline-year {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    color: white;
    font-weight: bold;
    border-radius: 1.5rem;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.timeline-description {
    color: #9ca3af;
    font-size: 0.875rem;
    line-height: 1.5;
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    hyphens: auto !important;
    max-width: 100% !important;
    width: 100% !important;
    overflow: hidden !important;
    box-sizing: border-box !important;
}

.timeline-description * {
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    hyphens: auto !important;
    max-width: 100% !important;
    width: auto !important;
    white-space: normal !important;
    min-width: 0 !important;
    max-height: none !important;
    box-sizing: border-box !important;
}

.timeline-description p {
    margin-bottom: 0.75rem;
    line-height: 1.5;
    white-space: normal !important;
    word-break: break-word !important;
    max-width: 100% !important;
}

.timeline-description ul,
.timeline-description ol {
    margin-left: 1rem;
    margin-bottom: 0.75rem;
    padding-left: 1rem;
    white-space: normal !important;
    word-break: break-word !important;
    max-width: calc(100% - 2rem) !important;
}

.timeline-description li {
    margin-bottom: 0.25rem;
    white-space: normal !important;
    word-break: break-word !important;
}

.timeline-description strong,
.timeline-description b {
    font-weight: 600;
    color: #d1d5db;
    white-space: normal !important;
    word-break: break-word !important;
}

.timeline-description em,
.timeline-description i {
    font-style: italic;
    white-space: normal !important;
    word-break: break-word !important;
}

.timeline-description a {
    color: #3b82f6;
    text-decoration: underline;
    transition: color 0.2s;
    word-break: break-all !important;
    white-space: normal !important;
}

.timeline-description a:hover {
    color: #60a5fa;
}

.timeline-description img,
.timeline-description table,
.timeline-description div,
.timeline-description span,
.timeline-description figure,
.timeline-description iframe {
    max-width: 100% !important;
    width: auto !important;
    height: auto !important;
    display: block !important;
}

.timeline-description table {
    width: 100% !important;
    table-layout: fixed !important;
    border-collapse: collapse !important;
}

.timeline-description td,
.timeline-description th {
    word-break: break-word !important;
    overflow-wrap: break-word !important;
}

.timeline-description .ProseMirror,
.timeline-description .tox-tinymce,
.timeline-description .rich-editor-content {
    width: 100% !important;
    max-width: 100% !important;
    word-break: break-word !important;
}

@media (max-width: 768px) {
    .timeline-description {
        font-size: 0.8125rem;
        line-height: 1.4;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }
    
    .timeline-content {
        padding: 1rem;
        width: calc(100% - 2rem);
        margin-left: auto;
        margin-right: auto;
    }
    
    .timeline-description * {
        font-size: 0.8125rem !important;
    }
}

.timeline-description .break-all {
    word-break: break-all !important;
    overflow-wrap: anywhere !important;
}

.value-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
    text-align: center;
}

.value-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3);
}

.value-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    position: relative;
    transition: all 0.4s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.value-card:hover .value-icon-wrapper {
    transform: rotateY(360deg) scale(1.1);
    box-shadow: 0 12px 35px rgba(59, 130, 246, 0.5);
}

.value-card-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150px;
    height: 150px;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    filter: blur(50px);
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: -1;
}

.value-card:hover .value-card-glow {
    opacity: 0.2;
}

.stat-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
    text-align: center;
    backdrop-filter: blur(10px);
}

.stat-card:hover {
    transform: translateY(-8px);
    border-color: rgba(59, 130, 246, 0.6);
    box-shadow: 0 15px 35px rgba(59, 130, 246, 0.3);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, #06b6d4);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.75rem;
    line-height: 1;
}

.stat-label {
    color: #9ca3af;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.stat-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0.75rem;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    opacity: 1;
    transform: scale(1.1);
    color: #3b82f6;
}

.stat-icon svg {
    stroke: currentColor;
}

@media (max-width: 768px) {
    .timeline-item {
        padding-left: 1.5rem;
    }
    .value-card {
        padding: 1.5rem 1rem;
    }
    .stat-number {
        font-size: 2rem;
    }
    .stat-card {
        padding: 1.5rem 1rem;
    }
}
</style>

@push('scripts')
<script>
function counter(config) {
    return {
        currentValue: 0,
        animationFrame: null,
        hasAnimated: false,
        target: config.target || 100,
        duration: config.duration || 2000,
        delay: config.delay || 0,
        suffix: config.suffix || '',
        startTime: null,
        
        init() {
            this.currentValue = 0;
        },
        
        startCounting() {
            if (this.hasAnimated) return;
            
            setTimeout(() => {
                this.hasAnimated = true;
                this.startTime = null;
                const animate = (currentTime) => {
                    if (!this.startTime) this.startTime = currentTime;
                    const elapsed = currentTime - this.startTime;
                    const progress = Math.min(elapsed / this.duration, 1);
                    
                    this.currentValue = progress * this.target;
                    
                    if (progress < 1) {
                        this.animationFrame = requestAnimationFrame(animate);
                    } else {
                        this.currentValue = this.target;
                    }
                };
                
                this.animationFrame = requestAnimationFrame(animate);
            }, this.delay);
        },
        
        resetCounter() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }
            this.currentValue = 0;
            this.hasAnimated = false;
            this.startTime = null;
        },
        
        restartCounting() {
            this.resetCounter();
            this.startCounting();
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-animate]');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight * 0.85 && elementBottom > 0) {
                const delay = element.getAttribute('data-delay') || 0;
                const shouldRepeat = element.hasAttribute('data-animate-repeat');
                
                setTimeout(() => {
                    if (shouldRepeat || !element.classList.contains('animated')) {
                        element.classList.add('animated');
                    }
                }, parseInt(delay));
            } else if (element.hasAttribute('data-animate-repeat')) {
                element.classList.remove('animated');
            }
        });
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const animatedElements = entry.target.querySelectorAll('[data-animate]');
                animatedElements.forEach((element, index) => {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => {
                        element.classList.add('animated');
                    }, parseInt(delay) + (index * 100));
                });
            } else {
                const animatedElements = entry.target.querySelectorAll('[data-animate][data-animate-repeat]');
                animatedElements.forEach(element => {
                    element.classList.remove('animated');
                });
            }
        });
    }, { 
        threshold: 0.3,
        rootMargin: '-100px 0px -100px 0px' 
    });

    document.querySelectorAll('[data-animate-section]').forEach(section => {
        sectionObserver.observe(section);
    });

    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    window.resetAnimations = function() {
        document.querySelectorAll('[data-animate]').forEach(element => {
            element.classList.remove('animated');
        });
    };
});
</script>
@endpush

@endsection