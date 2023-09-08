<?php

namespace App\Http\Controllers;

use App\Http\Services\WeatherService;
use App\Models\City;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;

class HttpController extends Controller
{
    protected array $cities;
    protected array $storeAbleData;
    protected  $service;

    public function __construct(WeatherService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
//        $cities = City::query()->with('weathers')->latest()->paginate(6);
        $weather = Weather::query()->with('city')->latest()->paginate(6);
        return response()->json($weather);
    }
}
