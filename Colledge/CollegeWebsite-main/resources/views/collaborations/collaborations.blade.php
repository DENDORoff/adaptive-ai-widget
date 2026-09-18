@extends('layouts.app')

@section('title', __('Collaborations'))

@section('content')

<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-black to-gray-900" style="min-height: 90vh;" data-animate-section>
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-cyan-500/10 rounded-full filter blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-blue-500/10 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-40 left-1/3 w-64 h-64 bg-blue-600/10 rounded-full filter blur-3xl"></div>
        
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="absolute top-2/3 right-1/4 w-96 h-px bg-gradient-to-r from-transparent via-cyan-500/30 to-transparent"></div>
            <div class="absolute left-1/4 top-1/3 w-px h-64 bg-gradient-to-b from-transparent via-blue-500/30 to-transparent"></div>
        </div>
        
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="
                background-image: radial-gradient(circle at 2px 2px, #3b82f6 1px, transparent 0);
                background-size: 40px 40px;
            "></div>
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-20">
        <div class="max-w-6xl mx-auto pt-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-animate="fade-right" data-delay="200" data-animate-repeat>
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 border border-blue-500/20 rounded-full mb-6" data-animate="fade-right" data-delay="100" data-animate-repeat>
                        <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full animate-pulse"></div>
                        <span class="text-blue-300 text-sm font-medium uppercase tracking-wider">
                            {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'badge_text', 'Партнёрские отношения') }}
                        </span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight" data-animate="fade-right" data-delay="300" data-animate-repeat>
                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'title_line1', 'Мост между') }}
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 mt-2" data-animate="fade-right" data-delay="400" data-animate-repeat>
                            {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'title_line2', 'образованием и индустрией') }}
                        </span>
                    </h1>

                    <p class="text-xl text-gray-300 mb-8 leading-relaxed" data-animate="fade-right" data-delay="500" data-animate-repeat>
                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'description', 'Создаём экосистему взаимовыгодного сотрудничества, где студенты получают практический опыт, а компании — доступ к талантливым специалистам') }}
                    </p>

                    <div class="flex flex-wrap gap-4 mt-10" data-animate="fade-up" data-delay="600" data-animate-repeat>
                        <a href="#partners" class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold py-3 px-8 rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300">
                            {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'button_text', 'Смотреть партнёров') }}
                        </a>
                    </div>
                </div>

                <div class="relative" data-animate="fade-left" data-delay="700" data-animate-repeat>
                    <div class="relative bg-gradient-to-br from-gray-900/80 to-black/80 border border-blue-500/20 rounded-2xl p-8 backdrop-blur-sm overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-500 animate-gradient-x"></div>
                        
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div x-data="counter({ 
                                target: {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'stat_1_value', '200') }}, 
                                duration: 2000, 
                                delay: 800, 
                                suffix: '+' 
                            })" 
                                 x-intersect.once="startCounting()"
                                 class="stat-circle">
                                <div class="stat-circle-inner">
                                    <div class="text-4xl font-bold text-white mb-2">
                                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                                    </div>
                                    <div class="text-sm text-blue-300">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'stat_1_label', 'Компаний-партнёров') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div x-data="counter({ 
                                target: {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'stat_2_value', '85') }}, 
                                duration: 2000, 
                                delay: 1000, 
                                suffix: '%' 
                            })" 
                                 x-intersect.once="startCounting()"
                                 class="stat-circle">
                                <div class="stat-circle-inner">
                                    <div class="text-4xl font-bold text-white mb-2">
                                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                                    </div>
                                    <div class="text-sm text-cyan-300">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'stat_2_label', 'Трудоустройство') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-blue-500/5 rounded-xl hover:bg-blue-500/10 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <span class="text-white font-medium">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'feature_1_text', 'Дуальное обучение') }}
                                    </span>
                                </div>
                                <span class="text-blue-300 font-bold">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'feature_1_number', '50+ программ') }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-cyan-500/5 rounded-xl hover:bg-cyan-500/10 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white font-medium">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'feature_2_text', 'Совместные проекты') }}
                                    </span>
                                </div>
                                <span class="text-cyan-300 font-bold">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'feature_2_number', '150+ реализовано') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-blue-400/50 rounded-tr-lg"></div>
                        <div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-cyan-400/50 rounded-bl-lg"></div>
                    </div>
                    
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-600/10 to-cyan-600/10 rounded-full blur-xl"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10" data-animate="fade-up" data-delay="1000" data-animate-repeat>
        <div class="flex flex-col items-center gap-2">
            <div class="text-gray-400 text-xs uppercase tracking-wider font-medium">
                {{ \App\Models\PageSection::getValue('collaborations', 'hero', 'scroll_text', 'Исследуйте партнёрства') }}
            </div>
            <div class="relative">
                <div class="w-8 h-12 border-2 border-blue-500/50 rounded-full flex items-start justify-center">
                    <div class="w-1 h-3 bg-gradient-to-b from-blue-400 to-cyan-400 rounded-full mt-2 animate-bounce"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="partners" class="py-24 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16" data-animate="fade-down" data-animate-repeat>
                <div class="inline-flex items-center gap-3 mb-4" data-animate="fade-down" data-delay="100" data-animate-repeat>
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="text-blue-400 font-semibold uppercase tracking-wider text-sm">
                        {{ \App\Models\PageSection::getValue('collaborations', 'partners_header', 'badge_text', 'Партнёрские организации') }}
                    </span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    {{ \App\Models\PageSection::getValue('collaborations', 'partners_header', 'title', 'Наши стратегические партнёры') }}
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
                <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                    {{ \App\Models\PageSection::getValue('collaborations', 'partners_header', 'description', 'Мы сотрудничаем с лидерами индустрии, чтобы обеспечить наших студентов доступом к современным технологиям и практическому опыту') }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
                {{-- Партнёр 1 --}}
                <div class="partner-card" data-animate="fade-up" data-delay="300" data-animate-repeat>
                    <div class="partner-logo-container">
                        <div class="partner-logo">
                            @php
                                $logo1 = \App\Models\PageSection::getValue('collaborations', 'partners_list', 'partner_1_logo', '/storage/partners/partner1.png');
                                $alt1 = \App\Models\PageSection::getValue('collaborations', 'partners_list', 'partner_1_name', 'Партнёр 1');
                            @endphp
                            @if($logo1 && file_exists(public_path($logo1)))
                                <img src="{{ asset($logo1) }}" alt="{{ $alt1 }}" class="w-16 h-16 object-contain">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="partner-name text-white font-bold text-lg mt-4">
                        {{ \App\Models\PageSection::getValue('collaborations', 'partners_list', 'partner_1_name', 'Партнёр 1') }}
                    </div>
                    <div class="partner-category text-blue-300 text-sm mt-1">
                        {{ \App\Models\PageSection::getValue('collaborations', 'partners_list', 'partner_1_category', 'Технологическая компания') }}
                    </div>
                </div>
                
                {{-- Партнёры 2-8 (аналогично) --}}
                @for($i = 2; $i <= 8; $i++)
                    <div class="partner-card" data-animate="fade-up" data-delay="{{ 300 + ($i-1)*100 }}" data-animate-repeat>
                        <div class="partner-logo-container">
                            <div class="partner-logo">
                                @php
                                    $logo = \App\Models\PageSection::getValue('collaborations', 'partners_list', "partner_{$i}_logo", "/storage/partners/partner{$i}.png");
                                    $alt = \App\Models\PageSection::getValue('collaborations', 'partners_list', "partner_{$i}_name", "Партнёр {$i}");
                                @endphp
                                @if($logo && file_exists(public_path($logo)))
                                    <img src="{{ asset($logo) }}" alt="{{ $alt }}" class="w-16 h-16 object-contain">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="partner-name text-white font-bold text-lg mt-4">
                            {{ \App\Models\PageSection::getValue('collaborations', 'partners_list', "partner_{$i}_name", "Партнёр {$i}") }}
                        </div>
                        <div class="partner-category text-blue-300 text-sm mt-1">
                            {{ \App\Models\PageSection::getValue('collaborations', 'partners_list', "partner_{$i}_category", 'Категория') }}
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

<section id="projects" class="py-24 bg-gradient-to-b from-black via-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-animate="fade-right" data-animate-repeat>
                    <div class="inline-flex items-center gap-3 mb-4" data-animate="fade-right" data-delay="100" data-animate-repeat>
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-blue-400 font-semibold uppercase tracking-wider text-sm">
                            {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'badge_text', 'Совместные проекты') }}
                        </span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'title', 'Реализованные проекты с партнёрами') }}
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mb-6" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
                    
                    <div class="space-y-6">
                        {{-- Проект 1 --}}
                        <div class="project-item" data-animate="fade-up" data-delay="300" data-animate-repeat>
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-2">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_1_title', 'Разработка CRM-системы') }}
                                    </h4>
                                    <p class="text-gray-400">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_1_description', 'Совместный проект с ведущей IT-компанией по созданию системы управления клиентами') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Проект 2 --}}
                        <div class="project-item" data-animate="fade-up" data-delay="400" data-animate-repeat>
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-2">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_2_title', 'Умный кампус') }}
                                    </h4>
                                    <p class="text-gray-400">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_2_description', 'Внедрение IoT-решений для автоматизации процессов в учебном заведении') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Проект 3 --}}
                        <div class="project-item" data-animate="fade-up" data-delay="500" data-animate-repeat>
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white mb-2">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_3_title', 'Система кибербезопасности') }}
                                    </h4>
                                    <p class="text-gray-400">
                                        {{ \App\Models\PageSection::getValue('collaborations', 'projects_list', 'project_3_description', 'Разработка и внедрение комплексной системы защиты данных') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-animate="fade-left" data-animate-repeat>
                    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 p-8 backdrop-blur-sm">
                        <div class="text-center mb-8">
                            <div class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-500 mb-4">50+</div>
                            <div class="text-xl text-white font-bold">
                                {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_title', 'Завершённых проектов') }}
                            </div>
                            <div class="text-blue-300">
                                {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_subtitle', 'в 2024 году') }}
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_web_label', 'Веб-разработка') }}
                                </span>
                                <span class="text-white font-bold">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_web_value', '24 проекта') }}
                                </span>
                            </div>
                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500" style="width: {{ \App\Models\PageSection::getValue('collaborations', 'projects_stats', 'web_progress', '80') }}%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_mobile_label', 'Мобильные приложения') }}
                                </span>
                                <span class="text-white font-bold">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_mobile_value', '18 проектов') }}
                                </span>
                            </div>
                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-500" style="width: {{ \App\Models\PageSection::getValue('collaborations', 'projects_stats', 'mobile_progress', '65') }}%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_data_label', 'Data Science') }}
                                </span>
                                <span class="text-white font-bold">
                                    {{ \App\Models\PageSection::getValue('collaborations', 'projects_header', 'stats_data_value', '8 проектов') }}
                                </span>
                            </div>
                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-600 to-cyan-600" style="width: {{ \App\Models\PageSection::getValue('collaborations', 'projects_stats', 'data_progress', '30') }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="dual-education" class="py-24 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden" data-animate-section>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16" data-animate="fade-down" data-animate-repeat>
                <div class="inline-flex items-center gap-3 mb-4" data-animate="fade-down" data-delay="100" data-animate-repeat>
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="text-blue-400 font-semibold uppercase tracking-wider text-sm">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'badge_text', 'Дуальное обучение и практика') }}
                    </span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'title', 'Обучение на рабочем месте') }}
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate="width-grow" data-delay="200" data-animate-repeat></div>
                <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                    {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'description', 'Сочетание теоретического обучения в колледже с практической работой на предприятиях-партнёрах') }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                {{-- Карточка 1 --}}
                <div class="dual-card" data-animate="fade-up" data-delay="300" data-animate-repeat>
                    <div class="dual-icon">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_1_title', 'Теория + Практика') }}
                    </h3>
                    <p class="text-gray-400">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_1_description', '40% времени - обучение в колледже, 60% - практика на предприятии под руководством опытных наставников') }}
                    </p>
                </div>
                
                {{-- Карточка 2 --}}
                <div class="dual-card" data-animate="fade-up" data-delay="400" data-animate-repeat>
                    <div class="dual-icon">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_2_title', 'Наставничество') }}
                    </h3>
                    <p class="text-gray-400">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_2_description', 'Каждый студент получает персонального наставника от предприятия-партнёра') }}
                    </p>
                </div>
                
                {{-- Карточка 3 --}}
                <div class="dual-card" data-animate="fade-up" data-delay="500" data-animate-repeat>
                    <div class="dual-icon">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_3_title', 'Трудоустройство') }}
                    </h3>
                    <p class="text-gray-400">
                        {{ \App\Models\PageSection::getValue('collaborations', 'dual_cards', 'card_3_description', '90% выпускников программ дуального обучения трудоустраиваются сразу после окончания') }}
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500/10 to-cyan-500/10 border border-blue-500/20 rounded-2xl p-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-4">
                            {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stats_title', 'Статистика дуального обучения') }}
                        </h3>
                        <p class="text-gray-400 mb-6">
                            {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stats_description', 'Наши студенты проходят практику в ведущих компаниях страны и получают ценный опыт работы') }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">
                                {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stat_1_value', '1200+') }}
                            </div>
                            <div class="text-blue-300">
                                {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stat_1_label', 'Студентов на дуальном обучении') }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-white mb-2">
                                {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stat_2_value', '85%') }}
                            </div>
                            <div class="text-blue-300">
                                {{ \App\Models\PageSection::getValue('collaborations', 'dual_education_header', 'stat_2_label', 'Успешное трудоустройство') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
[data-animate] {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
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
    transition: all 0.8s ease;
}

[data-animate="width-grow"].animated {
    width: 6rem;
    opacity: 1;
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 3s ease infinite;
}

@keyframes gradient-x {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.stat-circle {
    position: relative;
    padding: 1.5rem;
    border-radius: 1rem;
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
    border: 1px solid rgba(59, 130, 246, 0.3);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-circle:hover {
    transform: translateY(-5px);
    border-color: rgba(59, 130, 246, 0.6);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
}

.stat-circle::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 30%, rgba(59, 130, 246, 0.1), transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-circle:hover::before {
    opacity: 1;
}

.stat-circle-inner {
    position: relative;
    z-index: 1;
    text-align: center;
}

.partner-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.partner-card:hover {
    transform: translateY(-5px);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
}

.partner-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(6, 182, 212, 0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.partner-card:hover::before {
    opacity: 1;
}

.partner-logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80px;
    margin-bottom: 1rem;
}

.partner-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.project-item {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.project-item:hover {
    border-color: rgba(59, 130, 246, 0.5);
    transform: translateX(5px);
}

.dual-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1.5rem;
    padding: 2.5rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.dual-card:hover {
    transform: translateY(-10px);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
}

.dual-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(6, 182, 212, 0.2));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    transition: all 0.3s ease;
}

.dual-card:hover .dual-icon {
    transform: rotateY(360deg) scale(1.1);
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(6, 182, 212, 0.3));
}

@media (max-width: 768px) {
    .partner-card {
        padding: 1.5rem 1rem;
    }
    
    .dual-card {
        padding: 2rem 1.5rem;
    }
    
    h1 {
        font-size: 2.5rem;
    }
    
    .grid-cols-2 {
        grid-template-columns: 1fr;
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
});
</script>
@endpush

@endsection