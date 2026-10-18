@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1>{{ $title }}</h1>
        <a href="{{ route('flights.create') }}" class="btn btn-success align-self-center">
            + Добавить рейс
        </a>
    </div>

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
                <th></th>
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
                    <td class="text-end text-nowrap">
                        <a href="{{ route('flights.edit', $flight) }}"
                           class="btn btn-sm btn-outline-primary">
                            Изменить
                        </a>

                        <form method="POST"
                              action="{{ route('flights.destroy', $flight) }}"
                              class="d-inline"
                              onsubmit="return confirm('Удалить рейс?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Рейсы не найдены.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $flights->links() }}
@endsection