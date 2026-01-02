@extends('layouts.app')

@section('content')
<h1 class="mb-4">Все товары</h1>

<!-- Фильтры (sticky) -->
<div class="sticky-filters">
    <form class="row g-2" method="GET">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Поиск товара по названию, категории или бренду...">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">от</span>
                <input name="min_price" type="number" placeholder="Цена" class="form-control border-start-0" value="{{ request('min_price') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">до</span>
                <input name="max_price" type="number" placeholder="Цена" class="form-control border-start-0" value="{{ request('max_price') }}">
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100" type="submit">🔍</button>
        </div>
    </form>
</div>

<!-- Всплывающая новостная лента -->
@if(isset($news) && $news->isNotEmpty())
    <div class="alert alert-info d-flex align-items-center p-3 mb-4" style="border-radius: 8px; position: relative; z-index: 999;">
        <i class="bi bi-megaphone-fill me-2 text-danger" style="font-size: 1.2rem;"></i>
        <div class="flex-grow-1">
            <strong>🔥 Последние новости:</strong>
            @foreach($news->take(1) as $item)
                <a href="{{ route('news.show', $item) }}" class="ms-2 text-decoration-none">
                    {{ \Str::limit($item->title, 60) }}
                </a>
            @endforeach
        </div>
        <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-secondary ms-3">Все новости</a>
    </div>
@endif

<!-- Товары -->
<div class="row g-4">
    @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            @include('components.product-card', ['product' => $product])
        </div>
    @endforeach
</div>

{{ $products->links() }}

@endsection