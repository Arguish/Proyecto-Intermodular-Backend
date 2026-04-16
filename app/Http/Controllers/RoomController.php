<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = \App\Models\Room::all();
        return \App\Http\Resources\RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreRoomRequest $request)
    {
        $data = $request->validated();
        $room = \App\Models\Room::create($data);
        return (new \App\Http\Resources\RoomResource($room))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = \App\Models\Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Aula no encontrada'
            ], 404);
        }
        return new \App\Http\Resources\RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateRoomRequest $request, $id)
    {
        $room = \App\Models\Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Aula no encontrada'
            ], 404);
        }
        $room->update($request->validated());
        return new \App\Http\Resources\RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $room = \App\Models\Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Aula no encontrada'
            ], 404);
        }
        $room->delete();
        return response()->json([
            'message' => 'Aula eliminada correctamente'
        ], 200);
    }
}
