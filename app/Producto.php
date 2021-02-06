<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    // Productos
    protected $table= 'articulo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'stock',
        'precio_unitario',
        'precio_venta',
        'user_id',
        'categoria_id',
        'proveedor_id'
    ];


}
