<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GeoapifyApi
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Run the client.
     *
     * @param string $search
     *
     * @return array
     */
    public function handle(string $search): array
    {
        //
    }

    /**
     * The API key of the client.
     *
     * @return string
     */
    public function apiKey(): string
    {
        return config('services.geoapify.key');
    }

    /**
     * The url of the client.
     *
     * @return string
     */
    public function geocodeUrl(): string
    {
        return config('services.geoapify.url.geocode');
    }

    /**
     * Run the geocoding api./
     *
     * @param string $search
     *
     * @return array
     */
    public function geocoding(string $search): array
    {
        $results = [];
        try {
            $response = Http::get($this->geocodeUrl() . '/search', [
                'text' => $search,
                'apiKey' => $this->apiKey(),
            ]);

            if (!$response->ok()) {
                throw new HttpException($response->getStatusCode(), 'An error has occurred.');
            }

            $results = json_decode($response->body(), true);
        } catch (\Throwable $th) {
            info('---- GeoapifyApi Client Error ----');
            Log::error($th->getMessage());
            report($th);
        } finally {
            return $results;
        }
    }
}
