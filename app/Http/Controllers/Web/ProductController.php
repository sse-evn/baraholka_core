<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->q, fn ($q) =>
                $q->where('name', 'like', "%{$request->q}%")
            )
            ->when($request->min_price, fn ($q) =>
                $q->where('price', '>=', $request->min_price)
            )
            ->when($request->max_price, fn ($q) =>
                $q->where('price', '<=', $request->max_price)
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load('category', 'seller');
        return view('products.show', compact('product'));
    }
}
