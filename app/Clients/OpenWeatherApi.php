<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OpenWeatherApi
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Run the geocoding api./
     *
     * @param string $city
     * @param string $countryCode
     * @param string $unit (Optional)
     *
     * @return array
     */
    public function handle(string $city, string $countryCode, string $unit = 'metric'): array
    {
        $result = [];
        try {
            $response = Http::get($this->geocodeUrl(), [
                'q' => "{$city} {$countryCode}",
                'appId' => $this->apiKey(),
                'unit' => $unit ?? 'metric'
            ]);

            if (!$response->ok()) {
                throw new HttpException($response->getStatusCode(), 'An error has occurred.');
            }

            $result = json_decode($response->body(), true);
        } catch (\Throwable $th) {
            info('---- Open Weather Client Error ----');
            Log::error($th->getMessage());
            report($th);
        } finally {
            return $result;
        }
    }

    /**
     * The API key of the client.
     *
     * @return string
     */
    protected function apiKey(): string
    {
        return config('services.open_weather.key');
    }

    /**
     * The url of the client.
     *
     * @return string
     */
    protected function geocodeUrl(): string
    {
        return config('services.open_weather.url');
    }
}
