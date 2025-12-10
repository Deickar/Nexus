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
        // Crear tabla marcas
        Schema::create('marcas', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_marca')->autoIncrement()->primary();

            // Campos de datos
            $table->string('nombre_marca', 150)->nullable(false);
            $table->string('descripcion', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla marcas
        Schema::dropIfExists('marcas');
    }
};
