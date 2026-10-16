@extends('layouts.app')

@section('content')
    <h1>Рейс {{ $flight['number'] }}</h1>

    <dl class="row">
        <dt class="col-sm-3">Внутренний код</dt>
        <dd class="col-sm-9">{{ $flight['code'] }}</dd>

        <dt class="col-sm-3">Номер рейса</dt>
        <dd class="col-sm-9">{{ $flight['number'] }}</dd>

        <dt class="col-sm-3">Аэропорт</dt>
        <dd class="col-sm-9">{{ $flight['airport'] }}</dd>

        <dt class="col-sm-3">Время вылета</dt>
        <dd class="col-sm-9">
            {{ \Illuminate\Support\Carbon::parse($flight['departure_at'])->format('d.m.Y H:i') }}
        </dd>

        <dt class="col-sm-3">Количество мест</dt>
        <dd class="col-sm-9">{{ $flight['seats'] }}</dd>

        <dt class="col-sm-3">Цена билета</dt>
        <dd class="col-sm-9">{{ number_format($flight['ticket_price'], 2, ',', ' ') }} ₸</dd>

        <dt class="col-sm-3">Международный рейс</dt>
        <dd class="col-sm-9">
            {{ $flight['is_international'] ? 'Да' : 'Нет' }}
        </dd>
    </dl>

    <a href="{{ route('catalog.index') }}">← К расписанию</a>
@endsection