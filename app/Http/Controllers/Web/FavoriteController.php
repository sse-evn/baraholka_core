<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Product $product, Request $request)
    {
        $user = $request->user();
        $favorites = $user->favorites()->pluck('product_id')->toArray();

        if(in_array($product->id, $favorites)){
            $user->favorites()->detach($product->id);
            $added = false;
        } else {
            $user->favorites()->attach($product->id);
            $added = true;
        }

        return response()->json(['added' => $added]);
    }
}
