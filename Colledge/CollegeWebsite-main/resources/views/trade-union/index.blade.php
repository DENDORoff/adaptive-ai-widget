@extends('layouts.app')

@section('title', 'Профсоюз')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            {{-- Секция HERO --}}
            <div class="text-center mb-16" data-animate>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ \App\Models\PageSection::getValue('trade-union', 'hero', 'main_title_1', 'Профсоюзная') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500">
                        {{ \App\Models\PageSection::getValue('trade-union', 'hero', 'main_title_2', 'организация') }}
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-6" data-animate data-delay="100"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto" data-animate data-delay="200">
                    {{ \App\Models\PageSection::getValue('trade-union', 'hero', 'subtitle', 'Защита прав и интересов сотрудников колледжа, развитие социального партнерства') }}
                </p>
            </div>

            {{-- Секция ABOUT --}}
            <div class="mb-12" data-animate data-delay="300">
                <div class="bg-gradient-to-r from-blue-900/30 via-blue-800/30 to-cyan-900/30 rounded-2xl p-8 mb-12 border border-blue-500/20">
                    <h2 class="text-2xl font-bold text-white mb-6">
                        {{ \App\Models\PageSection::getValue('trade-union', 'about', 'title', 'О профсоюзной организации') }}
                    </h2>
                    <p class="text-gray-300 mb-4">
                        {{ \App\Models\PageSection::getValue('trade-union', 'about', 'description_1', 'Профсоюзная организация колледжа является добровольным общественным объединением работников, созданным для представительства и защиты их социально-трудовых прав и интересов.') }}
                    </p>
                    <p class="text-gray-300">
                        {{ \App\Models\PageSection::getValue('trade-union', 'about', 'description_2', 'Основные задачи профсоюза включают ведение коллективных переговоров, заключение коллективных договоров, контроль за соблюдением трудового законодательства, участие в урегулировании коллективных трудовых споров.') }}
                    </p>
                </div>
            </div>

            {{-- Секция ACTIVITIES --}}
            <div class="mb-16" data-animate data-delay="400">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('trade-union', 'activities', 'section_title', 'Деятельность') }}
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto"></div>
                    <p class="text-gray-400 mt-4">
                        {{ \App\Models\PageSection::getValue('trade-union', 'activities', 'section_subtitle', 'Основные направления работы профсоюзной организации') }}
                    </p>
                </div>

                <div class="activity-grid-minimal">
                    {{-- Динамическая генерация элементов деятельности --}}
                    @for($i = 1; $i <= 8; $i++)
                        @php
                            $title = \App\Models\PageSection::getValue('trade-union', 'activities', "item_{$i}_title");
                            $icon = \App\Models\PageSection::getValue('trade-union', 'activities', "item_{$i}_icon", 'fas fa-circle');
                            $route = \App\Models\PageSection::getValue('trade-union', 'activities', "item_{$i}_route", '#');
                            $isExternal = \App\Models\PageSection::getValue('trade-union', 'activities', "item_{$i}_is_external", '0') == '1';
                        @endphp
                        
                        @if($title && $route)
                            @if($isExternal)
                                <a href="{{ $route }}" target="_blank" class="activity-item-minimal" data-animate data-delay="{{ 400 + (($i-1) * 50) }}">
                                    <div class="activity-icon-minimal">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    <h3 class="activity-title-minimal">{{ $title }}</h3>
                                </a>
                            @else
                                @if(Route::has($route))
                                    <a href="{{ route($route) }}" class="activity-item-minimal" data-animate data-delay="{{ 400 + (($i-1) * 50) }}">
                                        <div class="activity-icon-minimal">
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                        <h3 class="activity-title-minimal">{{ $title }}</h3>
                                    </a>
                                @else
                                    <a href="#" class="activity-item-minimal" data-animate data-delay="{{ 400 + (($i-1) * 50) }}">
                                        <div class="activity-icon-minimal">
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                        <h3 class="activity-title-minimal">{{ $title }}</h3>
                                    </a>
                                @endif
                            @endif
                        @endif
                    @endfor
                </div>
            </div>

            {{-- Секция JOIN_INFO --}}
            <div class="mb-12" data-animate data-delay="800">
                <div class="bg-gradient-to-r from-blue-900/20 to-cyan-900/20 rounded-2xl p-6 border border-blue-500/10">
                    <div class="flex items-center">
                        <div class="mr-6">
                            <div class="info-icon-large">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">
                                {{ \App\Models\PageSection::getValue('trade-union', 'join_info', 'title', 'Как вступить в профсоюз?') }}
                            </h3>
                            <p class="text-gray-300">
                                {{ \App\Models\PageSection::getValue('trade-union', 'join_info', 'description', 'Для вступления в профсоюзную организацию необходимо подать заявление в профсоюзный комитет. Членство в профсоюзе дает право на юридическую защиту, социальную поддержку и участие в коллективных переговорах. Обращайтесь в кабинет 205 (главный корпус).') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    {{-- Стили остаются без изменений --}}
    .activity-grid-minimal {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px 32px;
        margin: 0 auto;
        max-width: 1200px;
    }

    .activity-item-minimal {
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 10px;
        transition: all 0.3s ease;
        border-radius: 8px;
        background: transparent;
        border: none;
    }

    .activity-item-minimal:hover {
        background: rgba(59, 130, 246, 0.05);
        transform: translateY(-3px);
    }

    .activity-icon-minimal {
        color: #60a5fa;
        margin-bottom: 16px;
        transition: all 0.3s ease;
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .activity-item-minimal:hover .activity-icon-minimal {
        color: #93c5fd;
        transform: scale(1.1);
    }

    .activity-title-minimal {
        font-size: 16px;
        font-weight: 500;
        color: white;
        line-height: 1.4;
        transition: color 0.3s ease;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .activity-item-minimal:hover .activity-title-minimal {
        color: #93c5fd;
    }

    .info-icon-large {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(59, 130, 246, 0.1);
        width: 64px;
        height: 64px;
        border-radius: 12px;
        border: 1px solid rgba(59, 130, 246, 0.2);
        font-size: 2rem;
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

    @media (max-width: 1200px) {
        .activity-grid-minimal {
            grid-template-columns: repeat(3, 1fr);
            gap: 32px 24px;
        }
    }

    @media (max-width: 900px) {
        .activity-grid-minimal {
            grid-template-columns: repeat(2, 1fr);
            gap: 32px 20px;
        }
        
        .activity-title-minimal {
            font-size: 15px;
        }
        
        .activity-icon-minimal {
            width: 56px;
            height: 56px;
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .activity-grid-minimal {
            grid-template-columns: 1fr;
            gap: 24px;
            max-width: 400px;
        }
        
        .activity-item-minimal {
            padding: 16px;
        }
        
        .activity-title-minimal {
            font-size: 16px;
            max-width: 280px;
        }
    }

    @media (max-width: 480px) {
        .activity-grid-minimal {
            gap: 20px;
        }
        
        .activity-item-minimal {
            padding: 14px 8px;
        }
        
        .activity-title-minimal {
            font-size: 15px;
        }
        
        .activity-icon-minimal {
            width: 52px;
            height: 52px;
            font-size: 2rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
@endsection