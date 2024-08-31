<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyOfficesController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicationPriceController;
use App\Http\Controllers\Api\ApplicationWorkerController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(["middleware" => "guest"], function (){
   Route::post("/auth", [AuthController::class, "login"])->name("login");
});

Route::group(["middleware" => "auth:sanctum"], function (){
    Route::resource("users", UsersController::class);
    Route::resource("offices", CompanyOfficesController::class);
});


Route::middleware('auth:api')->group(function () {

    Route::post('/api/applications/{application_id}/prices', [ApplicationPriceController::class, 'storeOrUpdate']);

    
    Route::post('/api/employees', [ApplicationWorkerController::class, 'store']);
});
