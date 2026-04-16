<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'barcode',
        'categoria',
        'estado',
        'disponible',
    ];

    /**
     * Casts de atributos
     */
    protected $casts = [
        'disponible' => 'boolean',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    /**
     * Un material puede estar en muchas reservas (muchos-a-muchos)
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'material_reservation');
    }
}
