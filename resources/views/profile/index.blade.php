@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Личный кабинет</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">← К покупкам</a>
    </div>

    <div class="row g-4">
        <!-- Данные -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px; height:80px; font-size:2rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'success' : ($user->role === 'seller' ? 'warning' : 'secondary') }}">
                        @switch($user->role)
                            @case('admin') Админ @break
                            @case('seller') Продавец @break
                            @default Покупатель
                        @endswitch
                    </span>
                </div>
            </div>
        </div>

        <!-- Вкладки: заказы, избранное, отзывы -->
        <div class="col-lg-8">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#orders">Заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#favorites">Избранное</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">Мои отзывы</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Заказы -->
                <div class="tab-pane fade show active" id="orders">
                    @if($orders->isEmpty())
                        <div class="alert alert-light">Нет заказов</div>
                    @else
                        @foreach($orders as $order)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Заказ №{{ $order->id }}</strong><br>
                                            <small>{{ $order->created_at->format('d.m.Y') }}</small>
                                        </div>
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                            @switch($order->status)
                                                @case('pending') Ожидает @break
                                                @case('confirmed') Подтверждён @break
                                                @case('shipped') Отправлен @break
                                                @case('delivered') Доставлен @break
                                                @case('cancelled') Отменён @break
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        @foreach($order->orderItems as $item)
                                            <div>{{ Str::limit($item->product->name, 25) }} × {{ $item->quantity }}</div>
                                        @endforeach
                                    </div>
                                    <div class="mt-2 fw-bold">{{ number_format($order->total, 0, ' ', ' ') }} ₸</div>
                                </div>
                            </div>
                        @endforeach
                        {{ $orders->links() }}
                    @endif
                </div>

                <!-- Избранное -->
                <div class="tab-pane fade" id="favorites">
                    @if($favorites->isEmpty())
                        <div class="alert alert-light">Нет избранных товаров</div>
                    @else
                        <div class="row g-3">
                            @foreach($favorites as $product)
                                <div class="col-6 col-md-4">
                                    @include('components.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Отзывы -->
                <div class="tab-pane fade" id="reviews">
                    @if($reviews->isEmpty())
                        <div class="alert alert-light">Вы ещё не оставляли отзывов</div>
                    @else
                        @foreach($reviews as $review)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $review->product->name }}</strong>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star-fill {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                            @endfor>
                                        </div>
                                    </div>
                                    <p class="mt-2 mb-1">{{ $review->comment }}</p>
                                    <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection