<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoriaComercio extends Pivot
{
    protected $table = 'tb_categoria_comercio';
    
    protected $fillable = [
        'ID_CATEGORIA',
        'ID_COMERCIO',
        'FEC_CREACION',
    ];
    
    public $timestamps = true;
    const CREATED_AT = 'FEC_CREACION';
    const UPDATED_AT = null;
}