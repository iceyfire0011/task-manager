<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Task\TaskController;
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

Route::prefix('auth')->group(function ($router) {
    $router->post('login', [AuthController::class, 'login']);
    $router->post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth:api'])->group(function ($router) {
    Route::prefix('task')->group(function () {
        Route::post('create', [TaskController::class, 'create']);
        Route::get('list', [TaskController::class, 'list']);
        Route::put('update/{id}', [TaskController::class, 'update']);
        Route::get('view/{id}', [TaskController::class, 'view']);
        Route::delete('delete/{id}', [TaskController::class, 'delete']);
    });
    $router->prefix('auth')->group(function ($router) {
        $router->post('logout', [AuthController::class, 'logout']);
    });
});
