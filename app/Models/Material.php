<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'status',
    ];

    /**
     * Relación: Un material puede tener muchos préstamos.
     */
    public function loans()
    {
        return $this->hasMany(MaterialLoan::class);
    }
}
