<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FlightApiRequest;
use App\Http\Resources\FlightResource;
use App\Models\Flight;
use App\Support\ApiFormat;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => ['sometimes', 'string', 'max:154'],
            'sort' => ['sometimes', 'in:number,-number,ticket_price,-ticket_price'],
            'per_page' => ['sometimes', 'integer', 'between:1,50'],
        ]);

        $query = Flight::with('airport');

        if ($request->filled('q')) {
            $query->where('number', 'like', '%' . $request->query('q') . '%');
        }

        $sort = $request->query('sort');

        if ($sort) {
            $query->orderBy(
                ltrim($sort, '-'),
                str_starts_with($sort, '-') ? 'desc' : 'asc'
            );
        } else {
            $query->latest();
        }

        $flights = $query->paginate($request->integer('per_page', 5));

        $payload = $flights->getCollection()
            ->map(fn (Flight $flight) => (new FlightResource($flight))->resolve())
            ->all();

        return ApiFormat::success($payload, 200, [
            'number' => $flights->currentPage(),
            'size' => $flights->perPage(),
            'total_items' => $flights->total(),
            'total_pages' => $flights->lastPage(),
        ]);
    }

    public function store(FlightApiRequest $request)
    {
        $flight = Flight::create($request->validated())->load('airport');

        return ApiFormat::success(
            (new FlightResource($flight))->resolve(),
            201
        )->header('Location', route('api.flights.show', $flight));
    }

    public function show(Flight $flight)
    {
        $flight->load('airport');

        return ApiFormat::success(
            (new FlightResource($flight))->resolve()
        );
    }

    public function update(FlightApiRequest $request, Flight $flight)
    {
        $flight->update($request->validated());
        $flight->load('airport');

        return ApiFormat::success(
            (new FlightResource($flight))->resolve()
        );
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->noContent();
    }
}