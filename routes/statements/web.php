<?php

use App\Statements\Http\Controllers\StatementsController;
use Illuminate\Support\Facades\Route;

Route::prefix('statements')->middleware('auth')->group(function () {
    Route::get('/', [StatementsController::class, 'index'])->name('statements');
    Route::get('/{statement}', [StatementsController::class, 'show'])->where('id', '[0-9]+')->name('statements.show');
    Route::post('/', [StatementsController::class, 'redirectToFilteredAndSortedPage'])->name('statements');
});
