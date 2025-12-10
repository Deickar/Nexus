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
            $table->integer('id_carrito')->autoIncrement()->primary();
            
            // Clave foranea
            $table->integer('id_usuario')->nullable(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            
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
        // Eliminar tabla carritos
        Schema::dropIfExists('carritos');
    }
};
