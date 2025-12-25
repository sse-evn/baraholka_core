@extends('layouts.app')

@section('content')
<h1>Все товары</h1>

@if($products->isEmpty())
    <p class="text-muted">Пока нет ни одного товара.</p>
@else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <span class="text-muted">Нет фото</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</h5>
                        <p class="text-muted small">{{ $product->category?->name }}</p>
                        <div class="mt-auto">
                            <p class="h5 mb-2">{{ number_format($product->price, 0, ',', ' ') }} ₸</p>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif
@endsection