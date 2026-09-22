<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}</title>
    
    
    <meta name="description" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'description', 'College website') }}">
    <meta name="keywords" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'keywords', 'college, education') }}">
    <meta name="author" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    
    <meta property="og:title" content="@yield('title') - {{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}">
    <meta property="og:description" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'description', 'College website') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
    
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - {{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}">
    <meta name="twitter:description" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'description', 'College website') }}">
    
    
    <link rel="canonical" href="{{ url()->current() }}">
    
    
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="kk" href="{{ url('kk' . str_replace(url('/'), '', url()->current())) }}">
    <link rel="alternate" hreflang="ru" href="{{ url('ru' . str_replace(url('/'), '', url()->current())) }}">
    
    <link rel="manifest" href="/manifest.json">
    <link rel="sitemap" href="/sitemap.xml">
    <link rel="robots" href="/robots.txt">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\PageSection::getValue('global', 'metadata', 'site_name', 'College') }}">
    
    <link rel="stylesheet" href="{{ asset('css/bvi-icons-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bvi-icons-override.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">

    <x-header-top-bar />

    
    <x-header-navbar />

    
    <x-modals.bug-report />
    <x-modals.pdf />
    <x-modals.reception-schedule />
    <x-modals.call-center />
    <x-modals.support />
    <x-modals.consultation />
    <x-modals.contacts />
    <x-modals.situation-center />

    <div class="content-wrapper">
        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    
    <div id="scrollArrow" class="scroll-arrow bottom">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>

    
    <button id="contactAdminBtn" class="contact-admin-fab" onclick="openContactAdmin()" aria-label="{{ \App\Models\PageSection::getValue('chat', 'window', 'fab_label', 'Связь с администратором') }}">
        <svg class="contact-admin-fab-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        <span>{{ \App\Models\PageSection::getValue('chat', 'window', 'fab_label', 'Связь с администратором') }}</span>
    </button>

    
    <div id="chatWindow" class="chat-window contact-admin-panel" role="dialog" aria-modal="true" aria-label="{{ \App\Models\PageSection::getValue('chat', 'window', 'title', 'Связь с администратором') }}">
        <div class="chat-header">
            <div class="chat-header-content">
                <div class="chat-avatar">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div class="chat-header-info">
                    <h3>{{ \App\Models\PageSection::getValue('chat', 'window', 'title', 'Связь с администратором') }}</h3>
                    <p>{{ \App\Models\PageSection::getValue('chat', 'window', 'subtitle', 'Позвоните, напишите или откройте чат-поддержку') }}</p>
                </div>
            </div>
            <button class="chat-close-btn" onclick="closeContactAdmin()" aria-label="{{ \App\Models\PageSection::getValue('chat', 'window', 'close_label', 'Закрыть') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="contact-admin-body">
            <div class="contact-admin-item">
                <svg class="contact-admin-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <div>
                    <div class="contact-admin-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phones_label', 'Телефоны') }}</div>
                    <div class="contact-admin-value">
                        <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone1_number', '+77182338733') }}">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone1_text', '(7182) 33-87-33') }}</a>
                        <span class="sep">·</span>
                        <a href="tel:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone2_number', '+77182338440') }}">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'phone2_text', '(7182) 33-84-40') }}</a>
                    </div>
                </div>
            </div>

            <div class="contact-admin-item">
                <svg class="contact-admin-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div>
                    <div class="contact-admin-label">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_label', 'E-mail') }}</div>
                    <div class="contact-admin-value"><a href="mailto:{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_address', 'vkeik@edu.kz') }}">{{ \App\Models\PageSection::getValue('modals', 'contacts', 'email_address', 'vkeik@edu.kz') }}</a></div>
                </div>
            </div>

            <div class="contact-admin-note">{{ \App\Models\PageSection::getValue('chat', 'window', 'note', 'Задайте вопрос в чате — ИИ-помощник отвечает сразу на основе данных колледжа, а при необходимости подключает специалиста.') }}</div>

            <button class="contact-admin-cta" onclick="closeContactAdmin(); window.AdaptiveWidget && window.AdaptiveWidget.open()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span>{{ \App\Models\PageSection::getValue('chat', 'window', 'cta_text', 'Открыть чат с поддержкой') }}</span>
            </button>
        </div>
    </div>

    
    <div id="mobile-menu" class="lg:hidden fixed inset-0 z-40 hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="mobile-menu-backdrop"></div>
        
        <div class="absolute top-0 left-0 right-0 w-full bg-white shadow-2xl transform transition-transform duration-300 overflow-y-auto max-h-screen">
            <div class="p-4">
                <button id="mobile-menu-close" class="ml-auto mb-4 p-2 text-gray-600 hover:text-gray-900 transition flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100" aria-label="{{ \App\Models\PageSection::getValue('header', 'mobile_menu', 'close_label', 'Закрыть меню') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                
                <div class="mobile-language-switcher">
                    <a href="{{ route('locale.switch', 'kk') }}" class="mobile-language-btn {{ app()->getLocale() == 'kk' ? 'active' : '' }}" title="Қазақша">{{ \App\Models\PageSection::getValue('header', 'languages', 'kaz_label', 'ҚАЗ') }}</a>
                    <a href="{{ route('locale.switch', 'ru') }}" class="mobile-language-btn {{ app()->getLocale() == 'ru' ? 'active' : '' }}" title="Русский">{{ \App\Models\PageSection::getValue('header', 'languages', 'rus_label', 'РУС') }}</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="mobile-language-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">{{ \App\Models\PageSection::getValue('header', 'languages', 'eng_label', 'ENG') }}</a>
                </div>

               
                <div id="mobile-weather-widget" class="mobile-weather-widget hidden">
                    <div class="mobile-weather-info">
                        <img id="mobile-weather-icon" src="" alt="{{ \App\Models\PageSection::getValue('weather', 'widget', 'alt_text', 'Погода') }}" class="mobile-weather-icon">
                        <div>
                            <div id="mobile-weather-temp" class="mobile-weather-temp"></div>
                            <div id="mobile-weather-desc" class="mobile-weather-details">{{ \App\Models\PageSection::getValue('weather', 'widget', 'city', 'Павлодар') }}</div>
                        </div>
                    </div>
                </div>
                <div id="mobile-weather-error" class="mobile-weather-error hidden">
                    {{ \App\Models\PageSection::getValue('weather', 'widget', 'error_message', 'Не удалось загрузить данные о погоде') }}
                </div>

                
                <div class="mobile-search-form">
                    <input type="text" 
                           class="mobile-search-input" 
                           placeholder="{{ \App\Models\PageSection::getValue('header', 'search', 'placeholder', 'Поиск по сайту...') }}"
                           id="mobileSearchInput"
                           oninput="handleMobileSearchInput(this.value)">
                    <div class="search-results-container hidden" id="mobileSearchResults"></div>
                </div>

                
                <nav class="space-y-2">
                    @php
                        $charterDoc = \App\Models\CollegeDocument::active()->ofType('charter')->orderBy('order', 'asc')->first();
                        $licenseDoc = \App\Models\CollegeDocument::active()->ofType('license')->orderBy('order', 'asc')->first();
                        $rulesDoc = \App\Models\CollegeDocument::active()->ofType('rules')->orderBy('order', 'asc')->first();
                        $lessonsSchedule = \App\Models\Schedule::active()->lessons()->latest()->first();
                        $bellsSchedule = \App\Models\Schedule::active()->bells()->latest()->first();
                    @endphp

                    <div class="mobile-top-buttons mb-4 pb-4 border-b border-gray-200">
                        <button onclick="closeMobileMenu(); openCallCenterModal();" class="block w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'call_center_label', 'Колл-центр') }}
                        </button>
                        <button onclick="closeMobileMenu(); openReceptionModal();" class="block w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'reception_schedule_label', 'График приёма') }}
                        </button>
                        <a href="{{ route('blog.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'blog_label', 'Блог руководителя') }}
                        </a>
                        <button onclick="closeMobileMenu(); openSupportModal();" class="block w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'support_label', 'Служба поддержки') }}
                        </button>
                        <button class="bvi-open block w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'bvi_label', 'Версия для слабовидящих') }}
                        </button>
                        <a href="{{ route('infoboard.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'situation_center_label', 'Ситуационный центр') }}
                        </a>
                    </div>

                    
                    <a href="{{ route('home') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'home_label', 'Главная') }}</a>
                    
                    
                    <div class="mobile-dropdown">
                        <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium" aria-expanded="false">
                            <span>{{ \App\Models\PageSection::getValue('navigation', 'menu', 'about_label', 'О колледже') }}</span>
                            <svg class="w-5 h-5 transform transition-transform dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-4 mt-2 space-y-2">
                            <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'about_us_label', 'О нас') }}</a>
                            @if($charterDoc)
                                <a href="{{ route('college-documents.show', 'charter') }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'charter_label', 'Устав колледжа') }}
                                </a>
                            @endif
                            @if($licenseDoc)
                                <a href="{{ route('college-documents.show', 'license') }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'license_label', 'Лицензия на образовательную деятельность') }}
                                </a>
                            @endif
                            <a href="{{ route('achievements.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'achievements_label', 'Достижения колледжа') }}</a>
                            <a href="{{ route('achievements.index') }}#graduates" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'graduates_label', 'Наши выпускники') }}</a>
                            <a href="{{ route('staff.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'staff_label', 'Администрация и преподаватели') }}</a>
                            <a href="{{ route('trade-union') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'trade_union_label', 'Профсоюз') }}</a>
                            <a href="{{ route('sovet') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'council_label', 'Советы при колледже') }}</a>
                        </div>
                    </div>
                    
                    
                    <div class="mobile-dropdown">
                        <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium" aria-expanded="false">
                            <span>{{ \App\Models\PageSection::getValue('navigation', 'menu', 'applicants_label', 'Поступающим') }}</span>
                            <svg class="w-5 h-5 transform transition-transform dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-4 mt-2 space-y-2">
                            <a href="javascript:void(0)" onclick="closeMobileMenu(); openConsultationModal();" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'consultation_label', 'Консультация приемной комиссии') }}</a>
                            <a href="{{ route('home') }}#virtual-tour" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'virtual_tour_label', 'Виртуальный тур') }}</a>
                            <a href="{{ route('home') }}#faq" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'faq_label', 'Частые вопросы') }}</a>
                            <a href="{{ route('blog.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'blog_label', 'Блог руководителя') }}</a>
                            <a href="{{ route('youth-movement') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'youth_movement_label', 'Молодежный движ') }}</a>
                            <a href="{{ route('collaborations') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'collaboration_label', 'Коллаборация') }}</a>
                        </div>
                    </div>

                    
                    <div class="mobile-dropdown">
                        <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium" aria-expanded="false">
                            <span>{{ \App\Models\PageSection::getValue('navigation', 'menu', 'students_label', 'Студентам') }}</span>
                            <svg class="w-5 h-5 transform transition-transform dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-4 mt-2 space-y-2">
                            <a href="{{ route('curators.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'curators_label', 'Кураторы групп') }}</a>
                            <a href="{{ route('contacts.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'contacts_label', 'Телефонный справочник') }}</a>
                            <a href="{{ route('library.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'library_label', 'Библиотека') }}</a>
                            <a href="{{ route('blog.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'blog_label', 'Блог руководителя') }}</a>
                            @if($rulesDoc)
                                <a href="{{ route('college-documents.show', 'rules') }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'rules_label', 'Правила внутреннего распорядка') }}
                                </a>
                            @endif
                            <a href="{{ route('youth-movement') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'youth_movement_label', 'Молодежный движ') }}</a>
                            <a href="{{ route('collaborations') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'collaboration_label', 'Коллаборация') }}</a>
                        </div>
                    </div>

                    
                    <div class="mobile-dropdown">
                        <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium" aria-expanded="false">
                            <span>{{ \App\Models\PageSection::getValue('navigation', 'menu', 'schedule_label', 'Расписание') }}</span>
                            <svg class="w-5 h-5 transform transition-transform dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-4 mt-2 space-y-2">
                            @if($lessonsSchedule)
                                <a href="javascript:void(0)" onclick="closeMobileMenu(); openPdfModal('{{ $lessonsSchedule->file_url }}', '{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}');" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}</a>
                            @else
                                <span class="block px-4 py-2 text-gray-500 cursor-not-allowed text-sm">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}</span>
                            @endif
                            @if($bellsSchedule)
                                <a href="javascript:void(0)" onclick="closeMobileMenu(); openPdfModal('{{ $bellsSchedule->file_url }}', '{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}');" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}</a>
                            @else
                                <span class="block px-4 py-2 text-gray-500 cursor-not-allowed text-sm">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}</span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('news.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'news_label', 'Новости') }}</a>
                    
                    <button onclick="closeMobileMenu(); openContactsModal();" class="block w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'contacts_label', 'Контакты') }}</button>

                    <a href="{{ route('goscorruption.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('header', 'burger_menu', 'anti_corruption_label', 'Противодействие коррупции') }}</a>
                    
                    <a href="{{ route('expertise.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('header', 'burger_menu', 'government_services_label', 'Государственные услуги') }}</a>
                    
                    <a href="{{ route('vacancies.index') }}" class="block px-4 py-3 hover:bg-gray-100 rounded-lg transition font-medium">{{ \App\Models\PageSection::getValue('header', 'burger_menu', 'vacancies_label', 'Вакансии педагогов') }}</a>
                </nav>
            </div>
        </div>
    </div>

    
    <div id="cookieBanner" class="cookie-banner">
        <div class="cookie-text">
            {{ \App\Models\PageSection::getValue('cookies', 'banner', 'text', 'Данный сайт используют файлы cookies, которые сохраняют нас идентификации и помогают нам удалить какой-нибудь информативным и ускорить использование услуги. Если вы продолжаете использование этого вебсайта, то означает, что вы согласны с этим.') }}
        </div>
        <button class="cookie-button" onclick="acceptCookies()">
            {{ \App\Models\PageSection::getValue('cookies', 'banner', 'button_text', 'Согласен') }}
        </button>
    </div>

    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym({{ config('services.yandex_metrika.counter_id') }}, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ config('services.yandex_metrika.counter_id') }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

    @livewireScripts

    <script src="{{ asset('js/app-layout.js') }}"></script>

   
    <style>
@media (max-width: 1023px) {
    .mobile-weather-widget {
        display: flex !important;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-radius: 12px;
        margin: 16px 0;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        text-decoration: none;
    }

    .mobile-weather-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .mobile-weather-temp {
        font-size: 18px;
        font-weight: 700;
        color: white;
        text-decoration: none;
    }

    .mobile-weather-icon {
        width: 40px;
        height: 40px;
        filter: brightness(0) invert(1);
    }

    .mobile-weather-details {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.9);
    }

    .mobile-weather-error {
        font-size: 14px;
        color: #64748b;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin: 16px 0;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .mobile-language-switcher {
        display: flex;
        gap: 8px;
        margin: 16px 0;
    }

    .mobile-language-btn {
        flex: 1;
        padding: 10px 16px;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        color: #475569;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .mobile-language-btn.active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .mobile-language-btn:hover {
        background: #e2e8f0;
    }

    .mobile-language-btn.active:hover {
        background: #2563eb;
    }
    
    .mobile-search-form {
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin: 16px 0;
        position: relative;
    }

    .mobile-search-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        background: white;
    }
    
    #mobile-menu {
        z-index: 10000 !important;
    }
    
    #mobile-menu .bg-white {
        transform: translateY(-100%);
        transition: transform 0.3s ease;
        z-index: 10001;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        max-width: 100%;
        height: auto;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 0 0 1rem 1rem;
        background: #ffffff !important;
    }
    
    #mobile-menu.show .bg-white {
        transform: translateY(0);
    }
    
    #mobile-menu.show {
        display: block !important;
    }
    
    .mobile-dropdown-menu {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        margin-top: 0.5rem;
        z-index: 1001;
    }
    
    .mobile-dropdown-menu.show {
        display: block !important;
    }
}
    </style>

    
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            if (!mobileMenu) return;
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('show');
            mobileMenu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const sidebar = mobileMenu.querySelector('.bg-white');
                if (sidebar) {
                    sidebar.style.transform = 'translateY(0)';
                }
            }, 10);
        });
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
    }

    
    document.querySelectorAll('.mobile-dropdown > button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const dropdown = this.parentElement;
            const menu = dropdown.querySelector('.mobile-dropdown-menu');
            const arrow = this.querySelector('.dropdown-arrow');
            
            document.querySelectorAll('.mobile-dropdown').forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    const otherMenu = otherDropdown.querySelector('.mobile-dropdown-menu');
                    const otherArrow = otherDropdown.querySelector('.dropdown-arrow');
                    if (otherMenu) {
                        otherMenu.classList.remove('show');
                        otherMenu.classList.add('hidden');
                    }
                    if (otherArrow) {
                        otherArrow.classList.remove('rotate-180');
                    }
                    otherDropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
                }
            });

            if (menu) {
                menu.classList.toggle('hidden');
                menu.classList.toggle('show');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
            const isExpanded = menu?.classList.contains('hidden') ? 'false' : 'true';
            this.setAttribute('aria-expanded', isExpanded);
        });
    });

    document.querySelectorAll('.mobile-dropdown-menu button').forEach(button => {
        button.addEventListener('click', function(e) {
            const dropdownMenu = this.closest('.mobile-dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.classList.remove('show');
                dropdownMenu.classList.add('hidden');
                
                const dropdown = dropdownMenu.closest('.mobile-dropdown');
                const button = dropdown?.querySelector('button');
                const arrow = dropdown?.querySelector('.dropdown-arrow');
                
                if (button) {
                    button.setAttribute('aria-expanded', 'false');
                }
                if (arrow) {
                    arrow.classList.remove('rotate-180');
                }
            }
        });
    });
});

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (!mobileMenu) return;
    
    const sidebar = mobileMenu.querySelector('.bg-white');
    if (sidebar) {
        sidebar.style.transform = 'translateY(-100%)';
    }
    
    setTimeout(() => {
        mobileMenu.classList.remove('show');
        mobileMenu.classList.add('hidden');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }, 300);
}
    </script>

    @stack('scripts')

    <script>
    window.ADAPTIVE_WIDGET = {
        siteName: 'Высший колледж электроники и коммуникации',
        position: 'right',
        endpoint: 'http://127.0.0.1:3000/api',
        model: 'qwen2.5:3b',
        provider: 'auto',
        aiEnabled: true,
        autoOpen: false,
        teaser: 'Спросите о поступлении, специальностях или документах',
        sound: false
    };
    </script>
    <script src="{{ asset('js/adaptive-widget.js') }}"></script>

</body>
</html>
