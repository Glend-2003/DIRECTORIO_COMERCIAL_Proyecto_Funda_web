<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_slider', function (Blueprint $table) {
            $table->id('ID_SLIDER'); // Clave primaria personalizada
            $table->string('DSC_NOMBRE', 100);
            $table->text('DSC_DESCRIPCION')->nullable();
            $table->string('IMG_URL', 255)->nullable();
            $table->boolean('ESTADO')->nullable();
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_slider');
    }
};
