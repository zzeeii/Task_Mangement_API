<?php


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::middleware('auth:api')->group(function () {

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::put('/tasks/{id}/Status', [TaskController::class, 'updateStatus']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    
   
    Route::post('/tasks/{id}/assign', [TaskController::class, 'assign']);


    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [AuthController::class, 'register']);
