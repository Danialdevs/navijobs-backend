<?php

use App\Http\Controllers\Api\AuthController;
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
});
