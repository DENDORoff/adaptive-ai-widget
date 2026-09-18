<div class="inline-block">
    @if(!$error && $weather)
        <div class="compact-weather flex items-center gap-2">
            <div class="text-white text-xs font-medium whitespace-nowrap">Pavlodar</div>
            
            <img src="https://openweathermap.org/img/wn/{{ $icon }}.png" 
                 alt="{{ $description }}"
                 class="w-6 h-6"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <svg class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z"/>
            </svg>
            
            <a href="https://openweathermap.org/city/1520240" 
               target="_blank" 
               class="text-white text-sm font-bold hover:text-blue-300 transition-colors whitespace-nowrap"
               title="Подробнее о погоде">
                {{ $temperature }}°
            </a>
            
            <button wire:click="refreshWeather" class="hover:bg-white/20 p-1 rounded-full transition flex-shrink-0" title="Обновить погоду">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </div>
    @else
        <div class="weather-error flex items-center gap-2">
            <div class="text-white text-xs font-medium whitespace-nowrap">Павлодар</div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <button wire:click="refreshWeather" class="hover:bg-white/20 p-1 rounded-full transition" title="Обновить погоду">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </div>
    @endif
</div>