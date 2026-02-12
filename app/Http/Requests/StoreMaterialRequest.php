<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo admin o conserje puede crear material
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
            'nombre' => ['required', 'string'],
            'codigo' => ['required', 'string', 'unique:materials,codigo'],
            'barcode' => ['nullable', 'string'],
            'categoria' => ['required', 'in:Informática,Audiovisual,Mobiliario,Deportivo,Laboratorio,Otros'],
            'estado' => ['required', 'in:Excelente,Bueno,Regular,Malo'],
            'disponible' => ['boolean'],
        ];
    }
}
