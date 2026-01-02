<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>БарахолЧа</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { background:#f8f9fa; }
        .card { border-radius:16px; border:none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .price { font-weight:700; font-size:1.1rem; }
        .navbar-brand { font-weight: 800; color: #4361ee; }
        .btn-sm { border-radius: 8px; }
        .sticky-filters {
            position: sticky;
            top: 80px;
            z-index: 1000;
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }
        @media (max-width: 767px) {
            .sticky-filters { top: 70px; }
        }
        .region-select {
            min-width: 160px;
            font-size: 0.875rem;
        }
    .nav-link i {
        transition: transform 0.2s;
    }
    .nav-link:hover i {
        transform: scale(1.1);
    }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">БарахолЧа</a>

        <!-- Кнопка для мобильных -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('home') }}">Товары</a>
                <a class="nav-link" href="{{ route('categories.index') }}">Категории</a>
                <a class="nav-link" href="{{ route('news.index') }}">Новости</a>
            </div>

            <div class="d-flex align-items-center">
                <!-- Регион -->
                <form method="POST" action="{{ route('region.set') }}" class="me-2">
                    @csrf
                    <select name="region_id" onchange="this.form.submit()" class="form-select form-select-sm region-select">
                        <option value="">Регион</option>
                        @foreach(\App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}" {{ session('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

@auth
    <!-- Корзина -->
    <a class="nav-link position-relative me-2" href="{{ route('cart.index') }}">
        <i class="bi bi-cart-fill fs-4 text-dark"></i>
        @php
            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
        @endphp
        @if($cartCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
            </span>
        @endif
    </a>

    <!-- Профиль -->
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4 text-dark"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile') }}">Мой профиль</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                    @csrf
                    <button type="submit" class="btn w-100 text-start">Выйти</button>
                </form>
            </li>
        </ul>
    </div>
@else
    <a class="nav-link" href="{{ route('login') }}">
        <i class="bi bi-box-arrow-in-right fs-4 text-dark"></i>
    </a>
@endauth
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

<footer class="text-center text-muted py-4 small">
    © {{ date('Y') }} БарахолЧа
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>