<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
        'es_invitado',
    ];

    /**
     * Casts de atributos
     */
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'es_invitado' => 'boolean',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    /**
     * Una reserva pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Una reserva puede pertenecer a un aula (nullable)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Una reserva puede tener muchos materiales (muchos-a-muchos)
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_reservation');
    }
}
