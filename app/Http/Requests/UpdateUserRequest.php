<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo admin puede actualizar usuarios
        return $this->user()?->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $this->route('user')],
            'password' => ['sometimes', 'string', 'min:6'],
            'role' => ['sometimes', 'in:admin,profesor,alumno'],
        ];
    }
}
