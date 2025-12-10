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
        // Crear tabla detalle_carrito
        Schema::create('detalle_carrito', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_detalle_carrito')->autoIncrement()->primary();

            // Claves foraneas
            $table->integer('id_carrito')->nullable(false);
            $table->foreign('id_carrito')->references('id_carrito')->on('carritos');

            $table->integer('id_producto')->nullable(false);
            $table->foreign('id_producto')->references('id_producto')->on('productos');

            // Campos de datos
            $table->integer('cantidad')->nullable(false);
            $table->decimal('precio_unitario', 10, 2)->nullable(false);
            $table->decimal('subtotal', 10, 2)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tabla detalle_carrito
        Schema::dropIfExists('detalle_carrito');
    }
};
