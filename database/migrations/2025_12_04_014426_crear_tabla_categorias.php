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
        // Crear tabla categorias
        Schema::create('categorias', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_categoria')->autoIncrement()->primary();

            // Campos de datos
            $table->string('nombre_categoria', 150)->nullable(false);
            $table->string('descripcion', 255)->nullable();

            // Clave foranea auto-referencial (categoria padre)
            $table->integer('id_categoria_padre')->nullable();
            $table->foreign('id_categoria_padre')->references('id_categoria')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla categorias
        Schema::dropIfExists('categorias');
    }
};
