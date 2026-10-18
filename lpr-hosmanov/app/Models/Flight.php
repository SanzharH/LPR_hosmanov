<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_id',
        'number',
        'departure_at',
        'seats',
        'ticket_price',
        'is_international',
    ];

    protected function casts(): array
    {
        return [
            'departure_at' => 'datetime',
            'ticket_price' => 'decimal:2',
            'is_international' => 'boolean',
        ];
    }

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }
}
