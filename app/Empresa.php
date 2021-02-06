<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //Empresa
    protected $table= 'empresa';

    protected $fillable = [
        'nombre',
        'ramo',
        'descripcion',
        'email',
        'user_id'
    ];
}
