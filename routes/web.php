<?php

use App\Statements\Http\Controllers\StatementsController;
use Illuminate\Support\Facades\Route;
//вернуть потом ->middleware('auth')

Route::get('/', [StatementsController::class, 'index']);
