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
        // Crear tabla imagenes_producto
        Schema::create('imagenes_producto', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_imagen')->autoIncrement()->primary();
            
            // Clave foranea
            $table->integer('id_producto')->nullable(false);
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            
            // Campos de datos
            $table->string('url_imagen', 255)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla imagenes_producto
        Schema::dropIfExists('imagenes_producto');
    }
};
