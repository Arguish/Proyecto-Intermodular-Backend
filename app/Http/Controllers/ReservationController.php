<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Material;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationDetailResource;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = \App\Models\Reservation::with(['user', 'room', 'materials'])->get();
        return \App\Http\Resources\ReservationDetailResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

        // Verificar solapamiento de aula
        if (!empty($data['room_id'])) {
            $roomOverlap = Reservation::where('room_id', $data['room_id'])
                ->where('fecha_inicio', '<', $data['fecha_fin'])
                ->where('fecha_fin', '>', $data['fecha_inicio'])
                ->whereIn('estado', ['activa', 'pendiente'])
                ->exists();
            if ($roomOverlap) {
                return response()->json([
                    'message' => 'Ya existe una reserva en ese horario',
                    'conflicts' => [
                        'aula' => 'El aula ya está reservada en ese horario',
                        'material' => null
                    ]
                ], 409);
            }
        }

        // Verificar solapamiento de materiales
        $materialConflict = null;
        if (!empty($data['material_ids'])) {
            $conflictingMaterial = null;
            foreach ($data['material_ids'] as $materialId) {
                $materialOverlap = Reservation::whereHas('materials', function ($q) use ($materialId) {
                    $q->where('materials.id', $materialId);
                })
                    ->where('fecha_inicio', '<', $data['fecha_fin'])
                    ->where('fecha_fin', '>', $data['fecha_inicio'])
                    ->whereIn('estado', ['activa', 'pendiente'])
                    ->exists();
                if ($materialOverlap) {
                    $mat = Material::find($materialId);
                    $conflictingMaterial = $mat ? $mat->nombre : 'Material ID ' . $materialId;
                    break;
                }
            }
            if ($conflictingMaterial) {
                return response()->json([
                    'message' => 'Ya existe una reserva en ese horario',
                    'conflicts' => [
                        'aula' => null,
                        'material' => $conflictingMaterial . ' ya está reservado en ese horario'
                    ]
                ], 409);
            }
        }

        // Crear la reserva
        $reservation = Reservation::create([
            'user_id' => $data['user_id'],
            'room_id' => $data['room_id'] ?? null,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'estado' => 'activa',
            'observaciones' => $data['observaciones'] ?? null,
            'es_invitado' => $data['es_invitado'] ?? false,
        ]);

        // Adjuntar materiales si hay
        if (!empty($data['material_ids'])) {
            $reservation->materials()->attach($data['material_ids']);
        }

        return (new ReservationResource($reservation->fresh()))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = \App\Models\Reservation::with(['user', 'room', 'materials'])->find($id);
        if (!$reservation) {
            return response()->json([
                'message' => 'Reserva no encontrada'
            ], 404);
        }
        return new \App\Http\Resources\ReservationDetailResource($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, $id)
    {
        $reservation = \App\Models\Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $data = $request->validated();

        // Verificar solapamiento de aula si se modifica
        if (array_key_exists('room_id', $data) && !empty($data['room_id'])) {
            $roomOverlap = \App\Models\Reservation::where('room_id', $data['room_id'])
                ->where('id', '!=', $reservation->id)
                ->where('fecha_inicio', '<', $data['fecha_fin'] ?? $reservation->fecha_fin)
                ->where('fecha_fin', '>', $data['fecha_inicio'] ?? $reservation->fecha_inicio)
                ->whereIn('estado', ['activa', 'pendiente'])
                ->exists();
            if ($roomOverlap) {
                return response()->json([
                    'message' => 'Ya existe una reserva en ese horario',
                    'conflicts' => [
                        'aula' => 'El aula ya está reservada en ese horario',
                        'material' => null
                    ]
                ], 409);
            }
        }

        // Verificar solapamiento de materiales si se modifican
        if (array_key_exists('material_ids', $data) && !empty($data['material_ids'])) {
            $conflictingMaterial = null;
            foreach ($data['material_ids'] as $materialId) {
                $materialOverlap = \App\Models\Reservation::whereHas('materials', function ($q) use ($materialId) {
                    $q->where('materials.id', $materialId);
                })
                    ->where('id', '!=', $reservation->id)
                    ->where('fecha_inicio', '<', $data['fecha_fin'] ?? $reservation->fecha_fin)
                    ->where('fecha_fin', '>', $data['fecha_inicio'] ?? $reservation->fecha_inicio)
                    ->whereIn('estado', ['activa', 'pendiente'])
                    ->exists();
                if ($materialOverlap) {
                    $mat = \App\Models\Material::find($materialId);
                    $conflictingMaterial = $mat ? $mat->nombre : 'Material ID ' . $materialId;
                    break;
                }
            }
            if ($conflictingMaterial) {
                return response()->json([
                    'message' => 'Ya existe una reserva en ese horario',
                    'conflicts' => [
                        'aula' => null,
                        'material' => $conflictingMaterial . ' ya está reservado en ese horario'
                    ]
                ], 409);
            }
        }

        // Actualizar campos simples
        $reservation->fill([
            'user_id' => $data['user_id'] ?? $reservation->user_id,
            'room_id' => $data['room_id'] ?? $reservation->room_id,
            'fecha_inicio' => $data['fecha_inicio'] ?? $reservation->fecha_inicio,
            'fecha_fin' => $data['fecha_fin'] ?? $reservation->fecha_fin,
            'estado' => $data['estado'] ?? $reservation->estado,
            'observaciones' => $data['observaciones'] ?? $reservation->observaciones,
            'es_invitado' => $data['es_invitado'] ?? $reservation->es_invitado,
        ]);
        $reservation->save();

        // Sincronizar materiales si corresponde
        if (array_key_exists('material_ids', $data)) {
            $reservation->materials()->sync($data['material_ids']);
        }

        return new \App\Http\Resources\ReservationResource($reservation->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = \App\Models\Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $user = request()->user();
        // Solo el propietario o admin puede eliminar
        if ($user->id !== $reservation->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reserva eliminada correctamente']);
    }

    /**
     * Cancel the specified reservation (change state to cancelada).
     */
    public function cancel($id)
    {
        $reservation = \App\Models\Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $user = request()->user();
        // Solo el propietario o admin puede cancelar
        if ($user->id !== $reservation->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reservation->estado = 'cancelada';
        $reservation->save();

        return response()->json(['message' => 'Reserva cancelada correctamente']);
    }

    /**
     * Marcar reserva como devuelta y materiales como disponibles
     */
    public function devolver($id)
    {
        $reservation = \App\Models\Reservation::with('materials')->find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $user = request()->user();
        // Solo admin o conserje puede marcar como devuelta
        if (!in_array($user->role, ['admin', 'conserje'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Cambiar estado de la reserva a completada
        $reservation->estado = 'completada';
        $reservation->save();

        // Marcar materiales como disponibles
        foreach ($reservation->materials as $material) {
            $material->disponible = true;
            $material->save();
        }

        return response()->json(['message' => 'Material devuelto correctamente']);
    }
}
