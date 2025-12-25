<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>БарахолЧа</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#f8f9fa; }
        .card { border-radius:16px; border:none; }
        .price { font-weight:700; font-size:1.1rem; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">БарахолЧа</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="{{ route('home') }}">Товары</a>
            <a class="nav-link" href="{{ route('categories.index') }}">Категории</a>
            <a class="nav-link" href="{{ route('news.index') }}">Новости</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

<footer class="text-center text-muted py-4 small">
    © {{ date('Y') }} БарахолЧа
</footer>

</body>
</html>
