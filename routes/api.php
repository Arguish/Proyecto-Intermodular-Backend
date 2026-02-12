
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

// ============================================================
// RUTAS PÚBLICAS (sin autenticación)
// ============================================================
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Material - Consulta pública
Route::get('/material', [\App\Http\Controllers\MaterialController::class, 'index']);
Route::get('/material/search', [\App\Http\Controllers\MaterialController::class, 'search']);
Route::get('/material/barcode/{barcode}', [\App\Http\Controllers\MaterialController::class, 'findByBarcode']);
Route::get('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'show']);

// ============================================================
// RUTAS PROTEGIDAS (requieren autenticación con Sanctum)
// ============================================================
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Autenticación
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
    
    // ============================================================
    // USUARIOS - Solo ADMIN
    // ============================================================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
        Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    });
    
    // ============================================================
    // MATERIAL - Gestión (solo admin/conserje)
    // ============================================================
    Route::middleware(['role:admin,conserje'])->group(function () {
        Route::post('/material', [\App\Http\Controllers\MaterialController::class, 'store']);
        Route::put('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'update']);
        Route::delete('/material/{id}', [\App\Http\Controllers\MaterialController::class, 'destroy']);
    });
    
    // ============================================================
    // AULAS - Consulta (todos), Gestión (admin/conserje)
    // ============================================================
    Route::get('/aulas', [\App\Http\Controllers\RoomController::class, 'index']);
    Route::get('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'show']);
    
    Route::middleware(['role:admin,conserje'])->group(function () {
        Route::post('/aulas', [\App\Http\Controllers\RoomController::class, 'store']);
        Route::put('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'update']);
        Route::delete('/aulas/{id}', [\App\Http\Controllers\RoomController::class, 'destroy']);
    });
    
    // ============================================================
    // RESERVAS - Todos autenticados pueden gestionar sus reservas
    // ============================================================
    Route::get('/reservas', [\App\Http\Controllers\ReservationController::class, 'index']);
    Route::get('/reservas/{id}', [\App\Http\Controllers\ReservationController::class, 'show']);
    Route::post('/reservas', [\App\Http\Controllers\ReservationController::class, 'store']);
    Route::put('/reservas/{id}', [\App\Http\Controllers\ReservationController::class, 'update']);
    Route::post('/reservas/{id}/cancel', [\App\Http\Controllers\ReservationController::class, 'cancel']);
    Route::delete('/reservas/{id}', [\App\Http\Controllers\ReservationController::class, 'destroy']);
    
    // Devolución de material (solo admin/conserje)
    Route::middleware(['role:admin,conserje'])->group(function () {
        Route::post('/reservas/{id}/devolver', [\App\Http\Controllers\ReservationController::class, 'devolver']);
    });
});
