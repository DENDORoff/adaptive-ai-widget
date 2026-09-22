<footer class="bg-gray-950 pt-16 pb-8">
    <div class="container mx-auto px-4">
        
        <div class="mb-12">
            <h3 class="text-white font-bold mb-4 uppercase">
                {{ \App\Models\PageSection::getValue('footer', 'map', 'title', 'МЕСТОПОЛОЖЕНИЕ') }}
            </h3>
            <div class="rounded-lg overflow-hidden h-96 w-full">
                <iframe 
                    src="{{ \App\Models\PageSection::getValue('footer', 'map', 'iframe_src', 'https://yandex.ru/map-widget/v1/?ll=76.97822717164688,52.29349433475749&z=15&l=map&pt=76.97822717164688,52.29349433475749,pm2rdm') }}" 
                    class="w-full h-full"
                    frameborder="0"
                    loading="lazy"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12 js-reveal">
            
           
            <div class="flex flex-col footer-btns">
                <h3 class="text-white font-bold mb-4 uppercase">
                    {{ \App\Models\PageSection::getValue('footer', 'quick_links', 'title', 'БЫСТРЫЕ ССЫЛКИ') }}
                </h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>
                        <button onclick="openCallCenterModal()" aria-label="{{ \App\Models\PageSection::getValue('header', 'top_menu', 'call_center_label', 'Колл-центр') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'call_center_label', 'Колл-центр') }}
                        </button>
                    </li>
                    <li>
                        <button onclick="openReceptionModal()" aria-label="{{ \App\Models\PageSection::getValue('header', 'top_menu', 'reception_schedule_label', 'График приёма') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'reception_schedule_label', 'График приёма') }}
                        </button>
                    </li>
                    <li>
                        <button onclick="openSupportModal()" aria-label="{{ \App\Models\PageSection::getValue('header', 'top_menu', 'support_label', 'Служба поддержки') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'support_label', 'Служба поддержки') }}
                        </button>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'blog_label', 'Блог руководителя') }}
                        </a>
                    </li>
                    <li>
                        <button class="bvi-open" aria-label="{{ \App\Models\PageSection::getValue('header', 'top_menu', 'bvi_label', 'Версия для слабовидящих') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('header', 'top_menu', 'bvi_label', 'Версия для слабовидящих') }}
                        </button>
                    </li>
                </ul>
            </div>

            
            <div class="flex flex-col footer-btns">
                <h3 class="text-white font-bold mb-4 uppercase">
                    {{ \App\Models\PageSection::getValue('footer', 'for_applicants', 'title', 'ПОСТУПАЮЩИМ') }}
                </h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>
                        <button onclick="openConsultationModal()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'consultation_label', 'Консультация приёмной комиссии') }}
                        </button>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#virtual-tour">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'virtual_tour_label', 'Виртуальный тур') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#faq">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'faq_label', 'Частые вопросы') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('youth-movement') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'youth_movement_label', 'Молодёжный движ') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('collaborations') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('navigation', 'submenu', 'collaboration_label', 'Коллаборация') }}
                        </a>
                    </li>
                </ul>
            </div>

            
            <div class="flex flex-col">
                <h3 class="text-white font-bold mb-4 uppercase">
                    {{ \App\Models\PageSection::getValue('footer', 'additional', 'title', 'Дополнительно') }}
                </h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    @for($i = 1; $i <= 3; $i++)
                        @php
                            $text = \App\Models\PageSection::getValue('footer', 'additional', "link_{$i}_text", '');
                            $url = \App\Models\PageSection::getValue('footer', 'additional', "link_{$i}_url", '');
                        @endphp
                        @if($text && $url)
                            <li><a href="{{ $url }}" class="hover:text-blue-400 transition">{{ $text }}</a></li>
                        @endif
                    @endfor
                    <li>
                        <button onclick="{{ \App\Models\PageSection::getValue('footer', 'additional', 'bug_report_function', 'openBugReportModal()') }}" class="hover:text-blue-400 transition flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('footer', 'additional', 'bug_report_text', 'Нашли ошибку на сайте?') }}
                        </button>
                    </li>
                </ul>
            </div>

            
            <div class="flex flex-col">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center overflow-hidden">
                        @php
                            $logoUrl = \App\Models\PageSection::getValue('footer', 'contacts', 'logo_url', asset('images/college-logo.png'));
                            $logoAlt = \App\Models\PageSection::getValue('footer', 'contacts', 'logo_alt', 'Логотип колледжа');
                            $logoFallback = \App\Models\PageSection::getValue('footer', 'contacts', 'logo_fallback', 'Лого');
                        @endphp
                        
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" 
                                 alt="{{ $logoAlt }}" 
                                 class="w-full h-full object-cover" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        
                        <div class="hidden text-gray-400 text-xs text-center flex items-center justify-center w-full h-full">
                            {{ $logoFallback }}
                        </div>
                    </div>
                    
                    <h3 class="text-white font-bold uppercase">
                        {{ \App\Models\PageSection::getValue('footer', 'contacts', 'title', 'КОНТАКТЫ') }}
                    </h3>
                </div>

                <ul class="space-y-3 text-sm text-gray-400">
                    
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('footer', 'contacts', 'address', 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2') }}</span>
                    </li>
                    
                    
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('footer', 'contacts', 'phone', '+7 (701) 490-05-66') }}</span>
                    </li>
                    
                    
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('footer', 'contacts', 'email', 'vkeik@edu.kz') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        
        <div class="border-t border-gray-800 pt-8 js-reveal">
            <div class="footer-strip">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-sm text-gray-500">{{ \App\Models\PageSection::getValue('header', 'social', 'find_us_label', 'Найди нас:') }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ \App\Models\PageSection::getValue('header', 'social', 'youtube_url', 'https://www.youtube.com/@%D0%9A%D0%BE%D0%BB%D0%BB%D0%B5%D0%B4%D0%B6%D0%92%D0%9A%D0%AD%D0%B8%D0%9A') }}" target="_blank" class="social-link" aria-label="YouTube">
                            <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        <a href="{{ \App\Models\PageSection::getValue('header', 'social', 'telegram_url', 'https://t.me/vkeik_kz') }}" target="_blank" class="social-link" aria-label="Telegram">
                            <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.91 3.79L20.3 20.84c-.25 1.21-.98 1.5-2 .94l-5.5-4.07-2.66 2.56c-.29.29-.55.54-1.1.54l.4-5.78 10.63-9.59c.44-.44-.1-.69-.66-.25L6.74 13.3 1.18 11.6c-1.18-.37-1.19-1.16.26-1.75l21.54-8.27c.98-.35 1.8.24 1.48 1.21z"/>
                            </svg>
                        </a>
                        <a href="{{ \App\Models\PageSection::getValue('header', 'social', 'instagram_url', 'https://www.instagram.com/vkeik_kz/?hl=ru') }}" target="_blank" class="social-link" aria-label="Instagram">
                            <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="{{ \App\Models\PageSection::getValue('header', 'social', 'whatsapp_url', 'https://wa.me/77014900566') }}" target="_blank" class="social-link" aria-label="WhatsApp">
                            <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.438 9.88-9.888 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="langs">
                    <a href="{{ route('locale.switch', 'kk') }}" class="language-btn {{ app()->getLocale() == 'kk' ? 'active' : '' }}" title="Қазақша">{{ \App\Models\PageSection::getValue('header', 'languages', 'kaz_label', 'ҚАЗ') }}</a>
                    <a href="{{ route('locale.switch', 'ru') }}" class="language-btn {{ app()->getLocale() == 'ru' ? 'active' : '' }}" title="Русский">{{ \App\Models\PageSection::getValue('header', 'languages', 'rus_label', 'РУС') }}</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="language-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">{{ \App\Models\PageSection::getValue('header', 'languages', 'eng_label', 'ENG') }}</a>
                </div>

                <div class="weather-widget-container">
                    @livewire('weather-widget')
                </div>
            </div>

            <p class="text-center text-sm text-gray-500">
                {{ \App\Models\PageSection::getValue('footer', 'copyright', 'text', '© 2025 Высший колледж электроники и коммуникации. Все права защищены.') }}
            </p>
            <p class="text-center text-xs mt-3 text-gray-600">
                developed by <a href="https://dendor.deworld.su" target="_blank" rel="noopener nofollow" class="text-gray-400 hover:text-white transition-colors">dendor</a>
            </p>
        </div>
    </div>
</footer>