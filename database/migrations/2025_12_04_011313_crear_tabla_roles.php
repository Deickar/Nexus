<?php
// database/migrations/2025_12_04_011313_crear_tabla_roles.php

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
        Schema::create('roles', function (Blueprint $table) {
            
            // 🥇 Opción 1 (Recomendada): Usar el nombre de columna por defecto 'id'
            // $table->id(); 
            
            // 🥈 Opción 2 (Si necesitas el nombre 'id_rol'): Usar el nombre personalizado
            $table->id('id_rol'); // ¡SOLO ESTA LÍNEA DEBE ESTAR!

            $table->string('nombre_rol')->unique();
            $table->string('descripcion')->nullable();
            
            // Asegúrate de que no hay líneas como:
            // $table->primary('id_rol'); 
        });
    }

    // ... (función down)
};