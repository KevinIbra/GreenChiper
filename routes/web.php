<?php

use App\Http\Controllers\SteganographyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SteganographyController::class, 'index'])->name('home');
Route::post('/steganography/encode', [SteganographyController::class, 'encode'])->name('steganography.encode');
Route::post('/steganography/decode', [SteganographyController::class, 'decode'])->name('steganography.decode');
Route::get('/download/{filename}', [SteganographyController::class, 'download'])
    ->name('steganography.download')
    ->where('filename', '.*');
Route::get('/download/{path}', [SteganographyController::class, 'download'])
    ->name('steganography.download')
    ->where('path', '.*');
