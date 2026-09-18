@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('home', 'hero', 'main_title', __('Home')))

@section('content')

<section class="relative h-[550px] flex items-center justify-center hero-section">
    <div class="absolute inset-0 z-0">
        <div x-data="carousel()" x-init="init()" @keydown.left="prevSlide()" @keydown.right="nextSlide()" class="relative w-full h-full">
            <div class="relative w-full h-full">
                @for($i = 1; $i <= 4; $i++)
                    @php
                        $image = \App\Models\PageSection::getValue('home', 'hero', "carousel_image_{$i}");
                        $alt = \App\Models\PageSection::getValue('home', 'hero', "carousel_alt_{$i}");
                    @endphp
                    
                    @if($image)
                    <div 
                        x-show="activeIndex === {{ $i - 1 }}" 
                        x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-1000"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 w-full h-full"
                    >
                        <img 
                            src="{{ asset($image) }}" 
                            alt="{{ $alt }}" 
                            class="w-full h-full object-cover"
                            loading="lazy"
                            onerror="this.src='{{ asset('images/placeholder.jpg') }}'"
                        >
                    </div>
                    @endif
                @endfor
            </div>
            
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
                @for($i = 1; $i <= 4; $i++)
                    @if(\App\Models\PageSection::getValue('home', 'hero', "carousel_image_{$i}"))
                    <button 
                        @click="goToSlide({{ $i - 1 }})"
                        class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent"
                        :class="{
                            'bg-white w-8': activeIndex === {{ $i - 1 }},
                            'bg-white/50 hover:bg-white/75': activeIndex !== {{ $i - 1 }}
                        }"
                        :aria-label="`Go to slide {{ $i }}`"
                        type="button"
                    ></button>
                    @endif
                @endfor
            </div>
            
            <button 
                @click="prevSlide()"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 z-10"
                aria-label="Previous slide"
                type="button"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <button 
                @click="nextSlide()"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 z-10"
                aria-label="Next slide"
                type="button"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        
        <div class="absolute inset-0 gradient-overlay"></div>
    </div>

    <div class="container relative z-10 text-center px-4">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">
                {{ \App\Models\PageSection::getValue('home', 'hero', 'main_title', __('Higher College of Electronics and Communications')) }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 animate-fade-in" style="animation-delay: 0.2s;">
                {{ \App\Models\PageSection::getValue('home', 'hero', 'main_description', __('Мы открываем двери для будущих специалистов в области железнодорожного транспорта, телекоммуникаций и информационных технологий')) }}
            </p>
            
            <div class="flex flex-col items-center gap-6 animate-fade-in" style="animation-delay: 0.4s;">
                
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto justify-center relative" style="z-index: 1000;">
                    <a href="{{ \App\Models\PageSection::getValue('home', 'hero', 'button_1_link', '#virtual-tour') }}" 
                       class="btn btn-primary w-full sm:w-auto flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('home', 'hero', 'button_1_text', __('Virtual Tour')) }}</span>
                    </a>
                    <a href="{{ \App\Models\PageSection::getValue('home', 'hero', 'button_2_link', 'https://college.smartnation.kz/ru/mng/login') }}" 
                       class="btn btn-secondary w-full sm:w-auto flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \App\Models\PageSection::getValue('home', 'hero', 'button_2_text', 'Личный кабинет студента') }}</span>
                    </a>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open"
                            class="btn btn-primary w-full sm:w-auto flex items-center justify-center gap-2 relative z-50"
                            type="button"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>{{ \App\Models\PageSection::getValue('home', 'hero', 'button_3_text', 'Полезные ссылки') }}</span>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div 
                            x-show="open" 
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="absolute left-0 sm:left-auto sm:right-0 top-full mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-[10000] py-2"
                            style="display: none;"
                            x-cloak
                        >
                            @for($i = 1; $i <= 4; $i++)
                                @php
                                    $title = \App\Models\PageSection::getValue('home', 'useful_links', "link_{$i}_title");
                                    $url = \App\Models\PageSection::getValue('home', 'useful_links', "link_{$i}_url");
                                    $icon = \App\Models\PageSection::getValue('home', 'useful_links', "link_{$i}_icon");
                                @endphp
                                
                                @if($title && $url)
                                    <a 
                                        href="{{ $url }}" 
                                        target="_blank"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ $i < 4 ? 'border-b border-gray-100' : '' }}"
                                    >
                                        @if($icon)
                                            <img src="{{ $icon }}" 
                                                 alt="Icon" 
                                                 class="w-4 h-4 mr-3 flex-shrink-0"
                                                 onerror="this.style.display='none'">
                                        @endif
                                        <svg class="w-4 h-4 mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <span class="flex-1 min-w-0">{{ $title }}</span>
                                    </a>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="flex justify-center w-full mt-4 relative">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl w-full">
                        @for($i = 1; $i <= 4; $i++)
                            @php
                                $value = \App\Models\PageSection::getValue('home', 'stats', "stat_{$i}_value");
                                $label = \App\Models\PageSection::getValue('home', 'stats', "stat_{$i}_label");
                                $suffix = \App\Models\PageSection::getValue('home', 'stats', "stat_{$i}_suffix", '');
                            @endphp
                            
                            @if($value && $label)
                                <div x-data="counter({ target: {{ $value }}, duration: 2000, delay: {{ ($i - 1) * 200 + 100 }}, suffix: '{{ $suffix }}' })" 
                                     x-intersect.once="startCounting()"
                                     x-intersect:leave="resetCounter()"
                                     x-intersect:enter="restartCounting()"
                                     class="hero-card group">
                                    <div class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600 mb-2">
                                        <span x-text="Math.floor(currentValue)"></span><span x-text="suffix"></span>
                                    </div>
                                    <div class="text-gray-400 text-xs uppercase tracking-wider">{{ $label }}</div>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.news-section')
@include('partials.virtual-tour')
@include('partials.faq-section')

@endsection

@push('styles')
<style>
    .gradient-overlay {
        background: linear-gradient(
            135deg,
            rgba(0, 0, 0, 0.6) 0%,
            rgba(0, 0, 0, 0.4) 50%,
            rgba(0, 0, 0, 0.6) 100%
        );
        pointer-events: none;
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
        opacity: 0;
    }
    
    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        line-height: 1.25rem;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        cursor: pointer;
        position: relative;
        white-space: normal;
    }
    
    .btn span {
        flex: 0 1 auto;
    }
    
    .btn-primary {
        background-color: #2563eb;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    
    .btn-secondary {
        background-color: #374151;
        color: white;
    }
    
    .btn-secondary:hover {
        background-color: #4b5563;
    }
    
    .hero-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        padding: 1.5rem 1rem;
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-width: 0;
    }
    
    .hero-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-4px);
    }

    [x-cloak] {
        display: none !important;
    }

    .z-\[10000\] {
        z-index: 10000 !important;
    }

    @media (max-width: 768px) {
        section.relative {
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;
            overflow: visible !important;
            padding-top: 1.5rem !important;
            padding-bottom: 3rem !important;
            flex-wrap: wrap !important;
        }
        
        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        
        h1.text-4xl {
            font-size: 1.75rem !important;
            line-height: 2.25rem !important;
            margin-bottom: 1rem !important;
        }
        
        p.text-xl {
            font-size: 0.9375rem !important;
            line-height: 1.375rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .btn {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.65rem !important;
            height: 32px !important;
            min-height: 32px !important;
            max-height: 32px !important;
            line-height: 1.2 !important;
            gap: 0.2rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            max-width: 100% !important;
            flex: 1 !important;
        }
        
        .btn svg {
            width: 12px !important;
            height: 12px !important;
            flex-shrink: 0 !important;
        }
        
        .btn span {
            flex: 1 1 auto !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }
        
        .flex.flex-col.sm\:flex-row {
            width: 100% !important;
            padding: 0 0.5rem !important;
            gap: 0.75rem !important;
        }
        
        .grid.grid-cols-2 {
            gap: 0.75rem !important;
            padding: 0 0.5rem !important;
            margin-top: 2rem !important;
        }
        
        .hero-card {
            padding: 1rem 0.75rem !important;
            min-height: 90px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function carousel() {
        return {
            activeIndex: 0,
            interval: null,
            intervalTime: 5000,
            imageCount: {{ count(array_filter([1,2,3,4], function($i) { 
                return \App\Models\PageSection::getValue('home', 'hero', "carousel_image_{$i}"); 
            })) }},
            
            init() {
                if (this.imageCount > 0) {
                    this.startAutoSlide();
                    this.$el.addEventListener('mouseenter', () => this.stopAutoSlide());
                    this.$el.addEventListener('mouseleave', () => this.startAutoSlide());
                }
            },
            
            startAutoSlide() {
                this.stopAutoSlide();
                if (this.imageCount > 0) {
                    this.interval = setInterval(() => {
                        this.nextSlide();
                    }, this.intervalTime);
                }
            },
            
            stopAutoSlide() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },
            
            nextSlide() {
                this.activeIndex = (this.activeIndex + 1) % this.imageCount;
            },
            
            prevSlide() {
                this.activeIndex = (this.activeIndex - 1 + this.imageCount) % this.imageCount;
            },
            
            goToSlide(index) {
                this.activeIndex = index;
                this.startAutoSlide();
            }
        };
    }

    function counter(config) {
        return {
            currentValue: 0,
            animationFrame: null,
            hasAnimated: false,
            target: config.target || 100,
            duration: config.duration || 2000,
            delay: config.delay || 0,
            suffix: config.suffix || '',
            startTime: null,
            
            init() {
                this.currentValue = 0;
            },
            
            startCounting() {
                if (this.hasAnimated) return;
                
                setTimeout(() => {
                    this.hasAnimated = true;
                    this.startTime = null;
                    const animate = (currentTime) => {
                        if (!this.startTime) this.startTime = currentTime;
                        const elapsed = currentTime - this.startTime;
                        const progress = Math.min(elapsed / this.duration, 1);
                        
                        this.currentValue = progress * this.target;
                        
                        if (progress < 1) {
                            this.animationFrame = requestAnimationFrame(animate);
                        } else {
                            this.currentValue = this.target;
                        }
                    };
                    
                    this.animationFrame = requestAnimationFrame(animate);
                }, this.delay);
            },
            
            resetCounter() {
                if (this.animationFrame) {
                    cancelAnimationFrame(this.animationFrame);
                    this.animationFrame = null;
                }
                this.currentValue = 0;
                this.hasAnimated = false;
                this.startTime = null;
            },
            
            restartCounting() {
                this.resetCounter();
                this.startCounting();
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const logos = document.querySelectorAll('img[onerror]');
        logos.forEach(logo => {
            logo.addEventListener('error', function() {
                this.style.display = 'none';
                const fallbackIcon = this.nextElementSibling;
                if (fallbackIcon && fallbackIcon.tagName === 'svg') {
                    fallbackIcon.style.display = 'block';
                }
            });
            logo.addEventListener('load', function() {
                const fallbackIcon = this.nextElementSibling;
                if (fallbackIcon && fallbackIcon.tagName === 'svg') {
                    fallbackIcon.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush