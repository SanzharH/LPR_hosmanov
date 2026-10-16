<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Временные данные
    private function flights(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'KC-1842',
                'number' => 'KC 852',
                'departure_at' => '2026-10-20 08:15:00',
                'seats' => 180,
                'ticket_price' => 24500.00,
                'is_international' => false,
                'airport' => 'NQZ — Астана',
            ],
            [
                'id' => 2,
                'code' => 'KC-7316',
                'number' => 'KC 705',
                'departure_at' => '2026-10-20 11:40:00',
                'seats' => 160,
                'ticket_price' => 31200.00,
                'is_international' => true,
                'airport' => 'ALA — Алматы',
            ],
            [
                'id' => 3,
                'code' => 'FS-2904',
                'number' => 'FS 7101',
                'departure_at' => '2026-10-21 07:30:00',
                'seats' => 90,
                'ticket_price' => 18900.00,
                'is_international' => false,
                'airport' => 'CIT — Шымкент',
            ],
            [
                'id' => 4,
                'code' => 'KC-5631',
                'number' => 'KC 951',
                'departure_at' => '2026-10-21 16:20:00',
                'seats' => 180,
                'ticket_price' => 27800.00,
                'is_international' => false,
                'airport' => 'NQZ — Астана',
            ],
            [
                'id' => 5,
                'code' => 'FS-4087',
                'number' => 'FS 7320',
                'departure_at' => '2026-10-22 09:05:00',
                'seats' => 150,
                'ticket_price' => 85600.00,
                'is_international' => true,
                'airport' => 'ALA — Алматы',
            ],
        ];
    }

    // GET /catalog?q=...&sort=...
    public function index(Request $request)
    {
        $flights = collect($this->flights());

        $search = $request->query('q');

        if ($search) {
            $flights = $flights->filter(
                fn ($flight) => mb_stripos($flight['number'], $search) !== false
            );
        }

        $sort = $request->query('sort', 'number');

        if (in_array($sort, ['number', 'departure_at', 'ticket_price'], true)) {
            $flights = $flights->sortBy($sort);
        }

        return view('catalog.index', [
            'title' => 'Расписание рейсов',
            'flights' => $flights,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    // GET /catalog/{id}
    public function show(int $id)
    {
        $flight = collect($this->flights())->firstWhere('id', $id);
        abort_if(! $flight, 404);

        return view('catalog.show', [
            'title' => $flight['number'],
            'flight' => $flight,
        ]);
    }

    // GET /catalog/code/{code}
    public function byCode(string $code)
    {
        $flight = collect($this->flights())->firstWhere('code', $code);
        abort_if(! $flight, 404);

        return view('catalog.show', [
            'title' => $flight['number'],
            'flight' => $flight,
        ]);
    }

    // GET /catalog/airport/{airport?}
    public function byAirport(?string $airport = null)
    {
        $flights = collect($this->flights());

        if ($airport) {
            $flights = $flights->where('airport', $airport);
        }

        return view('catalog.index', [
            'title' => $airport ? "Рейсы: {$airport}" : 'Аэропорты',
            'flights' => $flights,
            'search' => null,
            'sort' => 'number',
        ]);
    }
}
