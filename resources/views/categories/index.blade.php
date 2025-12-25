@extends('layouts.app')

@section('content')
<h1 class="mb-4">Категории</h1>

<div class="row g-3">
@foreach($categories as $category)
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('categories.show', $category) }}"
           class="card text-decoration-none shadow-sm h-100">
            <div class="card-body">
                <h5 class="mb-1">{{ $category->name }}</h5>
                <span class="text-muted small">
                    {{ $category->products_count }} товаров
                </span>
            </div>
        </a>
    </div>
@endforeach
</div>
@endsection
