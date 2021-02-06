<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Categoria
    protected $table = "categoria";

    protected $fillable = [
        'nombre', 
        'descripcion'
    ];
}
