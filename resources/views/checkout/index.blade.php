@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2>Оформление заказа</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Товары</div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <div>{{ $item->product->name }} × {{ $item->quantity }}</div>
                            <div>{{ number_format($item->product->price * $item->quantity, 0, ' ', ' ') }} ₸</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Итого: {{ number_format($total, 0, ' ', ' ') }} ₸</h5>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Подтвердить заказ</button>
                    </form>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary w-100 mt-2">← Назад в корзину</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection