<?php

namespace App\Http\Services;

use App\Models\City;
use App\Models\Weather;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected string $url;
    protected string $cityId;
    protected array $cities;
    protected array $storeAbleData;
    protected array $allStoreAbleData;
    protected $weatherResponse;

    public function getAndStore(): JsonResponse
    {
        $this->cities = cache()->rememberForever('cities', function() {
            return City::query()->get()->toArray();
        });

        foreach ($this->cities as $city) {

            $this->cityId = $city['id'];

            $this
                ->buildUrl(strtolower($city['name']),)
                ->getWeatherResponse()
                ->buildStoreAbleData();
        }

        return $this->storeWeatherData();
    }

    public function buildUrl($city): WeatherService
    {
        $baseUrl = "https://api.openweathermap.org/data/2.5/weather?";
        $latLon = "lat=" . config('cities.' . $city . '.lat') . "&lon=" . config('cities.' . $city . '.lon');
        $appId = "&appid=" . config('app.appid');
        $this->url = $baseUrl . $latLon . $appId;
        return $this;
    }

    public function getWeatherResponse(): WeatherService
    {
        $this->weatherResponse = Http::get($this->url);
        return $this;
    }

    public function buildStoreAbleData(): WeatherService
    {
        $this->storeAbleData = [
            'city' => $this->cityId,
            'coordinates' => json_encode($this->weatherResponse['coord']),
            'weather_condition' => $this->weatherResponse['weather'][0]['main'],
            'temperature' => $this->kelvinToCelsius($this->weatherResponse['main']['temp']),
            'feels_like' => $this->kelvinToCelsius($this->weatherResponse['main']['feels_like']),
            'humidity' => $this->weatherResponse['main']['humidity'],
            'wind_speed' => $this->mphToKmph($this->weatherResponse['wind']['speed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->allStoreAbleData[] = $this->storeAbleData;

        return $this;
    }

    public function storeWeatherData(): JsonResponse
    {

        Weather::query()->insert($this->allStoreAbleData);

        return response()->json(['message' => 'Data has been stored successfully']);
    }

    function kelvinToCelsius(float $kelvin): float
    {
        return $kelvin - 273.15;
    }

    function mphToKmph(float $mph): float
    {
        return $mph * 1.60934;
    }
}
