<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'tipo',
        'capacidad',
        'ubicacion',
        'disponible',
        'equipamiento',
    ];

    /**
     * Casts de atributos
     */
    protected $casts = [
        'disponible' => 'boolean',
        'equipamiento' => 'array',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    /**
     * Un aula puede tener muchas reservas
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
