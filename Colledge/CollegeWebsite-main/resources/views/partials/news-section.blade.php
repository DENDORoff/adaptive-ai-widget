<section id="news" class="py-20 bg-[#1a1d2e] relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <img src="{{ \App\Models\PageSection::getValue('news', 'background', 'image_url', 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop') }}" 
             alt="{{ \App\Models\PageSection::getValue('news', 'background', 'image_alt', 'Background') }}" 
             class="w-full h-full object-cover">
    </div>
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-500/3 rounded-full blur-3xl animate-pulse-slow delay-1000"></div>

    <div class="container mx-auto px-4 relative z-10 max-w-7xl">
        <div class="mb-12 text-left js-reveal">
            <h2 class="text-4xl font-bold text-white flex items-center mb-3">
                <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                {{ \App\Models\PageSection::getValue('news', 'header', 'title', 'News') }}
            </h2>
            <p class="text-gray-400 text-base ml-6">
                {{ \App\Models\PageSection::getValue('news', 'header', 'subtitle', 'Коммуникационный центр') }}
            </p>
            <p class="text-gray-500 text-base mt-2 ml-6 max-w-2xl">
                {{ \App\Models\PageSection::getValue('news', 'header', 'description', 'Последняя, ознакомьтесь с новостной рассылкой и не пропустите важные обновления') }}
            </p>
            <a href="{{ route('news.index') }}" class="text-blue-400 hover:text-blue-300 text-base font-medium inline-block mt-4 ml-6 transition-colors">
                {{ \App\Models\PageSection::getValue('news', 'header', 'link_text', 'Читать все новости') }} →
            </a>
        </div>

        @php
            $newsArray = $latestNews->take(8)->values();

            function getImageUrl($imagePath) {
                if (!$imagePath) return null;
                if (file_exists(public_path('uploads/' . $imagePath))) {
                    return asset('uploads/' . $imagePath);
                }
                if (file_exists(storage_path('app/public/' . $imagePath))) {
                    return asset('storage/' . $imagePath);
                }
                return asset('uploads/' . $imagePath);
            }
            
            $groupedNews = $latestNews->slice(3)->groupBy(function($item) {
                return $item->published_at->format('Y-m');
            })->sortKeysDesc()->take(6);
            
            $calendarData = $latestNews->map(function($news) {
                return [
                    'id' => $news->id,
                    'slug' => $news->slug,
                    'title' => $news->title,
                    'date' => $news->published_at->format('Y-m-d'),
                    'day' => $news->published_at->format('j'),
                    'image' => getImageUrl($news->image),
                    'excerpt' => $news->excerpt,
                    'formatted_date' => $news->published_at->format('d.m.Y'),
                    'url' => route('news.show', $news->slug),
                    'published_at' => $news->published_at
                ];
            });
            
            // Подготавливаем переводы месяцев для JavaScript
            $monthsData = [
                'январь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'январь', 'Январь'),
                'февраль' => \App\Models\PageSection::getValue('news', 'calendar_months', 'февраль', 'Февраль'),
                'март' => \App\Models\PageSection::getValue('news', 'calendar_months', 'март', 'Март'),
                'апрель' => \App\Models\PageSection::getValue('news', 'calendar_months', 'апрель', 'Апрель'),
                'май' => \App\Models\PageSection::getValue('news', 'calendar_months', 'май', 'Май'),
                'июнь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'июнь', 'Июнь'),
                'июль' => \App\Models\PageSection::getValue('news', 'calendar_months', 'июль', 'Июль'),
                'август' => \App\Models\PageSection::getValue('news', 'calendar_months', 'август', 'Август'),
                'сентябрь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'сентябрь', 'Сентябрь'),
                'октябрь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'октябрь', 'Октябрь'),
                'ноябрь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'ноябрь', 'Ноябрь'),
                'декабрь' => \App\Models\PageSection::getValue('news', 'calendar_months', 'декабрь', 'Декабрь'),
            ];
            
            // Подготавливаем переводы дней недели для JavaScript
            $daysData = [
                'пн' => \App\Models\PageSection::getValue('news', 'calendar_days', 'пн', 'Пн'),
                'вт' => \App\Models\PageSection::getValue('news', 'calendar_days', 'вт', 'Вт'),
                'ср' => \App\Models\PageSection::getValue('news', 'calendar_days', 'ср', 'Ср'),
                'чт' => \App\Models\PageSection::getValue('news', 'calendar_days', 'чт', 'Чт'),
                'пт' => \App\Models\PageSection::getValue('news', 'calendar_days', 'пт', 'Пт'),
                'сб' => \App\Models\PageSection::getValue('news', 'calendar_days', 'сб', 'Сб'),
                'вс' => \App\Models\PageSection::getValue('news', 'calendar_days', 'вс', 'Вс'),
            ];
            
            // Подготавливаем переводы для мобильной версии
            $mobileDaysData = [
                'пн' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'пн', 'Пн'),
                'вт' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'вт', 'Вт'),
                'ср' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'ср', 'Ср'),
                'чт' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'чт', 'Чт'),
                'пт' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'пт', 'Пт'),
                'сб' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'сб', 'Сб'),
                'вс' => \App\Models\PageSection::getValue('news', 'mobile_calendar_days', 'вс', 'Вс'),
            ];
        @endphp

        @if($latestNews->count() > 0)
            <div class="flex flex-row gap-6">
                <div class="hidden lg:flex lg:w-3/4 flex-row gap-6">
                    <div class="w-2/3">
                        @if($newsArray->count() > 0)
                            <article class="group cursor-pointer transition-all duration-500 hover:scale-[1.02] h-full">
                                <div class="relative h-[600px] rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all news-card-glow h-full">
                                    @php $imageUrl = getImageUrl($newsArray[0]->image); @endphp
                                    
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $newsArray[0]->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                             onerror="this.onerror=null; this.src='{{ \App\Models\PageSection::getValue('news', 'featured', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop') }}'">
                                    @else
                                        <img src="{{ \App\Models\PageSection::getValue('news', 'featured', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop') }}" 
                                             alt="{{ $newsArray[0]->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
                                    
                                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                                {{ \App\Models\PageSection::getValue('news', 'featured', 'tag_text', 'INFO | TODAY') }}
                                            </span>
                                            <span class="text-gray-300 text-sm">{{ $newsArray[0]->published_at->format('d.m.Y') }}</span>
                                        </div>
                                        <h3 class="text-2xl font-bold text-white mb-4 line-clamp-2 group-hover:text-blue-300 transition-colors">
                                            {{ $newsArray[0]->title }}
                                        </h3>
                                        <a href="{{ route('news.show', $newsArray[0]->slug) }}" 
                                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full text-sm font-bold transition-all w-fit shadow-lg hover:shadow-blue-500/50">
                                            {{ \App\Models\PageSection::getValue('news', 'featured', 'button_text', 'Читать') }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endif
                    </div>

                    <div class="w-1/3 flex flex-col gap-6">
                        @php $smallNews = $newsArray->slice(1)->take(2); @endphp
                        
                        @forelse($smallNews as $newsItem)
                            <article class="group cursor-pointer transition-all duration-500 hover:scale-[1.02] h-full">
                                <div class="relative h-[290px] rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all news-card-glow h-full">
                                    @php $imageUrl = getImageUrl($newsItem->image); @endphp
                                    
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $newsItem->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                             onerror="this.onerror=null; this.src='{{ \App\Models\PageSection::getValue('news', 'small_cards', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop') }}'">
                                    @else
                                        <img src="{{ \App\Models\PageSection::getValue('news', 'small_cards', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop') }}" 
                                             alt="{{ $newsItem->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
                                    
                                    <div class="absolute inset-0 p-6 flex flex-col justify-end">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full uppercase">
                                                {{ \App\Models\PageSection::getValue('news', 'small_cards', 'tag_text', 'INFO') }}
                                            </span>
                                            <span class="text-gray-300 text-xs">{{ $newsItem->published_at->format('d.m.Y') }}</span>
                                        </div>
                                        <h3 class="text-base font-bold text-white mb-3 line-clamp-2 group-hover:text-blue-300 transition-colors">
                                            {{ $newsItem->title }}
                                        </h3>
                                        <a href="{{ route('news.show', $newsItem->slug) }}" 
                                           class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-xs font-bold transition-all w-fit shadow-lg">
                                            {{ \App\Models\PageSection::getValue('news', 'small_cards', 'button_text', 'Читать') }}
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="h-[290px] rounded-2xl bg-[#2a2f42]/30 backdrop-blur-sm border border-gray-600/10 flex items-center justify-center h-full">
                                <p class="text-gray-500 text-sm">
                                    {{ \App\Models\PageSection::getValue('news', 'small_cards_empty', 'no_news_text', 'Нет новости') }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="hidden lg:block lg:w-1/4">
                    <div class="w-full rounded-3xl p-5 bg-[#2a2f42]/30 backdrop-blur-sm border border-gray-600/10 shadow-xl h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">
                                        {{ \App\Models\PageSection::getValue('news', 'calendar', 'title', 'Календарь новостей') }}
                                    </h4>
                                    <p class="text-gray-400 text-xs">
                                        {{ \App\Models\PageSection::getValue('news', 'calendar', 'subtitle', 'Выберите месяц для просмотра') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="showPreviousMonth()" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors" aria-label="{{ \App\Models\PageSection::getValue('news', 'calendar', 'prev_button_label', 'Предыдущий месяц') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button onclick="showNextMonth()" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors" aria-label="{{ \App\Models\PageSection::getValue('news', 'calendar', 'next_button_label', 'Следующий месяц') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-center gap-2 mb-2">
                                <h5 class="text-white font-bold text-xl" id="currentMonthYear"></h5>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="weekdays grid grid-cols-7 gap-1 mb-2 px-1" id="weekdaysDesktop">
                                @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
                                    <div class="text-center text-xs text-gray-500 font-medium py-1">
                                        {{ \App\Models\PageSection::getValue('news', 'calendar_days', strtolower($day), $day) }}
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="calendar-grid grid grid-cols-7 gap-1" id="calendarDays"></div>
                        </div>

                        <div class="mb-6">
                            <h5 class="text-white font-medium text-sm mb-3 px-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                {{ \App\Models\PageSection::getValue('news', 'calendar_news', 'daily_news_title', 'Новости дня') }}
                            </h5>
                            <div class="day-news space-y-3 max-h-[150px] overflow-y-auto pr-2" id="dayNews">
                                <div class="text-center py-6 text-gray-500 text-sm">
                                    {{ \App\Models\PageSection::getValue('news', 'calendar_news', 'select_date_text', 'Выберите дату в календаре') }}
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-white/10">
                            <div class="flex items-center justify-between mb-4 px-1">
                                <div class="text-sm text-gray-400">
                                    <span class="text-white font-medium">{{ $latestNews->count() }}</span> 
                                    {{ \App\Models\PageSection::getValue('news', 'calendar_stats', 'total_news_text', 'новостей всего') }}
                                </div>
                                <a href="{{ route('news.index') }}" 
                                   class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                                    {{ \App\Models\PageSection::getValue('news', 'calendar_stats', 'all_link_text', 'Все') }} →
                                </a>
                            </div>
                            <a href="{{ route('news.index') }}" 
                               class="w-full inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 hover:text-white px-5 py-3 rounded-xl text-sm font-medium transition-all duration-300 border border-blue-500/20 hover:border-blue-500/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                </svg>
                                <span>{{ \App\Models\PageSection::getValue('news', 'calendar_stats', 'archive_button_text', 'Весь архив') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:hidden flex flex-col gap-4">
                @if($newsArray->count() > 0)
                    <article class="group cursor-pointer transition-all duration-500 hover:scale-[1.02] h-full">
                        <div class="relative h-[300px] rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all news-card-glow h-full">
                            @php $imageUrl = getImageUrl($newsArray[0]->image); @endphp
                            
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $newsArray[0]->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                     onerror="this.onerror=null; this.src='{{ \App\Models\PageSection::getValue('news', 'mobile_featured', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop') }}'">
                            @else
                                <img src="{{ \App\Models\PageSection::getValue('news', 'mobile_featured', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop') }}" 
                                     alt="{{ $newsArray[0]->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
                            
                            <div class="absolute inset-0 p-6 flex flex-col justify-end">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-3 py-1 bg-blue-600 text-white text-sm font-bold rounded-full uppercase tracking-wider">
                                        {{ \App\Models\PageSection::getValue('news', 'mobile_featured', 'tag_text', 'INFO | TODAY') }}
                                    </span>
                                    <span class="text-gray-300 text-sm">{{ $newsArray[0]->published_at->format('d.m.Y') }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-3 line-clamp-2 group-hover:text-blue-300 transition-colors">
                                    {{ $newsArray[0]->title }}
                                </h3>
                                <a href="{{ route('news.show', $newsArray[0]->slug) }}" 
                                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition-all w-fit shadow-lg hover:shadow-blue-500/50">
                                    {{ \App\Models\PageSection::getValue('news', 'mobile_featured', 'button_text', 'Читать') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endif

                <div class="grid grid-cols-2 gap-3">
                    @php $smallNews = $newsArray->slice(1)->take(2); @endphp
                    
                    @forelse($smallNews as $newsItem)
                        <article class="group cursor-pointer transition-all duration-500 hover:scale-[1.02] h-full">
                            <div class="relative h-[180px] rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all news-card-glow h-full">
                                @php $imageUrl = getImageUrl($newsItem->image); @endphp
                                
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $newsItem->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                         onerror="this.onerror=null; this.src='{{ \App\Models\PageSection::getValue('news', 'mobile_small_cards', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop') }}'">
                                @else
                                    <img src="{{ \App\Models\PageSection::getValue('news', 'mobile_small_cards', 'fallback_image', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop') }}" 
                                         alt="{{ $newsItem->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
                                
                                <div class="absolute inset-0 p-4 flex flex-col justify-end">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full uppercase">
                                            {{ \App\Models\PageSection::getValue('news', 'mobile_small_cards', 'tag_text', 'INFO') }}
                                        </span>
                                        <span class="text-gray-300 text-xs">{{ $newsItem->published_at->format('d.m.Y') }}</span>
                                    </div>
                                    <h3 class="text-sm font-bold text-white mb-2 line-clamp-2 group-hover:text-blue-300 transition-colors">
                                        {{ $newsItem->title }}
                                    </h3>
                                    <a href="{{ route('news.show', $newsItem->slug) }}" 
                                       class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-full text-xs font-bold transition-all w-fit shadow-lg">
                                        {{ \App\Models\PageSection::getValue('news', 'mobile_small_cards', 'button_text', 'Читать') }}
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-2 h-[180px] rounded-xl bg-[#2a2f42]/30 backdrop-blur-sm border border-gray-600/10 flex items-center justify-center h-full">
                            <p class="text-gray-500 text-sm">
                                {{ \App\Models\PageSection::getValue('news', 'mobile_small_cards_empty', 'no_news_text', 'Нет новости') }}
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <div class="w-full rounded-2xl p-4 bg-[#2a2f42]/30 backdrop-blur-sm border border-gray-600/10 shadow-xl h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-600/20 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-sm">
                                        {{ \App\Models\PageSection::getValue('news', 'mobile_calendar', 'title', 'Календарь новостей') }}
                                    </h4>
                                    <p class="text-gray-400 text-xs">
                                        {{ \App\Models\PageSection::getValue('news', 'mobile_calendar', 'subtitle', 'Выберите месяц для просмотра') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button onclick="showPreviousMonth()" class="p-1 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors" aria-label="{{ \App\Models\PageSection::getValue('news', 'mobile_calendar', 'prev_button_label', 'Предыдущий месяц') }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button onclick="showNextMonth()" class="p-1 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors" aria-label="{{ \App\Models\PageSection::getValue('news', 'mobile_calendar', 'next_button_label', 'Следующий месяц') }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <h5 class="text-white font-bold text-base" id="currentMonthYearMobile"></h5>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="weekdays grid grid-cols-7 gap-0.5 mb-1 px-0.5" id="weekdaysMobile">
                                @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
                                    <div class="text-center text-xs text-gray-500 font-medium py-0.5">
                                        {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_days', strtolower($day), $day) }}
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="calendar-grid grid grid-cols-7 gap-0.5" id="calendarDaysMobile"></div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-white font-medium text-xs mb-2 px-1 flex items-center gap-1">
                                <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_news', 'daily_news_title', 'Новости дня') }}
                            </h5>
                            <div class="day-news space-y-2 max-h-[120px] overflow-y-auto pr-1" id="dayNewsMobile">
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_news', 'select_date_text', 'Выберите дату в календаре') }}
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-white/10">
                            <div class="flex items-center justify-between mb-3 px-1">
                                <div class="text-xs text-gray-400">
                                    <span class="text-white font-medium">{{ $latestNews->count() }}</span> 
                                    {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_stats', 'total_news_text', 'новостей всего') }}
                                </div>
                                <a href="{{ route('news.index') }}" 
                                   class="text-blue-400 hover:text-blue-300 text-xs font-medium transition-colors">
                                    {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_stats', 'all_link_text', 'Все') }} →
                                </a>
                            </div>
                            <a href="{{ route('news.index') }}" 
                               class="w-full inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 hover:text-white px-4 py-2 rounded-lg text-xs font-medium transition-all duration-300 border border-blue-500/20 hover:border-blue-500/40">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                </svg>
                                <span>{{ \App\Models\PageSection::getValue('news', 'mobile_calendar_stats', 'archive_button_text', 'Весь архив') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                {{ \App\Models\PageSection::getValue('news', 'empty_state', 'no_news_all_text', 'Новостей пока нет') }}
            </div>
        @endif
    </div>
</section>

<script>
const newsData = @json($calendarData);

// Переводы из PHP
const translations = {
    months: @json($monthsData),
    days: @json($daysData),
    mobileDays: @json($mobileDaysData)
};

const newsByMonth = {};
const newsByDate = {};

newsData.forEach(news => {
    const dateStr = news.date;
    const monthKey = dateStr.substring(0, 7);
    
    if (!newsByMonth[monthKey]) {
        newsByMonth[monthKey] = [];
    }
    newsByMonth[monthKey].push(news);
    
    if (!newsByDate[dateStr]) {
        newsByDate[dateStr] = [];
    }
    newsByDate[dateStr].push(news);
});

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let selectedDate = formatDate(currentDate);

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Функция для получения перевода месяца
function getMonthName(monthIndex) {
    const months = [
        'январь', 'февраль', 'март', 'апрель', 
        'май', 'июнь', 'июль', 'август', 
        'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
    ];
    
    const monthKey = months[monthIndex];
    return translations.months[monthKey] || months[monthIndex];
}

// Обновляем заголовок месяца (уже использует getMonthName с переводами)
function updateMonthYearDisplay() {
    const monthYearElement = document.getElementById('currentMonthYear');
    const monthYearElementMobile = document.getElementById('currentMonthYearMobile');
    
    if (monthYearElement) {
        const monthName = getMonthName(currentMonth);
        monthYearElement.textContent = `${monthName} ${currentYear}`;
    }
    
    if (monthYearElementMobile) {
        const monthName = getMonthName(currentMonth);
        monthYearElementMobile.textContent = `${monthName} ${currentYear}`;
    }
}

// Обновляем дни недели на основе текущего языка
function updateWeekdays() {
    const weekdaysDesktop = document.getElementById('weekdaysDesktop');
    const weekdaysMobile = document.getElementById('weekdaysMobile');
    
    if (weekdaysDesktop) {
        const daysOrder = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'];
        weekdaysDesktop.innerHTML = '';
        daysOrder.forEach(dayKey => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center text-xs text-gray-500 font-medium py-1';
            dayElement.textContent = translations.days[dayKey] || dayKey;
            weekdaysDesktop.appendChild(dayElement);
        });
    }
    
    if (weekdaysMobile) {
        const daysOrder = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'];
        weekdaysMobile.innerHTML = '';
        daysOrder.forEach(dayKey => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center text-xs text-gray-500 font-medium py-0.5';
            dayElement.textContent = translations.mobileDays[dayKey] || dayKey;
            weekdaysMobile.appendChild(dayElement);
        });
    }
}

function initCalendar() {
    if (document.getElementById('calendarDays')) {
        updateWeekdays(); // Обновляем дни недели
        updateMonthYearDisplay();
        renderCalendar();
        renderCalendarMobile();
        updateDayNews();
        updateDayNewsMobile();
    }
}

function renderCalendar() {
    const calendarDays = document.getElementById('calendarDays');
    if (!calendarDays) return;
    
    calendarDays.innerHTML = '';
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
    
    const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
    
    for (let i = 0; i < startingDay; i++) {
        const day = prevMonthLastDay - startingDay + i + 1;
        const date = new Date(currentYear, currentMonth - 1, day);
        const dateStr = formatDate(date);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-sm rounded-lg cursor-pointer transition-all h-8 w-full relative text-gray-600 hover:bg-white/10';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        
        calendarDays.appendChild(dayElement);
    }
    
    const todayStr = formatDate(new Date());
    
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(currentYear, currentMonth, day);
        const dateStr = formatDate(date);
        const isToday = dateStr === todayStr;
        const hasNews = newsByDate[dateStr] && newsByDate[dateStr].length > 0;
        const isSelected = dateStr === selectedDate;
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-sm rounded-lg cursor-pointer transition-all h-8 w-full relative';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        dayElement.onclick = () => selectDate(dateStr, dayElement);
        
        if (isSelected) {
            dayElement.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
        } else if (hasNews) {
            dayElement.classList.add('bg-blue-500/20', 'text-blue-300', 'font-medium', 'hover:bg-blue-500/30');
        } else {
            dayElement.classList.add('text-white', 'hover:bg-white/10');
        }
        
        if (isToday) {
            dayElement.classList.add('border', 'border-blue-400/50');
        }
        
        if (hasNews && !isSelected) {
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-1 w-1.5 h-1.5 rounded-full bg-blue-400';
            dayElement.appendChild(indicator);
        }
        
        calendarDays.appendChild(dayElement);
    }
    
    const totalCells = 42;
    const remainingCells = totalCells - (startingDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        const date = new Date(currentYear, currentMonth + 1, day);
        const dateStr = formatDate(date);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-sm rounded-lg cursor-pointer transition-all h-8 w-full relative text-gray-600 hover:bg-white/10';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        
        calendarDays.appendChild(dayElement);
    }
}

function renderCalendarMobile() {
    const calendarDays = document.getElementById('calendarDaysMobile');
    if (!calendarDays) return;
    
    calendarDays.innerHTML = '';
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
    
    const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
    
    for (let i = 0; i < startingDay; i++) {
        const day = prevMonthLastDay - startingDay + i + 1;
        const date = new Date(currentYear, currentMonth - 1, day);
        const dateStr = formatDate(date);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-xs rounded cursor-pointer transition-all h-6 w-full relative text-gray-600 hover:bg-white/10';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        
        calendarDays.appendChild(dayElement);
    }
    
    const todayStr = formatDate(new Date());
    
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(currentYear, currentMonth, day);
        const dateStr = formatDate(date);
        const isToday = dateStr === todayStr;
        const hasNews = newsByDate[dateStr] && newsByDate[dateStr].length > 0;
        const isSelected = dateStr === selectedDate;
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-xs rounded cursor-pointer transition-all h-6 w-full relative';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        dayElement.onclick = () => selectDateMobile(dateStr, dayElement);
        
        if (isSelected) {
            dayElement.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
        } else if (hasNews) {
            dayElement.classList.add('bg-blue-500/20', 'text-blue-300', 'font-medium', 'hover:bg-blue-500/30');
        } else {
            dayElement.classList.add('text-white', 'hover:bg-white/10');
        }
        
        if (isToday) {
            dayElement.classList.add('border', 'border-blue-400/50');
        }
        
        if (hasNews && !isSelected) {
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-0.5 w-1 h-1 rounded-full bg-blue-400';
            dayElement.appendChild(indicator);
        }
        
        calendarDays.appendChild(dayElement);
    }
    
    const totalCells = 42;
    const remainingCells = totalCells - (startingDay + daysInMonth);
    for (let day = 1; day <= remainingCells; day++) {
        const date = new Date(currentYear, currentMonth + 1, day);
        const dateStr = formatDate(date);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day flex items-center justify-center text-xs rounded cursor-pointer transition-all h-6 w-full relative text-gray-600 hover:bg-white/10';
        dayElement.textContent = day;
        dayElement.setAttribute('data-date', dateStr);
        
        calendarDays.appendChild(dayElement);
    }
}

function updateDayNews() {
    const dayNews = document.getElementById('dayNews');
    const newsForDate = newsByDate[selectedDate] || [];
    
    if (newsForDate.length === 0) {
        dayNews.innerHTML = `
            <div class="text-center py-6 text-gray-500 text-sm">
                <svg class="w-8 h-8 mx-auto text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ \App\Models\PageSection::getValue('news', 'calendar_no_news', 'text', 'На эту дату новостей нет') }}
            </div>
        `;
        return;
    }
    
    let html = '';
    newsForDate.forEach(news => {
        html += `
            <div>
                <a href="${news.url}" class="group/news-item block p-3 rounded-xl bg-blue-500/10 hover:bg-blue-500/20 transition-all duration-300 border border-blue-500/20 hover:border-blue-500/40">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-10 flex-shrink-0 rounded-lg overflow-hidden">
                            <img src="${news.image || '{{ \App\Models\PageSection::getValue('news', 'calendar_news', 'fallback', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop') }}'}" 
                                 alt="${news.title.replace(/"/g, '&quot;')}"
                                 class="w-full h-full object-cover group-hover/news-item:scale-110 transition-transform duration-300">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-white/70 font-medium mb-1">${news.formatted_date}</p>
                            <p class="text-sm text-white font-medium line-clamp-2 group-hover/news-item:text-blue-300 transition-colors">
                                ${news.title.replace(/</g, '&lt;').replace(/>/g, '&gt;')}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        `;
    });
    
    dayNews.innerHTML = html;
}

function updateDayNewsMobile() {
    const dayNews = document.getElementById('dayNewsMobile');
    const newsForDate = newsByDate[selectedDate] || [];
    
    if (newsForDate.length === 0) {
        dayNews.innerHTML = `
            <div class="text-center py-4 text-gray-500 text-xs">
                <svg class="w-6 h-6 mx-auto text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ \App\Models\PageSection::getValue('news', 'mobile_calendar_no_news', 'text', 'На эту дату новостей нет') }}
            </div>
        `;
        return;
    }
    
    let html = '';
    newsForDate.forEach(news => {
        html += `
            <div>
                <a href="${news.url}" class="group/news-item block p-2 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 transition-all duration-300 border border-blue-500/20 hover:border-blue-500/40">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-8 flex-shrink-0 rounded overflow-hidden">
                            <img src="${news.image || '{{ \App\Models\PageSection::getValue('news', 'mobile_calendar_news', 'fallback', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop') }}'}" 
                                 alt="${news.title.replace(/"/g, '&quot;')}"
                                 class="w-full h-full object-cover group-hover/news-item:scale-110 transition-transform duration-300">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-white/70 font-medium mb-0.5">${news.formatted_date}</p>
                            <p class="text-xs text-white font-medium line-clamp-2 group-hover/news-item:text-blue-300 transition-colors">
                                ${news.title.replace(/</g, '&lt;').replace(/>/g, '&gt;')}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        `;
    });
    
    dayNews.innerHTML = html;
}

function selectDate(dateStr, element) {
    selectedDate = dateStr;
    
    const todayStr = formatDate(new Date());
    
    document.querySelectorAll('#calendarDays .calendar-day').forEach(day => {
        const dayDate = day.getAttribute('data-date');
        const isOtherMonth = day.classList.contains('text-gray-600');
        const isToday = dayDate === todayStr;
        const hasNews = newsByDate[dayDate] && newsByDate[dayDate].length > 0;
        
        day.className = 'calendar-day flex items-center justify-center text-sm rounded-lg cursor-pointer transition-all h-8 w-full relative';
        
        if (isOtherMonth) {
            day.classList.add('text-gray-600', 'hover:bg-white/10');
        } else if (dayDate === selectedDate) {
            day.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
        } else if (hasNews) {
            day.classList.add('bg-blue-500/20', 'text-blue-300', 'font-medium', 'hover:bg-blue-500/30');
        } else {
            day.classList.add('text-white', 'hover:bg-white/10');
        }
        
        if (isToday) {
            day.classList.add('border', 'border-blue-400/50');
        }
        
        const existingIndicator = day.querySelector('.absolute');
        if (existingIndicator) {
            existingIndicator.remove();
        }
        
        if (hasNews && dayDate !== selectedDate && !isOtherMonth) {
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-1 w-1.5 h-1.5 rounded-full bg-blue-400';
            day.appendChild(indicator);
        }
    });
    
    updateDayNews();
}

function selectDateMobile(dateStr, element) {
    selectedDate = dateStr;
    
    const todayStr = formatDate(new Date());
    
    document.querySelectorAll('#calendarDaysMobile .calendar-day').forEach(day => {
        const dayDate = day.getAttribute('data-date');
        const isOtherMonth = day.classList.contains('text-gray-600');
        const isToday = dayDate === todayStr;
        const hasNews = newsByDate[dayDate] && newsByDate[dayDate].length > 0;
        
        day.className = 'calendar-day flex items-center justify-center text-xs rounded cursor-pointer transition-all h-6 w-full relative';
        
        if (isOtherMonth) {
            day.classList.add('text-gray-600', 'hover:bg-white/10');
        } else if (dayDate === selectedDate) {
            day.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
        } else if (hasNews) {
            day.classList.add('bg-blue-500/20', 'text-blue-300', 'font-medium', 'hover:bg-blue-500/30');
        } else {
            day.classList.add('text-white', 'hover:bg-white/10');
        }
        
        if (isToday) {
            day.classList.add('border', 'border-blue-400/50');
        }
        
        const existingIndicator = day.querySelector('.absolute');
        if (existingIndicator) {
            existingIndicator.remove();
        }
        
        if (hasNews && dayDate !== selectedDate && !isOtherMonth) {
            const indicator = document.createElement('div');
            indicator.className = 'absolute bottom-0.5 w-1 h-1 rounded-full bg-blue-400';
            day.appendChild(indicator);
        }
    });
    
    updateDayNews();
    updateDayNewsMobile();
}

function showPreviousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    selectedDate = formatDate(new Date(currentYear, currentMonth, 1));
    
    updateMonthYearDisplay();
    renderCalendar();
    renderCalendarMobile();
    updateDayNews();
    updateDayNewsMobile();
}

function showNextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    selectedDate = formatDate(new Date(currentYear, currentMonth, 1));
    
    updateMonthYearDisplay();
    renderCalendar();
    renderCalendarMobile();
    updateDayNews();
    updateDayNewsMobile();
}

document.addEventListener('DOMContentLoaded', initCalendar);
</script>

<style>
.news-card-glow {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
}

.news-card-glow:hover {
    box-shadow: 0 0 40px rgba(59, 130, 246, 0.3), 0 0 80px rgba(59, 130, 246, 0.1);
}

@keyframes pulse-slow {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 0.3; }
}

.animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
}

.weekdays {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 4px;
}

.weekdays > div {
    text-align: center;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 4px;
    min-height: 192px;
}

.calendar-day {
    min-height: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day.text-white {
    color: white;
}

.calendar-day.text-blue-300 {
    color: #93c5fd;
}

.calendar-day.bg-blue-500\/20 {
    background-color: rgba(59, 130, 246, 0.2);
}

.calendar-day.bg-blue-600 {
    background-color: #2563eb;
}

.delay-1000 {
    animation-delay: 1s;
}

.group\/news-item {
    background-color: rgba(59, 130, 246, 0.1);
}

.group\/news-item:hover {
    background-color: rgba(59, 130, 246, 0.2);
}

.border-blue-500\/20 {
    border-color: rgba(59, 130, 246, 0.2);
}

.hover\:border-blue-500\/40:hover {
    border-color: rgba(59, 130, 246, 0.4);
}

.text-white\/70 {
    color: rgba(255, 255, 255, 0.7);
}

.text-white {
    color: white;
}

.group-hover\/news-item\:text-blue-300:hover {
    color: #93c5fd;
}
</style>