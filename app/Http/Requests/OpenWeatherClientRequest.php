<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpenWeatherClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'required|string',
            'countryCode' => 'required|string',
            'unit' => 'nullable|string|in:imperial,metric',
        ];
    }

    public function messages(): array
    {
        return [
            'city.required' => 'A city is required.',
            'countryCode.required' => 'The country code of the city is required.',
            'unit.in' => 'Unit not allowed.'
        ];
    }
}
