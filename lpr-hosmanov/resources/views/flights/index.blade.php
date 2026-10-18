@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="GET" action="{{ route('flights.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Номер рейса"
            >
        </div>

        <div class="col-auto">
            <button class="btn btn-secondary">Найти</button>
        </div>
    </form>

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>№</th>
                <th>Рейс</th>
                <th>Аэропорт</th>
                <th>Вылет</th>
                <th>Места</th>
                <th>Цена</th>
                <th>Международный</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($flights as $flight)
                <tr>
                    <td>{{ $flight->id }}</td>
                    <td>{{ $flight->number }}</td>
                    <td>{{ $flight->airport->code }} — {{ $flight->airport->city }}</td>
                    <td>{{ $flight->departure_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $flight->seats }}</td>
                    <td>{{ number_format((float) $flight->ticket_price, 0, ',', ' ') }} ₸</td>
                    <td>{{ $flight->is_international ? 'Да' : 'Нет' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Рейсы не найдены.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $flights->links() }}
@endsection