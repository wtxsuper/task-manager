<?php

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
    Route::get('/user/{id}', 'info');
    Route::delete('/user/{id}', 'delete');
});

Route::controller(WorkspaceController::class)->group(function () {
    Route::post('/workspaces/', 'create');
    Route::put('/workspaces/{id}', 'update');
    Route::get('/workspaces/{id}', 'info');
    Route::delete('/workspaces/{id}', 'delete');
});
