<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
   return \Illuminate\Support\Facades\Hash::make("12345678");
});
