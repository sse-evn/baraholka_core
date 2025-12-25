<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->merge(['user_id' => $request->user()->id]);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;
        $itemsData = [];
        foreach ($request->items as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $price = $product->price;
            $total += $price * $item['quantity'];
            $itemsData[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $price,
            ];
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($itemsData as $data) {
            $order->items()->create($data);
        }

        return response()->json($order->load('items.product'), 201);
    }
}
