@extends('layouts.app')

@section('title', $newsItem->title)

@section('content')
<section class="py-12 bg-gradient-to-br from-gray-900 via-blue-900 to-blue-800 text-white">
    <div class="container px-4 max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-8 uppercase tracking-wide">
                {{ $newsItem->title }}
            </h1>
            <div class="h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent max-w-2xl mx-auto"></div>
        </div>

        <div class="mb-16">
            <article class="prose prose-invert prose-lg max-w-none">
                <div class="text-gray-300 leading-relaxed text-left space-y-6">
                    {!! $newsItem->content !!}
                </div>
            </article>
        </div>
    </div>
</section>

@if($newsItem->gallery && count($newsItem->gallery) > 0)
    <section class="py-12 bg-gray-900">
        <div class="container px-4 max-w-6xl mx-auto">
            @if(count($newsItem->gallery) == 1)
                <div class="relative">
                    <div class="relative group cursor-pointer max-w-2xl mx-auto" onclick="openImage(0)">
                        <div class="aspect-square bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                            <img src="{{ asset('uploads/' . $newsItem->gallery[0]) }}" 
                                 alt="{{ $newsItem->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=800&fit=crop'">
                        </div>
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/30 rounded-xl">
                            <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="relative" id="simpleCarousel">
                    <div class="flex items-center">
                        @if(count($newsItem->gallery) > 3)
                            <button onclick="previousImage()" 
                                    class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors mr-4 flex-shrink-0 z-10"
                                    title="Предыдущее фото">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                        @endif

                        <div class="flex-1 overflow-hidden">
                            <div class="flex gap-4 transition-transform duration-500 ease-in-out" 
                                 id="carouselContainer">
                                @foreach($newsItem->gallery as $index => $image)
                                    <div class="flex-shrink-0 w-1/3 px-2">
                                        <div class="relative group cursor-pointer" onclick="openImage({{ $index }})">
                                            <div class="aspect-square bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                                                <img src="{{ asset('uploads/' . $image) }}" 
                                                     alt="Фото {{ $index + 1 }} новости"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                     onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=400&fit=crop'">
                                            </div>
                                            
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/30 rounded-lg">
                                                <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if(count($newsItem->gallery) > 3)
                            <button onclick="nextImage()" 
                                    class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors ml-4 flex-shrink-0 z-10"
                                    title="Следующее фото">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @endif
                    </div>

                    @if(count($newsItem->gallery) > 3)
                        <div class="flex justify-center items-center gap-2 mt-8" id="indicatorsContainer">
                            @php
                                $totalPages = ceil(count($newsItem->gallery) / 3);
                            @endphp
                            @for($i = 0; $i < $totalPages; $i++)
                                <button onclick="selectPage({{ $i }})" 
                                        class="w-3 h-3 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-blue-500 scale-125' : 'bg-gray-700 hover:bg-gray-500' }}"
                                        title="Страница {{ $i + 1 }}">
                                </button>
                            @endfor
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@elseif($newsItem->image)
    <section class="py-12 bg-gray-900">
        <div class="container px-4 max-w-6xl mx-auto">
            <div class="relative">
                <div class="relative group cursor-pointer max-w-2xl mx-auto" onclick="openSingleImage()">
                    <div class="aspect-square bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                        @php
                            $imageUrl = null;
                            if (file_exists(public_path('uploads/' . $newsItem->image))) {
                                $imageUrl = asset('uploads/' . $newsItem->image);
                            } elseif (file_exists(storage_path('app/public/' . $newsItem->image))) {
                                $imageUrl = asset('storage/' . $newsItem->image);
                            }
                        @endphp
                        <img src="{{ $imageUrl ?: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=800&fit=crop' }}" 
                             alt="{{ $newsItem->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/30 rounded-xl">
                        <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeModalOnBackground(event)">
    <div class="relative w-full max-w-4xl max-h-[90vh]" onclick="event.stopPropagation()">
        <button onclick="closeModal()" 
                class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors z-10"
                title="Закрыть">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="relative">
            <div class="w-full h-full flex items-center justify-center">
                <img id="modalImage" 
                     src="" 
                     alt="Увеличенное фото"
                     class="max-w-full max-h-[80vh] object-contain rounded-lg">
            </div>

            @if(($newsItem->gallery && count($newsItem->gallery) > 1) || $newsItem->image)
                <button onclick="previousImageModal()" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors"
                        title="Предыдущее фото">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="nextImageModal()" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors"
                        title="Следующее фото">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 bg-black/70 backdrop-blur-sm rounded-full text-white text-sm">
                    <span id="modalImageCounter">1</span> 
                    @if($newsItem->gallery)
                        / {{ count($newsItem->gallery) }}
                    @else
                        / 1
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
const gallery = @json($newsItem->gallery ?? []);
const singleImage = @json($newsItem->image ?? null);
let currentPage = 0;
let currentModalIndex = 0;
const itemsPerPage = 3;
const totalPages = Math.ceil(gallery.length / itemsPerPage);

function updateCarousel() {
    const container = document.getElementById('carouselContainer');
    const indicators = document.querySelectorAll('[onclick^="selectPage"]');
    
    if (container) {
        const translateX = `-${currentPage * 100}%`;
        container.style.transform = `translateX(${translateX})`;
    }
    
    indicators.forEach((indicator, index) => {
        if (index === currentPage) {
            indicator.classList.add('bg-blue-500', 'scale-125');
            indicator.classList.remove('bg-gray-700', 'hover:bg-gray-500');
        } else {
            indicator.classList.remove('bg-blue-500', 'scale-125');
            indicator.classList.add('bg-gray-700', 'hover:bg-gray-500');
        }
    });
}

function nextImage() {
    if (gallery.length > itemsPerPage) {
        currentPage = (currentPage + 1) % totalPages;
        updateCarousel();
    }
}

function previousImage() {
    if (gallery.length > itemsPerPage) {
        currentPage = (currentPage - 1 + totalPages) % totalPages;
        updateCarousel();
    }
}

function selectPage(page) {
    if (gallery.length > itemsPerPage) {
        currentPage = page;
        updateCarousel();
    }
}

let currentModalImage = 0;
let isSingleImageMode = false;

function openImage(index) {
    currentModalImage = index;
    isSingleImageMode = false;
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const counter = document.getElementById('modalImageCounter');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    modalImage.src = '{{ asset("uploads") }}/' + gallery[index];
    modalImage.onload = function() {
        adjustModalImageSize(this);
    };
    
    if (counter) {
        counter.textContent = index + 1;
    }
}

function openSingleImage() {
    currentModalImage = 0;
    isSingleImageMode = true;
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const counter = document.getElementById('modalImageCounter');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    @if($newsItem->image)
        @php
            $imageUrl = null;
            if (file_exists(public_path('uploads/' . $newsItem->image))) {
                $imageUrl = asset('uploads/' . $newsItem->image);
            } elseif (file_exists(storage_path('app/public/' . $newsItem->image))) {
                $imageUrl = asset('storage/' . $newsItem->image);
            }
        @endphp
        modalImage.src = '{{ $imageUrl ?: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=800&fit=crop' }}';
        modalImage.onload = function() {
            adjustModalImageSize(this);
        };
    @endif
    
    if (counter) {
        counter.textContent = '1 / 1';
    }
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function closeModalOnBackground(event) {
    if (event.target === document.getElementById('imageModal')) {
        closeModal();
    }
}

function nextImageModal() {
    if (isSingleImageMode) return;
    
    if (gallery.length > 1) {
        currentModalImage = (currentModalImage + 1) % gallery.length;
        updateModal();
    }
}

function previousImageModal() {
    if (isSingleImageMode) return;
    
    if (gallery.length > 1) {
        currentModalImage = (currentModalImage - 1 + gallery.length) % gallery.length;
        updateModal();
    }
}

function updateModal() {
    const modalImage = document.getElementById('modalImage');
    const counter = document.getElementById('modalImageCounter');
    
    modalImage.style.opacity = '0';
    setTimeout(() => {
        modalImage.src = '{{ asset("uploads") }}/' + gallery[currentModalImage];
        modalImage.onload = function() {
            adjustModalImageSize(this);
            modalImage.style.opacity = '1';
        };
    }, 150);
    
    if (counter) {
        counter.textContent = currentModalImage + 1;
    }
}

function adjustModalImageSize(img) {
    const maxWidth = window.innerWidth * 0.9;
    const maxHeight = window.innerHeight * 0.9;
    
    const widthRatio = maxWidth / img.naturalWidth;
    const heightRatio = maxHeight / img.naturalHeight;
    
    const scale = Math.min(widthRatio, heightRatio, 1);
    
    img.style.width = (img.naturalWidth * scale) + 'px';
    img.style.height = (img.naturalHeight * scale) + 'px';
}

window.addEventListener('resize', function() {
    const modalImage = document.getElementById('modalImage');
    if (modalImage.src) {
        adjustModalImageSize(modalImage);
    }
});

let touchStartX = 0;
let touchEndX = 0;

const carouselElement = document.getElementById('simpleCarousel');
if (carouselElement) {
    carouselElement.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    carouselElement.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
}

function handleSwipe() {
    if (gallery.length > itemsPerPage) {
        if (touchEndX < touchStartX - 50) nextImage();
        if (touchEndX > touchStartX + 50) previousImage();
    }
}

document.addEventListener('keydown', (e) => {
    const modal = document.getElementById('imageModal');
    if (!modal.classList.contains('hidden')) {
        if (e.key === 'ArrowLeft' && !isSingleImageMode) previousImageModal();
        if (e.key === 'ArrowRight' && !isSingleImageMode) nextImageModal();
        if (e.key === 'Escape') closeModal();
    }
});

let autoSlideInterval;
function startAutoSlide() {
    if (gallery.length > itemsPerPage) {
        autoSlideInterval = setInterval(nextImage, 5000);
    }
}

function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}

if (gallery.length > itemsPerPage) {
    startAutoSlide();
    
    const carousel = document.getElementById('simpleCarousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);
    }
}
</script>

<style>
.prose {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    line-height: 1.7;
}

.prose-invert {
    color: #d1d5db;
}

.prose-lg p {
    font-size: 1.125rem;
    margin-bottom: 1.5em;
}

#carouselContainer {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

#carouselContainer > div {
    flex: 0 0 33.333333%;
    width: 33.333333%;
}

.aspect-square {
    aspect-ratio: 1 / 1;
}

#modalImage {
    transition: opacity 0.3s ease;
}

@media (max-width: 768px) {
    #carouselContainer > div {
        flex: 0 0 100%;
        width: 100%;
    }
    
    .prose-lg p {
        font-size: 1rem;
    }
}
</style>
@endsection