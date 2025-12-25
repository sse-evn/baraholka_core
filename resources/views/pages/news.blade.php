@extends('layouts.app')

@section('content')
<h1 class="mb-4">Новости</h1>

<div class="row g-4">
    @foreach($news as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                @if($item->image_url)
                    <img src="{{ asset('storage/'.$item->image_url) }}"
                         class="card-img-top"
                         style="height:180px; object-fit:cover">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="text-muted small">
                        {{ $item->created_at->format('d.m.Y') }}
                    </p>
                    <p class="card-text">
                        {{ \Str::limit(strip_tags($item->content), 120) }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $news->links() }}
</div>
@endsection
