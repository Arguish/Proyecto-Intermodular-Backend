<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_id',
        'loan_date',
        'due_date',
        'return_date',
        'observations',
        'status',
    ];

    /* =========================
     | RELACIONES
     |========================= */

    // Un préstamo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un préstamo pertenece a un material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
