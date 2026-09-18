@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue('blog', 'metadata', 'page_title', 'Блог руководителя'))

@php
    use App\Models\Setting;
@endphp

@section('content')

<section class="py-12 bg-gradient-to-b from-gray-900 to-black min-h-screen">
    <div class="container px-4 max-w-7xl mx-auto">
        
        <div class="mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">
                {{ \App\Models\PageSection::getValue('blog', 'header', 'main_title', 'БЛОГ РУКОВОДИТЕЛЯ') }}
            </h1>
            
            <div class="h-px bg-gradient-to-r from-blue-500 to-cyan-500 mb-4"></div>
            
            <div class="flex justify-between items-center text-sm font-semibold uppercase tracking-wide">
                <button onclick="showTab('greeting')" id="greetingTab" class="px-4 py-2 bg-blue-900/30 text-blue-300 rounded-lg transition-all duration-300 relative overflow-hidden tab-button active border border-blue-500/20">
                    {{ \App\Models\PageSection::getValue('blog', 'tabs', 'tab_1_label', 'ПРИВЕТСТВИЕ') }}
                    <div class="tab-line active"></div>
                </button>
                <div class="flex-1 h-px bg-gray-700 mx-4"></div>
                <button onclick="showTab('questions')" id="questionsTab" class="px-4 py-2 text-gray-400 hover:text-blue-300 hover:bg-blue-900/20 rounded-lg transition-all duration-300 relative overflow-hidden tab-button border border-gray-700 hover:border-blue-500/20">
                    {{ \App\Models\PageSection::getValue('blog', 'tabs', 'tab_2_label', 'ВОПРОС — ОТВЕТ') }}
                    <div class="tab-line"></div>
                </button>
            </div>
        </div>

        <div id="greetingContent" class="tab-content active">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                        <div class="flex items-center justify-center gap-3 mb-6 flex-wrap">
                            <a href="https://www.instagram.com/vkeik_kz/?hl=ru" target="_blank" 
                               class="w-10 h-10 bg-gradient-to-r from-purple-600 via-pink-600 to-red-500 hover:from-purple-700 hover:via-pink-700 hover:to-red-600 rounded-lg flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ \App\Models\PageSection::getValue('blog', 'social_links', 'youtube_url', 'https://www.youtube.com/@КолледжВКЭиК') }}" target="_blank" 
                               class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-lg flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ \App\Models\PageSection::getValue('blog', 'social_links', 'telegram_url', 'https://t.me/vkeik_kz') }}" target="_blank" 
                               class="w-10 h-10 bg-blue-500 hover:bg-blue-600 rounded-lg flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                                </svg>
                            </a>
                            
                            <a href="https://wa.me/{{ \App\Models\PageSection::getValue('blog', 'contact_info', 'whatsapp_number', '77014900566') }}" target="_blank" 
                               class="w-10 h-10 bg-green-600 hover:bg-green-700 rounded-lg flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.10c.48-.07 1.46-.60 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.10-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.50c.11-.11.27-.29.37-.44c.10-.15.13-.25.20-.41c.06-.17.03-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.20-.48-.40-.42-.56-.43c-.14 0-.30-.01-.47-.01z"/>
                                </svg>
                            </a>
                        </div>

                        <div class="space-y-4">
                            <!-- Телефон -->
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-400 border border-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-300">
                                    {{ \App\Models\PageSection::getValue('blog', 'contact_info', 'phone', '+7 701490-05-66') }}
                                </span>
                            </div>
                            
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-400 border border-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-300">
                                    {{ \App\Models\PageSection::getValue('blog', 'contact_info', 'address', 'г. Павлодар, ул. Жүсіпбек Аймауытұлы, 2') }}
                                </span>
                            </div>
                            
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-400 border border-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <a href="mailto:{{ \App\Models\PageSection::getValue('blog', 'contact_info', 'email', 'director@college.edu') }}" 
                                   class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                    {{ \App\Models\PageSection::getValue('blog', 'contact_info', 'email', 'director@college.edu') }}
                                </a>
                            </div>
                        </div>

                        <button onclick="openQuestionModal()" 
                                class="w-full mt-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('blog', 'buttons', 'ask_question_button', 'Задать вопрос руководителю') }}
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">
                            {{ \App\Models\PageSection::getValue('blog', 'greeting', 'title', 'Добро пожаловать в блог руководителя') }}
                        </h2>
                        
                        <div class="text-gray-300 leading-relaxed space-y-4">
                            @for($i = 1; $i <= 4; $i++)
                                @php
                                    $paragraph = \App\Models\PageSection::getValue('blog', 'greeting', "paragraph_{$i}", '');
                                @endphp
                                @if($paragraph)
                                    <p>{!! nl2br(e($paragraph)) !!}</p>
                                @endif
                            @endfor
                            
                            <p class="pt-4">
                                {!! \App\Models\PageSection::getValue('blog', 'greeting', 'signature', 'С уважением,<br><strong>Ныгметов Марат Жанатович</strong><br><span class="text-gray-400">Руководитель колледжа</span>') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="questionsContent" class="tab-content">
            <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-8 mb-16">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    {{ \App\Models\PageSection::getValue('blog', 'faq_section', 'title', 'Вопросы и ответы') }}
                </h2>
                
                @if($publishedQuestions->count() > 0)
                    <div class="space-y-6">
                        @foreach($publishedQuestions as $faq)
                            <div class="border border-gray-700 rounded-xl overflow-hidden hover:border-blue-500/30 transition-all duration-300">
                                <button 
                                    onclick="toggleFAQ({{ $faq->id }})"
                                    class="w-full px-6 py-4 text-left bg-gray-900/50 hover:bg-gray-900 transition-colors flex items-center justify-between gap-4 group"
                                >
                                    <div class="flex-1 text-left">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-semibold text-white">{{ $faq->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $faq->created_at->format('d.m.Y') }}</span>
                                        </div>
                                        <p class="text-gray-300 text-sm break-words">{{ $faq->question }}</p>
                                    </div>
                                    <svg id="icon-{{ $faq->id }}" class="w-5 h-5 text-gray-500 flex-shrink-0 transform transition-transform duration-300 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <div id="answer-{{ $faq->id }}" class="hidden px-6 pb-4">
                                    <div class="border-t border-gray-700 pt-4">
                                        <div class="text-sm max-w-none text-gray-300 break-words mb-4">
                                            {!! $faq->answer !!}
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-semibold text-blue-400">
                                                {{ \App\Models\PageSection::getValue('blog', 'faq_section', 'answer_signature', 'Руководитель колледжа') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($publishedQuestions->hasPages())
                        <div class="mt-8">
                            {{ $publishedQuestions->onEachSide(1)->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        <p class="text-gray-400 mb-4">
                            {{ \App\Models\PageSection::getValue('blog', 'faq_section', 'no_questions_text', 'Пока нет опубликованных вопросов. Будьте первым, кто задаст вопрос!') }}
                        </p>
                        <button onclick="openQuestionModal()" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg active:scale-95 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \App\Models\PageSection::getValue('blog', 'faq_section', 'ask_first_button', 'Задать вопрос') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

<div id="questionModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gray-900 rounded-2xl max-w-2xl w-full shadow-2xl border border-gray-700 animate-modal-in">
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <h3 class="text-2xl font-bold text-white">
                {{ \App\Models\PageSection::getValue('blog', 'modal', 'title', 'Задать вопрос') }}
            </h3>
            <button onclick="closeQuestionModal()" 
                    class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 transition-all duration-300 hover:scale-110 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('questions.store') }}" method="POST" class="p-6">
            @csrf
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-900/30 border border-green-600 rounded-lg text-green-400">
                    {{ \App\Models\PageSection::getValue('blog', 'messages', 'success_message', 'Ваш вопрос успешно отправлен! Спасибо за ваш интерес.') }}
                </div>
            @endif
            
            <div class="space-y-4">
                
                <div>
                    <label class="block text-gray-300 font-medium mb-2">
                        {{ \App\Models\PageSection::getValue('blog', 'modal', 'name_label', 'Ваше имя *') }}
                    </label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                           placeholder="{{ \App\Models\PageSection::getValue('blog', 'modal', 'name_placeholder', 'Введите ваше имя') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                
                <div>
                    <label class="block text-gray-300 font-medium mb-2">
                        {{ \App\Models\PageSection::getValue('blog', 'modal', 'email_label', 'Email *') }}
                    </label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                           placeholder="{{ \App\Models\PageSection::getValue('blog', 'modal', 'email_placeholder', 'Введите ваш email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                
                <div>
                    <label class="block text-gray-300 font-medium mb-2">
                        {{ \App\Models\PageSection::getValue('blog', 'modal', 'question_label', 'Ваш вопрос *') }}
                    </label>
                    <textarea name="question" required rows="5"
                              class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 resize-none"
                              placeholder="{{ \App\Models\PageSection::getValue('blog', 'modal', 'question_placeholder', 'Напишите ваш вопрос...') }}">{{ old('question') }}</textarea>
                    @error('question')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
           
            <div class="mt-6 flex gap-3">
                <button type="submit" 
                        class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg active:scale-95">
                    {{ \App\Models\PageSection::getValue('blog', 'modal', 'submit_button', 'Отправить вопрос') }}
                </button>
                <button type="button" onclick="closeQuestionModal()"
                        class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold rounded-lg transition-all duration-300">
                    {{ \App\Models\PageSection::getValue('blog', 'modal', 'cancel_button', 'Отмена') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
        content.classList.add('hidden');
    });
    
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'bg-blue-900/30', 'text-blue-300', 'border-blue-500/20');
        button.classList.add('text-gray-400', 'border-gray-700');
    });
    
    document.querySelectorAll('.tab-line').forEach(line => {
        line.classList.remove('active');
    });
    
    const activeContent = document.getElementById(tabName + 'Content');
    const activeButton = document.getElementById(tabName + 'Tab');
    const activeLine = activeButton.querySelector('.tab-line');
    
    activeContent.classList.remove('hidden');
    activeContent.classList.add('active');
    activeButton.classList.add('active', 'bg-blue-900/30', 'text-blue-300', 'border-blue-500/20');
    activeButton.classList.remove('text-gray-400', 'border-gray-700');
    activeLine.classList.add('active');
    
    localStorage.setItem('activeTab', tabName);
}

document.addEventListener('DOMContentLoaded', function() {
    const activeTab = '{{ $activeTab }}' || localStorage.getItem('activeTab') || 'greeting';
    showTab(activeTab);
});

function toggleFAQ(faqId) {
    const answer = document.getElementById('answer-' + faqId);
    const icon = document.getElementById('icon-' + faqId);
    
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        answer.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

function openQuestionModal() {
    const modal = document.getElementById('questionModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeQuestionModal() {
    const modal = document.getElementById('questionModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeQuestionModal();
    }
});

document.getElementById('questionModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('questionModal')) {
        closeQuestionModal();
    }
});

@if($errors->any())
    openQuestionModal();
@endif
</script>

<style>
.tab-button {
    position: relative;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s;
    border: 1px solid;
}

.tab-button.active {
    background-color: rgba(30, 58, 138, 0.3) !important;
    color: #93c5fd !important;
    border-color: rgba(59, 130, 246, 0.2) !important;
}

.tab-line {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    background-color: #60a5fa;
    width: 0;
    transition: width 0.3s;
}

.tab-line.active {
    width: 100% !important;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

@keyframes modal-in {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.animate-modal-in {
    animation: modal-in 0.3s ease-out;
}

.break-words {
    word-break: break-word;
    overflow-wrap: anywhere;
}

.rotate-180 {
    transform: rotate(180deg);
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

.pagination .page-link {
    background: #1f2937;
    color: #d1d5db;
    border-color: #374151;
}

.pagination .page-link:hover {
    background-color: #374151;
}

button.bg-blue-600 {
    background-color: #3b82f6 !important;
    color: white !important;
}

button.bg-blue-600:hover {
    background-color: #2563eb !important;
}

.text-blue-400 {
    color: #60a5fa;
}

.bg-blue-900\/30 {
    background-color: rgba(30, 58, 138, 0.3);
}

.border-blue-500\/20 {
    border-color: rgba(59, 130, 246, 0.2);
}
</style>

@endsection