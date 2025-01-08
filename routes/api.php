<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CongresoController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/
Route::post('/login', [AuthController::class, 'login']);

app(Router::class)->aliasMiddleware('xample', Authenticate::class);

Route::middleware(['xample'])->group(function(){
    Route::apiResource('user', UserController::class);
    Route::apiResource('topic', TopicController::class);
    Route::apiResource('attendance', AttendanceController::class);
    Route::apiResource('congreso', CongresoController::class);
});

