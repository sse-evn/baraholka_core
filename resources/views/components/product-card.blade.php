<div class="card h-100 shadow-sm position-relative">

    {{-- Кнопка избранного --}}
    @auth
        <button class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2 favorite-btn" 
                data-id="{{ $product->id }}">
            {{ auth()->user()->favorites->contains($product->id) ? '❤️' : '🤍' }}
        </button>
    @else
        <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2">
            🤍
        </a>
    @endauth

    {{-- Изображение --}}
<img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://randomuser.me/api/portraits/lego/1.jpg' }}"
     class="card-img-top"
     style="height:180px; object-fit:cover">

    {{-- Содержание --}}
    <div class="card-body d-flex flex-column">
        <h6 class="mb-1">{{ \Str::limit($product->name, 40) }}</h6>
        <span class="text-muted small mb-2">{{ $product->category?->name }}</span>

        <div class="mt-auto">
            <div class="fw-bold text-success mb-2">
                {{ number_format($product->price, 0, ',', ' ') }} ₸
            </div>
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                Подробнее
            </a>
        </div>
    </div>
</div>
