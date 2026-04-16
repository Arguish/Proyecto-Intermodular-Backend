<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo admin o conserje puede actualizar aulas
        return in_array($this->user()?->role, ['admin', 'conserje']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['sometimes', 'string'],
            'tipo' => ['sometimes', 'in:Teórica,Laboratorio,Informática,Taller,Auditorio,Estudio'],
            'capacidad' => ['sometimes', 'integer', 'min:1'],
            'codigo' => ['sometimes', 'string', 'unique:rooms,codigo,' . $this->route('id')],
            'ubicacion' => ['sometimes', 'string'],
            'disponible' => ['sometimes', 'boolean'],
            'equipamiento' => ['sometimes', 'array'],
        ];
    }
}
