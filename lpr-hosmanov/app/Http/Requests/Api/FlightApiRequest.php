<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlightApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $flightId = $this->route('flight')?->id;
        $required = $this->isMethod('PATCH') ? 'sometimes' : 'required';

        return [
            'airport_id' => [$required, 'integer', 'exists:airports,id'],
            'number' => [
                $required,
                'string',
                'min:2',
                'max:154',
                Rule::unique('flights', 'number')->ignore($flightId),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'departure_at' => [$required, 'date'],
            'seats' => [$required, 'integer', 'min:1', 'max:999'],
            'ticket_price' => [$required, 'numeric', 'min:0'],
            'is_international' => ['sometimes', 'boolean'],
        ];
    }
}