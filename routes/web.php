<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;



Route::get('/', function () {
    return view('auth.auth');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
    Route::post('/characters/favorite/{id}', [CharacterController::class, 'toggleFavorite'])
        ->name('characters.toggleFavorite');
    Route::get('/favorites', [CharacterController::class, 'showFavorites'])->name('favorites.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
