<?php

use App\Http\Controllers\SteganographyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatasetController;

Route::get('/', [SteganographyController::class, 'index'])->name('home');
Route::post('/steganography/encode', [SteganographyController::class, 'encode'])->name('steganography.encode');
Route::post('/steganography/decode', [SteganographyController::class, 'decode'])->name('steganography.decode');
Route::get('/download/{filename}', [SteganographyController::class, 'download'])
    ->name('steganography.download')
    ->where('filename', '.*');
Route::get('/download/{path}', [SteganographyController::class, 'download'])
    ->name('steganography.download')
    ->where('path', '.*');

Route::prefix('datasets')->group(function () {
    Route::get('/', [DatasetController::class, 'index'])->name('datasets.index');
    Route::post('/process', [DatasetController::class, 'process'])->name('datasets.process');
    Route::get('/metrics', [DatasetController::class, 'metrics'])->name('datasets.metrics');
});
