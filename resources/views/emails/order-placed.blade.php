<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Заказ оформлен</title>
</head>
<body>
    <h2>Спасибо за покупку!</h2>
    <p>Ваш заказ №{{ $order->id }} на сумму {{ number_format($order->total, 0, ' ', ' ') }} ₸ успешно оформлен.</p>
    <p>Статус: Ожидает подтверждения</p>
    <p>Вы можете отслеживать заказ в <a href="{{ url('/profile') }}">личном кабинете</a>.</p>
    <p>С уважением, команда БарахолЧа</p>
</body>
</html>