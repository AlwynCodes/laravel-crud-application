<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect('/product');
    })->name('dashboard');

    // Admin-only management routes (before the wildcard routes).
    Route::middleware('admin')->group(function () {
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    // Everyone signed in can browse.
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
});

require __DIR__.'/auth.php';