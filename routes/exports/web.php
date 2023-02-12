<?php

use App\Export\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export', [ExportController::class, 'export'])->name('export.save');
    Route::post('/export/{id}/download', [ExportController::class, 'download'])->name('export.download');
});
