@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        @else
            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                <span class="text-muted">Нет изображения</span>
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <h1>{{ $product->name }}</h1>
        <p class="text-muted">Категория: {{ $product->category?->name }}</p>
        <p class="h3 text-success">{{ number_format($product->price, 0, ',', ' ') }} ₸</p>
        <p>{!! nl2br(e($product->description)) !!}</p>

        @if($product->seller)
            <hr>
            <h5>Продавец:</h5>
            <p><strong>{{ $product->seller->name }}</strong></p>
            @if($product->seller->contact_email)
                <p>Email: {{ $product->seller->contact_email }}</p>
            @endif
        @endif

        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Назад к товарам</a>
    </div>
</div>
@endsection