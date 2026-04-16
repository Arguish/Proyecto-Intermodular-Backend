<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Solo admin puede listar usuarios
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos para acceder a este recurso'
            ], 403);
        }
        $users = \App\Models\User::all();
        return \App\Http\Resources\UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        $user = \App\Models\User::create($data);
        return (new \App\Http\Resources\UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // Solo admin puede ver usuarios
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos para acceder a este recurso'
            ], 403);
        }
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        return new \App\Http\Resources\UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateUserRequest $request, $id)
    {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return new \App\Http\Resources\UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }
}
