@extends('layouts.app')

@section('content')
<h1>Категории</h1>

@if($categories->isEmpty())
    <p class="text-muted">Нет категорий.</p>
@else
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                {{ $category->name }}
                <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
            </a>
        @endforeach
    </div>
@endif

<a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Назад к товарам</a>
@endsection