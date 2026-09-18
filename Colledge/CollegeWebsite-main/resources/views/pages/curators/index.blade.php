@extends('layouts.app')

@section('title', __('messages.Group curators'))

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    * {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
        -webkit-tap-highlight-color: transparent !important;
    }
    
    *:focus,
    *:focus-visible,
    *:focus-within {
        outline: none !important;
        box-shadow: none !important;
        border-color: inherit !important;
    }
    
    input, textarea, select {
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        user-select: text !important;
    }
</style>

<section class="relative overflow-visible bg-gradient-to-b from-gray-900 to-black pt-24">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10 overflow-hidden">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-12 overflow-visible">
        <div class="max-w-7xl mx-auto overflow-visible">
            <div class="text-center mb-16" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('curators', 'hero', 'main_title', 'Кураторы групп') }}
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('curators', 'hero', 'description', 'Познакомьтесь с кураторами ваших учебных групп') }}
                </p>
            </div>

            <div class="services-grid mb-24">
                <div class="service-card no-highlight" data-animate data-delay="50">
                    <div class="service-card-inner">
                        <div class="service-number">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                        <h3 class="service-title text-white">
                            {{ \App\Models\PageSection::getValue('curators', 'stats_cards', 'card_1_title', 'Всего кураторов') }}
                        </h3>
                        <div class="service-footer">
                            <div class="click-indicator">
                                <span class="text-3xl font-bold text-white">{{ count($curators) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card no-highlight" data-animate data-delay="100">
                    <div class="service-card-inner">
                        <div class="service-number">
                            <i class="fas fa-graduation-cap text-blue-400"></i>
                        </div>
                        <h3 class="service-title text-white">
                            {{ \App\Models\PageSection::getValue('curators', 'stats_cards', 'card_2_title', 'Активные курсы') }}
                        </h3>
                        <div class="service-footer">
                            <div class="click-indicator">
                                <span class="text-3xl font-bold text-white">{{ count($curatorsByCourse) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card no-highlight" data-animate data-delay="150">
                    <div class="service-card-inner">
                        <div class="service-number">
                            <i class="fas fa-book text-blue-400"></i>
                        </div>
                        <h3 class="service-title text-white">
                            {{ \App\Models\PageSection::getValue('curators', 'stats_cards', 'card_3_title', 'Специальности') }}
                        </h3>
                        <div class="service-footer">
                            <div class="click-indicator">
                                <span class="text-3xl font-bold text-white">{{ count($specialties) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-8 items-start lg:items-center mb-8">
            <div class="flex flex-wrap gap-4 flex-1">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    <select id="courseFilter" class="relative px-4 py-3 bg-gray-800 rounded-xl text-white transition-all duration-300 appearance-none pr-10 min-w-[180px] border border-blue-500/30">
                        <option value="">{{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'course_filter_all', 'Все курсы') }}</option>
                        @php
                            $sortedCourses = collect($courses)->sort(function($a, $b) {
                                return (int)$a <=> (int)$b;
                            });
                        @endphp
                        @foreach($sortedCourses as $course)
                            <option value="{{ $course }}">
                                {{ $course }} {{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'course_suffix', 'курс') }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-colors duration-300 group-hover:text-blue-400"></i>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    <select id="specialtyFilter" class="relative px-4 py-3 bg-gray-800 rounded-xl text-white transition-all duration-300 appearance-none pr-10 min-w-[200px] border border-blue-500/30">
                        <option value="">{{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'specialty_filter_all', 'Все специальности') }}</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-colors duration-300 group-hover:text-blue-400"></i>
                </div>
            </div>

            <div class="flex items-center gap-4 w-full lg:w-auto">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    <button id="resetFilters" class="relative w-full lg:w-auto px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl transition-all duration-300 flex items-center justify-center gap-2 group-hover:scale-105 text-base font-medium border border-blue-500/30 no-highlight">
                        <i class="fas fa-redo transition-transform duration-300 group-hover:rotate-180"></i>
                        {{ \App\Models\PageSection::getValue('curators', 'filter_buttons', 'reset_button', 'Сбросить') }}
                    </button>
                </div>
                
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    <button id="applyFilters" class="relative w-full lg:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white rounded-xl transition-all duration-300 flex items-center justify-center gap-2 group-hover:scale-105 text-base font-medium border border-blue-500/50 no-highlight">
                        <i class="fas fa-filter"></i>
                        {{ \App\Models\PageSection::getValue('curators', 'filter_buttons', 'apply_button', 'Применить') }}
                    </button>
                </div>
            </div>
        </div>

        <div id="activeFilters" class="flex flex-wrap gap-2 mb-12"></div>

        <div id="loadingState" class="hidden text-center py-20">
            <div class="inline-flex flex-col items-center gap-4">
                <div class="relative">
                    <div class="w-16 h-16 border-4 border-blue-500/20 rounded-full"></div>
                    <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full absolute top-0 left-0 animate-spin"></div>
                </div>
                <p class="text-gray-400 text-lg">{{ \App\Models\PageSection::getValue('curators', 'empty_state', 'loading', 'Загрузка...') }}</p>
            </div>
        </div>

        <div id="emptyState" class="hidden text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="relative inline-block mb-6">
                    <div class="w-32 h-32 bg-gray-800 rounded-3xl flex items-center justify-center border border-blue-500/30">
                        <i class="fas fa-search text-gray-600 text-4xl"></i>
                    </div>
                    <div class="absolute -inset-4 bg-blue-500/20 rounded-3xl blur-xl"></div>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">
                    {{ \App\Models\PageSection::getValue('curators', 'empty_state', 'no_results_title', 'Ничего не найдено') }}
                </h3>
                <p class="text-gray-400 mb-6 text-lg">
                    {{ \App\Models\PageSection::getValue('curators', 'empty_state', 'no_results_description', 'Попробуйте изменить параметры поиска или фильтры') }}
                </p>
                <button id="resetFiltersEmpty" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white rounded-xl transition-all duration-300 font-medium border border-blue-500/50 no-highlight">
                    {{ \App\Models\PageSection::getValue('curators', 'empty_state', 'no_results_button', 'Сбросить фильтры') }}
                </button>
            </div>
        </div>

        <div id="curatorsContainer" class="space-y-16">
            @php
                $sortedCuratorsByCourse = collect($curatorsByCourse)->sortKeys(SORT_NUMERIC);
            @endphp
            
            @foreach($sortedCuratorsByCourse as $course => $courseCurators)
                <div class="course-section" data-course="{{ $course }}">
                    <div class="relative mb-12 group">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 via-blue-500/20 to-cyan-500/20 rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                        <div class="relative bg-gray-800/50 rounded-3xl p-8 transition-all duration-500 overflow-hidden border border-blue-500/30 no-highlight">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/20 rounded-full -mr-20 -mt-20 group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-500/10 rounded-full -ml-16 -mb-16 group-hover:scale-125 transition-transform duration-700"></div>
                            
                            <div class="relative z-10">
                                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-blue-500/40">
                                                <span class="text-2xl font-bold text-white">{{ $course }}</span>
                                            </div>
                                            <div class="absolute -inset-3 bg-gradient-to-r from-blue-500/30 to-blue-500/30 rounded-2xl blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h2 class="text-3xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-400 group-hover:to-blue-300 transition-all duration-500 no-highlight">
                                            {{ $course }} {{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'course_suffix', 'курс') }}
                                        </h2>
                                        <p class="text-gray-300 text-lg mb-3 no-highlight">
                                            {{ count($courseCurators) }} {{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'groups_label', 'групп') }} • 
                                            {{ collect($courseCurators)->unique('specialty')->count() }} {{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'specialties_label', 'специальности') }}
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            @php
                                                $uniqueSpecialties = collect($courseCurators)
                                                    ->pluck('specialty')
                                                    ->filter()
                                                    ->unique()
                                                    ->take(4);
                                            @endphp
                                            
                                            @foreach($uniqueSpecialties as $specialty)
                                                <span class="px-3 py-2 bg-blue-500/30 rounded-lg text-sm text-blue-300 transition-all duration-300 hover:scale-105 hover:bg-blue-500/40 cursor-pointer border border-blue-500/30 no-highlight">
                                                    {{ $specialty }}
                                                </span>
                                            @endforeach
                                            
                                            @if(collect($courseCurators)->pluck('specialty')->unique()->count() > 4)
                                                <span class="px-3 py-2 bg-gray-700/50 rounded-lg text-sm text-gray-400 border border-gray-600 no-highlight">
                                                    +{{ collect($courseCurators)->pluck('specialty')->unique()->count() - 4 }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="font-medium text-lg text-white no-highlight">
                                            {{ count($courseCurators) }} {{ \App\Models\PageSection::getValue('curators', 'filter_labels', 'groups_label', 'групп') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative px-2 md:px-8">
                        <div class="relative overflow-hidden rounded-3xl bg-gray-800/50 p-2 md:p-4 border border-blue-500/30">
                            <button class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100 border border-blue-500/50 no-highlight" data-course="{{ $course }}">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100 border border-blue-500/50 no-highlight" data-course="{{ $course }}">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <div class="carousel-track flex transition-transform duration-700 ease-out gap-3 md:gap-4" data-course="{{ $course }}" id="carouselTrack{{ $course }}">
                                @foreach($courseCurators as $curator)
                                    <div class="carousel-item flex-shrink-0 w-full md:w-1/2 lg:w-1/3 xl:w-1/4">
                                        <div class="curator-card group relative h-full no-highlight"
                                             data-specialty="{{ $curator['specialty'] }}"
                                             data-course="{{ $curator['course'] }}"
                                             data-group="{{ $curator['group_name'] }}"
                                             data-curator="{{ $curator['curator_name'] }}">
                                            
                                            <div class="bg-gray-800/50 rounded-2xl overflow-hidden border border-blue-500/20 transition-all duration-500 h-full flex flex-col group hover:scale-105 relative hover:border-blue-500/40 no-highlight">
                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                
                                                <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-blue-800 overflow-hidden flex-shrink-0 h-[140px] border-b border-blue-600/40 no-highlight cursor-pointer group-header">
                                                    <div class="absolute inset-0 p-4 md:p-6 flex flex-col justify-center no-highlight">
                                                        <h3 class="text-lg md:text-xl font-bold text-white mb-2 md:mb-3 break-words line-clamp-2 leading-tight no-highlight">{{ $curator['group_name'] }}</h3>
                                                        <div class="text-blue-200/80 text-xs md:text-sm no-highlight">
                                                            <div class="flex items-start gap-2 no-highlight">
                                                                <span class="w-2 h-2 bg-green-400 rounded-full flex-shrink-0 mt-1.5 animate-pulse no-highlight"></span>
                                                                <span class="break-words leading-relaxed text-white text-xs md:text-sm line-clamp-2 no-highlight">{{ $curator['specialty'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="p-4 md:p-6 flex flex-col flex-1 no-highlight">
                                                    <div class="flex items-start gap-3 md:gap-4 mb-4 md:mb-6 no-highlight">
                                                        <div class="flex-shrink-0 relative no-highlight">
                                                            @if($curator['curator_photo'])
                                                                <img src="{{ asset('uploads/' . $curator['curator_photo']) }}" 
                                                                     alt="{{ $curator['curator_name'] }}"
                                                                     class="w-16 h-16 md:w-20 md:h-20 rounded-2xl object-cover group-hover:scale-110 transition-transform duration-700 ease-out border border-blue-500/40">
                                                            @else
                                                                <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-700/50 rounded-2xl flex items-center justify-center border border-blue-500/40">
                                                                    <i class="fas fa-user text-gray-500 text-xl md:text-2xl group-hover:text-blue-400 transition-colors duration-300"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0 no-highlight">
                                                            <h4 class="text-base md:text-lg font-bold text-white mb-1 break-words group-hover:text-blue-300 transition-colors">{{ $curator['curator_name'] }}</h4>
                                                            @if($curator['curator_position'])
                                                                <p class="text-blue-400 text-xs md:text-sm mb-2 md:mb-3 break-words bg-blue-500/20 px-2 py-1 md:px-3 md:py-1.5 rounded-full inline-block max-w-full border border-blue-500/40">{{ $curator['curator_position'] }}</p>
                                                            @endif
                                                            <div class="mt-1 md:mt-2 flex items-center gap-2 text-xs text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                                                <i class="fas fa-user-tie text-xs"></i>
                                                                {{ \App\Models\PageSection::getValue('curators', 'card_labels', 'curator_label', 'Куратор') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-2 md:space-y-3 mb-4 md:mb-6 no-highlight">
                                                        @if($curator['students_count'])
                                                            <div class="info-block flex items-center gap-2 md:gap-3 p-2 md:p-3 bg-gray-700/30 rounded-xl group-hover:bg-gray-700/50 transition-all duration-300 border border-blue-500/20">
                                                                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-500/20 rounded-lg flex items-center justify-center group-hover:bg-blue-500/30 transition-colors duration-300 flex-shrink-0 border border-blue-500/30">
                                                                    <i class="fas fa-users text-blue-400 text-xs md:text-sm"></i>
                                                                </div>
                                                                <div class="min-w-0">
                                                                    <p class="text-xs text-gray-400">
                                                                        {{ \App\Models\PageSection::getValue('curators', 'card_labels', 'students_label', 'Студентов') }}
                                                                    </p>
                                                                    <p class="text-sm md:text-base font-semibold text-white truncate">{{ $curator['students_count'] }}</p>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($curator['room_number'])
                                                            <div class="info-block flex items-center gap-2 md:gap-3 p-2 md:p-3 bg-gray-700/30 rounded-xl group-hover:bg-gray-700/50 transition-all duration-300 border border-blue-500/20">
                                                                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-500/20 rounded-lg flex items-center justify-center group-hover:bg-blue-500/30 transition-colors duration-300 flex-shrink-0 border border-blue-500/30">
                                                                    <i class="fas fa-door-closed text-blue-400 text-xs md:text-sm"></i>
                                                                </div>
                                                                <div class="min-w-0">
                                                                    <p class="text-xs text-gray-400">
                                                                        {{ \App\Models\PageSection::getValue('curators', 'card_labels', 'room_label', 'Кабинет') }}
                                                                    </p>
                                                                    <p class="text-sm md:text-base font-semibold text-white truncate">{{ $curator['room_number'] }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($curator['consultation_schedule'])
                                                        <div class="bg-gray-700/30 rounded-xl p-3 md:p-4 mb-3 md:mb-4 group-hover:bg-gray-700/40 transition-all duration-300 flex-1 border border-blue-500/20">
                                                            <h5 class="text-xs font-semibold text-white mb-1 md:mb-2 flex items-center gap-2">
                                                                <div class="w-5 h-5 md:w-6 md:h-6 bg-blue-500/20 rounded flex items-center justify-center group-hover:bg-blue-500/30 transition-colors duration-300 flex-shrink-0 border border-blue-500/30">
                                                                    <i class="fas fa-clock text-blue-400 text-xs"></i>
                                                                </div>
                                                                {{ \App\Models\PageSection::getValue('curators', 'card_labels', 'consultations_label', 'Консультации') }}
                                                            </h5>
                                                            <p class="text-xs text-gray-300 whitespace-pre-line leading-relaxed group-hover:text-gray-200 transition-colors duration-300 line-clamp-2 md:line-clamp-3">{{ $curator['consultation_schedule'] }}</p>
                                                        </div>
                                                    @else
                                                        <div class="flex-1"></div>
                                                    @endif

                                                    <div class="space-y-2 md:space-y-3 mt-auto">
                                                        @if($curator['curator_email'])
                                                            <div class="flex items-center gap-2 md:gap-3 p-2 md:p-3 bg-gray-700/30 rounded-xl transition-all duration-300 border border-blue-500/20">
                                                                <i class="fas fa-envelope text-gray-400 text-xs flex-shrink-0"></i>
                                                                <span class="text-xs md:text-sm text-gray-300 truncate flex-1">{{ $curator['curator_email'] }}</span>
                                                            </div>
                                                        @endif

                                                        @if($curator['curator_phone'])
                                                            <div class="flex items-center gap-2 md:gap-3 p-2 md:p-3 bg-gray-700/30 rounded-xl transition-all duration-300 border border-blue-500/20">
                                                                <i class="fas fa-phone text-gray-400 text-xs flex-shrink-0"></i>
                                                                <span class="text-xs md:text-sm text-gray-300 truncate flex-1">{{ $curator['curator_phone'] }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if(count($courseCurators) > 4)
                            <div class="flex items-center justify-center gap-2 mt-4 md:mt-6">
                                @for($i = 0; $i < min(8, ceil(count($courseCurators) / 4)); $i++)
                                    <button class="w-2 h-2 rounded-full bg-gray-600 hover:bg-blue-500 transition-colors carousel-indicator border border-blue-500/30 no-highlight" data-index="{{ $i }}" data-course="{{ $course }}"></button>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Модальное окно для полного названия группы -->
<div id="groupNameModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-blue-500/30">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" class="bg-gray-800 rounded-full p-2 text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none transition-all duration-300 group modal-close">
                    <i class="fas fa-times text-lg group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>
            
            <div class="px-6 pt-8 pb-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-2xl leading-6 font-bold text-white mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <span>Название группы</span>
                        </h3>
                        
                        <div class="mt-2">
                            <div class="bg-gray-800/50 rounded-xl p-4 border border-blue-500/30">
                                <h4 class="text-lg font-semibold text-blue-300 mb-2">Полное название:</h4>
                                <p id="modalGroupFullName" class="text-white text-xl font-bold break-words leading-relaxed"></p>
                            </div>
                            
                            <div class="mt-4 bg-gray-800/50 rounded-xl p-4 border border-blue-500/30">
                                <h4 class="text-lg font-semibold text-blue-300 mb-2">Специальность:</h4>
                                <p id="modalGroupSpecialty" class="text-white text-lg break-words leading-relaxed"></p>
                            </div>
                            
                            <div class="mt-4 bg-gray-800/50 rounded-xl p-4 border border-blue-500/30">
                                <h4 class="text-lg font-semibold text-blue-300 mb-2">Куратор:</h4>
                                <p id="modalGroupCurator" class="text-white text-lg break-words leading-relaxed"></p>
                            </div>
                            
                            <div class="mt-4 bg-gray-800/50 rounded-xl p-4 border border-blue-500/30">
                                <h4 class="text-lg font-semibold text-blue-300 mb-2">Курс:</h4>
                                <p id="modalGroupCourse" class="text-white text-lg break-words leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-900/50 border-t border-blue-500/30">
                <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-medium rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] focus:outline-none modal-close">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .no-highlight {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-touch-callout: none !important;
        cursor: default !important;
    }
    
    .info-block,
    .info-block * {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        pointer-events: none !important;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .service-card {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 16px;
        padding: 24px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
        background: rgba(30, 41, 59, 0.7);
    }

    .service-card:hover::before {
        transform: scaleX(1);
    }

    .service-card-inner {
        position: relative;
        z-index: 1;
    }

    .service-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 20px;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .service-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        line-height: 1.5;
        min-height: auto;
    }

    .service-footer {
        border-top: 1px solid rgba(59, 130, 246, 0.1);
        padding-top: 16px;
    }

    .click-indicator {
        color: #60a5fa;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: color 0.3s ease;
    }

    .service-card:hover .click-indicator {
        color: #93c5fd;
    }

    .service-card:hover .click-indicator i {
        transform: translateX(4px);
    }

    .click-indicator i {
        transition: transform 0.3s ease;
    }

    [data-animate] {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    [data-animate].animated {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(15px, -30px) scale(1.05); }
        50% { transform: translate(-15px, 15px) scale(0.95); }
        75% { transform: translate(30px, 30px) scale(1.03); }
    }

    .animate-blob {
        animation: blob 8s infinite ease-in-out;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    .grid-animation {
        background-image: 
            linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        width: 100%;
        height: 100%;
        animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
        0% {
            transform: translateY(0) translateX(0);
        }
        100% {
            transform: translateY(50px) translateX(50px);
        }
    }

    .carousel-track {
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .break-words {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .filter-chip {
        background: rgba(59, 130, 246, 0.3);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #93c5fd;
    }

    .carousel-prev,
    .carousel-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 50;
    }

    .curator-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        cursor: pointer;
    }

    .h-\[140px\] {
        height: 140px;
    }

    .group-header {
        position: relative;
        overflow: hidden;
    }

    .group-header:hover::after {
        content: 'Нажмите для просмотра полного названия';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        text-align: center;
        padding: 4px;
        font-size: 10px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .group-header:hover::after {
        opacity: 1;
    }

    @media (max-width: 640px) {
        .group-header:hover::after {
            content: 'Нажмите';
            font-size: 9px;
            padding: 3px;
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    #groupNameModal {
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .carousel-item {
            width: 85% !important;
        }
        
        .relative.px-2.md\:px-8 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .carousel-track {
            gap: 1rem;
        }
        
        .carousel-prev,
        .carousel-next {
            width: 2.5rem;
            height: 2.5rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .carousel-prev {
            left: 0.5rem;
        }
        
        .carousel-next {
            right: 0.5rem;
        }
        
        .h-\[140px\] {
            height: 120px;
        }

        #groupNameModal .inline-block {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .carousel-item {
            width: 45% !important;
        }
        
        .h-\[140px\] {
            height: 130px;
        }
    }

    @media (min-width: 1024px) and (max-width: 1280px) {
        .carousel-item {
            width: 30% !important;
        }
    }

    @media (min-width: 1280px) {
        .carousel-item {
            width: 23% !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousels = {};
        
        const animateOnScroll = () => {
            document.querySelectorAll('[data-animate]').forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9 && rect.bottom > 0) {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => element.classList.add('animated'), parseInt(delay));
                }
            });
        };
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();

        function initCarousel(courseSection) {
            const course = courseSection.dataset.course;
            const track = courseSection.querySelector('.carousel-track');
            const slides = track.querySelectorAll('.carousel-item');
            const prevBtn = courseSection.querySelector('.carousel-prev');
            const nextBtn = courseSection.querySelector('.carousel-next');
            const indicators = courseSection.querySelectorAll('.carousel-indicator');
            
            if (!slides.length) return;
            
            let currentIndex = 0;
            const itemsPerView = getItemsPerView();
            const maxIndex = Math.max(0, slides.length - itemsPerView);

            function getItemsPerView() {
                if (window.innerWidth < 768) return 1;
                if (window.innerWidth < 1024) return 2;
                if (window.innerWidth < 1280) return 3;
                return 4;
            }

            function updateCarousel() {
                const itemWidth = 100 / itemsPerView;
                const offset = currentIndex * itemWidth;
                track.style.transform = `translateX(-${offset}%)`;
                
                if (prevBtn) {
                    prevBtn.disabled = currentIndex === 0;
                    prevBtn.style.opacity = prevBtn.disabled ? '0.3' : '1';
                }
                
                if (nextBtn) {
                    nextBtn.disabled = currentIndex >= maxIndex;
                    nextBtn.style.opacity = nextBtn.disabled ? '0.3' : '1';
                }
                
                const currentPage = Math.floor(currentIndex / itemsPerView);
                indicators.forEach((indicator, index) => {
                    if (indicator.dataset.course === course) {
                        indicator.classList.toggle('bg-blue-500', index === currentPage);
                        indicator.classList.toggle('bg-gray-600', index !== currentPage);
                    }
                });
            }
            
            if (nextBtn) {
                nextBtn.onclick = () => {
                    if (currentIndex < maxIndex) {
                        currentIndex++;
                        updateCarousel();
                    }
                };
            }
            
            if (prevBtn) {
                prevBtn.onclick = () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateCarousel();
                    }
                };
            }

            indicators.forEach(indicator => {
                if (indicator.dataset.course === course) {
                    indicator.onclick = () => {
                        const pageIndex = parseInt(indicator.dataset.index);
                        currentIndex = pageIndex * itemsPerView;
                        if (currentIndex > maxIndex) currentIndex = maxIndex;
                        updateCarousel();
                    };
                }
            });

            carousels[course] = { currentIndex, updateCarousel, getItemsPerView };
            updateCarousel();
        }

        document.querySelectorAll('.course-section').forEach(initCarousel);

        const courseFilter = document.getElementById('courseFilter');
        const specialtyFilter = document.getElementById('specialtyFilter');
        const resetFilters = document.getElementById('resetFilters');
        const resetFiltersEmpty = document.getElementById('resetFiltersEmpty');
        const applyFilters = document.getElementById('applyFilters');
        const emptyState = document.getElementById('emptyState');
        const modal = document.getElementById('groupNameModal');
        const modalFullName = document.getElementById('modalGroupFullName');
        const modalSpecialty = document.getElementById('modalGroupSpecialty');
        const modalCurator = document.getElementById('modalGroupCurator');
        const modalCourse = document.getElementById('modalGroupCourse');
        const modalCloseButtons = document.querySelectorAll('.modal-close');

        function openGroupModal(groupName, specialty, curator, course) {
            modalFullName.textContent = groupName;
            modalSpecialty.textContent = specialty;
            modalCurator.textContent = curator;
            modalCourse.textContent = course + ' курс';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeGroupModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.querySelectorAll('.group-header').forEach(header => {
            header.addEventListener('click', function(e) {
                e.stopPropagation();
                const card = this.closest('.curator-card');
                const groupName = card.dataset.group;
                const specialty = card.dataset.specialty;
                const curator = card.dataset.curator;
                const course = card.dataset.course;
                
                openGroupModal(groupName, specialty, curator, course);
            });
        });

        modalCloseButtons.forEach(button => {
            button.addEventListener('click', closeGroupModal);
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeGroupModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeGroupModal();
            }
        });

        function updateActiveFilters() {
            activeFilters.innerHTML = '';
            
            if (courseFilter.value) {
                const chip = document.createElement('div');
                chip.className = 'filter-chip px-3 py-2 rounded-lg text-sm text-blue-300 flex items-center gap-2';
                chip.innerHTML = `
                    <span>Курс: ${courseFilter.value}</span>
                    <button type="button" class="text-blue-400 hover:text-blue-200 transition-colors remove-course-filter">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                `;
                chip.querySelector('.remove-course-filter').onclick = () => {
                    courseFilter.value = '';
                    filterCurators();
                };
                activeFilters.appendChild(chip);
            }
            
            if (specialtyFilter.value) {
                const chip = document.createElement('div');
                chip.className = 'filter-chip px-3 py-2 rounded-lg text-sm text-blue-300 flex items-center gap-2';
                chip.innerHTML = `
                    <span>Специальность: ${specialtyFilter.value}</span>
                    <button type="button" class="text-blue-400 hover:text-blue-200 transition-colors remove-specialty-filter">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                `;
                chip.querySelector('.remove-specialty-filter').onclick = () => {
                    specialtyFilter.value = '';
                    filterCurators();
                };
                activeFilters.appendChild(chip);
            }
        }

        function filterCurators() {
            const courseValue = courseFilter.value;
            const specialtyValue = specialtyFilter.value;

            let visibleCount = 0;
            const courseSections = document.querySelectorAll('.course-section');

            courseSections.forEach(section => {
                const cards = section.querySelectorAll('.curator-card');
                let visibleInSection = 0;

                cards.forEach(card => {
                    const cardCourse = card.dataset.course;
                    const cardSpecialty = card.dataset.specialty;

                    const matchesCourse = !courseValue || cardCourse === courseValue;
                    const matchesSpecialty = !specialtyValue || cardSpecialty === specialtyValue;

                    if (matchesCourse && matchesSpecialty) {
                        card.style.display = '';
                        card.closest('.carousel-item').style.display = '';
                        visibleInSection++;
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                        card.closest('.carousel-item').style.display = 'none';
                    }
                });

                if (visibleInSection > 0) {
                    section.style.display = '';
                    const carouselTrack = section.querySelector('.carousel-track');
                    if (carouselTrack && carousels[section.dataset.course]) {
                        carousels[section.dataset.course].currentIndex = 0;
                        carousels[section.dataset.course].updateCarousel();
                    }
                } else {
                    section.style.display = 'none';
                }
            });

            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            document.getElementById('curatorsContainer').style.display = visibleCount === 0 ? 'none' : 'block';
            updateActiveFilters();
        }

        applyFilters.onclick = filterCurators;
        courseFilter.addEventListener('change', filterCurators);
        specialtyFilter.addEventListener('change', filterCurators);

        function resetAllFilters() {
            courseFilter.value = '';
            specialtyFilter.value = '';
            filterCurators();
        }

        resetFilters.onclick = resetAllFilters;
        resetFiltersEmpty.onclick = resetAllFilters;

        window.addEventListener('resize', () => {
            Object.values(carousels).forEach(carousel => {
                if (carousel.updateCarousel) {
                    carousel.currentIndex = 0;
                    carousel.updateCarousel();
                }
            });
        });

        filterCurators();
    });
</script>
@endsection