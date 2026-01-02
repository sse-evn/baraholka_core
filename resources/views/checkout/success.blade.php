@extends('layouts.app')

@section('content')
<div class="py-5 text-center">
    <h2>Заказ успешно оформлен!</h2>
    <p class="text-success">Спасибо за покупку. Письмо отправлено на вашу почту.</p>

    <div class="mt-4">
        <h5>Отслеживание заказа</h5>
        <div id="map" style="height: 200px; border-radius: 8px; margin: 1rem auto; max-width: 600px;"></div>
        <p class="text-muted mt-2">Заказ будет обработан в ближайшее время</p>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary">Продолжить покупки</a>
    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Мой профиль</a>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const map = L.map('map').setView([43.238949, 76.889709], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([43.238949, 76.889709]).addTo(map)
            .bindPopup('Пункт выдачи заказов').openPopup();
    });
</script>
@endsection