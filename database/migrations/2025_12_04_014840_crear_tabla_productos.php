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
        // Crear tabla productos
        Schema::create('productos', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_producto')->autoIncrement()->primary();

            // Campos de datos
            $table->string('nombre_producto', 150)->nullable(false);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->nullable(false);
            $table->integer('existencia')->nullable(false)->default(0);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Claves foraneas
            $table->integer('id_categoria')->nullable(false);
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');

            $table->integer('id_marca')->nullable(false);
            $table->foreign('id_marca')->references('id_marca')->on('marcas');

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
        // Eliminar tabla productos
        Schema::dropIfExists('productos');
    }
};
