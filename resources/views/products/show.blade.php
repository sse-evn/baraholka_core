@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row g-4">
        <!-- Галерея -->
        <div class="col-md-6">
            <img id="main-img" src="{{ asset('storage/'.$product->image_url) }}"
                 class="img-fluid rounded mb-3"
                 alt="{{ $product->name }}"
                 style="object-fit: cover; height: 400px; width: 100%;">

            <!-- Миниатюры -->
            <div class="d-flex gap-2">
                @for($i = 1; $i <= 3; $i++)
                 <img id="main-img" src="{{ $product->image_url ?? 'https://via.placeholder.com/400?text=Нет+фото' }}"
     class="img-fluid rounded mb-3"
     alt="{{ $product->name }}"
     style="object-fit: cover; height: 400px; width: 100%;">
                @endfor
            </div>
        </div>

        <!-- Информация -->
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>

            <p class="text-muted">
                Категория: 
                <a href="{{ route('categories.show', $product->category) }}">
                    {{ $product->category?->name }}
                </a>
            </p>

            <div class="d-flex align-items-center mb-3">
                <span class="h3 text-success me-3">{{ number_format($product->price, 0, ' ', ' ') }} ₸</span>
                @if($product->reviews->isNotEmpty())
                    <div class="d-flex align-items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star-fill {{ $i <= round($product->averageRating()) ? 'text-warning' : 'text-secondary' }} me-1"></i>
                        @endfor>
                        <span class="ms-2 small">({{ $product->reviews->count() }})</span>
                    </div>
                @endif
            </div>

            <p class="mb-4">{!! nl2br(e($product->description)) !!}</p>

            <!-- Продавец -->
            @if($product->seller)
                <div class="card mb-4">
                    <div class="card-body">
                        <h6>Продавец: {{ $product->seller->shop_name }}</h6>
                        <p class="mb-1"><i class="bi bi-envelope me-2"></i> {{ $product->seller->contact_email }}</p>
                        <p class="mb-1"><i class="bi bi-telephone me-2"></i> {{ $product->seller->phone ?? '—' }}</p>
                        <p><i class="bi bi-geo-alt me-2"></i> {{ $product->seller->region?->name ?? '—' }}</p>
                    </div>
                </div>
            @endif

            <!-- Кнопки -->
            <div class="d-flex gap-2 mb-4">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary px-4">В корзину</button>
                </form>

                @auth
                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            @if(auth()->user()->favorites->contains($product->id))
                                Удалить из избранного ❤️
                            @else
                                В избранное 🤍
                            @endif
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-danger">В избранное 🤍</a>
                @endauth

                <button class="btn btn-outline-secondary" onclick="shareProduct()">
                    <i class="bi bi-share"></i>
                </button>
            </div>

            <a href="{{ route('home') }}" class="btn btn-secondary">← Назад к товарам</a>
        </div>
    </div>

    <!-- Отзывы -->
    <div class="mt-5">
        <h3>Отзывы ({{ $product->reviews->count() }})</h3>

        @if($product->reviews->isEmpty())
            <div class="alert alert-info">Пока нет отзывов.</div>
        @else
            @foreach($product->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star-fill {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor>
                            </div>
                        </div>
                        <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                        <p class="mt-2">{{ $review->comment }}</p>
                    </div>
                </div>
            @endforeach
        @endif

        @auth
            <div class="alert alert-light mt-4">
                <i>Форма добавления отзыва будет доступна позже.</i>
            </div>
        @endauth
    </div>
</div>

<script>
function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: 'Посмотрите этот товар!',
            url: window.location.href
        }).catch(console.error);
    }
}
</script>
@endsection