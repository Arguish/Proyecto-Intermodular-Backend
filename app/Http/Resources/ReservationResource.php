<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'room_id' => $this->room_id,
            'material_ids' => $this->materials->pluck('id')->all(),
            'fecha_inicio' => $this->fecha_inicio?->toISOString(),
            'fecha_fin' => $this->fecha_fin?->toISOString(),
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
            'es_invitado' => (bool) $this->es_invitado,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
