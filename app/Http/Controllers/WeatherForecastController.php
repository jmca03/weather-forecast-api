<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeoapifyClientRequest;
use App\Http\Requests\OpenWeatherClientRequest;
use App\Services\WeatherForecastService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherForecastController extends Controller
{
    /**
     * Create an instance of the controller
     */
    public function __construct(protected WeatherForecastService $service)
    {
        //
    }

    /**
     * @param \App\Http\Requests\GeoapifyClientRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchedPlaces(GeoapifyClientRequest $request): JsonResponse
    {
        return $this->service->getSearchedPlaces($request->validated());
    }

    /**
     * Get the forecast from the given place.
     *
     * @param \App\Http\Requests\OpenWeatherClientRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forecast(OpenWeatherClientRequest $request): JsonResponse
    {
        return $this->service->getWeatherForecast($request->validated());
    }
}
