<?php

use App\Http\Controllers\Api\ProjectController;
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
    Route::get('/user/{user}/workspaces/', 'getWorkspace');
    Route::get('/user/{user}/projects/', 'getProject');
    Route::get('/user/{user}/tasks/', 'getTasks');
});

Route::controller(WorkspaceController::class)->group(function () {
    Route::post('/workspace/', 'create');
    Route::put('/workspace/{workspace}', 'update');
    Route::get('/workspace/{workspace}', 'info');
    Route::delete('/workspace/{workspace}', 'delete');
    Route::get('/workspace/{workspace}/users/', 'getUser');
    Route::post('/workspace/{workspace}/users/', 'addUser');
    Route::delete('/workspace/{workspace}/users/', 'removeUser');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/task/', 'create');
    Route::put('/task/{task}', 'update');
    Route::get('/task/{task}', 'info');
    Route::delete('/task/{task}', 'delete');
});

Route::controller(ProjectController::class)->group(function () {
    Route::post('/project/', 'create');
    Route::put('/project/{project}', 'update');
    Route::get('/project/{project}', 'info');
    Route::delete('/project/{project}', 'delete');
    Route::get('/project/{project}/users/', 'getUser');
    Route::post('/project/{project}/users/', 'addUser');
    Route::delete('/project/{project}/users/', 'removeUser');
});
