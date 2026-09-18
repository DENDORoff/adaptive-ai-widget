@extends('layouts.app')

@section('title', \App\Models\PageSection::getValue("state_symbols", "metadata", "title", __("messages.State symbols")))

@section('content')
<section class="relative overflow-visible bg-gradient-to-b from-gray-900 to-black pt-12 pb-32 min-h-screen">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-800/20"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 rounded-full filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 pt-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3 leading-tight">
                    {{ \App\Models\PageSection::getValue('state_symbols', 'header', 'main_title', 'Государственные символы') }}
                </h1>
                <div class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-500 to-cyan-500 text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                    {{ \App\Models\PageSection::getValue('state_symbols', 'header', 'subtitle', 'Республики Казахстан') }}
                </div>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto mb-5"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    {{ \App\Models\PageSection::getValue('state_symbols', 'header', 'description', 'Официальные государственные символы, отражающие суверенитет и национальные ценности') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl border border-gray-700/50">
                    <div class="p-6">
                        <h2 class="text-white font-bold text-2xl mb-6 text-center">
                            {{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'title', 'Государственный флаг') }}
                        </h2>
                        <div class="flex flex-col items-center mb-6">
                            <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'image_url', 'images/flagrk.png') }}" target="_blank" class="group mb-6">
                                <img src="{{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'image_url', 'images/flagrk.png') }}" 
                                     alt="{{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'image_alt', 'Государственный флаг Казахстана') }}" 
                                     class="w-64 h-40 object-contain group-hover:scale-105 transition-transform duration-300">
                            </a>
                            <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'download_url', 'images/flagrk.png') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'download_text', 'Скачать флаг') }}
                            </a>
                            <p class="text-xs text-gray-400 italic text-center mt-2">
                                {{ \App\Models\PageSection::getValue('state_symbols', 'flag', 'dimensions', 'Соотношение сторон: 1:2') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 border-t border-gray-700">
                        <div class="space-y-4 text-gray-300">
                            @for($i = 1; $i <= 5; $i++)
                                @php
                                    $paragraph = \App\Models\PageSection::getValue('state_symbols', 'flag', "description_{$i}", '');
                                @endphp
                                @if($paragraph)
                                    <p class="text-sm">{{ $paragraph }}</p>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl border border-gray-700/50">
                    <div class="p-6">
                        <h2 class="text-white font-bold text-2xl mb-6 text-center">
                            {{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'title', 'Государственный герб') }}
                        </h2>
                        <div class="flex flex-col items-center mb-6">
                            <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'image_url', 'images/gerb.png') }}" target="_blank" class="group mb-6">
                                <img src="{{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'image_url', 'images/gerb.png') }}" 
                                     alt="{{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'image_alt', 'Государственный герб Казахстана') }}" 
                                     class="w-64 h-40 object-contain group-hover:scale-105 transition-transform duration-300">
                            </a>
                            <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'download_url', 'images/gerb.png') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'download_text', 'Скачать герб') }}
                            </a>
                            <p class="text-xs text-gray-400 italic text-center mt-2">
                                {{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', 'colors', 'Цвета: золотой и голубой') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 border-t border-gray-700">
                        <div class="space-y-4 text-gray-300">
                            @for($i = 1; $i <= 6; $i++)
                                @php
                                    $paragraph = \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms', "description_{$i}", '');
                                @endphp
                                @if($paragraph)
                                    <p class="text-sm">{{ $paragraph }}</p>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl border border-gray-700/50">
                    <div class="p-6">
                        <h2 class="text-white font-bold text-2xl mb-6 text-center">
                            {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'title', 'Государственный гимн') }}
                        </h2>
                        <div class="flex flex-col items-center mb-6">
                            <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'image_url', 'images/gimn.png') }}" target="_blank" class="group mb-6">
                                <img src="{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'image_url', 'images/gimn.png') }}" 
                                     alt="{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'image_alt', 'Государственный гимн Казахстана') }}" 
                                     class="w-64 h-40 object-contain group-hover:scale-105 transition-transform duration-300">
                            </a>
                            <div class="space-y-3 w-full max-w-xs">
                                <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'audio_url', 'audio/National_Anthem.mp4') }}" 
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-300 w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'audio_button', 'Скачать MP3') }}
                                </a>
                                <a href="{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'sheet_music_url', 'documents/Anthem_Score.pdf') }}" 
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg transition-all duration-300 w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'sheet_music_button', 'Скачать ноты (PDF)') }}
                                </a>
                            </div>
                            <p class="text-xs text-gray-400 italic text-center mt-2">
                                <strong>{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'adopted_label', 'Принят:') }}</strong> 
                                {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'adopted_date', '7 января 2006 года') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 border-t border-gray-700">
                        <div class="space-y-4 text-gray-300">
                            <p class="text-sm">
                                <strong>{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'authors_label', 'Авторы текста:') }}</strong> 
                                {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'authors', 'Жумекен Нажимеденов, Нурсултан Назарбаев') }}
                            </p>
                            
                            <p class="text-sm">
                                <strong>{{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'composer_label', 'Автор музыки:') }}</strong> 
                                {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'composer', 'Шамши Калдаяков') }}
                            </p>
                            
                            @for($i = 1; $i <= 5; $i++)
                                @php
                                    $paragraph = \App\Models\PageSection::getValue('state_symbols', 'anthem', "description_{$i}", '');
                                @endphp
                                @if($paragraph)
                                    <p class="text-sm">{{ $paragraph }}</p>
                                @endif
                            @endfor

                            <div class="mt-6">
                                <div class="bg-gray-800/30 rounded-lg p-3">
                                    @php
                                        $audioUrl = \App\Models\PageSection::getValue('state_symbols', 'anthem', 'audio_url', 'audio/National_Anthem.mp4');
                                    @endphp
                                    @if($audioUrl)
                                        <audio controls class="w-full">
                                            <source src="{{ $audioUrl }}" type="audio/mpeg">
                                            {{ \App\Models\PageSection::getValue('state_symbols', 'anthem', 'audio_fallback', 'Ваш браузер не поддерживает аудио элемент.') }}
                                        </audio>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl p-6 shadow-2xl border border-gray-700/50">
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('state_symbols', 'flag_symbolism', 'title', 'Символика флага') }}
                    </h3>
                    <div class="space-y-4 text-gray-300">
                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $paragraph = \App\Models\PageSection::getValue('state_symbols', 'flag_symbolism', "paragraph_{$i}", '');
                            @endphp
                            @if($paragraph)
                                <p class="text-sm">{{ $paragraph }}</p>
                            @endif
                        @endfor
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl p-6 shadow-2xl border border-gray-700/50">
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms_symbolism', 'title', 'Символика герба') }}
                    </h3>
                    <div class="space-y-4 text-gray-300">
                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $paragraph = \App\Models\PageSection::getValue('state_symbols', 'coat_of_arms_symbolism', "paragraph_{$i}", '');
                            @endphp
                            @if($paragraph)
                                <p class="text-sm">{{ $paragraph }}</p>
                            @endif
                        @endfor
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl p-6 shadow-2xl border border-gray-700/50">
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'title', 'Текст государственного гимна') }}
                    </h3>
                    
                    
                    <div class="bg-gray-800/50 p-4 rounded-lg border-l-4 border-blue-500 mb-4">
                        <div class="space-y-3 text-sm text-white">
                            
                            <div>
                                <p class="whitespace-pre-line font-medium leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'verse_1_kz', '') }}</p>
                            </div>
                            
                            
                            <div>
                                <p class="whitespace-pre-line font-medium leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'verse_2_kz', '') }}</p>
                            </div>
                            
                            
                            <div class="mt-3">
                                <p class="text-blue-400 font-bold mb-1 text-sm">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'chorus_label_kz', 'Қайырмасы:') }}</p>
                                <p class="whitespace-pre-line font-semibold leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'chorus_kz', '') }}</p>
                            </div>
                            
                            
                            <div class="mt-3">
                                <p class="whitespace-pre-line font-medium leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'verse_3_kz', '') }}</p>
                            </div>
                            
                            
                            <div>
                                <p class="whitespace-pre-line font-medium leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'verse_4_kz', '') }}</p>
                            </div>
                            
                           
                            <div>
                                <p class="whitespace-pre-line font-medium leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'verse_5_kz', '') }}</p>
                            </div>
                            
                            
                            <div class="mt-3">
                                <p class="text-blue-400 font-bold mb-1 text-sm">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'chorus_label_kz', 'Қайырмасы:') }}</p>
                                <p class="whitespace-pre-line font-semibold leading-relaxed">{{ \App\Models\PageSection::getValue('state_symbols', 'anthem_text', 'chorus_kz', '') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="space-y-3 text-gray-300">
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $paragraph = \App\Models\PageSection::getValue('state_symbols', 'anthem_text', "description_{$i}", '');
                            @endphp
                            @if($paragraph)
                                <p class="text-sm">{{ $paragraph }}</p>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-800/70 to-gray-900/70 backdrop-blur-sm rounded-2xl p-6 shadow-2xl border border-gray-700/50 mb-8">
                <h3 class="text-2xl font-bold text-white mb-4">
                    {{ \App\Models\PageSection::getValue('state_symbols', 'legal_basis', 'title', 'Правовая основа') }}
                </h3>
                <div class="text-gray-300 space-y-3">
                    <p>{{ \App\Models\PageSection::getValue('state_symbols', 'legal_basis', 'description', 'Государственные символы Республики Казахстан установлены Конституционным законом "О государственных символах Республики Казахстан".') }}</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $symbol = \App\Models\PageSection::getValue('state_symbols', 'legal_basis', "symbol_{$i}", '');
                            @endphp
                            @if($symbol)
                                <li>{!! $symbol !!}</li>
                            @endif
                        @endfor
                    </ul>
                    
                    <div class="mt-4 p-4 bg-blue-600/20 border border-blue-500/50 rounded-lg">
                        <p class="text-blue-300 text-sm">
                            <strong>{{ \App\Models\PageSection::getValue('state_symbols', 'legal_basis', 'important_label', 'Важно:') }}</strong> 
                            {{ \App\Models\PageSection::getValue('state_symbols', 'legal_basis', 'important_text', 'Государственные символы охраняются законом. Неуважительное отношение к государственным символам преследуется по закону.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ \App\Models\PageSection::getValue('state_symbols', 'navigation', 'back_button', 'Назад на главную') }}
                </a>
            </div>

        </div>
    </div>
</section>

<style>
.whitespace-pre-line {
    white-space: pre-line;
}
</style>
@endsection