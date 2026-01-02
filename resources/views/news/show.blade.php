@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="card shadow-sm mb-4">
        @if($news->image_url)
            <img src="{{ asset('storage/'.$news->image_url) }}" class="card-img-top" style="height:250px; object-fit:cover;">
        @endif
        <div class="card-body">
            <h1 class="mb-3">{{ $news->title }}</h1>
            <p class="text-muted small mb-4">
                Опубликовано: {{ $news->created_at->format('d.m.Y H:i') }}
            </p>
            <div class="prose">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>
    </div>

    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">← Все новости</a>
</div>
@endsection