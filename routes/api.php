<?php

use Illuminate\Support\Facades\Route;
use App\Statements\Http\Controllers\api\ApiStatementsController;
//->middleware('auth.token') Добавить обратно, если заработает
Route::prefix('/statements')->middleware('auth.token')->group(function () {
    Route::post('/get', [ApiStatementsController::class, 'getFilteredStatements']);
    Route::post('/', [ApiStatementsController::class, 'store']);
    Route::get('/{statement}', [ApiStatementsController::class, 'show'])->where('statement', '[0-9]+');
});

//->middleware('auth.token') Добавить обратно, если заработает
Route::prefix('/xAPI/statements')->group(function () {
    Route::post('', [ApiStatementsController::class, 'storeV2']);
    Route::get('', [ApiStatementsController::class, 'indexV2']);
});


