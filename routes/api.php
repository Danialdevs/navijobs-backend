<?php

use App\Http\Controllers\Api\ApplicationsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyOfficesController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(["middleware" => "guest"], function (){
   Route::post("/auth", [AuthController::class, "login"])->name("login");
});
Route::group(["middleware" => "auth:sanctum"], function (){
    Route::resource("users", UsersController::class);
    Route::resource("offices", CompanyOfficesController::class);

    Route::get('applications/office/{office_id}', [ApplicationsController::class, 'getApplicationsByOffice']);
    Route::get('applications/company/{company_id}', [ApplicationsController::class, 'getApplicationsByCompany']);
    Route::get('applications/{application_id}', [ApplicationsController::class, 'getApplication']);
    Route::get('applications/{applications_id}/status', [ApplicationsController::class, 'updateApplicationStatus']);
});
