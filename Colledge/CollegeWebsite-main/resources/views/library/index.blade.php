@extends('layouts.app')

@section('title', 'Библиотека колледжа')

@section('content')

<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-black" style="min-height: 80vh;">
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(0deg, #3b82f6 0px, transparent 1px, transparent 40px), repeating-linear-gradient(90deg, #3b82f6 0px, transparent 1px, transparent 40px);"></div>
    
    <div class="container mx-auto px-4 relative z-10 pt-32">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block mb-6 px-4 py-2 bg-blue-600/20 border border-blue-500/50 rounded-full">
                <span class="text-blue-400 text-sm font-semibold">
                    {{ \App\Models\PageSection::getValue('library', 'hero', 'badge_text', 'DIGITAL LIBRARY') }}
                </span>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                {{ \App\Models\PageSection::getValue('library', 'hero', 'main_title_part1', 'Библиотека') }}
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-500">
                    {{ \App\Models\PageSection::getValue('library', 'hero', 'main_title_part2', 'колледжа') }}
                </span>
            </h1>
            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                {{ \App\Models\PageSection::getValue('library', 'hero', 'description', 'Современное пространство для обучения, исследований и инноваций. Место, где знания встречаются с технологиями.') }}
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ \App\Models\PageSection::getValue('library', 'hero', 'button_1_link', '#virtual') }}" 
                   class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all transform hover:scale-105">
                    {{ \App\Models\PageSection::getValue('library', 'hero', 'button_1_text', 'Виртуальный тур') }}
                </a>
                <a href="{{ \App\Models\PageSection::getValue('library', 'hero', 'button_2_link', '#features') }}" 
                   class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg border border-white/20 transition-all">
                    {{ \App\Models\PageSection::getValue('library', 'hero', 'button_2_text', 'Узнать больше') }}
                </a>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<section id="features" class="py-20 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('library', 'key_features', 'section_title', 'Ключевые возможности') }}
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 max-w-7xl mx-auto">
            {{-- Главная карточка --}}
            <div class="lg:row-span-2 group relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 hover:border-blue-500 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/20">
                <div class="relative h-full min-h-[500px] overflow-hidden">
                    @php
                        $mainImage = \App\Models\PageSection::getValue('library', 'key_features', 'main_card_image', 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800');
                        $mainAlt = 'Читальный зал';
                    @endphp
                    <img src="{{ $mainImage }}" 
                         alt="{{ $mainAlt }}" 
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
                    
                    <div class="absolute top-0 right-0 w-32 h-32">
                        <div class="absolute top-4 right-4 w-20 h-20 border-t-2 border-r-2 border-blue-500 opacity-50"></div>
                    </div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-0.5 bg-blue-500"></div>
                            <span class="text-blue-400 text-sm font-semibold uppercase tracking-wider">
                                {{ \App\Models\PageSection::getValue('library', 'key_features', 'main_card_badge', 'Premium Space') }}
                            </span>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">
                            {{ \App\Models\PageSection::getValue('library', 'key_features', 'main_card_title', 'Читальный зал нового поколения') }}
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            {{ \App\Models\PageSection::getValue('library', 'key_features', 'main_card_description', 'Просторный зал на 150 мест, оборудованный современной мебелью, индивидуальными рабочими местами с розетками USB-C и беспроводной зарядкой. Система климат-контроля и звукоизоляция обеспечивают максимальный комфорт.') }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center gap-2 px-4 py-2 bg-blue-600/20 border border-blue-500/30 rounded-full">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-blue-400 font-semibold">
                                    {{ \App\Models\PageSection::getValue('library', 'key_features', 'main_card_stat_1_label', '150 мест') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-cyan-600/20 border border-cyan-500/30 rounded-full">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                </svg>
                                <span class="text-cyan-400 font-semibold">
                                    {{ \App\Models\PageSection::getValue('library', 'key_features', 'main_card_stat_2_label', 'Высокоскоростной Wi-Fi') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Карточки 2 и 3 --}}
            @for($i = 2; $i <= 3; $i++)
                @php
                    $cardImage = \App\Models\PageSection::getValue('library', 'key_features', "card_{$i}_image");
                    $cardBadge = \App\Models\PageSection::getValue('library', 'key_features', "card_{$i}_badge");
                    $cardTitle = \App\Models\PageSection::getValue('library', 'key_features', "card_{$i}_title");
                    $cardDescription = \App\Models\PageSection::getValue('library', 'key_features', "card_{$i}_description");
                    $cardStat = \App\Models\PageSection::getValue('library', 'key_features', "card_{$i}_stat");
                    
                    // Определяем цвет в зависимости от карточки
                    $color = ($i == 2) ? 'cyan' : 'blue';
                @endphp
                
                @if($cardTitle && $cardDescription)
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 hover:border-{{ $color }}-500 transition-all duration-500 hover:shadow-2xl hover:shadow-{{ $color }}-500/20">
                    <div class="relative h-full min-h-[240px] overflow-hidden">
                        <img src="{{ $cardImage }}" 
                             alt="{{ $cardTitle }}" 
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            @if($cardBadge)
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-0.5 bg-{{ $color }}-500"></div>
                                <span class="text-{{ $color }}-400 text-xs font-semibold uppercase tracking-wider">
                                    {{ $cardBadge }}
                                </span>
                            </div>
                            @endif
                            
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $cardTitle }}</h3>
                            <p class="text-gray-300 text-sm leading-relaxed mb-3">
                                {{ $cardDescription }}
                            </p>
                            
                            @if($cardStat)
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-{{ $color }}-600/20 border border-{{ $color }}-500/30 rounded-full w-fit">
                                <svg class="w-4 h-4 text-{{ $color }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($i == 2)
                                        {{-- Иконка для книги --}}
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    @else
                                        {{-- Иконка для здания --}}
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    @endif
                                </svg>
                                <span class="text-{{ $color }}-400 text-sm font-semibold">{{ $cardStat }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endfor
        </div>
    </div>
</section>

<section id="virtual" class="py-20 bg-gradient-to-b from-black via-gray-900 to-black relative">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
    
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('library', 'virtual_tour', 'section_title', 'Виртуальный тур 360°') }}
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-4"></div>
            <p class="text-gray-300 max-w-2xl mx-auto">
                {{ \App\Models\PageSection::getValue('library', 'virtual_tour', 'section_description', 'Совершите виртуальную прогулку по библиотеке не выходя из дома') }}
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-700" style="padding-top: 56.25%;">
                <iframe 
                    src="{{ \App\Models\PageSection::getValue('library', 'virtual_tour', 'iframe_src', 'https://www.google.com/maps/embed?pb=!4v1234567890!6m8!1m7!1sCAoSLEFGMVFpcE5rOXBxYzRCNVpfX0hfRVE4QlFwQkxVRV8!2m2!1d40.7127281!2d-74.0060152!3f0!4f0!5f0.7820865974627469') }}" 
                    class="absolute inset-0 w-full h-full"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- Стили для отзывов (если будут добавлены позже) --}}
<style>
.testimonials-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
    max-height: 600px;
    overflow: hidden;
    mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
}

.testimonials-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.testimonials-column[data-direction="up"] {
    animation: scrollUp 30s linear infinite;
}

.testimonials-column[data-direction="down"] {
    animation: scrollDown 35s linear infinite;
}

@keyframes scrollUp {
    0% { transform: translateY(0); }
    100% { transform: translateY(-50%); }
}

@keyframes scrollDown {
    0% { transform: translateY(-50%); }
    100% { transform: translateY(0); }
}

.testimonials-container:hover .testimonials-column {
    animation-play-state: paused;
}

.testimonial-card {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.testimonial-card:hover {
    border-color: rgba(59, 130, 246, 0.5);
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
}

@media (max-width: 1024px) {
    .testimonials-container {
        grid-template-columns: repeat(2, 1fr);
    }
    .testimonials-column:last-child {
        display: none;
    }
}

@media (max-width: 768px) {
    .testimonials-container {
        grid-template-columns: 1fr;
    }
    .testimonials-column:nth-child(2) {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.testimonials-column').forEach(col => {
        const cards = Array.from(col.children);
        cards.forEach(card => col.appendChild(card.cloneNode(true)));
    });
});
</script>

@endsection