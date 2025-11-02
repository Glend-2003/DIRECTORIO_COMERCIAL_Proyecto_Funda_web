<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'tb_categoria';
    protected $primaryKey = 'ID_CATEGORIA';

    protected $fillable = [
        'DSC_NOMBRE',
        'DSC_DESCRIPCION',
        'DSC_CORREO',
        'IMG_URL',
        'FEC_CREACION',
        'NUM_ESTADO',
    ];

    public $timestamps = false; 
    
    const CREATED_AT = 'FEC_CREACION';
    const UPDATED_AT = null; 

    protected $casts = [
        'FEC_CREACION' => 'datetime',
        'NUM_ESTADO' => 'integer',
    ];

    /**
     * Relación muchos a muchos con Comercio
     */
    public function comercios()
    {
        return $this->belongsToMany(
            Comercio::class,
            'tb_categoria_comercio',
            'ID_CATEGORIA',
            'ID_COMERCIO'
        )->withTimestamps();
    }
}