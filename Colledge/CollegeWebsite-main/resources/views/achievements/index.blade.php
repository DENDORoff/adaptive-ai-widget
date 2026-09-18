@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('achievements', 'hero', 'main_title', 'Достижения колледжа и наши выпускники'))

@section('content')

{{-- Hero Section --}}
<section class="relative py-32 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>

    <div class="container px-4 max-w-7xl mx-auto relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6" data-animate="fade-up">
                {{ \App\Models\PageSection::getValue('achievements', 'hero', 'main_title', 'Достижения колледжа и наши выпускники') }}
            </h1>
            <p class="text-xl text-gray-300 mb-8 leading-relaxed" data-animate="fade-up" data-delay="200">
                {{ \App\Models\PageSection::getValue('achievements', 'hero', 'main_description', 'Мы гордимся нашими достижениями и людьми, которые воплощают наши амбициозные стандарты в профессиональную значимость колледжа и вдохновляющие успехи выпускников.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-animate="fade-up" data-delay="400">
                <a href="#achievements" 
                   class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/50 active:scale-95">
                    {{ \App\Models\PageSection::getValue('achievements', 'hero', 'button_1_text', 'Посмотреть достижения') }}
                </a>
                <a href="#graduates" 
                   class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300">
                    {{ \App\Models\PageSection::getValue('achievements', 'hero', 'button_2_text', 'Наши выпускники') }}
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
        <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

{{-- Stats Section --}}
<section class="bg-gray-900 border-b border-gray-800" data-animate-section>
    <div class="container px-4 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 -mt-16 mb-16">
            <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-transform duration-300" data-animate="fade-up" data-delay="100">
                <div class="text-5xl font-bold text-white mb-2 counter" 
                     data-target="{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_1_value', 85) }}" 
                     data-counter-repeat>0</div>
                <div class="text-blue-100 text-lg">{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_1_label', 'Профессиональные партнеры') }}</div>
            </div>
            <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-transform duration-300" data-animate="fade-up" data-delay="200">
                <div class="text-5xl font-bold text-white mb-2 counter" 
                     data-target="{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_2_value', 91) }}" 
                     data-counter-repeat>0</div>
                <div class="text-blue-100 text-lg">{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_2_label', 'Трудоустройство выпускников') }}</div>
            </div>
            <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-transform duration-300" data-animate="fade-up" data-delay="300">
                <div class="text-5xl font-bold text-white mb-2 counter" 
                     data-target="{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_3_value', 500) }}" 
                     data-counter-repeat>0</div>
                <div class="text-blue-100 text-lg">{{ \App\Models\PageSection::getValue('achievements', 'stats', 'stat_3_label', 'Успешных выпускников') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- Achievements Section --}}
<section id="achievements" class="py-20 bg-gray-900" data-animate-section>
    <div class="container px-4 max-w-7xl mx-auto">
        <div class="text-center mb-16" data-animate="fade-down" data-animate-repeat>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('achievements', 'achievements_section', 'section_title', 'Достижения колледжа') }}
            </h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                {{ \App\Models\PageSection::getValue('achievements', 'achievements_section', 'section_subtitle', 'Наши глобальные победы, партнёрство и академическое сотрудничество') }}
            </p>
        </div>

        @if($achievements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($achievements as $index => $achievement)
                    <div class="achievement-card bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-500 group" 
                         data-animate="fade-up" data-delay="{{ $index * 100 }}" data-animate-repeat>
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg">
                            @switch($achievement->icon)
                                @case('handshake')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                                    </svg>
                                    @break
                                @case('trophy')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 a3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    @break
                                @case('certificate')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @break
                                @case('lab')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    @break
                                @case('briefcase')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    @break
                                @case('medal')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 a3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                            @endswitch
                        </div>

                        <h3 class="text-xl font-bold text-white mb-4 break-words-wrap min-h-[3.5rem]">
                            {{ $achievement->title }}
                        </h3>
                        <p class="text-gray-400 leading-relaxed break-words-wrap">
                            {{ $achievement->description }}
                        </p>

                        <div class="mt-6 pt-6 border-t border-gray-700/50">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $achievement->year }}</span>
                                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-full">{{ $achievement->status }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-400 text-lg">{{ \App\Models\PageSection::getValue('achievements', 'achievements_section', 'empty_state_text', 'Достижения скоро появятся...') }}</p>
            </div>
        @endif
    </div>
</section>

{{-- Graduates Section --}}
<section id="graduates" class="py-20 bg-gradient-to-b from-gray-900 to-gray-800" data-animate-section>
    <div class="container px-4 max-w-7xl mx-auto">
        <div class="text-center mb-16" data-animate="fade-down" data-animate-repeat>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('achievements', 'graduates_section', 'section_title', 'Истории выпускников') }}
            </h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                {{ \App\Models\PageSection::getValue('achievements', 'graduates_section', 'section_subtitle', 'Карьеры наших выпускников — доказательство качества образования') }}
            </p>
        </div>

        @if($graduates->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @foreach($graduates as $index => $graduate)
                    <div class="graduate-card bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-500 group h-full"
                         data-animate="fade-up" data-delay="{{ $index * 150 }}" data-animate-repeat>
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-48 h-64 md:h-auto bg-gradient-to-br from-blue-600 to-blue-700 flex-shrink-0 relative overflow-hidden">
                                <img src="{{ $graduate->photo_url }}" 
                                     alt="{{ $graduate->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                            </div>

                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-2xl font-bold text-white mb-2 break-words-wrap">
                                    {{ $graduate->name }}
                                </h3>
                                <p class="text-blue-400 text-sm mb-1 break-words-wrap">
                                    {{ $graduate->specialty }}
                                </p>
                                <p class="text-gray-400 text-sm mb-4 break-words-wrap">
                                    {{ $graduate->position }}
                                    @if($graduate->company)
                                        <span class="text-gray-500">в {{ $graduate->company }}</span>
                                    @endif
                                </p>
                                <p class="text-gray-300 leading-relaxed break-words-wrap flex-1">
                                    {{ $graduate->story }}
                                </p>

                                @if($graduate->graduation_year)
                                    <div class="mt-4 pt-4 border-t border-gray-700/50 flex items-center justify-between">
                                        <span class="text-gray-500 text-sm">Выпуск {{ $graduate->graduation_year }}</span>
                                        <svg class="w-6 h-6 text-blue-500/50" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-400 text-lg">{{ \App\Models\PageSection::getValue('achievements', 'graduates_section', 'empty_state_text', 'Истории выпускников скоро появятся...') }}</p>
            </div>
        @endif
    </div>
</section>

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

[data-animate="fade-down"] {
    transform: translateY(-30px);
}

[data-animate="fade-down"].animated {
    transform: translateY(0);
}

[data-animate="fade-up"].animated {
    transform: translateY(0);
}

.break-words-wrap {
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
    hyphens: auto;
    max-width: 100%;
}

html {
    scroll-behavior: smooth;
}

.achievement-card:hover,
.graduate-card:hover {
    transform: translateY(-5px);
}

.stat-card:hover {
    box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.5);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-animate]');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight * 0.85 && elementBottom > 0) {
                const delay = element.getAttribute('data-delay') || 0;
                const shouldRepeat = element.hasAttribute('data-animate-repeat');
                
                setTimeout(() => {
                    if (shouldRepeat || !element.classList.contains('animated')) {
                        element.classList.add('animated');
                    }
                }, parseInt(delay));
            } else if (element.hasAttribute('data-animate-repeat')) {
                element.classList.remove('animated');
            }
        });
    };

    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current) + (target > 90 ? '%' : '+');
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target + (target > 90 ? '%' : '+');
            }
        };

        updateCounter();
    };

    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target.querySelector('.counter');
                const target = parseInt(element?.getAttribute('data-target'));
                
                if (element && target) {
                    if (element.hasAttribute('data-counter-repeat')) {
                        element.textContent = '0';
                    }
                    
                    if (!element.classList.contains('counted') || element.hasAttribute('data-counter-repeat')) {
                        animateCounter(element);
                        element.classList.add('counted');
                    }
                }
            } else if (entry.target.hasAttribute('data-counter-repeat')) {
                const counter = entry.target.querySelector('.counter');
                if (counter) {
                    counter.classList.remove('counted');
                    counter.textContent = '0';
                }
            }
        });
    }, { 
        threshold: 0.5,
        rootMargin: '50px'
    });

    document.querySelectorAll('.stat-card').forEach(card => {
        statObserver.observe(card);
    });

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
            } else {
                const animatedElements = entry.target.querySelectorAll('[data-animate][data-animate-repeat]');
                animatedElements.forEach(element => {
                    element.classList.remove('animated');
                });
                
                const counters = entry.target.querySelectorAll('.counter[data-counter-repeat]');
                counters.forEach(counter => {
                    counter.classList.remove('counted');
                    counter.textContent = '0';
                });
            }
        });
    }, { 
        threshold: 0.3,
        rootMargin: '-100px 0px -100px 0px'
    });

    document.querySelectorAll('[data-animate-section]').forEach(section => {
        sectionObserver.observe(section);
    });

    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

@endsection