<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    // Ventas
    protected $table= 'ventas';

    protected $fillable = [
        'cantidad',
        'total',
        'articulo_id',
        'created_at',
        'updated_at'
    ];
}
