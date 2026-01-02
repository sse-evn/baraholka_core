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
    $regionId = session('region_id');

    $products = Product::with(['category', 'seller'])
        ->when($regionId, fn ($q) => $q->whereHas('seller', fn($sq) => $sq->where('region_id', $regionId)))
        ->when($request->q, fn ($q) => $q->where('name', 'like', "%{$request->q}%"))
        ->when($request->min_price, fn ($q) => $q->where('price', '>=', $request->min_price))
        ->when($request->max_price, fn ($q) => $q->where('price', '<=', $request->max_price))
        ->where('is_active', true)
        ->latest()
        ->paginate(12)
        ->withQueryString();

    // Только 1 последняя новость для всплывающей ленты
    $news = \App\Models\News::where('is_published', true)->latest()->take(1)->get();

    return view('products.index', compact('products', 'news'));
}
    public function show(Product $product): View
    {
        $product->load('category', 'seller');
        return view('products.show', compact('product'));
    }
    
}
