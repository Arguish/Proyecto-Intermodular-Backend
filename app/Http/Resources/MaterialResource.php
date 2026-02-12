<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'codigo' => $this->codigo,
            'barcode' => $this->barcode,
            'categoria' => $this->categoria,
            'disponible' => (bool) $this->disponible,
            'estado' => $this->estado,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
