<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'capacidad' => $this->capacidad,
            'codigo' => $this->codigo,
            'ubicacion' => $this->ubicacion,
            'disponible' => (bool) $this->disponible,
            'equipamiento' => $this->equipamiento,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
