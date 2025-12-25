<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function toggle(Product $product, Request $request): JsonResponse
    {
        $user = $request->user(); 
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $favorites = $user->favorites()->pluck('product_id')->toArray();

        if (in_array($product->id, $favorites)) {
            $user->favorites()->detach($product->id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorites()->attach($product->id);
            return response()->json(['status' => 'added']);
        }
    }
    
}
