<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'status',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    // Un material puede tener muchos préstamos
    public function loans()
    {
        return $this->hasMany(MaterialLoan::class);
    }
}
