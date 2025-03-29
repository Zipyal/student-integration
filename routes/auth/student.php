<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentAuthController;

Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StudentAuthController::class, 'login']);
Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');

Route::get('/register', [StudentAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [StudentAuthController::class, 'register']);

Route::get('/forgot-password', [StudentAuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [StudentAuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [StudentAuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [StudentAuthController::class, 'reset'])->name('password.update');