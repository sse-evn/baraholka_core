@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2>Корзина</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-info">Корзина пуста</div>
        <a href="{{ route('home') }}" class="btn btn-primary">Вернуться к покупкам</a>
    @else
        <div class="row g-3">
            @foreach($cartItems as $item)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1">{{ $item->product->name }}</h5>
                                <p class="mb-0">{{ number_format($item->product->price, 0, ',', ' ') }} ₸ × {{ $item->quantity }}</p>
                            </div>
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('checkout') }}" class="btn btn-success mt-3">Оформить заказ</a>
    @endif
</div>
@endsection