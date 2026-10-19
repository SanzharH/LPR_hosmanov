<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'description' => $this->description,
            'departure_at' => $this->departure_at?->toIso8601String(),
            'seats' => (int) $this->seats,
            'ticket_price' => (float) $this->ticket_price,
            'is_international' => $this->is_international ? 'yes' : 'no',
            'airport' => $this->whenLoaded('airport', fn () => [
                'id' => $this->airport->id,
                'code' => $this->airport->code,
                'city' => $this->airport->city,
            ]),
        ];
    }
}