<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkspaceController;
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

Route::controller(UserController::class)->group(function () {
    Route::post('/users/', 'create');
    Route::put('/users/{user}', 'update');
    Route::get('/users/{user}', 'info');
    Route::delete('/users/{user}', 'delete');
    Route::get('/users/{user}/workspaces/', 'getWorkspace');
    Route::get('/users/{user}/projects/', 'getProject');
    Route::get('/users/{user}/tasks/', 'getTasks');
});

Route::controller(WorkspaceController::class)->group(function () {
    Route::post('/workspaces/', 'create');
    Route::put('/workspaces/{workspace}', 'update');
    Route::get('/workspaces/{workspace}', 'info');
    Route::delete('/workspaces/{workspace}', 'delete');
    Route::get('/workspaces/{workspace}/users/', 'getUser');
    Route::post('/workspaces/{workspace}/users/', 'addUser');
    Route::delete('/workspaces/{workspace}/users/', 'removeUser');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/tasks/', 'create');
    Route::put('/tasks/{task}', 'update');
    Route::get('/tasks/{task}', 'info');
    Route::delete('/tasks/{task}', 'delete');
});

Route::controller(ProjectController::class)->group(function () {
    Route::post('/projects/', 'create');
    Route::put('/projects/{project}', 'update');
    Route::get('/projects/{project}', 'info');
    Route::delete('/projects/{project}', 'delete');
    Route::get('/projects/{project}/users/', 'getUser');
    Route::post('/projects/{project}/users/', 'addUser');
    Route::delete('/projects/{project}/users/', 'removeUser');
});
