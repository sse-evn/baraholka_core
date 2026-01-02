<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with('product')
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->when(!Auth::check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::findOrFail($request->product_id);

        $cartItem = Cart::where(function ($q) {
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id() ?? null,
                'session_id' => Auth::check() ? null : session()->getId(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function destroy(Cart $cartItem): RedirectResponse
    {
        if (Auth::check()) {
            if ($cartItem->user_id !== Auth::id()) {
                abort(403);
            }
        } else {
            if ($cartItem->session_id !== session()->getId()) {
                abort(403);
            }
        }

        $cartItem->delete();
        return back()->with('success', 'Товар удалён из корзины');
    }
}