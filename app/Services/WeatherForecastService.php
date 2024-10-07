<?php

namespace App\Services;

use App\Clients\GeoapifyApi;
use App\Clients\OpenWeatherApi;
use App\Http\Resources\SearchedPlacesResource;
use App\Http\Resources\WeatherForecastResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeatherForecastService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected GeoapifyApi $geoapifyApi, protected OpenWeatherApi $openWeatherApi)
    {
        //
    }

    /**
     * Search Place
     *
     * @param array $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchedPlaces(array $request): JsonResponse
    {
        try {
            $geopifyApi = $this->geoapifyApi->geocoding($request['search']);

            return (SearchedPlacesResource::collection($geopifyApi['features'] ?? []))->additional([
                'message' => 'Successfully fetched list of places.',
                'statusCode' => 200
            ])->response();

        } catch (\Throwable $throwable) {
            info('---- Open Weather Client Error ----');
            Log::error($throwable->getMessage());
            report($throwable);

            return response()->json([
                'message' => $throwable->getMessage(),
                'statusCode'    => $throwable->getCode() ?? 500,
            ]);
        }
    }

    public function getWeatherForecast(array $request): JsonResponse
    {
        try {
            $openWeatherApi = $this->openWeatherApi->handle($request['city'], $request['countryCode']);

            return (new WeatherForecastResource(head($openWeatherApi['list'] ?? [])))->additional([
                'message' => 'Successfully fetch weather forecast.',
                'statusCode' => 200
            ])->response();

        } catch (\Throwable $throwable) {
            info('---- Open Weather Client Error ----');
            Log::error($throwable->getMessage());
            report($throwable);

            return response()->json([
                'message' => $throwable->getMessage(),
                'code'    => $throwable->getCode() ?? 500,
            ]);
        }
    }
}
