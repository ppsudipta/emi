<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (protected by Breeze auth + email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (already from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/loan-details', [AdminController::class, 'index'])->name('loan-details');
    Route::get('process', [AdminController::class, 'create'])->name('process.page');
    Route::post('/process', [AdminController::class, 'processData'])->name('process.do');
   
});



require __DIR__.'/auth.php';