<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\RoomReservationController;
use App\Http\Controllers\Api\MaterialLoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación (públicas)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas con autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Gestión de Aulas
    Route::apiResource('rooms', RoomController::class);

    // Gestión de Materiales
    Route::apiResource('materials', MaterialController::class);

    // Gestión de Reservas de Aulas
    Route::apiResource('room-reservations', RoomReservationController::class);

    // Gestión de Préstamos de Material
    Route::apiResource('material-loans', MaterialLoanController::class);
});
