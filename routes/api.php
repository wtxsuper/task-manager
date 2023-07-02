<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function () {
    Route::post('/user/', 'create');
    Route::put('/user/{user}', 'update');
    Route::get('/user/{user}', 'info');
    Route::delete('/user/{user}', 'delete');
});

Route::controller(WorkspaceController::class)->group(function () {
    Route::post('/workspace/', 'create');
    Route::put('/workspace/{workspace}', 'update');
    Route::get('/workspace/{workspace}', 'info');
    Route::delete('/workspace/{workspace}', 'delete');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/task/', 'create');
    Route::put('/task/{task}', 'update');
    Route::get('/task/{task}', 'info');
    Route::delete('/task/{task}', 'delete');
});
