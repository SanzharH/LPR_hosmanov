<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlightController extends Controller
{
    public function index(Request $request): View
    {
        $query = Flight::with('airport');

        if ($search = $request->query('q')) {
            $query->where('number', 'like', "%{$search}%");
        }

        $query->latest();

        return view('flights.index', [
            'title' => 'Расписание рейсов',
            'flights' => $query->paginate(5)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('flights.form', [
            'title' => 'Новый рейс',
            'flight' => new Flight(),
            'airports' => Airport::orderBy('code')->get(),
        ]);
    }

    public function store(FlightRequest $request): RedirectResponse
    {
        $flight = Flight::create($request->validated());

        return redirect()
            ->route('flights.index')
            ->with('status', "Добавлен рейс {$flight->number}.");
    }

    public function edit(Flight $flight): View
    {
        return view('flights.form', [
            'title' => 'Редактирование рейса',
            'flight' => $flight,
            'airports' => Airport::orderBy('code')->get(),
        ]);
    }

    public function update(FlightRequest $request, Flight $flight): RedirectResponse
    {
        $flight->update($request->validated());

        return redirect()
            ->route('flights.index')
            ->with('status', "Изменения рейса {$flight->number} сохранены.");
    }

    public function destroy(Flight $flight): RedirectResponse
    {
        $number = $flight->number;
        $flight->delete();

        return redirect()
            ->route('flights.index')
            ->with('status', "Рейс {$number} удалён.");
    }
}