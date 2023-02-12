<?php

use App\Statements\Http\Controllers\StatementsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StatementsController::class, 'index'])->middleware('auth');
