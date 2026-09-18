<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherWidget extends Component
{
    public $weather;
    public $city = 'Pavlodar';
    public $temperature;
    public $description;
    public $icon;
    public $humidity;
    public $windSpeed;
    public $error = false;

    public function mount()
    {
        $this->fetchWeather();
    }

    public function fetchWeather()
    {
        try {

            $apiKey = config('services.openweathermap.key');
            
            if (!$apiKey) {
                $this->error = true;
                return;
            }


            $this->weather = Cache::remember('weather_' . $this->city, 1800, function () use ($apiKey) {
                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                    'q' => $this->city . ',KZ',
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'ru'
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            });

            if ($this->weather) {
                $this->temperature = round($this->weather['main']['temp']);
                $this->description = ucfirst($this->weather['weather'][0]['description']);
                $this->icon = $this->weather['weather'][0]['icon'];
                $this->humidity = $this->weather['main']['humidity'];
                $this->windSpeed = round($this->weather['wind']['speed']);
                $this->error = false;
            } else {
                $this->error = true;
            }
        } catch (\Exception $e) {
            $this->error = true;
            \Log::error('Weather API Error: ' . $e->getMessage());
        }
    }

    public function refreshWeather()
    {
        Cache::forget('weather_' . $this->city);
        $this->fetchWeather();
    }

    public function render()
    {
        return view('livewire.weather-widget');
    }
}