<div class="card h-100 shadow-sm position-relative overflow-hidden">
    @auth
        <form action="{{ route('favorites.toggle', $product) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2" title="В избранное">
                @if(auth()->user()->favorites->contains($product->id))
                    ❤️
                @else
                    🤍
                @endif
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2" title="В избранное">
            🤍
        </a>
    @endauth

    <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : 'https://randomuser.me/api/portraits/lego/1.jpg' }}"
         class="card-img-top"
         style="height:160px; object-fit:cover;">

    <div class="card-body d-flex flex-column p-3">
        <h6 class="mb-1 fw-bold">{{ \Str::limit($product->name, 35) }}</h6>
        <span class="text-muted small mb-2">{{ $product->category?->name }}</span>

        @if(method_exists($product, 'averageRating') && $product->averageRating() > 0)
            <div class="d-flex align-items-center mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star-fill {{ $i <= round($product->averageRating()) ? 'text-warning' : 'text-secondary' }} me-1" style="font-size:0.8rem;"></i>
                @endfor
            </div>
        @endif

        <div class="mt-auto">
            <div class="fw-bold text-success mb-2">
                {{ number_format($product->price, 0, ' ', ' ') }} ₸
            </div>
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100 btn-sm">
                Подробнее
            </a>
        </div>
    </div>
</div>