<header class="bg-white sticky top-0 z-50 border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="header-container">
            <div class="logo-left">
                <a href="{{ route('home') }}" class="group" aria-label="{{ \App\Models\PageSection::getValue('header', 'logo', 'home_label', 'На главную страницу') }}">
                    <div class="logo-item">
                        <img src="{{ asset(\App\Models\PageSection::getValue('header', 'logo', 'logo1_url', 'images/new45.png')) }}" 
                             alt="{{ \App\Models\PageSection::getValue('header', 'logo', 'logo1_alt', 'College Logo') }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-blue-600 rounded-full hidden items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ \App\Models\PageSection::getValue('header', 'logo', 'logo1_fallback', 'П') }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <nav class="nav-container hidden lg:flex items-center gap-4">
                <a href="{{ route('home') }}" class="nav-link">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'home_label', 'Главная') }}</a>
                
                @php
                    $charterDoc = \App\Models\CollegeDocument::active()->ofType('charter')->orderBy('order', 'asc')->first();
                    $licenseDoc = \App\Models\CollegeDocument::active()->ofType('license')->orderBy('order', 'asc')->first();
                    $rulesDoc = \App\Models\CollegeDocument::active()->ofType('rules')->orderBy('order', 'asc')->first();
                @endphp

                <div class="relative nav-dropdown-click">
                    <button class="nav-link" aria-expanded="false" onclick="toggleDropdown(this)">
                        {{ \App\Models\PageSection::getValue('navigation', 'menu', 'about_label', 'О колледже') }}
                        <svg class="w-4 h-4 ml-1 inline transition-transform dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu opacity-0 invisible">
                        <a href="{{ route('about') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'about_us_label', 'О нас') }}</a>
                        
                        @if($charterDoc)
                            <a href="{{ route('college-documents.show', 'charter') }}" target="_blank" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'charter_label', 'Устав колледжа') }}</span>
                            </a>
                        @else
                            <span class="block px-4 py-2 text-gray-500 cursor-not-allowed">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'charter_label', 'Устав колледжа') }}</span>
                        @endif
                        
                        @if($licenseDoc)
                            <a href="{{ route('college-documents.show', 'license') }}" target="_blank" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'license_label', 'Лицензия на образовательную деятельность') }}</span>
                            </a>
                        @else
                            <span class="block px-4 py-2 text-gray-500 cursor-not-allowed">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'license_label', 'Лицензия на образовательную деятельность') }}</span>
                        @endif
                        
                        <a href="{{ route('achievements.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'achievements_label', 'Достижения колледжа') }}</a>
                        <a href="{{ route('achievements.index') }}#graduates">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'graduates_label', 'Наши выпускники') }}</a>
                        <a href="{{ route('staff.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'staff_label', 'Администрация и преподаватели') }}</a>
                        <a href="{{ route('trade-union') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'trade_union_label', 'Профсоюз') }}</a>
                        <a href="{{ route('sovet') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'council_label', 'Советы при колледже') }}</a>
                    </div>
                </div>
                
                <div class="relative nav-dropdown-click">
                    <button class="nav-link" aria-expanded="false" onclick="toggleDropdown(this)">
                        {{ \App\Models\PageSection::getValue('navigation', 'menu', 'applicants_label', 'Поступающим') }}
                        <svg class="w-4 h-4 ml-1 inline transition-transform dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu opacity-0 invisible">
                        <a href="javascript:void(0)" onclick="openConsultationModal()">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'consultation_label', 'Консультация приемной комиссии') }}</a>
                        <a href="{{ route('home') }}#virtual-tour" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'virtual_tour_label', 'Виртуальный тур') }}</a>
                        <a href="{{ route('home') }}#faq" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'faq_label', 'Частые вопросы') }}</a>
                        <a href="{{ route('blog.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'blog_label', 'Блог руководителя') }}</a>
                        <a href="{{ route('youth-movement') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'youth_movement_label', 'Молодежный движ') }}</a>
                        <a href="{{ route('collaborations') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-lg text-sm transition">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'collaboration_label', 'Коллаборация') }}</a>
                    </div>
                </div>
                
                <div class="relative nav-dropdown-click">
                    <button class="nav-link" aria-expanded="false" onclick="toggleDropdown(this)">
                        {{ \App\Models\PageSection::getValue('navigation', 'menu', 'students_label', 'Студентам') }}
                        <svg class="w-4 h-4 ml-1 inline transition-transform dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu opacity-0 invisible">
                        <a href="{{ route('curators.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'curators_label', 'Кураторы групп') }}</a>
                        <a href="{{ route('contacts.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'contacts_label', 'Телефонный справочник') }}</a>
                        <a href="{{ route('library.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'library_label', 'Библиотека') }}</a>
                        <a href="{{ route('blog.index') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'blog_label', 'Блог руководителя') }}</a>
                        
                        @if($rulesDoc)
                            <a href="{{ route('college-documents.show', 'rules') }}" target="_blank" class="flex items-center gap-2 rules-link">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span>{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'rules_label', 'Правила внутреннего распорядка') }}</span>
                            </a>
                        @else
                            <span class="block px-4 py-2 text-gray-500 cursor-not-allowed rules-link">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'rules_label', 'Правила внутреннего распорядка') }}</span>
                        @endif
                        
                        <a href="{{ route('youth-movement') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'youth_movement_label', 'Молодежный движ') }}</a>
                        <a href="{{ route('collaborations') }}">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'collaboration_label', 'Коллаборация') }}</a>
                    </div>
                </div>
                
                <div class="relative nav-dropdown-click">
                    <button class="nav-link" aria-expanded="false" onclick="toggleDropdown(this)">
                        {{ \App\Models\PageSection::getValue('navigation', 'menu', 'schedule_label', 'Расписание') }}
                        <svg class="w-4 h-4 ml-1 inline transition-transform dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu opacity-0 invisible">
                        @php
                            $lessonsSchedule = \App\Models\Schedule::active()->lessons()->latest()->first();
                            $bellsSchedule = \App\Models\Schedule::active()->bells()->latest()->first();
                        @endphp
                        @if($lessonsSchedule)
                            <a href="javascript:void(0)" onclick="openPdfModal('{{ $lessonsSchedule->file_url }}', '{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}')">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}</a>
                        @else
                            <span class="block px-3 py-2 text-gray-500 cursor-not-allowed">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'lessons_schedule_label', 'Расписание занятий') }}</span>
                        @endif
                        @if($bellsSchedule)
                            <a href="javascript:void(0)" onclick="openPdfModal('{{ $bellsSchedule->file_url }}', '{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}')">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}</a>
                        @else
                            <span class="block px-3 py-2 text-gray-500 cursor-not-allowed">{{ \App\Models\PageSection::getValue('navigation', 'submenu', 'bells_schedule_label', 'Расписание звонков') }}</span>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('news.index') }}" class="nav-link">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'news_label', 'Новости') }}</a>
                
                <button onclick="openContactsModal()" class="nav-link">{{ \App\Models\PageSection::getValue('navigation', 'menu', 'contacts_label', 'Контакты') }}</button>
                
                <div class="relative search-wrapper">
                    <button class="nav-link search-button" onclick="toggleSearch()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    <form class="search-form" id="searchForm">
                        <input type="text" 
                               class="search-input" 
                               placeholder="{{ \App\Models\PageSection::getValue('header', 'search', 'placeholder', 'Поиск по сайту...') }}" 
                               id="searchInput"
                               oninput="handleSearchInput(this.value)">
                        <div class="search-results-container hidden" id="searchResults"></div>
                    </form>
                </div>

                <div class="burger-menu-desktop">
                    <button class="burger-btn-desktop" onclick="toggleDesktopBurgerMenu()" aria-label="{{ \App\Models\PageSection::getValue('header', 'burger_menu', 'open_label', 'Открыть меню') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="burger-menu-desktop-content" id="desktopBurgerMenu">
                        <div class="burger-menu-header">
                            <div class="burger-menu-title">{{ \App\Models\PageSection::getValue('header', 'burger_menu', 'title', 'Дополнительное меню') }}</div>
                            <button class="burger-menu-close" onclick="closeDesktopBurgerMenu()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <a href="{{ route('infoboard.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'situation_center_label', 'Ситуационный центр') }}
                        </a>
                        <a href="{{ route('state-symbols.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'state_symbols_label', 'Государственные символы') }}
                        </a>
                        <a href="{{ route('vacancies.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'vacancies_label', 'Вакансии педагогов') }}
                        </a>
                        <a href="{{ route('goscorruption.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'anti_corruption_label', 'Противодействие коррупции') }}
                        </a>
                        <a href="{{ route('expertise.index') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'burger_menu', 'government_services_label', 'Государственные услуги') }}
                        </a>
                    </div>
                </div>
            </nav>

            <div class="logo-right">
                <a href="{{ route('home') }}" class="group" aria-label="{{ \App\Models\PageSection::getValue('header', 'logo', 'home_label', 'На главную страницу') }}">
                    <div class="logo-item">
                        <img src="{{ asset(\App\Models\PageSection::getValue('header', 'logo', 'logo2_url', 'images/college-logo.png')) }}" 
                             alt="{{ \App\Models\PageSection::getValue('header', 'logo', 'logo2_alt', 'Second Logo') }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-green-600 rounded-full hidden items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ \App\Models\PageSection::getValue('header', 'logo', 'logo2_fallback', 'Л') }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 transition" aria-label="{{ \App\Models\PageSection::getValue('header', 'mobile_menu', 'open_label', 'Открыть меню') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="flex items-center lg:hidden gap-2">
                <a href="{{ route('home') }}" class="logo-container mobile-logo group" aria-label="{{ \App\Models\PageSection::getValue('header', 'logo', 'home_label', 'На главную страницу') }}">
                    <div class="logo-item">
                        <img src="{{ asset(\App\Models\PageSection::getValue('header', 'logo', 'logo1_url', 'images/new45.png')) }}" 
                             alt="{{ \App\Models\PageSection::getValue('header', 'logo', 'logo1_alt', 'College Logo') }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-blue-600 rounded-full hidden items-center justify-content-center">
                            <span class="text-white font-bold text-2xl">{{ \App\Models\PageSection::getValue('header', 'logo', 'logo1_fallback', 'П') }}</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('home') }}" class="logo-container mobile-second-logo group" aria-label="{{ \App\Models\PageSection::getValue('header', 'logo', 'home_label', 'На главную страницу') }}">
                    <div class="logo-item">
                        <img src="{{ asset(\App\Models\PageSection::getValue('header', 'logo', 'logo2_url', 'images/college-logo.png')) }}" 
                             alt="{{ \App\Models\PageSection::getValue('header', 'logo', 'logo2_alt', 'Second Logo') }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-green-600 rounded-full hidden items-center justify-content-center">
                            <span class="text-white font-bold text-2xl">{{ \App\Models\PageSection::getValue('header', 'logo', 'logo2_fallback', 'Л') }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>
