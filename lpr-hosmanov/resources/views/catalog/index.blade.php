@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                class="form-control"
                placeholder="Номер рейса..."
            >
        </div>

        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="number" @selected($sort === 'number')>По номеру</option>
                <option value="departure_at" @selected($sort === 'departure_at')>По времени вылета</option>
                <option value="ticket_price" @selected($sort === 'ticket_price')>По цене билета</option>
            </select>
        </div>

        <div class="col-auto">
            <button class="btn btn-secondary">Найти</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Рейс</th>
                <th>Аэропорт</th>
                <th>Вылет</th>
                <th>Места</th>
                <th>Международный</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($flights as $flight)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('catalog.show', ['id' => $flight['id']]) }}">
                            {{ $flight['number'] }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('catalog.airport', ['airport' => $flight['airport']]) }}">
                            {{ $flight['airport'] }}
                        </a>
                    </td>
                    <td>{{ \Illuminate\Support\Carbon::parse($flight['departure_at'])->format('d.m.Y H:i') }}</td>
                    <td>{{ $flight['seats'] }}</td>
                    <td>
                        @if ($flight['is_international'])
                            <span class="badge bg-primary">Да</span>
                        @else
                            <span class="badge bg-secondary">Нет</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted">Рейсы не найдены.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection