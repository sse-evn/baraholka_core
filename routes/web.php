<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\FavoriteController;

// Главная
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Категории
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Новости
Route::get('/news', function () {
    $news = \App\Models\News::where('is_published', true)
        ->latest()
        ->paginate(6);
    return view('pages.news', compact('news'));
})->name('news.index');

// Регистрация и авторизация
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])
    ->name('favorites.toggle')
    ->middleware('auth');});
