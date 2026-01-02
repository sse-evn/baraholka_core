@extends('layouts.app')

@section('content')
<div class="py-2">
    <!-- Sticky фильтры -->
    <div class="bg-white sticky-top shadow-sm p-3 rounded mb-4" style="z-index: 100;">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control border-start-0"
                        placeholder="Поиск по названию, категории или бренду..."
                    >
                </div>
            </div>
            <div class="col-6 col-md-2">
                <input
                    name="min_price"
                    type="number"
                    class="form-control"
                    placeholder="От"
                    value="{{ request('min_price') }}"
                >
            </div>
            <div class="col-6 col-md-2">
                <input
                    name="max_price"
                    type="number"
                    class="form-control"
                    placeholder="До"
                    value="{{ request('max_price') }}"
                >
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-primary w-100" type="submit">
                    Применить
                </button>
            </div>
        </form>
    </div>

    <!-- Новости (опционально) -->
    @if(isset($news) && $news->isNotEmpty())
        <div class="alert alert-light border border-warning-subtle bg-warning-subtle mb-4 d-flex align-items-center">
            <i class="bi bi-megaphone-fill text-warning me-2"></i>
            <div class="flex-grow-1">
                <strong>🔥 Акции:</strong>
                @foreach($news->take(1) as $item)
                    <a href="{{ route('news.show', $item) }}" class="ms-2 text-decoration-none text-dark fw-medium">
                        {{ \Str::limit($item->title, 50) }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Заголовок и сортировка (можно добавить позже) -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Все товары</h1>
        <small class="text-muted">{{ $products->total() }} товаров</small>
    </div>

    <!-- Сетка товаров -->
    @if($products->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Товары не найдены</p>
        </div>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            @foreach($products as $product)
                <div class="col">
                    @include('components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection