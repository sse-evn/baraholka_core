<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class CheckoutController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $cartItems = Cart::with('product')
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(): RedirectResponse
    {
        $cartItems = Cart::with('product')
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['Корзина пуста']);
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
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

        Cart::when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->delete();

        // Отправка email
        Mail::to(Auth::user()->email)->send(new OrderPlaced($order));

        return redirect()->route('checkout.success', ['order' => $order->id]);
    }

    public function success(): View
    {
    $pickupPoints = PickupPoint::where('is_active', true)->get();

    return view('checkout.success', compact('pickupPoints'));

    }
}