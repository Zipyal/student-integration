<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AdmissionController,
    StudentController,
    UniversityController,
    ApplicationController,
    NewsController
};

/*
|--------------------------------------------------------------------------
| Основные маршруты
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('cache.headers:public;max_age=3600'); // Кэширование на 1 час

/*
|--------------------------------------------------------------------------
| Маршруты для поступающих
|--------------------------------------------------------------------------
*/
Route::prefix('admission')
    ->name('admission.') // Префикс для имен маршрутов
    ->middleware(['throttle:admission']) // Ограничение запросов
    ->group(function () {
        
    // Информационные страницы
    Route::get('/', [AdmissionController::class, 'index'])
        ->name('index')
        ->middleware('do_not_cache'); // Отключаем кэш для динамического контента

    Route::get('/requirements', [AdmissionController::class, 'requirements'])
        ->name('requirements')
        ->middleware('do_not_cache');

    Route::get('/documents', [AdmissionController::class, 'documents'])
        ->name('documents')
        ->middleware('do_not_cache');

    Route::get('/deadlines', [AdmissionController::class, 'deadlines'])
        ->name('deadlines')
        ->middleware('do_not_cache');

    // Обработка заявок
    Route::prefix('applications')
        ->name('applications.')
        ->controller(ApplicationController::class)
        ->group(function () {
            Route::get('/create', 'create')
                ->name('create')
                ->middleware('signed'); // Защита подписанным URL

            Route::post('/', 'store')
                ->name('store')
                ->middleware('throttle:3,1'); // 3 запроса в минуту

            Route::get('/{application}', 'show')
                ->name('show')
                ->middleware('can:view,application'); // Политика доступа
        });
});

/*
|--------------------------------------------------------------------------
| Маршруты университетов
|--------------------------------------------------------------------------
*/
Route::resource('universities', UniversityController::class)
    ->only(['index', 'show'])
    ->parameters(['universities' => 'university:slug']) // Используем slug вместо ID
    ->missing(function () {
        return response()->view('errors.404', [], 404);
    });

/*
|--------------------------------------------------------------------------
| Маршруты новостей
|--------------------------------------------------------------------------
*/
Route::resource('news', NewsController::class)
    ->only(['index', 'show'])
    ->scoped(['news' => 'slug']) // Используем slug
    ->missing(function () {
        return redirect()->route('news.index');
    });

/*
|--------------------------------------------------------------------------
| Личный кабинет студента (требует аутентификации)
|--------------------------------------------------------------------------
*/
Route::prefix('student')
    ->name('student.')
    ->middleware([
        'auth:student',
        'verified', // Подтвержденный email
        'student.active' // Проверка активного статуса
    ])
    ->group(function () {
        
    // Дашборд
    Route::get('/dashboard', [StudentController::class, 'dashboard'])
        ->name('dashboard');

    // Расписание
    Route::get('/schedule', [StudentController::class, 'schedule'])
        ->name('schedule')
        ->middleware('cache:private;max_age=300'); // Кэш 5 минут

    // Документы
    Route::prefix('documents')
        ->name('documents.')
        ->controller(StudentController::class)
        ->group(function () {
            Route::get('/', 'documentsIndex')
                ->name('index');
                
            Route::get('/download/{document}', 'downloadDocument')
                ->name('download')
                ->middleware('signed');
        });

    // Техподдержка
    Route::prefix('support')
        ->name('support.')
        ->controller(StudentController::class)
        ->group(function () {
            Route::get('/', 'supportIndex')
                ->name('index');
                
            Route::post('/ticket', 'createTicket')
                ->name('create')
                ->middleware('throttle:2,1'); // 2 запроса в минуту
        });
});

/*
|--------------------------------------------------------------------------
| Аутентификация студентов
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth/student.php';

/*
|--------------------------------------------------------------------------
| Дополнительные сервисные маршруты
|--------------------------------------------------------------------------
*/
Route::prefix('api')
    ->name('api.')
    ->middleware(['api', 'auth:sanctum'])
    ->group(base_path('routes/api.php'));

// Health-чек для мониторинга
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
})->name('health.check');