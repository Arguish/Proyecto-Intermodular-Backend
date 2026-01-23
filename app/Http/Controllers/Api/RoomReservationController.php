<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomReservation;
use Illuminate\Http\Request;

class RoomReservationController extends Controller
{
    /**
     * Listar todas las reservas de aulas
     */
    public function index()
    {
        $reservations = RoomReservation::with(['user', 'room'])->get();
        return response()->json($reservations);
    }

    /**
     * Crear nueva reserva de aula
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'observations' => 'nullable|string',
            'status' => 'sometimes|in:activa,finalizada,atrasada',
        ]);

        $reservation = RoomReservation::create($request->all());

        return response()->json($reservation->load(['user', 'room']), 201);
    }

    /**
     * Mostrar detalles de una reserva específica
     */
    public function show(string $id)
    {
        $reservation = RoomReservation::with(['user', 'room'])->findOrFail($id);
        return response()->json($reservation);
    }

    /**
     * Actualizar información de una reserva
     */
    public function update(Request $request, string $id)
    {
        $reservation = RoomReservation::findOrFail($id);

        $request->validate([
            'room_id' => 'sometimes|required|exists:rooms,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'observations' => 'nullable|string',
            'status' => 'sometimes|in:activa,finalizada,atrasada',
        ]);

        $reservation->update($request->all());

        return response()->json($reservation->load(['user', 'room']));
    }

    /**
     * Eliminar una reserva
     */
    public function destroy(string $id)
    {
        $reservation = RoomReservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Reserva eliminada exitosamente']);
    }
}
