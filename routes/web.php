<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/categories/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');

    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/create', [ProductController::class, 'create'])
    ->middleware(['auth', 'role'])
    ->name('products.create');
Route::post('/', [ProductController::class, 'store'])->name('products.store');
Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

