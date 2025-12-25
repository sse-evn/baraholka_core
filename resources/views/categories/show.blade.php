@extends('layouts.app')

@section('content')
<h1>Товары в категории: {{ $category->name }}</h1>

@if($products->isEmpty())
    <p class="text-muted">В этой категории пока нет товаров.</p>
@else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 160px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                            <span class="text-muted">Нет фото</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ \Illuminate\Support\Str::limit($product->name, 25) }}</h6>
                        <p class="h6 text-success mt-auto">{{ number_format($product->price, 0, ',', ' ') }} ₸</p>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif

<a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">← Все категории</a>
@endsection