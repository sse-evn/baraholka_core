@extends('layouts.app')

@section('content')
<h1 class="mb-4">Категории</h1>

<div class="row g-4">
@foreach($categories as $category)
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('categories.show', $category) }}" class="card text-decoration-none shadow-sm h-100 border-0">
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                <h5 class="mb-2 text-center">{{ $category->name }}</h5>
                <span class="text-muted small">{{ $category->products_count }} товаров</span>
            </div>
        </a>
    </div>
@endforeach
</div>
@endsection