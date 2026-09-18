<div class="p-4">
    <x-filament::section>
        <x-slot name="heading">
            📈 История изменений
        </x-slot>

        <x-slot name="description">
            Динамика изменения показателя за последние 30 дней
        </x-slot>

        @if($history->isEmpty())
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-2">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium">Нет данных в истории</p>
                <p class="text-gray-500 text-sm mt-1">История будет сохраняться автоматически каждый день</p>
            </div>
        @else
            <!-- Сводка -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <!-- Тренд -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-600 mb-1">Тренд (7 дней)</div>
                    @if($trend === 'growing')
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">📈</span>
                            <span class="text-green-600 font-bold">Растёт</span>
                        </div>
                    @elseif($trend === 'declining')
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">📉</span>
                            <span class="text-red-600 font-bold">Падает</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">📊</span>
                            <span class="text-gray-600 font-bold">Стабильно</span>
                        </div>
                    @endif
                </div>

                <!-- Средний рост -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-600 mb-1">Средний рост</div>
                    @if($avgGrowth !== null)
                        <div class="text-2xl font-bold {{ $avgGrowth > 0 ? 'text-green-600' : ($avgGrowth < 0 ? 'text-red-600' : 'text-gray-600') }}">
                            {{ $avgGrowth > 0 ? '+' : '' }}{{ $avgGrowth }}%
                        </div>
                    @else
                        <div class="text-gray-400">Н/Д</div>
                    @endif
                </div>

                <!-- Записей в истории -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-600 mb-1">Записей в истории</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $history->count() }}
                    </div>
                </div>
            </div>

            <!-- График -->
            <div class="mb-6">
                <canvas id="statisticChart" style="max-height: 300px;"></canvas>
            </div>

            <!-- Таблица истории -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-3 font-semibold text-gray-700">Дата</th>
                            <th class="text-right py-2 px-3 font-semibold text-gray-700">Значение</th>
                            <th class="text-right py-2 px-3 font-semibold text-gray-700">Изменение</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-2 px-3 text-gray-700">
                                    {{ $item->recorded_at->format('d.m.Y') }}
                                    <span class="text-xs text-gray-500">{{ $item->recorded_at->format('H:i') }}</span>
                                </td>
                                <td class="py-2 px-3 text-right font-medium">
                                    {{ $item->value }}
                                </td>
                                <td class="py-2 px-3 text-right">
                                    @if($item->change_percent !== null)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold 
                                            {{ $item->change_percent > 0 ? 'bg-green-100 text-green-700' : ($item->change_percent < 0 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ $item->change_percent > 0 ? '+' : '' }}{{ $item->change_percent }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    @if(!$history->isEmpty())
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('statisticChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartData['labels'] ?? []),
                            datasets: [{
                                label: '{{ $record->label ?? "Статистика" }}',
                                data: @json($chartData['values'] ?? []),
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return '{{ $record->label ?? "Статистика" }}: ' + context.parsed.y;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endif
</div>