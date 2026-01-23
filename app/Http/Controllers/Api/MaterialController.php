<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Listar todos los materiales
     */
    public function index()
    {
        $materials = Material::with('loans')->get();
        return response()->json($materials);
    }

    /**
     * Crear nuevo material
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:materials,barcode',
            'status' => 'sometimes|in:disponible,averiado,en_mantenimiento',
        ]);

        $material = Material::create($request->all());

        return response()->json($material, 201);
    }

    /**
     * Mostrar detalles de un material específico
     */
    public function show(string $id)
    {
        $material = Material::with('loans.user')->findOrFail($id);
        return response()->json($material);
    }

    /**
     * Actualizar información de un material
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'barcode' => 'sometimes|required|string|unique:materials,barcode,' . $id,
            'status' => 'sometimes|in:disponible,averiado,en_mantenimiento',
        ]);

        $material->update($request->all());

        return response()->json($material);
    }

    /**
     * Eliminar un material
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return response()->json(['message' => 'Material eliminado exitosamente']);
    }
}
