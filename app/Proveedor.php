<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Proveedor
    protected $table = "proveedor";

    protected $fillable = [
        'nombre',
        'ruc',
        'descripcion',
        'telefono',
        'giro'
    ];
}
