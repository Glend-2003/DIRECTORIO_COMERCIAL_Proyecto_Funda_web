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
        'NUM_ESTADO',  
    ];
    
    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->FEC_CREACION) {
                $model->FEC_CREACION = now();
            }
            if (!isset($model->NUM_ESTADO)) {
                $model->NUM_ESTADO = 1;  
            }
        });
    }
}