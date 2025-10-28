<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    //Tabla en Base de datos
    protected $table = 'tb_administrador';

    //ID
    protected $primaryKey = 'ID_ADMINISTRADOR';





    protected $fillable = [
        'DSC_NOMBRE',
        'DSC_CORREO',
        'DSC_CONTRASENIA',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'DSC_CONTRASENIA',
        'remember_token',
    ];

    //Mapear el campo de contraseña
    public function getAuthPassword()
    {
        return $this->DSC_CONTRASENIA;
    }
    
    //Mapear el campo de email
    public function getEmailForPasswordReset()
    {
        return $this->DSC_CORREO;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'FEC_CREACION' => 'datetime',
            'DSC_CONTRASENIA' => 'hashed'
        ];
    }
}
