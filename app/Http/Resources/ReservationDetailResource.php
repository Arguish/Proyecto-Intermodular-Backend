<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationDetailResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'room' => $this->room ? new RoomResource($this->room) : null,
            'materials' => MaterialResource::collection($this->whenLoaded('materials')),
            'fecha_inicio' => $this->fecha_inicio?->toISOString(),
            'fecha_fin' => $this->fecha_fin?->toISOString(),
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
            'es_invitado' => (bool) $this->es_invitado,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
