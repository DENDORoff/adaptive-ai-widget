<section id="faq" class="py-16 bg-gray-900">
    <div class="container px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-white mb-2">{{ __('FAQ') }}</h2>
            <p class="text-gray-400">{{ \App\Models\PageSection::getValue('faq', 'header', 'subtitle', 'Ответы на часто задаваемые вопросы') }}</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700">
                
                <div class="border-b border-gray-700">
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_1', 'title', 'Какие специальности доступны в колледже?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        @php
                            $items_1 = [];
                            for($i = 1; $i <= 5; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_1', "item_{$i}", '');
                                if($item) $items_1[] = $item;
                            }
                        @endphp
                        @if(count($items_1) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_1 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="border-b border-gray-700">
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_2', 'title', 'Какие документы нужны для поступления?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        @php
                            $items_2 = [];
                            for($i = 1; $i <= 6; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_2', "item_{$i}", '');
                                if($item) $items_2[] = $item;
                            }
                        @endphp
                        @if(count($items_2) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_2 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="border-b border-gray-700">
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_3', 'title', 'Какова стоимость обучения?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        @php
                            $items_3 = [];
                            for($i = 1; $i <= 3; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_3', "item_{$i}", '');
                                if($item) $items_3[] = $item;
                            }
                        @endphp
                        @if(count($items_3) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_3 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="mt-2 text-sm text-gray-300">
                            {{ \App\Models\PageSection::getValue('faq', 'question_3', 'additional_info', 'Также доступно государственное финансирование (грант) для отличников.') }}
                        </p>
                    </div>
                </div>

                <div class="border-b border-gray-700">
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_4', 'title', 'Есть ли общежитие для иногородних студентов?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        <p class="mb-2 text-sm text-gray-300">
                            {{ \App\Models\PageSection::getValue('faq', 'question_4', 'intro', 'Да, наш колледж предоставляет общежитие:') }}
                        </p>
                        @php
                            $items_4 = [];
                            for($i = 1; $i <= 5; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_4', "item_{$i}", '');
                                if($item) $items_4[] = $item;
                            }
                        @endphp
                        @if(count($items_4) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_4 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="mt-2 text-sm font-medium text-white">
                            {{ \App\Models\PageSection::getValue('faq', 'question_4', 'price_info', 'Стоимость: 25 000 тг/месяц') }}
                        </p>
                    </div>
                </div>

                <div class="border-b border-gray-700">
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_5', 'title', 'Сколько длится обучение?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        @php
                            $items_5 = [];
                            for($i = 1; $i <= 2; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_5', "item_{$i}", '');
                                if($item) $items_5[] = $item;
                            }
                        @endphp
                        @if(count($items_5) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_5 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div>
                    <button onclick="toggleFAQ(this)" class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-750 transition">
                        <span class="text-white font-medium text-left">
                            {{ \App\Models\PageSection::getValue('faq', 'question_6', 'title', 'Предоставляется ли помощь с трудоустройством?') }}
                        </span>
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-4">
                        <p class="mb-2 text-sm text-gray-300">
                            {{ \App\Models\PageSection::getValue('faq', 'question_6', 'intro', 'Да, мы предоставляем:') }}
                        </p>
                        @php
                            $items_6 = [];
                            for($i = 1; $i <= 5; $i++) {
                                $item = \App\Models\PageSection::getValue('faq', 'question_6', "item_{$i}", '');
                                if($item) $items_6[] = $item;
                            }
                        @endphp
                        @if(count($items_6) > 0)
                            <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
                                @foreach($items_6 as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="mt-2 text-sm font-medium text-blue-400">
                            {{ \App\Models\PageSection::getValue('faq', 'question_6', 'statistic', 'Более 85% выпускников трудоустраиваются в течение 3 месяцев!') }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="text-center mt-6">
                <p class="text-gray-400 mb-3 text-sm">
                    {{ \App\Models\PageSection::getValue('faq', 'footer', 'text', 'Не нашли ответ на свой вопрос?') }}
                </p>
                <button onclick="openConsultationModal()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    {{ \App\Models\PageSection::getValue('faq', 'footer', 'button_text', 'Задать вопрос') }}
                </button>
            </div>
        </div>
    </div>
</section>

<style>
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.faq-answer.active {
    max-height: 2000px;
}

.faq-answer.hidden {
    display: none;
}
</style>

<script>
function toggleFAQ(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('svg');
    const isActive = answer.classList.contains('active');
    
    document.querySelectorAll('.faq-answer.active').forEach(item => {
        item.classList.remove('active');
        setTimeout(() => {
            item.classList.add('hidden');
        }, 300);
    });
    
    document.querySelectorAll('svg').forEach(item => {
        item.classList.remove('rotate-180');
    });
    
    if (!isActive) {
        answer.classList.remove('hidden');
        setTimeout(() => {
            answer.classList.add('active');
        }, 10);
        icon.classList.add('rotate-180');
    }
}
</script>