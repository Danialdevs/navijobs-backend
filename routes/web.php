<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'AuthPage'])->name('auth-page');
    Route::post('/', [AuthController::class, 'AuthAction'])->name('auth-action');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [DashboardController::class, 'HomePage'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'workers', 'as' => 'workers-'], function () {
        Route::get('/', [WorkersController::class, 'index'])->name('index');
        Route::get('/{id}', [WorkersController::class, 'show'])->name('show');
        Route::put('/{id}', [WorkersController::class, 'update'])->name('update');
        Route::delete('/{id}', [WorkersController::class, 'destroy'])->name('destroy');
        Route::post('/', [WorkersController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'services', 'as' => 'services-'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'requests', 'as' => 'request-'], function () {
        Route::get('/request', [\App\Http\Controllers\RequestsController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\RequestsController::class, 'show'])->name('show');
        Route::put('/{id}', [\App\Http\Controllers\RequestsController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\RequestsController::class, 'destroy'])->name('destroy');
        Route::post('/', [\App\Http\Controllers\RequestsController::class, 'store'])->name('store');
        Route::post('/{id}/change-status', [\App\Http\Controllers\RequestsController::class, 'changeStatus'])->name('change-status');
        Route::post('/{id}/assign-worker', [\App\Http\Controllers\RequestsController::class, 'assignWorker'])->name('assign-worker');


    });
    Route::get('/report', [ReportController::class, 'index'])->name('report');




    Route::get('/bot', [\App\Http\Controllers\TelegramBotController::class, 'handle']);




});
