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

    Route::group(['prefix' => 'workers', 'as' => 'workers-'], function () {
        Route::get('/', [WorkersController::class, 'index'])->name('index');
        Route::get('/{id}', [WorkersController::class, 'show'])->name('show');
        Route::post('/', [WorkersController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'services', 'as' => 'services-'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
    });
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/request', [\App\Http\Controllers\RequestsController::class, 'index'])->name('request');
});
