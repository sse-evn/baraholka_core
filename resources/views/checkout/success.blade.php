@extends('layouts.app')

@section('content')
<div class="py-5 text-center">
    <h2>Заказ успешно оформлен!</h2>
    <p class="text-success">Спасибо за покупку. Письмо отправлено на вашу почту.</p>

    @if($pickupPoints->isNotEmpty())
        <div class="mt-4">
            <h5>Пункты выдачи заказа</h5>
            <div id="map" style="height: 250px; border-radius: 8px; margin: 1rem auto; max-width: 700px; border: 1px solid #ddd;"></div>
            <p class="text-muted mt-2">Выберите удобный пункт для получения заказа</p>
        </div>
    @else
        <p class="text-muted">Пункты выдачи временно недоступны.</p>
    @endif

    <a href="{{ route('home') }}" class="btn btn-primary">Продолжить покупки</a>
    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Мой профиль</a>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if($pickupPoints->isNotEmpty())
            const firstPoint = @json($pickupPoints->first()->getCoordinates());
            const map = L.map('map').setView(firstPoint, 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const points = @json($pickupPoints->map(fn($p) => [
                'name' => $p->name,
                'address' => $p->address,
                'coords' => $p->getCoordinates()
            ]));

            points.forEach(point => {
                const marker = L.marker(point.coords).addTo(map);
                marker.bindPopup(`<strong>${point.name}</strong><br>📍 ${point.address}`);
            });
        @endif
    });
</script>
@endsection