@extends('layouts.app')

@section('title', 'Администрация и преподавательский состав')

@section('content')

<section class="relative overflow-hidden bg-black min-h-screen">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-900/20"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-10"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-blue-700 rounded-full filter blur-3xl opacity-10"></div>
        <div class="absolute top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-500 rounded-full filter blur-3xl opacity-5"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-8">
        <div class="max-w-7xl mx-auto">
            {{-- HERO SECTION --}}
            <div class="text-center mb-16" data-animate="fade-down">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    <span class="text-white">{{ \App\Models\PageSection::getValue('staff', 'hero', 'main_title_part1', 'Администрация') }}</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-500 to-blue-600">{{ \App\Models\PageSection::getValue('staff', 'hero', 'main_title_part2', 'и преподаватели') }}</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-12 leading-relaxed max-w-2xl mx-auto">
                    {{ \App\Models\PageSection::getValue('staff', 'hero', 'description', 'Знакомство с профессиональной командой, которая создаёт будущее нашего образовательного учреждения') }}
                </p>
            </div>

            <div class="mb-20">
                {{-- ADMINISTRATION HEADER --}}
                <div class="flex items-center justify-between mb-8" data-animate="fade-right">
                    <h2 class="text-3xl font-bold text-white relative">
                        <span class="relative z-10">{{ \App\Models\PageSection::getValue('staff', 'administration_header', 'title', 'Администрация колледжа') }}</span>
                        <div class="absolute -bottom-2 left-0 w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"></div>
                    </h2>
                </div>
                
                {{-- DIRECTOR (Руководитель с самым высоким порядком) --}}
                @if($director)
                <div class="mb-12" data-animate="fade-up">
                    <div class="contact-main-card group">
                        <div class="flex relative z-10 h-96">
                            <div class="w-1/3 flex-shrink-0 relative overflow-hidden group/photo">
                                @if($director->photo)
                                    <img src="{{ $director->photo_url }}" 
                                         alt="{{ $director->full_name }}"
                                         class="absolute inset-0 w-full h-full object-cover group-hover/photo:scale-110 transition-transform duration-1000 ease-out">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($director->full_name) }}&size=320&background=1e40af&color=fff&font-size=0.4&bold=true" 
                                         alt="{{ $director->full_name }}"
                                         class="absolute inset-0 w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="p-8 flex-1 flex flex-col justify-center">
                                <div class="mb-4">
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 break-words-wrap leading-tight">{{ $director->full_name }}</h3>
                                    <div class="min-h-[3rem] flex items-center">
                                        <p class="text-blue-400 font-semibold text-lg break-words-wrap bg-blue-500/10 px-3 py-1 rounded-full inline-block max-w-full">
                                            {{ $director->position }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    @if($director->education)
                                        <div class="text-gray-300 text-sm break-words-wrap bg-gray-800/30 rounded-xl p-3 border border-gray-700/50">
                                            <strong class="text-blue-400">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'education_label', 'Образование:') }}</strong> {{ $director->education }}
                                        </div>
                                    @endif

                                    @if($director->diploma_specialty)
                                        <div class="text-gray-300 text-sm break-words-wrap bg-gray-800/30 rounded-xl p-3 border border-gray-700/50">
                                            <strong class="text-blue-400">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'specialty_label', 'Специальность:') }}</strong> {{ $director->diploma_specialty }}
                                        </div>
                                    @endif

                                    @if($director->category)
                                        <div class="text-gray-300 text-sm break-words-wrap bg-gray-800/30 rounded-xl p-3 border border-gray-700/50">
                                            <strong class="text-blue-400">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'category_label', 'Категория:') }}</strong> {{ $director->category }}
                                        </div>
                                    @endif

                                    @if($director->work_experience_total)
                                        <div class="text-gray-300 text-sm break-words-wrap bg-gray-800/30 rounded-xl p-3 border border-gray-700/50">
                                            <strong class="text-blue-400">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'total_experience_label', 'Общий стаж:') }}</strong> {{ $director->work_experience_total }}
                                        </div>
                                    @endif

                                    @if($director->work_experience_pedagogical)
                                        <div class="text-gray-300 text-sm break-words-wrap bg-gray-800/30 rounded-xl p-3 border border-gray-700/50">
                                            <strong class="text-blue-400">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'pedagogical_experience_label', 'Пед. стаж:') }}</strong> {{ $director->work_experience_pedagogical }}
                                        </div>
                                    @endif
                                </div>

                                @if($director->bio)
                                    <div class="text-gray-300 text-sm leading-relaxed mb-6 max-h-32 overflow-y-auto custom-scrollbar break-words-wrap bg-gray-800/30 rounded-xl p-4 border border-gray-700/50">
                                        {{ $director->bio }}
                                    </div>
                                @endif

                                <div class="space-y-3">
                                    @if($director->email)
                                        <a href="mailto:{{ $director->email }}" 
                                           class="flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-all duration-300 group/contact hover:translate-x-1">
                                            <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover/contact:bg-blue-600/30 transition-colors">
                                                <svg class="w-5 h-5 flex-shrink-0 group-hover/contact:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <span class="break-words-wrap font-medium">{{ $director->email }}</span>
                                        </a>
                                    @endif
                                    
                                    @if($director->phone)
                                        <a href="tel:{{ $director->phone }}" 
                                           class="flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-all duration-300 group/contact hover:translate-x-1">
                                            <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover/contact:bg-blue-600/30 transition-colors">
                                                <svg class="w-5 h-5 flex-shrink-0 group-hover/contact:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                            </div>
                                            <span class="break-words-wrap font-medium">{{ $director->phone }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- LEADERSHIP CAROUSEL (Остальное руководство) --}}
                @if($leadership->count() > 0)
                    <div class="relative px-4 md:px-12" data-animate="fade-up" data-delay="200">
                        <div class="overflow-hidden rounded-3xl bg-gray-800/20 backdrop-blur-sm p-4 border border-gray-700/30">
                            <div class="flex transition-transform duration-700 ease-out" id="leadershipTrack">
                                @foreach($leadership as $index => $member)
                                    <div class="carousel-item w-full md:w-1/3 flex-shrink-0 px-3">
                                        <div class="feature-card group cursor-pointer h-full flex flex-col min-h-[520px]"
                                             onclick="openTeacherModal({{ $member->id }})">
                                            <div class="h-64 bg-gradient-to-br from-gray-700 to-gray-800 relative overflow-hidden rounded-2xl mb-4 flex-shrink-0">
                                                @if($member->photo)
                                                    <img src="{{ $member->photo_url }}" 
                                                         alt="{{ $member->full_name }}"
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->full_name) }}&size=256&background=1e40af&color=fff&font-size=0.4&bold=true" 
                                                         alt="{{ $member->full_name }}"
                                                         class="w-full h-full object-cover">
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-transparent"></div>
                                            </div>
                                            
                                            <div class="flex flex-col flex-1 min-h-0">
                                                <div class="mb-4 flex-shrink-0">
                                                    <h4 class="text-lg font-bold text-white mb-2 break-words-wrap group-hover:text-blue-300 transition-colors leading-tight min-h-[3rem] flex items-center">
                                                        {{ $member->full_name }}
                                                    </h4>
                                                    <div class="min-h-[2.5rem] flex items-center">
                                                        <p class="text-blue-400 text-sm break-words-wrap bg-blue-500/10 px-3 py-1.5 rounded-full inline-block max-w-full leading-relaxed">
                                                            {{ $member->position }}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="space-y-3 mb-4 flex-shrink-0">
                                                    @if($member->education)
                                                        <div class="text-gray-400 text-xs leading-relaxed break-words-wrap min-h-[2rem] flex items-start">
                                                            <div>
                                                                <strong class="text-blue-400 block text-xs mb-1">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'education_label', 'Образование:') }}</strong> 
                                                                <span class="line-clamp-2 text-gray-300 text-xs leading-relaxed">{{ $member->education }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($member->work_experience_pedagogical)
                                                        <div class="text-gray-400 text-xs leading-relaxed break-words-wrap min-h-[1.5rem] flex items-center">
                                                            <div>
                                                                <strong class="text-blue-400 text-xs">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'pedagogical_experience_label', 'Пед. стаж:') }}</strong> 
                                                                <span class="text-gray-300 text-xs ml-1">{{ $member->work_experience_pedagogical }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($member->category)
                                                        <div class="text-gray-400 text-xs leading-relaxed break-words-wrap min-h-[1.5rem] flex items-center">
                                                            <div>
                                                                <strong class="text-blue-400 text-xs">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'category_label', 'Категория:') }}</strong> 
                                                                <span class="text-gray-300 text-xs ml-1">{{ $member->category }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($member->bio)
                                                    <div class="mb-4 flex-1 min-h-0">
                                                        <p class="text-gray-400 text-xs leading-relaxed break-words-wrap line-clamp-3 h-full">
                                                            {{ $member->bio }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="flex-1"></div>
                                                @endif
                                                
                                                <div class="space-y-2 mt-auto pt-4 border-t border-gray-700/50 flex-shrink-0">
                                                    @if($member->email)
                                                        <a href="mailto:{{ $member->email }}" 
                                                           onclick="event.stopPropagation()"
                                                           class="flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-all duration-300 group/link hover:translate-x-1 min-h-[1.5rem]">
                                                            <svg class="w-4 h-4 flex-shrink-0 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                            </svg>
                                                            <span class="text-xs break-words-wrap flex-1 min-w-0 truncate" title="{{ $member->email }}">
                                                                {{ $member->email }}
                                                            </span>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($member->phone)
                                                        <a href="tel:{{ $member->phone }}" 
                                                           onclick="event.stopPropagation()"
                                                           class="flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-all duration-300 group/link hover:translate-x-1 min-h-[1.5rem]">
                                                            <svg class="w-4 h-4 flex-shrink-0 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                            </svg>
                                                            <span class="text-xs break-words-wrap">{{ $member->phone }}</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        @if($leadership->count() > 3)
                            <button id="prevBtn" type="button"
                                    class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-full flex items-center justify-center text-white shadow-2xl transition-all hover:scale-110 z-10 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100 border border-blue-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            
                            <button id="nextBtn" type="button"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-full flex items-center justify-center text-white shadow-2xl transition-all hover:scale-110 z-10 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100 border border-blue-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @endif

                        <div class="flex justify-center mt-6 space-x-2" id="carouselIndicators">
                            @for($i = 0; $i < min(5, ceil($leadership->count() / 3)); $i++)
                                <button class="w-2 h-2 rounded-full bg-gray-600 hover:bg-gray-400 transition-colors carousel-indicator" data-index="{{ $i }}"></button>
                            @endfor
                        </div>
                    </div>
                @endif
            </div>

            {{-- TEACHERS SECTION --}}
            <div data-animate="fade-up" data-delay="400" id="teachers-section">
                <div class="mb-8">
                    {{-- TEACHERS HEADER --}}
                    <h2 class="text-3xl font-bold text-white mb-6 relative">
                        <span class="relative z-10">{{ \App\Models\PageSection::getValue('staff', 'teachers_header', 'title', 'Преподавательский состав') }}</span>
                        <div class="absolute -bottom-2 left-0 w-32 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"></div>
                    </h2>
                    
                    {{-- FILTER FORM --}}
                    <form method="GET" action="{{ route('staff.index') }}" class="mb-8" id="filter-form">
                        <input type="hidden" name="scroll_position" id="scroll_position" value="">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="{{ \App\Models\PageSection::getValue('staff', 'search_placeholder', 'text', 'Поиск по ФИО, должности или дисциплинам...') }}"
                                       class="w-full px-4 py-3 pl-12 bg-gray-800/70 backdrop-blur-sm border border-gray-700/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <div class="relative">
                                <select name="sort" 
                                        class="w-full px-4 py-3 pr-10 bg-gray-800/70 backdrop-blur-sm border border-gray-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none">
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'name_asc', 'По имени А-Я') }}</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'name_desc', 'По имени Я-А') }}</option>
                                    <option value="position_asc" {{ request('sort') == 'position_asc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'position_asc', 'По должности А-Я') }}</option>
                                    <option value="position_desc" {{ request('sort') == 'position_desc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'position_desc', 'По должности Я-А') }}</option>
                                    <option value="experience_desc" {{ request('sort') == 'experience_desc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'experience_desc', 'По стажу (убыв.)') }}</option>
                                    <option value="experience_asc" {{ request('sort') == 'experience_asc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'experience_asc', 'По стажу (возр.)') }}</option>
                                    <option value="category_asc" {{ request('sort') == 'category_asc' ? 'selected' : '' }}>{{ \App\Models\PageSection::getValue('staff', 'sort_options', 'category_asc', 'По категории А-Я') }}</option>
                                </select>
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-300 hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('staff', 'button_labels', 'apply_filter_btn', 'Применить') }}
                                </button>
                                <a href="{{ route('staff.index') }}" 
                                   class="px-4 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl transition-all duration-300 hover:scale-105 flex items-center justify-center"
                                   title="{{ \App\Models\PageSection::getValue('staff', 'button_labels', 'reset_filter_btn', 'Сбросить фильтры') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- STATISTICS --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="feature-card text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $teachers->total() }}</div>
                            <div class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('staff', 'stats_labels', 'stat_1_label', 'Всего преподавателей') }}</div>
                        </div>
                        <div class="feature-card text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $teachers->where('category', '!=', '')->count() }}</div>
                            <div class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('staff', 'stats_labels', 'stat_2_label', 'С категорией') }}</div>
                        </div>
                        <div class="feature-card text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $teachers->perPage() }}</div>
                            <div class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('staff', 'stats_labels', 'stat_3_label', 'На странице') }}</div>
                        </div>
                        <div class="feature-card text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $teachers->currentPage() }}</div>
                            <div class="text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('staff', 'stats_labels', 'stat_4_label', 'Текущая страница') }}</div>
                        </div>
                    </div>

                    {{-- ACTIVE FILTERS --}}
                    @if(request('search') || request('sort'))
                        <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/30 rounded-xl">
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <span class="text-blue-400 font-semibold">{{ \App\Models\PageSection::getValue('staff', 'active_filters', 'title', 'Активные фильтры:') }}</span>
                                
                                @if(request('search'))
                                    <span class="flex items-center gap-2 bg-blue-500/20 px-3 py-1 rounded-full text-blue-300">
                                        {{ \App\Models\PageSection::getValue('staff', 'active_filters', 'search_label', 'Поиск:') }} "{{ request('search') }}"
                                        <a href="{{ route('staff.index', array_merge(request()->except('search'), ['sort' => request('sort')])) }}" 
                                           class="text-blue-400 hover:text-blue-200 transition-colors"
                                           title="{{ \App\Models\PageSection::getValue('staff', 'button_labels', 'remove_filter_btn', 'Удалить фильтр') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                                
                                @if(request('sort'))
                                    @php
                                        $sortLabels = [
                                            'name_asc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'name_asc', 'Имя А-Я'),
                                            'name_desc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'name_desc', 'Имя Я-А'),
                                            'position_asc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'position_asc', 'Должность А-Я'),
                                            'position_desc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'position_desc', 'Должность Я-А'),
                                            'experience_desc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'experience_desc', 'Стаж (убыв.)'),
                                            'experience_asc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'experience_asc', 'Стаж (возр.)'),
                                            'category_asc' => \App\Models\PageSection::getValue('staff', 'sort_options', 'category_asc', 'Категория А-Я')
                                        ];
                                    @endphp
                                    <span class="flex items-center gap-2 bg-blue-500/20 px-3 py-1 rounded-full text-blue-300">
                                        {{ \App\Models\PageSection::getValue('staff', 'active_filters', 'sort_label', 'Сортировка:') }} {{ $sortLabels[request('sort')] ?? request('sort') }}
                                        <a href="{{ route('staff.index', array_merge(request()->except('sort'), ['search' => request('search')])) }}" 
                                           class="text-blue-400 hover:text-blue-200 transition-colors"
                                           title="{{ \App\Models\PageSection::getValue('staff', 'button_labels', 'remove_filter_btn', 'Удалить фильтр') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                                
                                <a href="{{ route('staff.index') }}" 
                                   class="ml-auto text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('staff', 'button_labels', 'reset_all_btn', 'Сбросить все') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- TEACHERS LIST --}}
                @if($teachers->count() > 0)
                    <div class="teachers-scroll-container mb-8 max-h-[800px] overflow-y-auto custom-scrollbar pr-2">
                        <div class="space-y-4">
                            @foreach($teachers as $index => $teacher)
                                <div class="feature-card group cursor-pointer" 
                                     onclick="openTeacherModal({{ $teacher->id }})">
                                    <div class="md:flex items-center relative z-10">
                                        <div class="md:w-32 h-32 bg-gradient-to-br from-gray-700 to-gray-800 flex-shrink-0 relative overflow-hidden group/photo rounded-2xl">
                                            @if($teacher->photo)
                                                <img src="{{ $teacher->photo_url }}" 
                                                     alt="{{ $teacher->full_name }}"
                                                     class="w-full h-full object-cover group-hover/photo:scale-110 transition-transform duration-700 ease-out">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->full_name) }}&size=128&background=1e40af&color=fff&font-size=0.4&bold=true" 
                                                     alt="{{ $teacher->full_name }}"
                                                     class="w-full h-full object-cover">
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
                                        </div>
                                        
                                        <div class="p-5 flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <h4 class="text-lg font-bold text-white mb-1 break-words-wrap group-hover:text-blue-300 transition-colors">{{ $teacher->full_name }}</h4>
                                                <p class="text-blue-400 text-sm break-words-wrap bg-blue-500/10 px-2 py-1 rounded-full inline-block">{{ $teacher->position }}</p>
                                            </div>
                                            
                                            <div class="text-sm">
                                                @if($teacher->education)
                                                    <p class="text-gray-300 mb-1 break-words-wrap">
                                                        <span class="text-gray-500">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'education_label', 'Образование:') }}</span> 
                                                        <span class="text-blue-400 font-medium">{{ $teacher->education }}</span>
                                                    </p>
                                                @endif
                                                @if($teacher->teaching_subjects)
                                                    <p class="text-gray-300 break-words-wrap">
                                                        <span class="text-gray-500">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'teaching_subjects_label', 'Дисциплины:') }}</span> 
                                                        <span class="text-blue-300 font-medium">{{ $teacher->teaching_subjects }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm">
                                                @if($teacher->work_experience_pedagogical)
                                                    <p class="text-gray-300 mb-1 break-words-wrap">
                                                        <span class="text-gray-500">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'pedagogical_experience_label', 'Пед. стаж:') }}</span> 
                                                        <span class="text-blue-400 font-medium">{{ $teacher->work_experience_pedagogical }}</span>
                                                    </p>
                                                @endif
                                                @if($teacher->category)
                                                    <p class="text-gray-300 break-words-wrap">
                                                        <span class="text-gray-500">{{ \App\Models\PageSection::getValue('staff', 'field_labels', 'category_label', 'Категория:') }}</span> 
                                                        <span class="text-green-400 font-medium">{{ $teacher->category }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm space-y-1">
                                                @if($teacher->email)
                                                    <a href="mailto:{{ $teacher->email }}" 
                                                       onclick="event.stopPropagation()"
                                                       class="flex items-center gap-1.5 text-blue-400 hover:text-blue-300 transition truncate group/link hover:translate-x-1">
                                                        <svg class="w-4 h-4 flex-shrink-0 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="truncate break-words-wrap">{{ $teacher->email }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="hidden md:flex items-center justify-center w-16 text-gray-500 group-hover:text-blue-400 transition-all group-hover:translate-x-2 duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PAGINATION --}}
                    @if($teachers->hasPages())
                        <div class="flex justify-center">
                            <div class="flex items-center gap-1 bg-gray-800/50 backdrop-blur-sm rounded-2xl p-2 border border-gray-700/30">
                                @if($teachers->onFirstPage())
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-700 text-gray-600 rounded-xl cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $teachers->previousPageUrl() }}" 
                                       class="w-10 h-10 flex items-center justify-center bg-gray-700 hover:bg-blue-600 text-white rounded-xl transition-all hover:scale-110 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </a>
                                @endif

                                @php
                                    $currentPage = $teachers->currentPage();
                                    $lastPage = $teachers->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @if($start > 1)
                                    <a href="{{ $teachers->url(1) }}" 
                                       class="w-10 h-10 flex items-center justify-center bg-gray-700 hover:bg-blue-600 text-white rounded-xl transition-all hover:scale-110">
                                        1
                                    </a>
                                    @if($start > 2)
                                        <span class="text-gray-500 px-1">...</span>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    @if($page == $currentPage)
                                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $teachers->url($page) }}" 
                                           class="w-10 h-10 flex items-center justify-center bg-gray-700 hover:bg-blue-600 text-white rounded-xl transition-all hover:scale-110">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endfor

                                @if($end < $lastPage)
                                    @if($end < $lastPage - 1)
                                        <span class="text-gray-500 px-1">...</span>
                                    @endif
                                    <a href="{{ $teachers->url($lastPage) }}" 
                                       class="w-10 h-10 flex items-center justify-center bg-gray-700 hover:bg-blue-600 text-white rounded-xl transition-all hover:scale-110">
                                        {{ $lastPage }}
                                    </a>
                                @endif

                                @if($teachers->hasMorePages())
                                    <a href="{{ $teachers->nextPageUrl() }}" 
                                       class="w-10 h-10 flex items-center justify-center bg-gray-700 hover:bg-blue-600 text-white rounded-xl transition-all hover:scale-110 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-700 text-gray-600 rounded-xl cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="contact-main-card text-center">
                        <svg class="w-20 h-20 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-gray-400 text-lg mb-4">{{ \App\Models\PageSection::getValue('staff', 'no_results', 'message', 'Преподаватели не найдены') }}</p>
                        @if(request('search') || request('sort'))
                            <a href="{{ route('staff.index') }}" 
                               class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-300 hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ \App\Models\PageSection::getValue('staff', 'button_labels', 'reset_filters_btn', 'Сбросить фильтры') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- MODAL WINDOW --}}
<div id="teacherModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl border border-gray-700/50 w-full max-w-4xl max-h-[90vh] overflow-hidden animate-modal-in shadow-2xl">
        <div class="p-6 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 id="modalTitle" class="text-2xl font-bold text-white mb-2"></h3>
                    <p id="modalPosition" class="text-blue-400 text-lg"></p>
                </div>
                <button onclick="closeTeacherModal()" class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-700/50 rounded-lg"
                        title="{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'close_btn', 'Закрыть') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-2xl overflow-hidden h-80">
                        <img id="modalPhoto" src="" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div class="lg:col-span-2 space-y-6">
                    <div id="modalBioBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-3 text-lg">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'bio_title', 'О преподавателе') }}</h4>
                        </div>
                        <p id="modalBio" class="text-gray-300 leading-relaxed"></p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div id="modalEducationBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'education_title', 'Образование') }}</h4>
                            </div>
                            <p id="modalEducation" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalSpecialtyBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'specialty_title', 'Специальность') }}</h4>
                            </div>
                            <p id="modalSpecialty" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalSubjectsBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'subjects_title', 'Преподаваемые дисциплины') }}</h4>
                            </div>
                            <p id="modalSubjects" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalCategoryBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'category_title', 'Категория') }}</h4>
                            </div>
                            <p id="modalCategory" class="text-green-400 font-medium"></p>
                        </div>
                        
                        <div id="modalPedagogicalExperienceBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'pedagogical_experience_title', 'Педагогический стаж') }}</h4>
                            </div>
                            <p id="modalPedagogicalExperience" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalTotalExperienceBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'total_experience_title', 'Общий стаж') }}</h4>
                            </div>
                            <p id="modalTotalExperience" class="text-gray-300"></p>
                        </div>
                    </div>
                    
                    <div id="modalAwardsBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'awards_title', 'Награды и достижения') }}</h4>
                        </div>
                        <p id="modalAwards" class="text-gray-300"></p>
                    </div>
                    
                    <div id="modalDevelopmentBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'development_title', 'Повышение квалификации') }}</h4>
                        </div>
                        <p id="modalDevelopment" class="text-gray-300"></p>
                    </div>
                    
                    <div class="border-t border-gray-700/50 pt-6">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'contact_info_title', 'Контактная информация') }}</h4>
                        </div>
                        <div class="space-y-3">
                            <a id="modalEmail" href="#" class="hidden flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors group">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover:bg-blue-600/30 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span id="modalEmailText" class="font-medium"></span>
                            </a>
                            
                            <a id="modalPhone" href="#" class="hidden flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors group">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover:bg-blue-600/30 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span id="modalPhoneText" class="font-medium"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.contact-main-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1.5rem;
    padding: 2.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.contact-main-card:hover {
    transform: translateY(-8px);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
}

.contact-main-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.8), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.contact-main-card:hover::before {
    transform: translateX(100%);
}

.feature-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
    border: 1px solid rgba(59, 130, 246, 0.15);
    border-radius: 1.5rem;
    padding: 2rem;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.feature-card:hover {
    transform: translateY(-5px);
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 15px 30px rgba(59, 130, 246, 0.15);
}

.grid-animation {
    background-image:
        repeating-linear-gradient(0deg, #3b82f6 0px, transparent 1px, transparent 60px),
        repeating-linear-gradient(90deg, #3b82f6 0px, transparent 1px, transparent 60px);
    animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
    0% { transform: translate(0, 0); }
    100% { transform: translate(60px, 60px); }
}

.break-words-wrap {
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
    hyphens: auto;
    max-width: 100%;
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

.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(31, 41, 55, 0.5);
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #1e40af);
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #1e3a8a);
}

#leadershipTrack {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

.carousel-item {
    transition: all 0.5s ease;
    height: auto;
}

@media (min-width: 768px) {
    .carousel-item {
        width: calc(33.333% - 1rem);
    }
}

@media (max-width: 767px) {
    .carousel-item {
        width: 100%;
    }
}

.animate-modal-in {
    animation: modalIn 0.3s ease-out;
}

@keyframes modalIn {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.min-h-\[3rem\] {
    min-height: 3rem;
}

.min-h-\[2\.5rem\] {
    min-height: 2.5rem;
}

.min-h-\[2rem\] {
    min-height: 2rem;
}

.min-h-\[1\.5rem\] {
    min-height: 1.5rem;
}

.min-h-\[520px\] {
    min-height: 520px;
}

.blue-divider {
    position: relative;
    padding-bottom: 0.5rem;
}

.blue-divider::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, #1e40af, transparent);
    border-radius: 2px;
}

.blue-divider h4 {
    position: relative;
    display: inline-block;
}

@media (max-width: 767px) {
    .contact-main-card {
        border-radius: 1rem;
        padding: 1.5rem;
    }
    
    .contact-main-card .flex {
        flex-direction: column;
        height: auto;
    }
    
    .contact-main-card .w-1\/3 {
        width: 100%;
        height: 16rem;
    }
    
    .contact-main-card .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .contact-main-card .p-8 {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    initAnimations();
    initEventHandlers();
    
    
    const urlParams = new URLSearchParams(window.location.search);
    const savedPosition = urlParams.get('scroll_position');
    if (savedPosition) {
        setTimeout(() => {
            const teachersSection = document.getElementById('teachers-section');
            if (teachersSection) {
                const sectionTop = teachersSection.getBoundingClientRect().top + window.pageYOffset;
                const targetPosition = sectionTop + parseInt(savedPosition);
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }, 100);
    }
});

function saveScrollPosition() {
    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    const teachersSection = document.getElementById('teachers-section');
    if (teachersSection) {
        const sectionTop = teachersSection.getBoundingClientRect().top + window.pageYOffset;
        const relativePosition = scrollPosition - sectionTop;
        document.getElementById('scroll_position').value = relativePosition;
    }
}

function openTeacherModal(staffId) {
    const modal = document.getElementById('teacherModal');
    if (!modal) return;

    
    modal.querySelector('.p-6').innerHTML = `
        <div class="flex items-center justify-center h-64">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
            <span class="ml-3 text-white">Загрузка...</span>
        </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    
    fetch(`/api/staff/${staffId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateModalContent(data.data);
            } else {
                throw new Error(data.error || 'Ошибка загрузки данных');
            }
        })
        .catch(error => {
            console.error('Error loading staff data:', error);
            modal.querySelector('.p-6').innerHTML = `
                <div class="flex flex-col items-center justify-center h-64 text-center">
                    <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-white text-lg mb-4">Не удалось загрузить данные преподавателя</p>
                    <p class="text-gray-400 text-sm mb-6">${error.message}</p>
                    <button onclick="closeTeacherModal()" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Закрыть
                    </button>
                </div>
            `;
        });
}

function updateModalContent(data) {
    const modal = document.getElementById('teacherModal');
    const content = modal.querySelector('.p-6');
    
    
    if (!modal.dataset.originalContent) {
        
        const originalModal = document.createElement('div');
        originalModal.innerHTML = `
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 id="modalTitle" class="text-2xl font-bold text-white mb-2"></h3>
                    <p id="modalPosition" class="text-blue-400 text-lg"></p>
                </div>
                <button onclick="closeTeacherModal()" class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-700/50 rounded-lg"
                        title="{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'close_btn', 'Закрыть') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-2xl overflow-hidden h-80">
                        <img id="modalPhoto" src="" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div class="lg:col-span-2 space-y-6">
                    <div id="modalBioBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-3 text-lg">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'bio_title', 'О преподавателе') }}</h4>
                        </div>
                        <p id="modalBio" class="text-gray-300 leading-relaxed"></p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div id="modalEducationBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'education_title', 'Образование') }}</h4>
                            </div>
                            <p id="modalEducation" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalSpecialtyBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'specialty_title', 'Специальность') }}</h4>
                            </div>
                            <p id="modalSpecialty" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalSubjectsBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'subjects_title', 'Преподаваемые дисциплины') }}</h4>
                            </div>
                            <p id="modalSubjects" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalCategoryBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'category_title', 'Категория') }}</h4>
                            </div>
                            <p id="modalCategory" class="text-green-400 font-medium"></p>
                        </div>
                        
                        <div id="modalPedagogicalExperienceBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'pedagogical_experience_title', 'Педагогический стаж') }}</h4>
                            </div>
                            <p id="modalPedagogicalExperience" class="text-gray-300"></p>
                        </div>
                        
                        <div id="modalTotalExperienceBlock" class="hidden">
                            <div class="blue-divider mb-3">
                                <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'total_experience_title', 'Общий стаж') }}</h4>
                            </div>
                            <p id="modalTotalExperience" class="text-gray-300"></p>
                        </div>
                    </div>
                    
                    <div id="modalAwardsBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'awards_title', 'Награды и достижения') }}</h4>
                        </div>
                        <p id="modalAwards" class="text-gray-300"></p>
                    </div>
                    
                    <div id="modalDevelopmentBlock" class="hidden">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold mb-2">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'development_title', 'Повышение квалификации') }}</h4>
                        </div>
                        <p id="modalDevelopment" class="text-gray-300"></p>
                    </div>
                    
                    <div class="border-t border-gray-700/50 pt-6">
                        <div class="blue-divider mb-4">
                            <h4 class="text-white font-semibold">{{ \App\Models\PageSection::getValue('staff', 'modal_labels', 'contact_info_title', 'Контактная информация') }}</h4>
                        </div>
                        <div class="space-y-3">
                            <a id="modalEmail" href="#" class="hidden flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors group">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover:bg-blue-600/30 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span id="modalEmailText" class="font-medium"></span>
                            </a>
                            
                            <a id="modalPhone" href="#" class="hidden flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors group">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center group-hover:bg-blue-600/30 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span id="modalPhoneText" class="font-medium"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        modal.dataset.originalContent = originalModal.innerHTML;
    }
    
    content.innerHTML = modal.dataset.originalContent;
    
   
    document.getElementById('modalTitle').textContent = data.full_name || 'Не указано';
    document.getElementById('modalPosition').textContent = data.position || 'Не указано';
    
    
    const photoUrl = data.photo || 
        `https://ui-avatars.com/api/?name=${encodeURIComponent(data.full_name || 'Преподаватель')}&size=320&background=1e40af&color=fff&font-size=0.4&bold=true`;
    document.getElementById('modalPhoto').src = photoUrl;
    document.getElementById('modalPhoto').alt = data.full_name || 'Преподаватель';
    
    
    updateFieldIfExists('modalBio', data.bio, 'modalBioBlock');
    updateFieldIfExists('modalEducation', data.education, 'modalEducationBlock');
    updateFieldIfExists('modalSpecialty', data.diploma_specialty, 'modalSpecialtyBlock');
    updateFieldIfExists('modalSubjects', data.teaching_subjects, 'modalSubjectsBlock');
    updateFieldIfExists('modalPedagogicalExperience', data.work_experience_pedagogical, 'modalPedagogicalExperienceBlock');
    updateFieldIfExists('modalTotalExperience', data.work_experience_total, 'modalTotalExperienceBlock');
    updateFieldIfExists('modalCategory', data.category, 'modalCategoryBlock');
    updateFieldIfExists('modalAwards', data.awards, 'modalAwardsBlock');
    updateFieldIfExists('modalDevelopment', data.professional_development, 'modalDevelopmentBlock');
    
    
    if (data.email) {
        const emailElement = document.getElementById('modalEmail');
        emailElement.href = 'mailto:' + data.email;
        document.getElementById('modalEmailText').textContent = data.email;
        emailElement.classList.remove('hidden');
    }
    
    if (data.phone) {
        const phoneElement = document.getElementById('modalPhone');
        phoneElement.href = 'tel:' + data.phone;
        document.getElementById('modalPhoneText').textContent = data.phone;
        phoneElement.classList.remove('hidden');
    }
}

function updateFieldIfExists(elementId, value, blockId) {
    const element = document.getElementById(elementId);
    const block = document.getElementById(blockId);
    if (element && block) {
        if (value && value.trim() !== '') {
            element.textContent = value;
            block.classList.remove('hidden');
        } else {
            block.classList.add('hidden');
        }
    }
}

function closeTeacherModal() {
    const modal = document.getElementById('teacherModal');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-0');
        document.body.style.overflow = '';
    }, 300);
}

function initCarousel() {
    const track = document.getElementById('leadershipTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const indicators = document.querySelectorAll('.carousel-indicator');

    if (!track || !prevBtn || !nextBtn) return;

    let currentIndex = 0;
    const items = track.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    
    function getItemsPerView() {
        return window.innerWidth >= 768 ? 3 : 1;
    }
    
    let itemsPerView = getItemsPerView();
    let maxIndex = Math.max(0, totalItems - itemsPerView);

    function updateCarousel() {
        const itemWidth = 100 / itemsPerView;
        const offset = currentIndex * itemWidth;
        track.style.transform = `translateX(-${offset}%)`;
        
        if (prevBtn) prevBtn.disabled = currentIndex === 0;
        if (nextBtn) nextBtn.disabled = currentIndex >= maxIndex;
        
        indicators.forEach((indicator, index) => {
            if (indicator) {
                indicator.classList.toggle('bg-blue-500', index === currentIndex);
                indicator.classList.toggle('bg-gray-600', index !== currentIndex);
            }
        });
    }

    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateCarousel();
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });
    }

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
        });
    });

    let autoScrollInterval = setInterval(() => {
        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }, 5000);

    if (track) {
        track.addEventListener('mouseenter', () => {
            clearInterval(autoScrollInterval);
        });

        track.addEventListener('mouseleave', () => {
            autoScrollInterval = setInterval(() => {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            }, 5000);
        });

        let touchStartX = 0;
        let touchEndX = 0;

        track.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            clearInterval(autoScrollInterval);
        });

        track.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            
            autoScrollInterval = setInterval(() => {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            }, 5000);
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold && currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
            if (touchEndX > touchStartX + swipeThreshold && currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        }
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            itemsPerView = getItemsPerView();
            maxIndex = Math.max(0, totalItems - itemsPerView);
            currentIndex = Math.min(currentIndex, maxIndex);
            updateCarousel();
        }, 250);
    });

    updateCarousel();
}

function initAnimations() {
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-animate]');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight * 0.85 && elementBottom > 0) {
                const delay = element.getAttribute('data-delay') || 0;
                
                setTimeout(() => {
                    element.classList.add('animated');
                }, parseInt(delay));
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
            }
        });
    }, { 
        threshold: 0.1
    });

    document.querySelectorAll('section').forEach(section => {
        sectionObserver.observe(section);
    });
    
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
}

function initEventHandlers() {
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            saveScrollPosition();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeTeacherModal();
        }
    });

    document.getElementById('teacherModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'teacherModal') {
            closeTeacherModal();
        }
    });

    const contactLinks = document.querySelectorAll('a[href^="mailto:"], a[href^="tel:"]');
    contactLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
}


window.openTeacherModal = openTeacherModal;
window.closeTeacherModal = closeTeacherModal;
window.saveScrollPosition = saveScrollPosition;
</script>

@endsection