@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Оформление заказа</h2>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <!-- Пункт выдачи -->
        <div class="mb-4">
            <h5>Выберите пункт выдачи</h5>
            @foreach($pickupPoints as $point)
                <div class="form-check mb-2">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="pickup_point_id"
                        value="{{ $point->id }}"
                        id="point-{{ $point->id }}"
                        required
                    >
                    <label class="form-check-label" for="point-{{ $point->id }}">
                        <strong>{{ $point->name }}</strong> — {{ $point->address }}
                    </label>
                </div>
            @endforeach
            @error('pickup_point_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Товары -->
        <div class="card mb-4">
            <div class="card-header">Товары</div>
            <div class="card-body">
                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between">
                        <span>{{ $item->product->name }}</span>
                        <span>{{ number_format($item->product->price * $item->quantity, 0, ' ', ' ') }} ₸</span>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100">Перейти к оплате</button>
    </form>
</div>
@endsection