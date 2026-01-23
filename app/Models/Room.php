<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'description',
    ];

    /**
     * Relación: Un aula puede tener muchas reservas.
     */
    public function reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }
}
