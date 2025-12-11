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
        // Crear tabla carritos
        Schema::create('carritos', function (Blueprint $table) {
            // Clave primaria
            $table->id('id_carrito');

            // Clave foranea
            $table->unsignedBigInteger("id_usuario");
            $table->foreign("id_usuario")->references("id_usuario")->on("usuarios");

            // Campos de datos
            $table->enum('estado', ['abierto', 'cerrado', 'cancelado'])->default('abierto');

            // Timestamps
            $table->dateTime('fecha_creacion')->useCurrent();
            $table->dateTime('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        // Elemina la FK en tabla de carrito
        Schema::table('carrito',function(Blueprint $table){
            $table->dropForeign(['id_usuario']);
        });
        // Eliminar tabla carritos
        Schema::dropIfExists('carritos');
    }
};
