@extends('layouts.app')

@section('content')
<h1>Товары в категории: {{ $category->name }}</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    @foreach($products as $product)
        <div class="col">
            @include('components.product-card', ['product' => $product])
        </div>
    @endforeach
</div>

{{ $products->links() }}
@endsection
