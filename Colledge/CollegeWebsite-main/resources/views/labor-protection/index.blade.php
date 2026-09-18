@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('labor_protection', 'metadata', 'title', 'Охрана труда'))

@section('content')

<section class="py-12 bg-gradient-to-b from-gray-900 to-black min-h-screen">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('labor_protection', 'hero', 'main_title', 'Охрана труда') }}
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6"></div>
            <p class="text-gray-300 text-lg max-w-3xl mx-auto">
                {{ \App\Models\PageSection::getValue('labor_protection', 'hero', 'main_description', 'Нормативные документы по охране труда и технике безопасности. Все документы представлены в формате PDF для просмотра и скачивания.') }}
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="lg:w-1/4">
                <div class="sticky top-24">
                    <div class="bg-gradient-to-r from-blue-900/30 via-blue-800/30 to-cyan-900/30 rounded-xl p-6 mb-6 border border-blue-500/20">
                        <h2 class="text-xl font-bold text-white mb-4">
                            {{ \App\Models\PageSection::getValue('labor_protection', 'navigation', 'documents_title', 'Нормативные документы') }}
                        </h2>
                        <p class="text-gray-300 text-sm">{{ \App\Models\PageSection::getValue('labor_protection', 'navigation', 'documents_subtitle', 'Выберите документ для изучения') }}</p>
                    </div>
                    
                    <nav class="space-y-1 max-h-[calc(100vh-300px)] overflow-y-auto pr-2">
                        @foreach($documents as $index => $document)
                            <a href="#document-{{ $document->id }}" 
                               class="document-nav-item block p-4 rounded-lg transition-all duration-200 {{ $index === 0 ? 'active' : '' }}"
                               data-document-id="{{ $document->id }}">
                                <div class="flex items-start">
                                    <div class="mr-3 flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 document-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-300 leading-relaxed text-sm">{{ $document->title }}</span>
                                </div>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>

            
            <div class="lg:w-3/4">
                @foreach($documents as $index => $document)
                <div id="document-{{ $document->id }}" class="document-section mb-12 scroll-mt-24">
                    
                    <div class="mb-8 text-center">
                        <div class="inline-flex items-center justify-center px-4 py-2 bg-blue-600/20 border border-blue-500/30 rounded-full mb-4">
                            <svg class="w-4 h-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-blue-400 text-sm font-semibold">{{ \App\Models\PageSection::getValue('labor_protection', 'document_header', 'normative_label', 'НОРМАТИВНЫЙ ДОКУМЕНТ') }}</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
                            {{ $document->title }}
                        </h2>
                        <div class="flex items-center justify-center space-x-4 text-gray-400 text-sm mb-4">
                            @if($document->file_size)
                                <span class="px-3 py-1 bg-blue-600/20 rounded-full text-blue-300">{{ $document->file_size }}</span>
                            @endif
                            <span class="px-3 py-1 bg-blue-600/20 rounded-full text-blue-300">{{ $document->pages }} {{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'pages_label', 'стр.') }}</span>
                        </div>
                    </div>

                    
                    <div class="bg-gray-800/50 rounded-xl p-4 mb-4 border border-gray-700">
                        <div class="pdf-viewer-container">
                            <div class="pdf-viewer-header flex justify-between items-center mb-4 p-3 bg-gray-900/50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <button class="pdf-control-btn zoom-out" title="{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'zoom_out_title', 'Уменьшить') }}">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <span class="pdf-zoom-level text-blue-300 font-medium">100%</span>
                                    <button class="pdf-control-btn zoom-in" title="{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'zoom_in_title', 'Увеличить') }}">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                    <span class="text-gray-600 mx-2">|</span>
                                    <span class="pdf-page-info text-gray-400 text-sm">{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'page_label', 'Страница') }} <span class="font-semibold text-white">1</span> {{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'of_label', 'из') }} <span class="font-semibold text-white">{{ $document->pages }}</span></span>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('labor-protection.preview', ['document' => $document->slug]) }}" 
                                       target="_blank" 
                                       class="pdf-control-btn external-link" 
                                       title="{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'open_new_tab_title', 'Открыть в новой вкладке') }}">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                           
                            <div class="pdf-viewport rounded-lg overflow-hidden bg-gray-900">
                                <iframe 
                                    src="{{ route('labor-protection.preview', ['document' => $document->slug]) }}"
                                    class="w-full min-h-[600px]"
                                    frameborder="0"
                                    scrolling="yes"
                                    title="{{ $document->title }}">
                                </iframe>
                            </div>

                            
                            <div class="pdf-navigation flex justify-between items-center mt-4 p-3 bg-gray-900/50 rounded-lg">
                                <button class="pdf-nav-btn prev-page flex items-center text-gray-300 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'prev_button', 'Предыдущая') }}
                                </button>
                                
                                <div class="flex items-center space-x-2">
                                    <input type="number" 
                                           class="page-input w-16 px-3 py-1 border border-gray-600 rounded text-center text-white bg-gray-800"
                                           min="1" 
                                           max="{{ $document->pages }}" 
                                           value="1">
                                    <span class="text-gray-400">{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'of_label', 'из') }} {{ $document->pages }}</span>
                                </div>
                                
                                <button class="pdf-nav-btn next-page flex items-center text-gray-300 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                    {{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'next_button', 'Следующая') }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="text-center">
                        <a href="{{ route('labor-protection.download', ['document' => $document->slug]) }}" 
                           download="{{ $document->title }}.pdf" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            @if($document->file_size)
                                {{ \App\Models\PageSection::getValue('labor_protection', 'download', 'download_with_size', 'Скачать документ') }} ({{ $document->file_size }})
                            @else
                                {{ \App\Models\PageSection::getValue('labor_protection', 'download', 'download_button', 'Скачать документ') }}
                            @endif
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        
        <div class="mt-12">
            <div class="bg-gradient-to-r from-blue-900/20 to-cyan-900/20 rounded-2xl p-8 border border-blue-500/10">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/4 mb-6 md:mb-0">
                        <div class="info-icon-large mx-auto md:mx-0">
                            <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-3/4 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-white mb-4">{{ \App\Models\PageSection::getValue('labor_protection', 'info_block', 'title', 'Важность охраны труда') }}</h3>
                        <p class="text-gray-300 leading-relaxed">
                            {{ \App\Models\PageSection::getValue('labor_protection', 'info_block', 'description', 'Охрана труда является важнейшим направлением деятельности любой организации. Нормативные документы по охране труда обеспечивают безопасные условия работы, предотвращают производственные травмы и заболевания, способствуют сохранению здоровья работников. Регулярное изучение и соблюдение требований охраны труда является обязательным для всех сотрудников и руководителей.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.document-nav-item {
    background: transparent;
    border: none;
}

.document-nav-item.active {
    background: rgba(59, 130, 246, 0.15);
    border-left: 3px solid #3b82f6;
}

.document-nav-item.active .document-arrow {
    color: #3b82f6;
}

.document-nav-item.active span {
    color: white;
    font-weight: 500;
}

.document-nav-item:hover:not(.active) {
    background: rgba(59, 130, 246, 0.08);
}

.document-nav-item:hover:not(.active) .document-arrow {
    color: #60a5fa;
}

.document-nav-item:hover:not(.active) span {
    color: #93c5fd;
}

.document-nav-item .document-arrow {
    color: #6b7280;
    transition: color 0.2s ease;
}

.pdf-control-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.3);
    transition: all 0.2s ease;
    cursor: pointer;
}

.pdf-control-btn:hover {
    background: rgba(59, 130, 246, 0.25);
    border-color: rgba(59, 130, 246, 0.5);
}

.pdf-nav-btn {
    padding: 8px 16px;
    border-radius: 8px;
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.3);
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}

.pdf-nav-btn:hover:not(:disabled) {
    background: rgba(59, 130, 246, 0.25);
    border-color: rgba(59, 130, 246, 0.5);
    color: white;
}

.page-input {
    border: 1px solid #4b5563;
    outline: none;
    transition: all 0.2s ease;
    background: #1f2937;
    color: white;
}

.page-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.5);
}

.document-section {
    scroll-margin-top: 6rem;
}

nav::-webkit-scrollbar {
    width: 6px;
}

nav::-webkit-scrollbar-track {
    background: rgba(31, 41, 55, 0.5);
    border-radius: 3px;
}

nav::-webkit-scrollbar-thumb {
    background: rgba(75, 85, 99, 0.8);
    border-radius: 3px;
}

nav::-webkit-scrollbar-thumb:hover {
    background: rgba(107, 114, 128, 0.8);
}

.info-icon-large {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(59, 130, 246, 0.15);
    width: 80px;
    height: 80px;
    border-radius: 20px;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

@media (max-width: 1024px) {
    .document-section {
        scroll-margin-top: 4rem;
    }
}

@media (max-width: 768px) {
    .document-section {
        scroll-margin-top: 3rem;
    }
    
    .pdf-navigation {
        flex-direction: column;
        gap: 12px;
    }
    
    .pdf-nav-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.document-nav-item');
    const documentSections = document.querySelectorAll('.document-section');
    
    function updateActiveNav() {
        let currentSection = '';
        const scrollPosition = window.scrollY + 100;
        
        documentSections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSection = section.id;
            }
        });
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${currentSection}`) {
                item.classList.add('active');
            }
        });
    }
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                
                window.scrollTo({
                    top: targetSection.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                history.pushState(null, null, targetId);
            }
        });
    });
    
    documentSections.forEach((section, index) => {
        const pdfContainer = section.querySelector('.pdf-viewer-container');
        const pageInput = pdfContainer.querySelector('.page-input');
        const pages = parseInt(pageInput.getAttribute('max'));
        
        function updatePagination(currentPage) {
            const prevBtn = pdfContainer.querySelector('.prev-page');
            const nextBtn = pdfContainer.querySelector('.next-page');
            const pageInfo = pdfContainer.querySelector('.pdf-page-info');
            
            pageInput.value = currentPage;
            pageInfo.innerHTML = `{{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'page_label', 'Страница') }} <span class="font-semibold text-white">${currentPage}</span> {{ \App\Models\PageSection::getValue('labor_protection', 'pdf_viewer', 'of_label', 'из') }} <span class="font-semibold text-white">${pages}</span>`;
            
            prevBtn.disabled = currentPage <= 1;
            nextBtn.disabled = currentPage >= pages;
        }
        
        let currentPage = 1;
        updatePagination(currentPage);
        
        const prevBtn = pdfContainer.querySelector('.prev-page');
        const nextBtn = pdfContainer.querySelector('.next-page');
        const zoomOutBtn = pdfContainer.querySelector('.zoom-out');
        const zoomInBtn = pdfContainer.querySelector('.zoom-in');
        const zoomLevel = pdfContainer.querySelector('.pdf-zoom-level');
        let currentZoom = 100;
        
        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updatePagination(currentPage);
            }
        });
        
        nextBtn.addEventListener('click', () => {
            if (currentPage < pages) {
                currentPage++;
                updatePagination(currentPage);
            }
        });
        
        pageInput.addEventListener('change', (e) => {
            let page = parseInt(e.target.value);
            if (page < 1) page = 1;
            if (page > pages) page = pages;
            if (!isNaN(page)) {
                currentPage = page;
                updatePagination(currentPage);
            }
        });
        
        zoomOutBtn.addEventListener('click', () => {
            if (currentZoom > 50) {
                currentZoom -= 10;
                zoomLevel.textContent = `${currentZoom}%`;
            }
        });
        
        zoomInBtn.addEventListener('click', () => {
            if (currentZoom < 200) {
                currentZoom += 10;
                zoomLevel.textContent = `${currentZoom}%`;
            }
        });
    });
    
    if (window.location.hash) {
        const targetSection = document.querySelector(window.location.hash);
        if (targetSection) {
            setTimeout(() => {
                targetSection.scrollIntoView();
            }, 100);
            
            navItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === window.location.hash) {
                    item.classList.add('active');
                }
            });
        }
    }
    
    window.addEventListener('scroll', updateActiveNav);
    updateActiveNav();
});
</script>

@endsection