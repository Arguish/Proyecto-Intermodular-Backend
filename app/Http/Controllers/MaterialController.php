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

    /**
     * Buscar material por texto (nombre, codigo, categoria)
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return \App\Http\Resources\MaterialResource::collection([]);
        }
        
        $materials = \App\Models\Material::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('codigo', 'LIKE', "%{$query}%")
            ->orWhere('categoria', 'LIKE', "%{$query}%")
            ->get();
        
        return \App\Http\Resources\MaterialResource::collection($materials);
    }

    /**
     * Buscar material por código de barras
     */
    public function findByBarcode($barcode)
    {
        $material = \App\Models\Material::where('barcode', $barcode)->first();
        
        if (!$material) {
            return response()->json([
                'message' => 'Material no encontrado'
            ], 404);
        }
        
        return new \App\Http\Resources\MaterialResource($material);
    }
}
