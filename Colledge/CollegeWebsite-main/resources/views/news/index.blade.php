@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('news', 'hero', 'meta_title', 'Новости колледжа'))

@section('content')

<section class="relative py-24 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full animate-pulse"></div>
        <div class="absolute top-1/4 right-20 w-16 h-16 bg-blue-300 rounded-full animate-bounce"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-blue-200 rounded-full animate-pulse delay-1000"></div>
    </div>
    
    <div class="container px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in-up">
                {{ \App\Models\PageSection::getValue('news', 'hero', 'main_title', 'Новости колледжа') }}
            </h1>
            <p class="text-xl text-blue-100 mb-8 animate-fade-in-up delay-200">
                {{ \App\Models\PageSection::getValue('news', 'hero', 'subtitle', 'Будьте в курсе последних событий и важных обновлений') }}
            </p>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-gray-900 to-gray-800 relative">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
    
    <div class="container px-4 max-w-7xl relative">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12">
            <div class="mb-6 md:mb-0">
                <h2 class="text-3xl font-bold text-white mb-2">
                    {{ \App\Models\PageSection::getValue('news', 'listing', 'section_title', 'Последние новости') }}
                </h2>
                <p class="text-gray-400">
                    {{ \App\Models\PageSection::getValue('news', 'listing', 'total_text', 'Всего публикаций') }}: 
                    <span class="text-blue-400 font-semibold">{{ $news->total() }}</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($news as $index => $newsItem)
                <article class="group cursor-pointer transform hover:-translate-y-2 transition-all duration-500">
                    <a href="{{ route('news.show', $newsItem->slug) }}" class="block">
                        <div class="relative h-80 rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 news-card-glow">
                            @php
                                $imageUrl = null;
                                if ($newsItem->image) {
                                    if (file_exists(public_path('uploads/' . $newsItem->image))) {
                                        $imageUrl = asset('uploads/' . $newsItem->image);
                                    } elseif (file_exists(storage_path('app/public/' . $newsItem->image))) {
                                        $imageUrl = asset('storage/' . $newsItem->image);
                                    }
                                }
                            @endphp
                            
                            <img src="{{ $imageUrl ?: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop' }}" 
                                 alt="{{ $newsItem->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                 onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop'">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-90 group-hover:opacity-95 transition-opacity duration-500"></div>
                            
                            @if($newsItem->published_at->gt(now()->subDays(3)))
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full uppercase animate-pulse">
                                        {{ \App\Models\PageSection::getValue('news', 'listing', 'new_badge', 'NEW') }}
                                    </span>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 p-6 flex flex-col justify-end transform group-hover:translate-y-0 transition-transform duration-500">
                                <div class="flex items-center gap-3 mb-3">
                                    @php
                                        $categoryTypes = [
                                            'Событие',
                                            'Обновление', 
                                            'Инфо'
                                        ];
                                        $categoryIndex = $index % 3;
                                        $categoryKey = "category_{$categoryIndex}_name";
                                    @endphp
                                    
                                    <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full uppercase shadow-lg">
                                        {{ \App\Models\PageSection::getValue('news', 'listing', $categoryKey, $categoryTypes[$categoryIndex]) }}
                                    </span>
                                    <span class="text-gray-300 text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $newsItem->published_at->format('d.m.Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-blue-300 transition-colors duration-300">
                                    {{ $newsItem->title }}
                                </h3>
                                
                                @if($newsItem->excerpt)
                                    <p class="text-gray-300 text-sm line-clamp-3 mb-4 opacity-90">
                                        {{ $newsItem->excerpt }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-white/20">
                                    <span class="text-blue-300 text-sm font-semibold flex items-center gap-2 group-hover:gap-3 transition-all duration-300">
                                        {{ \App\Models\PageSection::getValue('news', 'listing', 'read_more_text', 'Читать далее') }}
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="max-w-md mx-auto">
                        <div class="w-32 h-32 mx-auto mb-6 relative">
                            <div class="absolute inset-0 bg-blue-500 rounded-full opacity-20 animate-ping"></div>
                            <div class="absolute inset-4 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">
                            {{ \App\Models\PageSection::getValue('news', 'listing', 'empty_title', 'Новостей пока нет') }}
                        </h3>
                        <p class="text-gray-400 mb-6">
                            {{ \App\Models\PageSection::getValue('news', 'listing', 'empty_subtitle', 'Следите за обновлениями, скоро здесь появятся интересные материалы') }}
                        </p>
                        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                            {{ \App\Models\PageSection::getValue('news', 'listing', 'subscribe_button', 'Подписаться на обновления') }}
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        @if($news->hasPages())
            <div class="mt-16">
                <div class="bg-gray-800 rounded-2xl p-8 backdrop-blur-sm bg-opacity-50">
                    <div class="pagination-wrap">
                        {{ $news->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

<style>
.news-card-glow {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
}

.news-card-glow:hover {
    box-shadow: 0 0 60px rgba(59, 130, 246, 0.4), 
                0 0 100px rgba(59, 130, 246, 0.1),
                0 0 140px rgba(59, 130, 246, 0.05);
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}

.shadow-3xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.pagination-wrap .flex {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
    gap: 0.25rem !important;
}

.pagination-wrap .space-x-2 > :not([hidden]) ~ :not([hidden]) {
    margin-right: 0 !important;
    margin-left: 0 !important;
}

@media (max-width: 768px) {
    .pagination-wrap .flex {
        gap: 0.125rem !important;
    }
    
    .pagination-wrap span,
    .pagination-wrap a {
        min-width: 2.5rem !important;
        min-height: 2.5rem !important;
        padding: 0.5rem !important;
        font-size: 0.875rem !important;
    }
    
    .pagination-wrap .hidden {
        display: none !important;
    }
    
    .pagination-wrap .gap {
        display: none !important;
    }
}
</style>

@endsection