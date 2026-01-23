<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Relación: Un préstamo pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un préstamo pertenece a un material.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
