<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_administrador')->insert([
            [
                'DSC_NOMBRE' => 'Administrador Principal',
                'DSC_CORREO' => 'admin@example.com',
                'DSC_CONTRASENIA' => Hash::make('password123'),
                'FEC_CREACION' => now(),
            ],
            [
                'DSC_NOMBRE' => 'Usuario Test',
                'DSC_CORREO' => 'test@example.com',
                'DSC_CONTRASENIA' => Hash::make('password123'),
                'FEC_CREACION' => now(),
            ],
        ]);
    }
}