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
        // Crear tabla movimientos_inventario
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_movimiento')->autoIncrement()->primary();

            // Clave foranea
            $table->integer('id_producto')->nullable(false);
            $table->foreign('id_producto')->references('id_producto')->on('productos');

            // Campos de datos
            $table->enum('tipo_movimiento', ['entrada', 'salida'])->nullable(false);
            $table->integer('cantidad')->nullable(false);
            $table->string('descripcion', 255)->nullable();

            // Timestamp
            $table->dateTime('fecha_creacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla movimientos_inventario
        Schema::dropIfExists('movimientos_inventario');
    }
};
