<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Поступление
Route::prefix('admission')->group(function () {
    Route::get('/', [AdmissionController::class, 'index'])->name('admission.index');
    Route::get('/requirements', [AdmissionController::class, 'requirements'])->name('admission.requirements');
    Route::get('/documents', [AdmissionController::class, 'documents'])->name('admission.documents');
    Route::get('/deadlines', [AdmissionController::class, 'deadlines'])->name('admission.deadlines');
    
    // Заявки
    Route::resource('applications', ApplicationController::class)->only(['create', 'store', 'show']);
});

// Университеты
Route::resource('universities', UniversityController::class)->only(['index', 'show']);

// Новости
Route::resource('news', NewsController::class)->only(['index', 'show']);

// Для текущих студентов
Route::prefix('student')->middleware(['auth:student'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/schedule', [StudentController::class, 'schedule'])->name('student.schedule');
    Route::get('/documents', [StudentController::class, 'documents'])->name('student.documents');
    Route::get('/support', [StudentController::class, 'support'])->name('student.support');
});

// Аутентификация студентов
require __DIR__.'/auth/student.php';