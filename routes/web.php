<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    Artisan::call('cache:clear');
//    Artisan::call('config:clear');
//    Artisan::call('config:cache');
//    echo 'Config Cached';
//});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
