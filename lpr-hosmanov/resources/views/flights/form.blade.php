@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="POST"
          class="col-lg-8"
          action="{{ $flight->exists
              ? route('flights.update', $flight)
              : route('flights.store') }}">
        @csrf
        @if ($flight->exists)
            @method('PUT')
        @endif

        <label class="form-label">Аэропорт</label>
        <select name="airport_id"
                class="form-select mb-2 @error('airport_id') is-invalid @enderror">
            <option value="">Выберите аэропорт</option>
            @foreach ($airports as $airport)
                <option value="{{ $airport->id }}"
                    @selected(old('airport_id', $flight->airport_id) == $airport->id)>
                    {{ $airport->code }} — {{ $airport->city }}
                </option>
            @endforeach
        </select>
        @error('airport_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        <label class="form-label mt-2">Номер рейса</label>
        <input name="number"
               value="{{ old('number', $flight->number) }}"
               class="form-control @error('number') is-invalid @enderror">
        @error('number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label class="form-label mt-2">Описание</label>
        <textarea name="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $flight->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label class="form-label mt-2">Дата и время вылета</label>
        <input type="datetime-local"
               name="departure_at"
               value="{{ old('departure_at', $flight->departure_at?->format('Y-m-d\TH:i')) }}"
               class="form-control @error('departure_at') is-invalid @enderror">
        @error('departure_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label class="form-label mt-2">Количество мест</label>
        <input type="number"
               name="seats"
               min="1"
               max="999"
               value="{{ old('seats', $flight->seats) }}"
               class="form-control @error('seats') is-invalid @enderror">
        @error('seats')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label class="form-label mt-2">Цена билета</label>
        <input type="number"
               name="ticket_price"
               min="0"
               step="0.01"
               value="{{ old('ticket_price', $flight->ticket_price) }}"
               class="form-control @error('ticket_price') is-invalid @enderror">
        @error('ticket_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-check my-3">
            <input type="checkbox"
                   name="is_international"
                   value="1"
                   class="form-check-input"
                   @checked(old('is_international', $flight->is_international))>
            <label class="form-check-label">Международный рейс</label>
        </div>

        <button class="btn btn-primary">Сохранить</button>
        <a href="{{ route('flights.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection