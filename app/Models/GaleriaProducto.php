<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class GaleriaProducto extends Model
{
     use HasFactory;

    protected $table = 'tb_galeria_producto';
    protected $primaryKey = 'ID_GALERIA_PRODUCTO';

    protected $fillable = [
        'ID_PRODUCTO',
        'IMG_URL',
        'DSC_ORDEN',
        'FEC_CREACION',
        'NUM_ESTADO',
    ];

    public $timestamps = false; 
    
    const CREATED_AT = 'FEC_CREACION';
    const UPDATED_AT = null; 

    protected $casts = [
        'FEC_CREACION' => 'datetime',
        'NUM_ESTADO' => 'integer',
        'DSC_ORDEN' => 'integer',
    ];

    // Relación con Producto    
   public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_PRODUCTO', 'ID_PRODUCTO');
    }

    // Scope para imágenes activas ordenadas
    public function scopeActivas($query)
    {
        return $query->where('NUM_ESTADO', 1)->orderBy('DSC_ORDEN', 'asc');
    }
}
