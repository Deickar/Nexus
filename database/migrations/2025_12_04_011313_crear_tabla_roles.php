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
        // Crear tabla roles
        Schema::create('roles', function (Blueprint $table) {
            // Clave primaria
            $table->id('id_rol');

            // Campos de datos
            $table->string('nombre_rol')->unique();
            $table->string('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla roles
        Schema::dropIfExists('roles');
    }
};
