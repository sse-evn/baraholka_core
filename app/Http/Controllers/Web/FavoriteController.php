<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
public function toggle(Product $product): RedirectResponse
{
    $user = Auth::user();

    if ($user->favorites()->where('product_id', $product->id)->exists()) {
        $user->favorites()->detach($product->id);
    } else {
        $user->favorites()->attach($product->id);
    }

    return back()->with('success', 'Избранное обновлено');
}}