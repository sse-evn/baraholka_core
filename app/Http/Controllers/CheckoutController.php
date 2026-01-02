<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request; // ← ОБЯЗАТЕЛЬНО!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\OrderPlaced;

class CheckoutController extends Controller
{
    /**
     * Показать страницу оформления заказа
     */
   public function show(): View|RedirectResponse
{
    $cartItems = Cart::with('product')
        ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
        ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
    }

    $pickupPoints = PickupPoint::where('is_active', true)->get();
    $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

    return view('checkout.index', compact('cartItems', 'pickupPoints', 'total'));
}
    /**
     * Создать заказ и перейти к оплате
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pickup_point_id' => 'required|exists:pickup_points,id',
        ]);

        $cartItems = Cart::with('product')
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Корзина пуста.']);
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'pickup_point_id' => $request->pickup_point_id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Очистка корзины
        Cart::when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->delete();

        // Отправка email
        if (Auth::check()) {
            Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
        }

        // Перенаправляем на страницу оплаты (или успеха, если без оплаты)
        return redirect()->route('checkout.success', ['order' => $order->id]);
    }

    /**
     * Страница "Заказ оформлен"
     */
public function success(Order $order): View
{
    $pickupPoints = PickupPoint::where('is_active', true)->get();
    $selectedPoint = $order->pickupPoint; // ← связь должна быть в модели Order

    return view('checkout.success', compact('order', 'pickupPoints', 'selectedPoint'));
}
}