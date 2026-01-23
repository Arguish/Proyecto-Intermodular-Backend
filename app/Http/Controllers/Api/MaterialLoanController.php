<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialLoan;
use Illuminate\Http\Request;

class MaterialLoanController extends Controller
{
    /**
     * Listar todos los préstamos de material
     */
    public function index()
    {
        $loans = MaterialLoan::with(['user', 'material'])->get();
        return response()->json($loans);
    }

    /**
     * Crear nuevo préstamo de material
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'material_id' => 'required|exists:materials,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'return_date' => 'nullable|date',
            'observations' => 'nullable|string',
            'status' => 'sometimes|in:prestado,devuelto,atrasado',
        ]);

        $loan = MaterialLoan::create($request->all());

        return response()->json($loan->load(['user', 'material']), 201);
    }

    /**
     * Mostrar detalles de un préstamo específico
     */
    public function show(string $id)
    {
        $loan = MaterialLoan::with(['user', 'material'])->findOrFail($id);
        return response()->json($loan);
    }

    /**
     * Actualizar información de un préstamo (ej: marcar como devuelto)
     */
    public function update(Request $request, string $id)
    {
        $loan = MaterialLoan::findOrFail($id);

        $request->validate([
            'material_id' => 'sometimes|required|exists:materials,id',
            'loan_date' => 'sometimes|required|date',
            'due_date' => 'sometimes|required|date|after:loan_date',
            'return_date' => 'nullable|date',
            'observations' => 'nullable|string',
            'status' => 'sometimes|in:prestado,devuelto,atrasado',
        ]);

        $loan->update($request->all());

        return response()->json($loan->load(['user', 'material']));
    }

    /**
     * Eliminar un préstamo
     */
    public function destroy(string $id)
    {
        $loan = MaterialLoan::findOrFail($id);
        $loan->delete();

        return response()->json(['message' => 'Préstamo eliminado exitosamente']);
    }
}
