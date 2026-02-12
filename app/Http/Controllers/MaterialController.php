<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = \App\Models\Material::all();
        return \App\Http\Resources\MaterialResource::collection($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreMaterialRequest $request)
    {
        $data = $request->validated();
        $material = \App\Models\Material::create($data);
        return (new \App\Http\Resources\MaterialResource($material))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $material = \App\Models\Material::find($id);
        if (!$material) {
            return response()->json([
                'message' => 'Material no encontrado'
            ], 404);
        }
        return new \App\Http\Resources\MaterialResource($material);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateMaterialRequest $request, $id)
    {
        $material = \App\Models\Material::find($id);
        if (!$material) {
            return response()->json([
                'message' => 'Material no encontrado'
            ], 404);
        }
        $material->update($request->validated());
        return new \App\Http\Resources\MaterialResource($material);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $material = \App\Models\Material::find($id);
        if (!$material) {
            return response()->json([
                'message' => 'Material no encontrado'
            ], 404);
        }
        $material->delete();
        return response()->json([
            'message' => 'Material eliminado correctamente'
        ], 200);
    }
}
