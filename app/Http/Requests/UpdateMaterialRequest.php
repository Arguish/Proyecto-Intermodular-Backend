<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo admin o conserje puede actualizar material
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
            'codigo' => ['sometimes', 'string', 'unique:materials,codigo,' . $this->route('id')],
            'barcode' => ['sometimes', 'string'],
            'categoria' => ['sometimes', 'in:Informática,Audiovisual,Mobiliario,Deportivo,Laboratorio,Otros'],
            'estado' => ['sometimes', 'in:Excelente,Bueno,Regular,Malo'],
            'disponible' => ['sometimes', 'boolean'],
        ];
    }
}
