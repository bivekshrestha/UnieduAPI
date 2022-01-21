<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//
//Route::middleware('auth:sanctum')
//    ->get('/user', [AuthController::class, 'user']);

require_once 'api-admin.php';
require_once 'api-app.php';

Route::get('/user', [AuthController::class, 'user']);

Route::get('pricing', [PackageController::class, 'get']);
