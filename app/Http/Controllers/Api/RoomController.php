<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Listar todas las aulas
     */
    public function index()
    {
        $rooms = Room::with('reservations')->get();
        return response()->json($rooms);
    }

    /**
     * Crear nueva aula
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:rooms,barcode',
            'description' => 'nullable|string',
        ]);

        $room = Room::create($request->all());

        return response()->json($room, 201);
    }

    /**
     * Mostrar detalles de un aula específica
     */
    public function show(string $id)
    {
        $room = Room::with('reservations.user')->findOrFail($id);
        return response()->json($room);
    }

    /**
     * Actualizar información de un aula
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'barcode' => 'sometimes|required|string|unique:rooms,barcode,' . $id,
            'description' => 'nullable|string',
        ]);

        $room->update($request->all());

        return response()->json($room);
    }

    /**
     * Eliminar un aula
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(['message' => 'Aula eliminada exitosamente']);
    }
}
