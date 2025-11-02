<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercio;
use App\Models\galeriaProducto;

class Producto extends Model
{
     use HasFactory;

    protected $table = 'tb_producto';
    protected $primaryKey = 'ID_PRODUCTO';

    protected $fillable = [
        'ID_COMERCIO',
        'DSC_NOMBRE',
        'DSC_PRODUCTO',
        'MONTO_PRECIO',
        'IMG_IMAGEN_DESTACADA',
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

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'ID_COMERCIO', 'ID_COMERCIO');
    }

    // Relación con Galería de Imágenes
    public function galeria()
    {
        return $this->hasMany(GaleriaProducto::class, 'ID_PRODUCTO', 'ID_PRODUCTO')
            ->where('NUM_ESTADO', 1)
            ->orderBy('DSC_ORDEN', 'asc');
    }

    // Obtener todas las imágenes de la galería (incluyendo inactivas)
    public function todasLasImagenes()
    {
        return $this->hasMany(GaleriaProducto::class, 'ID_PRODUCTO', 'ID_PRODUCTO')
            ->orderBy('DSC_ORDEN', 'asc');
    }

}
