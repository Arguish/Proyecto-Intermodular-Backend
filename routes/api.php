
<?php

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

// Rutas públicas
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    // Rutas públicas de material
    Route::get('/material', [\App\Http\Controllers\MaterialController::class, 'index']);
    Route::get('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'show']);
    Route::post('/material', [\App\Http\Controllers\MaterialController::class, 'store'])->middleware('role:admin,conserje');
    Route::put('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'update'])->middleware('role:admin,conserje');
    Route::delete('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->middleware('role:admin,conserje');
    // Rutas de aulas
    Route::get('/aulas', [\App\Http\Controllers\RoomController::class, 'index']);
    Route::get('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'show']);
    Route::post('/aulas', [\App\Http\Controllers\RoomController::class, 'store'])->middleware('role:admin,conserje');
    Route::put('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'update'])->middleware('role:admin,conserje');
    Route::delete('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'destroy'])->middleware('role:admin,conserje');
    // Ejemplo de ruta protegida
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
