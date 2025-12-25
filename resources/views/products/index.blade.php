@extends('layouts.app')

@section('content')
<h1 class="mb-4">Все товары</h1>

<form class="card card-body mb-4">
    <div class="row g-2">
        <div class="col-md-5">
            <input name="q" value="{{ request('q') }}"
                   class="form-control"
                   placeholder="Поиск товара">
        </div>
        <div class="col-md-3">
            <input name="min_price" type="number"
                   placeholder="Цена от"
                   class="form-control">
        </div>
        <div class="col-md-3">
            <input name="max_price" type="number"
                   placeholder="Цена до"
                   class="form-control">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100">OK</button>
        </div>
    </div>
</form>

<div class="row g-4">
@foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        @include('components.product-card', ['product'=>$product])
    </div>
@endforeach
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
