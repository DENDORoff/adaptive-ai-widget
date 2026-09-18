<section id="virtual-tour" class="py-16 bg-gray-800">
    <div class="container px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-white mb-2" data-editable data-section="virtual-tour" data-group="hero" data-key="title">
                {{ \App\Models\PageSection::getValue('virtual-tour', 'hero', 'title', 'Virtual Tour') }}
            </h2>
            <p class="text-gray-400" data-editable data-section="virtual-tour" data-group="hero" data-key="subtitle">
                {{ \App\Models\PageSection::getValue('virtual-tour', 'hero', 'subtitle', 'Познакомьтесь с нашим колледжем онлайн') }}
            </p>
        </div>
        
        <div class="w-full max-w-6xl mx-auto">
            <div id="tourContainer" class="relative rounded-lg overflow-hidden shadow-xl" style="padding-bottom: 40%;" data-editable data-section="virtual-tour" data-group="tour_iframe">
                @php
                    $iframeSrc = \App\Models\PageSection::getValue('virtual-tour', 'tour_iframe', 'iframe_src', '/virtual-tour/index.html');
                    $iframeAlt = \App\Models\PageSection::getValue('virtual-tour', 'tour_iframe', 'iframe_alt', 'Виртуальный тур по колледжу');
                @endphp
                
                <iframe 
                    id="tourIframe"
                    src="{{ $iframeSrc }}" 
                    class="absolute top-0 left-0 w-full h-full"
                    frameborder="0" 
                    loading="lazy"
                    allowfullscreen
                    title="{{ $iframeAlt }}">
                </iframe>
            </div>

            <div class="text-center mt-8">
                <button onclick="toggleFullscreen()" class="px-5 py-2.5 border border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-white rounded-lg font-medium transition inline-flex items-center" data-editable data-section="virtual-tour" data-group="hero" data-key="fullscreen_button_text">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                    </svg>
                    {{ \App\Models\PageSection::getValue('virtual-tour', 'hero', 'fullscreen_button_text', 'Полноэкранный режим') }}
                </button>
            </div>
        </div>

        <div class="mt-16 w-full max-w-6xl mx-auto">
            <h3 class="text-2xl font-bold text-white text-center mb-8" data-editable data-section="virtual-tour" data-group="videos_carousel" data-key="carousel_title">
                {{ \App\Models\PageSection::getValue('virtual-tour', 'videos_carousel', 'carousel_title', 'Видеоматериалы') }}
            </h3>
            
            <div class="relative" data-editable data-section="virtual-tour" data-group="videos_carousel">
                <div id="progressBar" class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gray-700 rounded-full overflow-hidden hidden">
                    <div id="progressFill" class="h-full bg-blue-500 w-0 transition-all duration-300"></div>
                </div>
                
                <div class="flex items-center justify-center">
                    <button onclick="prevVideo()" class="mr-3 z-10 bg-gray-900/90 hover:bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all shadow-xl border border-gray-700 hover:scale-110 active:scale-95 group flex-shrink-0">
                        <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    
                    <div class="flex-1 overflow-hidden">
                        <div id="videoCarouselContainer" class="relative">
                            <div id="videoCarousel" class="flex pb-4">
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="nextVideo()" class="ml-3 z-10 bg-gray-900/90 hover:bg-gray-800 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all shadow-xl border border-gray-700 hover:scale-110 active:scale-95 group flex-shrink-0">
                        <svg class="w-6 h-6 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="pageIndicators" class="flex justify-center items-center mt-6 space-x-2">
            </div>
        </div>

        <div id="videoModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4 opacity-0 transition-opacity duration-300">
            <div class="relative w-full max-w-4xl transform scale-95 transition-transform duration-300">
                <button onclick="closeVideoModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl hover:scale-110 transition-transform">
                    &times;
                </button>
                <div id="videoPlayer" class="relative w-full rounded-xl overflow-hidden" style="padding-bottom: 56.25%;">
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const videoSettings = {
    autoplayEnabled: {{ \App\Models\PageSection::getValue('virtual-tour', 'videos_carousel', 'autoplay_enabled', 'false') === 'true' ? 'true' : 'false' }},
    autoplayInterval: {{ \App\Models\PageSection::getValue('virtual-tour', 'videos_carousel', 'autoplay_interval', '5000') }}
};

let videos = [];

@for($i = 1; $i <= 20; $i++)
    @php
        $videoId = \App\Models\PageSection::getValue('virtual-tour', 'videos_carousel', "video_{$i}_id");
        $videoTitle = \App\Models\PageSection::getValue('virtual-tour', 'videos_carousel', "video_{$i}_title");
    @endphp
    
    @if($videoId && $videoTitle)
        videos.push({ 
            id: '{{ $videoId }}', 
            title: '{{ addslashes($videoTitle) }}' 
        });
    @endif
@endfor

if (videos.length === 0) {
    videos = [
        { id: 'dQw4w9WgXcQ', title: 'Экскурсия по колледжу' },
        { id: '9bZkp7q19f0', title: 'День открытых дверей' },
        { id: 'kXYiU_JCYtU', title: 'Лаборатории и оборудование' },
        { id: 'n6BwAWiHcSg', title: 'Студенческая жизнь' },
        { id: '2Vv-BfVoq4g', title: 'Спортивные объекты' },
        { id: 'T6DJcgm3wNY', title: 'Библиотека и ресурсы' },
        { id: 'L_jWHffIx5E', title: 'Мероприятия и праздники' },
        { id: 'CduA0TULnow', title: 'Профессорско-преподавательский состав' },
        { id: 'FEKEjpTzB0Q', title: 'Международные программы' },
        { id: 'ZbZSe6N_BXs', title: 'Карьерные перспективы' }
    ];
}

let currentIndex = 0;
let currentPage = 0;
let isAnimating = false;
let animationTimeout = null;
const itemsPerPage = 4;
const totalPages = videos.length > 0 ? Math.ceil(videos.length / (itemsPerPage - 1)) : 1;

function initVideoCarousel() {
    if (videos.length === 0) {
        console.warn('Нет видео для отображения');
        document.getElementById('videoCarouselContainer').innerHTML = 
            '<div class="text-center py-8 text-gray-400">Видеоматериалы скоро будут добавлены</div>';
        return;
    }
    updateCarousel();
    updatePageIndicators();
    
    if (videoSettings.autoplayEnabled && videos.length > itemsPerPage) {
        startAutoCarousel();
    }
}

function getVideoIndex(index) {
    if (videos.length === 0) return 0;
    return ((index % videos.length) + videos.length) % videos.length;
}

function showLoadingAnimation() {
    const progressBar = document.getElementById('progressBar');
    const progressFill = document.getElementById('progressFill');
    
    if (!progressBar || !progressFill) return;
    
    progressBar.classList.remove('hidden');
    progressFill.style.width = '0%';
    
    setTimeout(() => {
        progressFill.style.width = '100%';
    }, 10);
    
    setTimeout(() => {
        progressFill.style.width = '0%';
        setTimeout(() => {
            progressBar.classList.add('hidden');
        }, 300);
    }, 500);
}

function updatePageIndicators() {
    const indicatorsContainer = document.getElementById('pageIndicators');
    if (!indicatorsContainer) return;
    
    indicatorsContainer.innerHTML = '';
    for (let i = 0; i < totalPages; i++) {
        const button = document.createElement('button');
        button.className = `indicator-dot w-2 h-2 rounded-full transition-all duration-300 ${i === currentPage ? 'w-6 bg-blue-500' : 'bg-gray-600 hover:bg-gray-500'}`;
        button.onclick = () => goToVideoPage(i);
        indicatorsContainer.appendChild(button);
    }
}

function goToVideoPage(page) {
    currentPage = page;
    currentIndex = page * (itemsPerPage - 1);
    updateCarousel();
    updatePageIndicators();
}

function smoothUpdateCarousel() {
    const carousel = document.getElementById('videoCarousel');
    if (!carousel) return;
    
    const cards = carousel.querySelectorAll('.video-card');
    
    cards.forEach((card, index) => {
        card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        card.style.opacity = '0';
        card.style.transform = `translateX(${index < 2 ? '-20px' : '20px'}) scale(0.95)`;
    });
    
    setTimeout(() => {
        updateCarouselContent();
        
        const newCards = carousel.querySelectorAll('.video-card');
        newCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = `translateX(${index < 2 ? '-20px' : '20px'}) scale(0.95)`;
            
            setTimeout(() => {
                card.style.opacity = index === 3 ? '0.7' : '1';
                card.style.transform = 'translateX(0) scale(1)';
            }, index * 50);
        });
    }, 400);
}

function updateCarouselContent() {
    const carousel = document.getElementById('videoCarousel');
    if (!carousel) return;
    
    carousel.innerHTML = '';
    
    for (let i = 0; i < itemsPerPage; i++) {
        const videoIndex = getVideoIndex(currentIndex + i);
        const video = videos[videoIndex];
        const videoElement = document.createElement('div');
        const isPartial = i === 3;
        
        videoElement.className = `video-card flex-none ${isPartial ? 'w-1/4' : 'w-1/3'} px-2 opacity-0`;
        videoElement.innerHTML = `
            <div class="relative rounded-xl overflow-hidden bg-gray-900 h-full cursor-pointer group transform transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl" data-video-id="${video.id}">
                <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative overflow-hidden">
                    <img 
                        src="https://img.youtube.com/vi/${video.id}/hqdefault.jpg" 
                        alt="${video.title}"
                        class="w-full h-40 object-cover transform transition-transform duration-700 group-hover:scale-110"
                        loading="lazy"
                        onerror="this.src='{{ asset('images/placeholder-video.jpg') }}'"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center transform transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4 transform transition-transform duration-500 group-hover:-translate-y-1">
                    <h4 class="text-white text-sm font-semibold line-clamp-2">${video.title}</h4>
                    <div class="flex items-center mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <span class="text-xs text-gray-300">Нажмите для просмотра</span>
                        <svg class="w-3 h-3 ml-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </div>
                ${isPartial ? '<div class="absolute inset-0 bg-gradient-to-r from-transparent via-gray-900/50 to-gray-900"></div>' : ''}
            </div>
        `;
        
        videoElement.addEventListener('click', () => openVideo(video.id));
        carousel.appendChild(videoElement);
    }
}

function updateCarousel() {
    if (isAnimating || videos.length === 0) return;
    
    isAnimating = true;
    showLoadingAnimation();
    
    smoothUpdateCarousel();
    
    currentPage = Math.floor(currentIndex / (itemsPerPage - 1));
    updatePageIndicators();
    
    if (animationTimeout) clearTimeout(animationTimeout);
    animationTimeout = setTimeout(() => {
        isAnimating = false;
    }, 800);
}

function prevVideo() {
    if (videos.length === 0) return;
    currentIndex = getVideoIndex(currentIndex - 1);
    updateCarousel();
}

function nextVideo() {
    if (videos.length === 0) return;
    currentIndex = getVideoIndex(currentIndex + 1);
    updateCarousel();
}

function openVideo(videoId) {
    const modal = document.getElementById('videoModal');
    const player = document.getElementById('videoPlayer');
    
    if (!modal || !player) return;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('flex');
        modal.style.opacity = '1';
        const modalContent = modal.querySelector('.relative');
        if (modalContent) {
            modalContent.style.transform = 'scale(1)';
        }
    }, 10);
    
    player.innerHTML = `
        <iframe 
            src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&modestbranding=1&playsinline=1" 
            class="absolute top-0 left-0 w-full h-full rounded-xl"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            title="YouTube video player">
        </iframe>
    `;
    
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const player = document.getElementById('videoPlayer');
    
    if (!modal || !player) return;
    
    modal.style.opacity = '0';
    const modalContent = modal.querySelector('.relative');
    if (modalContent) {
        modalContent.style.transform = 'scale(0.95)';
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        player.innerHTML = '';
        document.body.style.overflow = '';
    }, 300);
}

function toggleFullscreen() {
    const container = document.getElementById('tourContainer');
    if (!container) return;
    
    if (!document.fullscreenElement) {
        container.requestFullscreen?.() || 
        container.webkitRequestFullscreen?.() || 
        container.msRequestFullscreen?.();
    } else {
        document.exitFullscreen?.() || 
        document.webkitExitFullscreen?.() || 
        document.msExitFullscreen?.();
    }
}

function handleFullscreenChange() {
    const container = document.getElementById('tourContainer');
    if (!container) return;
    
    const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement;
    
    if (isFullscreen) {
        container.style.paddingBottom = '0';
        container.style.height = '100vh';
    } else {
        container.style.paddingBottom = '40%';
        container.style.height = '';
    }
}

function startAutoCarousel() {
    if (!videoSettings.autoplayEnabled || videos.length <= itemsPerPage) return;
    
    setInterval(() => {
        if (!isAnimating && !document.querySelector('#videoModal.flex')) {
            currentIndex = getVideoIndex(currentIndex + 1);
            updateCarousel();
        }
    }, parseInt(videoSettings.autoplayInterval));
}

document.addEventListener('DOMContentLoaded', () => {
    initVideoCarousel();
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeVideoModal();
        if (e.key === 'ArrowLeft') prevVideo();
        if (e.key === 'ArrowRight') nextVideo();
    });
    
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    
    setTimeout(() => {
        const videoCards = document.querySelectorAll('.video-card');
        videoCards.forEach((card, index) => {
            card.style.opacity = index === 3 ? '0.7' : '1';
            card.style.transform = 'translateX(0) scale(1)';
        });
    }, 100);
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.w-1\/3 {
    width: 33.333333%;
}

.w-1\/4 {
    width: 25%;
}

#videoCarousel {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.video-card {
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.video-card:hover {
    z-index: 10;
}

#videoModal {
    backdrop-filter: blur(10px);
}

#videoCarouselContainer {
    scroll-behavior: smooth;
}

.video-card:nth-child(2) {
    position: relative;
}

.video-card:nth-child(2)::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 3px;
    background: #3b82f6;
    border-radius: 2px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-card:nth-child(2):hover::after {
    opacity: 1;
}

.indicator-dot {
    transition: all 0.3s ease;
}

.indicator-dot:hover {
    transform: scale(1.2);
}

.flex.items-center.justify-center {
    gap: 0.75rem;
}

.mr-3 {
    margin-right: 0.75rem;
}

.ml-3 {
    margin-left: 0.75rem;
}

@media (max-width: 768px) {
    .w-1\/3 {
        width: 50%;
    }
    
    .w-1\/4 {
        width: 33.333%;
    }
    
    .flex.items-center.justify-center {
        gap: 0.5rem;
    }
    
    .mr-3 {
        margin-right: 0.5rem;
    }
    
    .ml-3 {
        margin-left: 0.5rem;
    }
}

@media (max-width: 640px) {
    .w-1\/3 {
        width: 100%;
    }
    
    .w-1\/4 {
        width: 50%;
    }
    
    .flex.items-center.justify-center {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>