@extends('layouts.app')

@section('title', 'Телефонный справочник')

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
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-500 to-blue-600">
                        {{ \App\Models\PageSection::getValue('phonebook', 'hero', 'main_title_part1', 'Телефонный') }}
                    </span>
                    <span class="text-white">
                        {{ \App\Models\PageSection::getValue('phonebook', 'hero', 'main_title_part2', 'справочник') }}
                    </span>
                </h1>
            </div>

            {{-- DEPARTMENTS SECTION --}}
            <div class="contact-main-card" data-animate="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 6; $i++)
                        @php
                            $name = \App\Models\PageSection::getValue('phonebook', 'departments', "department_{$i}_name");
                            $phone = \App\Models\PageSection::getValue('phonebook', 'departments', "department_{$i}_phone");
                            $iconPath = \App\Models\PageSection::getValue('phonebook', 'departments', "department_{$i}_icon_path");
                        @endphp
                        
                        @if($name && $phone)
                            <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl border border-gray-600/30 hover:border-blue-500/50 transition-all duration-300 group hover:scale-105 min-h-[90px]">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center group-hover:bg-blue-600/30 transition-colors flex-shrink-0">
                                        @if($iconPath)
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                                            </svg>
                                        @else
                                            {{-- Fallback иконка телефона --}}
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-gray-300 font-medium text-sm whitespace-nowrap truncate">{{ $name }}</div>
                                    </div>
                                </div>
                                <div class="ml-auto pl-3 flex-shrink-0">
                                    <div class="text-white font-bold text-base whitespace-nowrap">{{ $phone }}</div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-main-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1.5rem;
    padding: 2rem;
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

[data-animate] {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

[data-animate].animated {
    opacity: 1;
    transform: translateY(0);
}

.min-h-\[90px\] {
    min-height: 90px;
}
</style>

<script>
function initAnimations() {
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-animate]');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight * 0.85) {
                element.classList.add('animated');
            }
        });
    };

    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
}

document.addEventListener('DOMContentLoaded', function() {
    initAnimations();
});
</script>

@endsection