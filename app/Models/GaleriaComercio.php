<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Comercio;
class GaleriaComercio extends Model
{

    use HasFactory;

    protected $table = 'tb_galeria_comercio';

    protected $primaryKey = 'ID_GALERIA_COMERCIO';

    protected $fillable = [
        'ID_COMERCIO',
        'IMG_URL',
        'DSC_ORDEN',
        'FEC_CREACION',
        'NUM_ESTADO',
    ];

    public $timestamps = false;

    const CREATED_AT = 'FEC_CREACION';

    const UPDATED_AT = null;

    public $casts = [
        'FEC_CREACION' => 'datetime',
        'NUM_ESTADO' => 'integer',
        'DSC_ORDEN' => 'integer',
    ];

    // Relación con Comercio

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'ID_COMERCIO', 'ID_COMERCIO');
    }

    // Scope para imágenes activas ordenadas
    public function scopeActivas($query)
    {
        return $query->where('NUM_ESTADO', 1)->orderBy('DSC_ORDEN', 'asc');
    }

}
