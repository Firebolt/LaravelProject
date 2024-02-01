<?php

use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/create', 'App\Http\Controllers\ProductController@create');
Route::post('/', 'App\Http\Controllers\ProductController@store');
Route::get('/{id}', 'App\Http\Controllers\ProductController@show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';