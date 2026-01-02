<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\FavoriteController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Главная
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Категории
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Новости
Route::get('/news', function () {
    $news = \App\Models\News::where('is_published', true)->latest()->paginate(6);
    return view('pages.news', compact('news'));
})->name('news.index');

Route::get('/news/{news}', function (\App\Models\News $news) {
    if (!$news->is_published && !Auth::check()) {
        abort(404);
    }
    return view('news.show', compact('news'));
})->name('news.show');
// Авторизация
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Регион
Route::post('/set-region', [RegionController::class, 'set'])->name('region.set');

// Избранное
Route::middleware('auth')->group(function () {
        Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Корзина — доступна всем для добавления, просмотр только авторизованным
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.remove');
});

// Оформление
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

});
