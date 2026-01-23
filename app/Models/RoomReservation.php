<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'observations',
        'status',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    // Una reserva pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una reserva pertenece a un aula
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
