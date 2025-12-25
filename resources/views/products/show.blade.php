@extends('layouts.app')

@section('content')
<div class="row g-4">

    <div class="col-md-6">
        <img src="{{ asset('storage/'.$product->image) }}"
             class="img-fluid rounded">
    </div>

    <div class="col-md-6">
        <h1>{{ $product->name }}</h1>

        <p class="text-muted">
            Категория:
            <a href="{{ route('categories.show',$product->category) }}">
                {{ $product->category?->name }}
            </a>
        </p>

        <p class="h3 text-success">
            {{ number_format($product->price,0,' ',' ') }} ₸
        </p>

        <p>{!! nl2br(e($product->description)) !!}</p>

        @if($product->seller)
            <div class="card mt-4">
                <div class="card-body">
                    <strong>{{ $product->seller->name }}</strong><br>
                    {{ $product->seller->contact_email }}
                </div>
            </div>
        @endif

        <a href="{{ route('home') }}"
           class="btn btn-secondary mt-4">
            ← Назад
        </a>
    </div>
</div>
@endsection
