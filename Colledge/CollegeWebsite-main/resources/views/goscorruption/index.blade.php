@extends('layouts.app')

@section('title', $title ?? 'Противодействие коррупции')

@section('content')
<section class="relative overflow-visible bg-gradient-to-b from-gray-900 to-black pt-24 pb-32 min-h-screen">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10 overflow-hidden">
        <div class="grid-animation"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 pt-8 overflow-visible">
        <div class="max-w-7xl mx-auto overflow-visible">
            <div class="text-center mb-12" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('anticorruption', 'hero', 'title_part1', 'Противодействие') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500">
                        {{ \App\Models\PageSection::getValue('anticorruption', 'hero', 'title_part2', 'коррупции') }}
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('anticorruption', 'hero', 'description', 'Информационная страница о мерах противодействия коррупции, официальные документы и нормативные акты') }}
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 overflow-visible">
                <div class="lg:w-2/3 overflow-visible">
                    
                    <div class="mb-16" id="posters-section">
                        <h2 class="text-3xl font-bold text-white mb-8">
                            {{ \App\Models\PageSection::getValue('anticorruption', 'posters', 'section_title', 'Информационные материалы') }}
                        </h2>
                        
                        <div class="space-y-10">
                            @foreach($posters as $poster)
                            <div class="poster-wrapper" id="poster-{{ $poster['id'] }}" data-animate data-delay="{{ 300 + ($loop->index * 50) }}">
                                @if(isset($imagePaths[$poster['id']]) && $imagePaths[$poster['id']])
                                    <img src="{{ asset($poster['image_path']) }}" 
                                         alt="{{ $poster['title'] }}" 
                                         class="w-full rounded-xl shadow-2xl poster-image">
                                @else
                                    <div class="w-full h-64 bg-gradient-to-r from-blue-900/20 to-cyan-900/20 rounded-2xl border-2 border-dashed border-blue-500/30 flex flex-col items-center justify-center p-8">
                                        <i class="{{ $poster['icon'] }} {{ $poster['icon_color'] }} text-5xl mb-4"></i>
                                        <p class="text-gray-300 text-xl mb-2">{{ $poster['title'] }}</p>
                                        <p class="text-sm text-blue-400 bg-blue-400/10 px-4 py-2 rounded-lg">
                                            Изображение не найдено: {{ $poster['image_path'] }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    
                    <div class="mb-16" id="documents-section">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-3xl font-bold text-white mb-2" data-animate data-delay="100">
                                    {{ \App\Models\PageSection::getValue('anticorruption', 'documents', 'section_title', 'Документы по противодействию коррупции') }}
                                </h2>
                                <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-cyan-500" data-animate data-delay="150"></div>
                            </div>
                            
                            <a href="{{ route('anticorruption.documents') }}" 
                               class="btn-primary group" 
                               data-animate data-delay="200">
                                <span>{{ \App\Models\PageSection::getValue('anticorruption', 'documents', 'button_text', 'Все документы') }}</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if(count($documents) > 0)
                                @foreach($documents as $document)
                                <a href="{{ $document['url'] }}" 
                                   target="_blank"
                                   class="document-card cursor-pointer" 
                                   data-animate 
                                   data-delay="{{ 250 + ($loop->index * 50) }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="document-date text-white">{{ $document['date'] }}</div>
                                        <div class="flex items-center gap-2 text-sm {{ $document['type_color'] }}">
                                            <i class="{{ $document['type_icon'] }}"></i>
                                            <span>{{ $document['type'] }}</span>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-3 line-clamp-2">{{ $document['title'] }}</h3>
                                    <p class="text-gray-300 text-sm mb-4 line-clamp-3">{{ $document['description'] }}</p>
                                    <div class="flex items-center gap-2 text-blue-400 text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Открыть PDF</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <div class="col-span-3">
                                    <div class="document-card">
                                        <div class="flex items-center justify-center p-8">
                                            <div class="text-center">
                                                <i class="fas fa-info-circle text-blue-400 text-4xl mb-4"></i>
                                                <p class="text-white text-lg mb-2">
                                                    {{ \App\Models\PageSection::getValue('anticorruption', 'documents', 'empty_title', 'Документы отсутствуют') }}
                                                </p>
                                                <p class="text-gray-400">
                                                    {{ \App\Models\PageSection::getValue('anticorruption', 'documents', 'empty_description', 'Документы будут добавлены позже') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                   
                    <div class="mb-16" id="information-section">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-3xl font-bold text-white mb-2" data-animate data-delay="100">
                                    {{ \App\Models\PageSection::getValue('anticorruption', 'information', 'section_title', 'Перечень сведений, подлежащих опубликованию') }}
                                </h2>
                                <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-cyan-500" data-animate data-delay="150"></div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if(isset($information) && count($information) > 0)
                                @foreach($information as $info)
                                <a href="{{ $info['url'] }}" 
                                   target="_blank"
                                   class="document-card cursor-pointer" 
                                   data-animate 
                                   data-delay="{{ 250 + ($loop->index * 50) }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="document-date text-white">{{ $info['date'] }}</div>
                                        <div class="flex items-center gap-2 text-sm {{ $info['type_color'] }}">
                                            <i class="{{ $info['type_icon'] }}"></i>
                                            <span>{{ $info['type'] }}</span>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-3 line-clamp-2">{{ $info['title'] }}</h3>
                                    <p class="text-gray-300 text-sm mb-4 line-clamp-3">{{ $info['description'] }}</p>
                                    <div class="flex items-center gap-2 text-blue-400 text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Открыть PDF</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <div class="col-span-3">
                                    <div class="document-card">
                                        <div class="flex items-center justify-center p-8">
                                            <div class="text-center">
                                                <i class="fas fa-info-circle text-blue-400 text-4xl mb-4"></i>
                                                <p class="text-white text-lg mb-2">
                                                    {{ \App\Models\PageSection::getValue('anticorruption', 'information', 'empty_title', 'Информация отсутствует') }}
                                                </p>
                                                <p class="text-gray-400">
                                                    {{ \App\Models\PageSection::getValue('anticorruption', 'information', 'empty_description', 'Данные будут добавлены позже') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                
                <div class="lg:w-1/3 overflow-visible">
                    <div class="sticky-sidebar">
                        <div class="sidebar-menu">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                                <i class="fas fa-list-ol text-blue-400"></i>
                                <span>{{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'title', 'Содержание') }}</span>
                            </h3>
                            
                            <nav class="space-y-4">
                                <a href="#posters-section" class="menu-item active">
                                    <div class="flex items-center gap-4">
                                        <div class="menu-icon">
                                            <span class="menu-number">01</span>
                                        </div>
                                        <div class="text-left flex-1">
                                            <div class="font-medium text-white">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item1_title', 'Информационные материалы') }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item1_description', 'Плакаты и наглядные материалы') }}
                                            </div>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-500 text-sm"></i>
                                    </div>
                                </a>
                                
                                <a href="#documents-section" class="menu-item">
                                    <div class="flex items-center gap-4">
                                        <div class="menu-icon">
                                            <span class="menu-number">02</span>
                                        </div>
                                        <div class="text-left flex-1">
                                            <div class="font-medium text-white">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item2_title', 'Документы') }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item2_description', 'Нормативные акты и отчеты') }}
                                            </div>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-500 text-sm"></i>
                                    </div>
                                </a>
                                
                                <a href="#information-section" class="menu-item">
                                    <div class="flex items-center gap-4">
                                        <div class="menu-icon">
                                            <span class="menu-number">03</span>
                                        </div>
                                        <div class="text-left flex-1">
                                            <div class="font-medium text-white">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item3_title', 'Информация') }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ \App\Models\PageSection::getValue('anticorruption', 'sidebar', 'item3_description', 'Сведения о противодействии коррупции') }}
                                            </div>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-500 text-sm"></i>
                                    </div>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    section,
    .container,
    .max-w-7xl,
    .flex-col,
    .lg\:flex-row,
    .lg\:w-1\/3,
    .lg\:w-2\/3 {
        overflow: visible !important;
    }

    section {
        padding-bottom: 8rem !important;
    }

    .sticky-sidebar {
        position: sticky;
        top: 120px;
        height: fit-content;
        z-index: 50;
        align-self: flex-start;
        margin-top: 0;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .sticky-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sticky-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 2px;
    }

    .sticky-sidebar::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.5);
        border-radius: 2px;
    }

    @media (max-width: 1023px) {
        .sticky-sidebar {
            position: static;
            margin-bottom: 2rem;
            max-height: none;
            overflow-y: visible;
        }
    }

    .sidebar-menu {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        transition: all 0.2s ease;
        z-index: 100;
    }

    .menu-item {
        display: block;
        width: 100%;
        padding: 16px;
        background: rgba(59, 130, 246, 0.08);
        border: 1px solid transparent;
        border-radius: 12px;
        text-align: left;
        transition: all 0.25s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        margin-bottom: 0;
    }

    .menu-item:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
        text-decoration: none;
    }

    .menu-item.active {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.25);
    }

    .menu-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, #3b82f6, #06b6d4);
        border-radius: 4px;
    }

    .menu-icon {
        width: 44px;
        height: 44px;
        background: rgba(59, 130, 246, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        flex-shrink: 0;
        font-size: 18px;
        transition: all 0.3s ease;
        position: relative;
    }

    .menu-number {
        font-size: 14px;
        font-weight: 700;
        color: #3b82f6;
        transition: all 0.3s ease;
    }

    .menu-item.active .menu-icon {
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .menu-item.active .menu-number {
        color: white;
        font-weight: 800;
    }

    .menu-item:hover .menu-icon {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
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

    .poster-image {
        width: 100%;
        height: auto;
        border-radius: 0.75rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease;
        display: block;
        max-width: 100%;
    }

    .poster-image:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    }

    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        outline: none;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        text-decoration: none;
    }

    .document-card {
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 14px;
        padding: 20px;
        transition: all 0.2s ease;
        cursor: pointer;
        height: 100%;
        display: block;
        position: relative;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
    }

    .document-card:hover {
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(59, 130, 246, 0.3);
        text-decoration: none;
        color: inherit;
    }

    .document-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 14px;
        border: 2px solid transparent;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(6, 182, 212, 0.1)) border-box;
        -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .document-card:hover::after {
        opacity: 1;
    }

    .document-date {
        color: white !important;
        font-weight: 500;
    }

    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        max-height: 3em;
        line-height: 1.5em;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        max-height: 4.5em;
        line-height: 1.5em;
    }

    
    .document-card h3,
    .document-card p {
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
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

    .reading-progress-bar {
        transition: width 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM загружен, инициализируем sticky sidebar...');
        
        const readingProgress = document.querySelector('.reading-progress');
        const readingProgressBar = document.querySelector('.reading-progress-bar');
        const menuItems = document.querySelectorAll('.menu-item');
        const sidebar = document.querySelector('.sticky-sidebar');
        const footer = document.querySelector('footer') || document.querySelector('.footer');
        
        if (!sidebar) {
            console.error('Sidebar не найден!');
            return;
        }
        
        console.log('Sidebar найден:', sidebar);
        
        sidebar.style.position = 'sticky';
        sidebar.style.top = '120px';
        sidebar.style.zIndex = '50';
        
        const sections = [
            { id: 'posters-section', element: document.getElementById('posters-section') },
            { id: 'documents-section', element: document.getElementById('documents-section') },
            { id: 'information-section', element: document.getElementById('information-section') }
        ];

        const preventFooterOverlap = () => {
            if (!footer) return;
            
            const footerRect = footer.getBoundingClientRect();
            const sidebarRect = sidebar.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            if (footerRect.top < windowHeight && footerRect.top > 0) {
                const overlap = windowHeight - footerRect.top;
                const sidebarBottom = sidebarRect.bottom;
                
                if (sidebarBottom > footerRect.top - 20) {
                    const newTop = 120 - (sidebarBottom - footerRect.top + 20);
                    sidebar.style.top = Math.max(20, newTop) + 'px';
                } else {
                    sidebar.style.top = '120px';
                }
            } else {
                sidebar.style.top = '120px';
            }
        };

        const animateOnScroll = () => {
            document.querySelectorAll('[data-animate]').forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.9 && rect.bottom > 0) {
                    const delay = element.getAttribute('data-delay') || 0;
                    setTimeout(() => element.classList.add('animated'), parseInt(delay));
                }
            });
        };

        const updateActiveMenu = () => {
            let activeSection = '';
            let minDistance = Infinity;
            
            sections.forEach(section => {
                if (section.element) {
                    const rect = section.element.getBoundingClientRect();
                    if (rect.top <= window.innerHeight / 2 && rect.bottom >= 100) {
                        const distance = Math.abs(rect.top - window.innerHeight / 3);
                        if (distance < minDistance) {
                            minDistance = distance;
                            activeSection = section.id;
                        }
                    }
                }
            });

            if (activeSection) {
                menuItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('href') === '#' + activeSection) {
                        item.classList.add('active');
                    }
                });
            }
        };

        const updateReadingProgress = () => {
            if (!sections[0].element || !sections[sections.length - 1].element) return;
            
            const start = sections[0].element.getBoundingClientRect().top + window.pageYOffset;
            const end = sections[sections.length - 1].element.getBoundingClientRect().bottom + window.pageYOffset;
            const totalHeight = end - start;
            const scrollPosition = window.pageYOffset + window.innerHeight / 2;
            
            let progress = 0;
            
            if (scrollPosition < start) {
                progress = 0;
            } else if (scrollPosition > end) {
                progress = 100;
            } else {
                progress = ((scrollPosition - start) / totalHeight) * 100;
            }
            
            progress = Math.max(0, Math.min(100, progress));
            
            if (readingProgress) readingProgress.textContent = Math.round(progress) + '%';
            if (readingProgressBar) readingProgressBar.style.width = progress + '%';
        };

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    const headerOffset = 140;
                    const targetPosition = target.getBoundingClientRect().top;
                    const offsetPosition = targetPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    setTimeout(() => {
                        updateActiveMenu();
                        updateReadingProgress();
                        preventFooterOverlap();
                    }, 300);
                }
            });
        });

        const handleScroll = () => {
            animateOnScroll();
            updateActiveMenu();
            updateReadingProgress();
            preventFooterOverlap();
        };

        window.addEventListener('scroll', handleScroll);
        window.addEventListener('resize', handleScroll);

        animateOnScroll();
        updateActiveMenu();
        updateReadingProgress();
        preventFooterOverlap();
        
        const forceOverflowVisible = () => {
            const elements = document.querySelectorAll('section, .container, .max-w-7xl, .flex-col, .lg\\:flex-row, .lg\\:w-1\\/3, .lg\\:w-2\\/3');
            elements.forEach(el => {
                el.style.overflow = 'visible';
                el.style.position = 'relative';
            });
        };
        
        forceOverflowVisible();
        
        document.querySelectorAll('.document-date').forEach(el => {
            el.style.color = 'white';
            el.style.fontWeight = '500';
        });
        
        console.log('Сайт "Противодействие коррупции" инициализирован');
    });
</script>
@endsection