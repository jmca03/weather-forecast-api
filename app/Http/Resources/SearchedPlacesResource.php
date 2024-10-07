<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchedPlacesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $city = data_get($this,'properties.city');
        $countryCode = data_get($this,'properties.country_code');

        return [
            'label' => data_get($this, 'properties.formatted', 'Location not available.'),
            'value' => [
                'city' => $city, 'countryCode' => $countryCode
            ]
        ];
    }
}
