<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::with('category', 'seller')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->paginate(20);

        return response()->json($products);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::with('category', 'seller')
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json($product);
    }
    
}
