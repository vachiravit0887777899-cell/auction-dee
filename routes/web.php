<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $endingSoon = Product::where('status', 'active')
        ->withCount('bids')
        ->orderBy('ends_at')
        ->limit(4)
        ->get();

    $recentlyAdded = Product::where('status', 'active')
        ->withCount('bids')
        ->latest()
        ->limit(4)
        ->get();

    $stats = [
        'products' => Product::where('status', 'active')->count(),
        'users' => User::count(),
        'sold' => Product::where('status', 'ended')->whereNotNull('winner_id')->count(),
    ];

    return view('welcome', compact('endingSoon', 'recentlyAdded', 'stats'));
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ===== Products & Bidding =====
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/products-create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}/bid', [ProductController::class, 'bid'])->name('products.bid');
});

// ===== Admin Panel =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::patch('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
});
Route::get('/cron/close-expired-auctions/{secret}', function (string $secret) {
    if ($secret !== config('app.cron_secret')) {
        abort(403);
    }

    \Illuminate\Support\Facades\Artisan::call('auctions:close-expired');

    return response()->json(['status' => 'ok', 'output' => \Illuminate\Support\Facades\Artisan::output()]);
});