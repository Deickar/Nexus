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
        // Crear tabla usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            // Clave primaria
            $table->id('id_usuario');

            // Campos de datos
            $table->string('nombre_completo', 150)->nullable(false);
            $table->string('correo_electronico', 150)->nullable(false)->unique();
            $table->string('contrasena', 255)->nullable(false);
            $table->string('telefono', 30)->nullable();
            $table->string('direccion', 255)->nullable();

            // Clave foranea
            $table->unsignedBigInteger("id_rol");
            $table->foreign("id_rol")->references("id_rol")->on("roles");
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
        Schema::table('usuarios',function(Blueprint $table){
            $table->dropForeign(['id_rol']);
        });
        // Eliminar tabla usuarios
        Schema::dropIfExists('usuarios');
    }
};
