@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('search', 'metadata', 'page_title', 'Поиск') . ($query ? ': ' . $query : ''))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ \App\Models\PageSection::getValue('search', 'header', 'main_title', 'Результаты поиска') }}
            </h1>
            
            @if($query)
                <p class="text-lg text-gray-600">
                    {{ \App\Models\PageSection::getValue('search', 'header', 'search_for', 'По запросу:') }}
                    <span class="font-semibold text-blue-600">"{{ $query }}"</span>
                    @if($totalResults > 0)
                        <span class="text-gray-500"> — {{ \App\Models\PageSection::getValue('search', 'header', 'results_found', 'найдено результатов:') }} {{ $totalResults }}</span>
                    @endif
                </p>
            @endif
        </div>

        <div class="mb-12">
            <form action="{{ route('search') }}" method="GET" class="max-w-3xl" aria-label="{{ \App\Models\PageSection::getValue('search', 'aria_labels', 'search_form_label', 'Форма поиска') }}">
                <div class="flex gap-4">
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}"
                            placeholder="{{ \App\Models\PageSection::getValue('search', 'header', 'search_placeholder', 'Введите поисковый запрос...') }}"
                            class="w-full px-6 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                            autofocus
                            aria-label="{{ \App\Models\PageSection::getValue('search', 'aria_labels', 'search_input_label', 'Поисковый запрос') }}"
                        >
                    </div>
                    <button 
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-xl transition flex items-center justify-center gap-2 text-lg font-medium whitespace-nowrap w-48"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('search', 'header', 'search_button', 'Найти') }}</span>
                    </button>
                </div>
            </form>
        </div>

        @if($query)
            @if($totalResults > 0)
                <div class="space-y-6">
                    @foreach($results as $result)
                        <a href="{{ $result['url'] }}" class="block bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 border border-gray-200 hover:border-blue-300">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center
                                        @if($result['type'] === 'news') bg-blue-100 text-blue-600
                                        @elseif($result['type'] === 'blog') bg-purple-100 text-purple-600
                                        @elseif($result['type'] === 'staff') bg-green-100 text-green-600
                                        @elseif($result['type'] === 'vacancy') bg-orange-100 text-orange-600
                                        @endif">
                                        @if($result['type'] === 'news')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        @elseif($result['type'] === 'blog')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        @elseif($result['type'] === 'vacancy')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($result['type'] === 'news') bg-blue-100 text-blue-800
                                                @elseif($result['type'] === 'blog') bg-purple-100 text-purple-800
                                                @elseif($result['type'] === 'staff') bg-green-100 text-green-800
                                                @elseif($result['type'] === 'vacancy') bg-orange-100 text-orange-800
                                                @endif">
                                                {{ \App\Models\PageSection::getValue('search', 'result_types', $result['type'], ucfirst($result['type'])) }}
                                            </span>
                                            
                                            @if($result['date'])
                                                <span class="text-sm text-gray-500">{{ $result['date'] }}</span>
                                            @endif
                                        </div>

                                        <h3 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 transition">
                                            {{ $result['title'] }}
                                        </h3>

                                        @if($result['excerpt'])
                                            <p class="text-gray-600 line-clamp-2">
                                                {!! $result['excerpt'] !!}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                        {{ \App\Models\PageSection::getValue('search', 'messages', 'no_results_title', 'Ничего не найдено') }}
                    </h3>
                    <p class="text-gray-600 mb-6">
                        {{ \App\Models\PageSection::getValue('search', 'messages', 'no_results_text', 'Попробуйте изменить поисковый запрос или использовать другие ключевые слова.') }}
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ \App\Models\PageSection::getValue('search', 'buttons', 'back_to_home', 'На главную') }}
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                    {{ \App\Models\PageSection::getValue('search', 'messages', 'enter_query_title', 'Введите поисковый запрос') }}
                </h3>
                <p class="text-gray-600">
                    {{ \App\Models\PageSection::getValue('search', 'messages', 'enter_query_text', 'Вы можете найти новости, статьи блога, информацию о сотрудниках и вакансии') }}
                </p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .modal-overlay.show {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }
    
    .modal-content {
        background: white;
        border-radius: 12px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }
    
    .modal-overlay.show .modal-content {
        transform: translateY(0);
    }
    
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-close:hover {
        color: #374151;
    }
    
    .form-modal-body {
        padding: 24px;
    }
    
    .staff-modal-content {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    .staff-photo {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        margin: 0 auto 24px;
    }
    
    .staff-info-item {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 16px;
        margin-bottom: 16px;
    }
    
    .staff-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .staff-info-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .staff-info-value {
        font-size: 1rem;
        color: #111827;
        line-height: 1.5;
    }
    
    @media (max-width: 640px) {
        .modal-content {
            width: 95%;
            margin: 10px;
        }
        
        .modal-header {
            padding: 16px 20px;
        }
        
        .form-modal-body {
            padding: 20px;
        }
        
        .staff-photo {
            width: 150px;
            height: 150px;
        }
    }
</style>
@endpush

@push('scripts')
<script>

</script>
@endpush