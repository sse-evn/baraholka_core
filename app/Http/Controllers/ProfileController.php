<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(5);

        $favorites = $user->favorites; 

        $reviews = \App\Models\Review::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();

        return view('profile.index', compact('user', 'orders', 'favorites', 'reviews'));
    }
}