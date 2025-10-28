<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'tb_slider';
    public $timestamps = true;
    protected $primaryKey = 'ID_SLIDER';

    protected $fillable = [
        'DSC_NOMBRE',
        'DSC_DESCRIPCION',
        'IMG_URL',
        'ESTADO'
    ];
}
