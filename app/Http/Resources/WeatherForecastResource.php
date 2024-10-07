<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class WeatherForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'temperature' => data_get($this, 'main.temp'),
            'weather' => Str::title(data_get($this, 'weather.0.description', '')),
            'weather_icon' => data_get($this, 'weather.0.icon'),
        ];
    }
}
