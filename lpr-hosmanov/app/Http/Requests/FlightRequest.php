<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $flightId = $this->route('flight')?->id;

        return [
            'airport_id' => ['required', 'integer', 'exists:airports,id'],
            'number' => [
                'required',
                'string',
                'min:2',
                'max:154',
                Rule::unique('flights', 'number')->ignore($flightId),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'departure_at' => ['required', 'date'],
            'seats' => ['required', 'integer', 'min:1', 'max:999'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
            'is_international' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» обязательно.',
            'exists' => 'Выбранный аэропорт не существует.',
            'number.min' => 'Номер рейса должен содержать не менее :min символов.',
            'number.max' => 'Номер рейса должен содержать не более :max символов.',
            'number.unique' => 'Такой номер рейса уже существует.',
            'departure_at.date' => 'Укажите корректные дату и время вылета.',
            'seats.integer' => 'Количество мест должно быть целым числом.',
            'seats.min' => 'Количество мест должно быть не меньше :min.',
            'seats.max' => 'Количество мест должно быть не больше :max.',
            'ticket_price.numeric' => 'Цена должна быть числом.',
            'ticket_price.min' => 'Цена не может быть отрицательной.',
        ];
    }

    public function attributes(): array
    {
        return [
            'airport_id' => 'Аэропорт',
            'number' => 'Номер рейса',
            'description' => 'Описание',
            'departure_at' => 'Время вылета',
            'seats' => 'Количество мест',
            'ticket_price' => 'Цена билета',
            'is_international' => 'Международный рейс',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_international' => $this->boolean('is_international'),
        ]);
    }
}