<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CongresoController;
use App\Http\Middleware\Authenticate;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

app(Router::class)->aliasMiddleware('xample', Authenticate::class);
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::prefix('api')->group(function () {
    

    // // Route::middleware(['xample'])->group(function () {
    // Route::get('/user', [UserController::class, 'index']);
    // Route::get('/user/{user}', [UserController::class, 'get']);
    // Route::post('/user', [UserController::class, 'create']);
    // Route::put('/user/{user}', [UserController::class, 'update']);
    // Route::delete('/user/{user}', [UserController::class, 'destroy']);

    // Route::get('/topic', [TopicController::class, 'index']);
    // Route::get('/topic/{topic}', [TopicController::class, 'get']);
    // Route::post('/topic', [TopicController::class, 'create']);
    // Route::put('/topic/{topic}', [TopicController::class, 'update']);
    // Route::delete('/topic/{topic}', [TopicController::class, 'destroy']);

    // Route::get('/attendance', [AttendanceController::class, 'index']);
    // Route::get('/attendance/{attendance}', [AttendanceController::class, 'get']);
    // Route::post('/attendance', [AttendanceController::class, 'create']);
    // Route::put('/attendance/{attendance}', [AttendanceController::class, 'update']);
    // Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy']);

    // Route::get('/congreso', [CongresoController::class, 'index']);
    // Route::get('/congreso/{congreso}', [CongresoController::class, 'get']);
    // Route::post('/congreso', [CongresoController::class, 'create']);
    // Route::put('/congreso/{congreso}', [CongresoController::class, 'update']);
    // Route::delete('/congreso/{congreso}', [CongresoController::class, 'destroy']);
    //});
});
