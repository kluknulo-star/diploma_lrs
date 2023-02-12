<?php

use App\Users\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.index');
    Route::get('/{id}', [UsersController::class, 'show'])->where('id', '[0-9]+')->name('users.show');
    Route::get('/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/', [UsersController::class, 'store'])->name('users.store');
    Route::put('/{id}', [UsersController::class, 'update'])->where('id', '[0-9]+')->name('users.update');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->where('id', '[0-9]+')->name('users.edit');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->where('id', '[0-9]+')->name('users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
    Route::post('/profile', [UsersController::class, 'generateUserToken'])->name('create.token');
    Route::delete('/profile/{token}', [UsersController::class, 'deleteToken'])->name('delete.token');
});
