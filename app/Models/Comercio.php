<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    use HasFactory;

    protected $table = 'tb_comercio';
    protected $primaryKey = 'ID_COMERCIO';

    protected $fillable = [
        'DSC_COMERCIO',
        'DSC_DIRECCION',
        'NUM_TELEFONO',
        'DSC_CORREO',
        'DSC_INSTAGRAM',
        'DSC_FACEBOOK',
        'NUM_LATITUD',
        'NUM_LONGITUD',
        'IMG_DESTACADA',
        'NUM_ESTADO', 
    ];

    public $timestamps = false; 
    
    const CREATED_AT = 'FEC_CREACION';
    const UPDATED_AT = null; 

    protected $casts = [
        'NUM_LATITUD' => 'decimal:8',
        'NUM_LONGITUD' => 'decimal:8',
        'FEC_CREACION' => 'datetime',
        'NUM_ESTADO' => 'integer',
    ];

    /**
     * Relación muchos a muchos con Categoria
     */
    public function categorias()
{
    return $this->belongsToMany(
        Categoria::class,
        'tb_categoria_comercio',
        'ID_COMERCIO',      
        'ID_CATEGORIA'     
    )
    ->using(CategoriaComercio::class)
    ->withPivot('FEC_CREACION', 'NUM_ESTADO');
}

public function galeria()
{
    return $this->hasMany(GaleriaComercio::class, 'ID_COMERCIO', 'ID_COMERCIO')
        ->orderBy('DSC_ORDEN', 'asc');
}
}