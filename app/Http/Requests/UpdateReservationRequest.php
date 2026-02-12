<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Cualquier usuario autenticado puede actualizar reservas (ajustar si se requiere solo propietario/admin)
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'material_ids' => ['nullable', 'array'],
            'material_ids.*' => ['exists:materials,id'],
            'fecha_inicio' => ['sometimes', 'date', 'date_format:Y-m-d H:i:s'],
            'fecha_fin' => ['sometimes', 'date', 'after:fecha_inicio', 'date_format:Y-m-d H:i:s'],
            'observaciones' => ['nullable', 'string'],
            'es_invitado' => ['boolean'],
            'estado' => ['sometimes', 'in:activa,pendiente,cancelada,completada'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            if (empty($data['room_id']) && (empty($data['material_ids']) || count($data['material_ids']) === 0)) {
                $validator->errors()->add('room_id', 'Debe especificar al menos un aula o un material.');
            }
        });
    }
}
