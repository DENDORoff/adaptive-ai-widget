@extends('layouts.app')

@section('title', '{{ \App\Models\PageSection::getValue("vacancies", "metadata", "title", "Вакансии") }}')

@section('content')

<section class="relative bg-gradient-to-br from-blue-900 via-gray-900 to-gray-900 pt-16 pb-12">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,{{ \App\Models\PageSection::getValue('vacancies', 'background', 'pattern_base64', 'PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnoiIHN0cm9rZT0iIzFFMzA0RSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9nPjwvc3ZnPg==') }}'] opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('vacancies', 'hero', 'title', 'Вакансии') }}
            </h1>
            <p class="text-xl text-gray-300">
                {{ \App\Models\PageSection::getValue('vacancies', 'hero', 'subtitle', 'Присоединяйтесь к нашей команде профессионалов') }}
            </p>
        </div>
    </div>
</section>

<section class="bg-gradient-to-r from-blue-700 to-blue-800 py-8 px-4 -mt-6 relative z-20 shadow-xl">
    <div class="container mx-auto max-w-6xl">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-white/20 shadow-2xl">
            <h1 class="text-2xl md:text-3xl font-bold text-white text-center mb-4 md:mb-6 leading-snug md:leading-tight">
                {{ \App\Models\PageSection::getValue('vacancies', 'announcement', 'title', 'КГП на ПХВ «Высший колледж электроники и коммуникаций»<br class="hidden md:block">управления образования Павлодарской области акимата Павлодарской области<br class="hidden md:block">объявляет о конкурсе на вакантные должности') }}
            </h1>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-6 text-blue-100">
                
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm md:text-base font-medium">
                        {{ \App\Models\PageSection::getValue('vacancies', 'announcement', 'badge_1', 'Текущие вакансии') }}
                    </span>
                </div>
                <div class="h-6 w-px bg-white/30 hidden md:block"></div>
                
                
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm md:text-base font-medium">
                        {{ \App\Models\PageSection::getValue('vacancies', 'announcement', 'badge_2', 'Полная занятость') }}
                    </span>
                </div>
                <div class="h-6 w-px bg-white/30 hidden md:block"></div>
                
                
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm md:text-base font-medium">
                        {{ \App\Models\PageSection::getValue('vacancies', 'announcement', 'badge_3', 'Павлодарская область') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 md:py-16 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="container mx-auto px-4 max-w-6xl">
        
        @if($vacancies->count() > 0)
            <div class="mb-16 md:mb-20 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 md:mb-4">
                    {{ \App\Models\PageSection::getValue('vacancies', 'vacancies_list', 'title', 'Открытые вакансии') }}
                </h2>
                <div class="inline-flex items-center gap-3 md:gap-4 bg-gray-800/50 px-5 md:px-6 py-2 md:py-3 rounded-full">
                    <span class="text-gray-300 text-sm md:text-base">
                        {{ \App\Models\PageSection::getValue('vacancies', 'vacancies_list', 'found_label', 'Найдено вакансий:') }}
                    </span>
                    <span class="bg-blue-600 text-white font-bold px-3 md:px-4 py-1 rounded-full text-sm md:text-base">{{ $vacancies->total() }}</span>
                </div>
            </div>

            <div class="space-y-8 md:space-y-12">
                @foreach($vacancies as $vacancy)
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl md:rounded-2xl overflow-hidden border border-gray-700 hover:border-blue-500 transition-all duration-300 hover:shadow-xl md:hover:shadow-2xl hover:shadow-blue-500/20 group">
                        <div class="flex flex-col lg:flex-row">
                            
                            <div class="lg:w-1/3 bg-gradient-to-br from-blue-900/80 to-blue-800/80 p-6 md:p-8 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 md:w-40 h-32 md:h-40 bg-white/5 rounded-full -mr-16 md:-mr-20 -mt-16 md:-mt-20"></div>
                                <div class="relative z-10 h-full flex flex-col">
                                    <div class="mb-4 md:mb-6">
                                        <h2 class="text-xl md:text-2xl font-bold text-white mb-2 md:mb-3 group-hover:scale-105 transition-transform">
                                            {{ $vacancy->title }}
                                        </h2>
                                        @if($vacancy->location)
                                            <div class="flex items-center gap-2 text-blue-200">
                                                <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="font-medium text-sm md:text-base">{{ $vacancy->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    
                                    <div class="mt-auto space-y-3 md:space-y-4">
                                        @if($vacancy->salary)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600/30 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 md:w-5 h-4 md:h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs md:text-sm text-blue-100">
                                                        {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_details', 'salary_label', 'Оклад') }}
                                                    </p>
                                                    <p class="text-base md:text-lg font-bold text-white">{{ $vacancy->salary }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($vacancy->employment_type)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600/30 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 md:w-5 h-4 md:h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs md:text-sm text-blue-100">
                                                        {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_details', 'employment_label', 'Тип занятости') }}
                                                    </p>
                                                    <p class="text-base md:text-lg font-bold text-white">{{ $vacancy->employment_type }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            
                            <div class="lg:w-2/3 p-6 md:p-8 flex flex-col">
                                <div class="flex-1">
                                    <h3 class="text-lg md:text-xl font-bold text-white mb-3 md:mb-4 flex items-center gap-2 md:gap-3">
                                        <svg class="w-5 md:w-6 h-5 md:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_details', 'description_title', 'Описание вакансии') }}
                                    </h3>
                                    <p class="text-gray-300 mb-4 md:mb-6 leading-relaxed text-sm md:text-base">
                                        {{ $vacancy->description }}
                                    </p>
                                    
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4 mt-4 md:mt-6">
                                        @for($i = 1; $i <= 4; $i++)
                                            @php
                                                $feature = \App\Models\PageSection::getValue('vacancies', 'vacancy_features', "feature_{$i}", '');
                                            @endphp
                                            @if($feature)
                                                <div class="flex items-center gap-2 md:gap-3 text-gray-300">
                                                    @switch($i)
                                                        @case(1)
                                                            <svg class="w-4 md:w-5 h-4 md:h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            @break
                                                        @case(2)
                                                            <svg class="w-4 md:w-5 h-4 md:h-5 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                            </svg>
                                                            @break
                                                        @case(3)
                                                            <svg class="w-4 md:w-5 h-4 md:h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                            </svg>
                                                            @break
                                                        @case(4)
                                                            <svg class="w-4 md:w-5 h-4 md:h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                            @break
                                                    @endswitch
                                                    <span class="text-xs md:text-sm">{{ $feature }}</span>
                                                </div>
                                            @endif
                                        @endfor
                                        
                                        
                                        <div class="flex items-center gap-2 md:gap-3 text-gray-300">
                                            <svg class="w-4 md:w-5 h-4 md:h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-xs md:text-sm">
                                                {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_features', 'date_label', 'Дата публикации:') }} 
                                                {{ $vacancy->published_at->format('d.m.Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-3 md:gap-4">
                                    <div class="flex items-center gap-2 md:gap-3 text-gray-300">
                                        <div>
                                            <p class="text-xs text-gray-400 hidden sm:block">
                                                {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_card', 'pdf_description', 'Официальный PDF документ с деталями вакансии') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row items-center gap-3 md:gap-4 w-full sm:w-auto">
                                        @if($vacancy->expires_at)
                                            <div class="text-center sm:text-right">
                                                <p class="text-xs text-gray-400 mb-1">
                                                    {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_card', 'expires_label', 'Актуально до') }}
                                                </p>
                                                <p class="text-xs md:text-sm font-medium {{ $vacancy->expires_at->isPast() ? 'text-red-400' : 'text-green-400' }}">
                                                    {{ $vacancy->expires_at->format('d.m.Y') }}
                                                    @if($vacancy->expires_at->isPast())
                                                        <span class="ml-1 md:ml-2">
                                                            {{ \App\Models\PageSection::getValue('vacancies', 'vacancy_card', 'expired_text', '(Истекло)') }}
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                        
                                        
                                        <a href="{{ route('vacancies.show', $vacancy->slug) }}" 
                                           target="_blank"
                                           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 md:px-8 py-2 md:py-3 rounded-lg md:rounded-xl transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-1 w-full sm:w-auto text-sm md:text-base">
                                            <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>{{ \App\Models\PageSection::getValue('vacancies', 'vacancy_card', 'pdf_button', 'Открыть PDF вакансии') }}</span>
                                            <svg class="w-4 md:w-5 h-4 md:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($vacancies->hasPages())
                <div class="mt-16 md:mt-20">
                    {{ $vacancies->links() }}
                </div>
            @endif

        @else
            
            <div class="text-center py-16 md:py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-gray-800 rounded-full mb-6">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">
                    {{ \App\Models\PageSection::getValue('vacancies', 'empty_state', 'title', 'Вакансий пока нет') }}
                </h3>
                <p class="text-gray-400 mb-6 text-sm md:text-base">
                    {{ \App\Models\PageSection::getValue('vacancies', 'empty_state', 'description', 'Следите за обновлениями - новые вакансии появятся в ближайшее время') }}
                </p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 rounded-lg">
                    <svg class="w-4 md:w-5 h-4 md:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-gray-300 text-xs md:text-sm">
                        {{ \App\Models\PageSection::getValue('vacancies', 'empty_state', 'hint', 'Попробуйте зайти позже') }}
                    </span>
                </div>
            </div>
        @endif

        
        <div class="mt-16 md:mt-20 pt-8 md:pt-10 border-t border-gray-700">
            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl md:rounded-2xl p-6 md:p-8 border border-gray-700">
                    <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-600/20 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 md:w-8 h-6 md:h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg md:text-xl font-bold text-white mb-2">
                                {{ \App\Models\PageSection::getValue('vacancies', 'info_block', 'title', 'О PDF документах вакансий') }}
                            </h4>
                            <p class="text-gray-300 mb-3 text-sm md:text-base">
                                {{ \App\Models\PageSection::getValue('vacancies', 'info_block', 'description', 'Каждая вакансия содержит официальный PDF документ с полным описанием требований, обязанностей и условий работы в КГП на ПХВ «Высший колледж электроники и коммуникаций» управления образования Павлодарской области.') }}
                            </p>
                            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 text-xs md:text-sm text-gray-400">
                                @for($i = 1; $i <= 3; $i++)
                                    @php
                                        $point = \App\Models\PageSection::getValue('vacancies', 'info_block', "point_{$i}", '');
                                    @endphp
                                    @if($point)
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-blue-500 rounded-full"></div>
                                            <span>{{ $point }}</span>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection