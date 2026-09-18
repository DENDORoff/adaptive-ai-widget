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

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            
           
            <div class="flex flex-col">
                <h3 class="text-white font-bold mb-4 uppercase">
                    {{ \App\Models\PageSection::getValue('footer', 'quick_links', 'title', 'БЫСТРЫЕ ССЫЛКИ') }}
                </h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    @for($i = 1; $i <= 4; $i++)
                        @php
                            $text = \App\Models\PageSection::getValue('footer', 'quick_links', "link_{$i}_text", '');
                            $url = \App\Models\PageSection::getValue('footer', 'quick_links', "link_{$i}_url", '');
                        @endphp
                        @if($text && $url)
                            <li><a href="{{ $url }}" class="hover:text-blue-400 transition">{{ $text }}</a></li>
                        @endif
                    @endfor
                </ul>
            </div>

            
            <div class="flex flex-col">
                <h3 class="text-white font-bold mb-4 uppercase">
                    {{ \App\Models\PageSection::getValue('footer', 'for_applicants', 'title', 'ПОСТУПАЮЩИМ') }}
                </h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    @for($i = 1; $i <= 4; $i++)
                        @php
                            $text = \App\Models\PageSection::getValue('footer', 'for_applicants', "link_{$i}_text", '');
                            $url = \App\Models\PageSection::getValue('footer', 'for_applicants', "link_{$i}_url", '');
                            $is_modal = \App\Models\PageSection::getValue('footer', 'for_applicants', "link_{$i}_is_modal", false);
                        @endphp
                        @if($text)
                            <li>
                                @if($is_modal)
                                    <button onclick="{{ $url }}" class="hover:text-blue-400 transition">{{ $text }}</button>
                                @else
                                    <a href="{{ $url }}" class="hover:text-blue-400 transition">{{ $text }}</a>
                                @endif
                            </li>
                        @endif
                    @endfor
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

        
        <div class="border-t border-gray-800 pt-8">
            <p class="text-center text-sm text-gray-500">
                {{ \App\Models\PageSection::getValue('footer', 'copyright', 'text', '© 2025 Высший колледж электроники и коммуникаций. Все права защищены.') }}
            </p>
        </div>
    </div>
</footer>