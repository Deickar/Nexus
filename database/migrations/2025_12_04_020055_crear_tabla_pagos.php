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
        // Crear tabla pagos
        Schema::create('pagos', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_pago')->autoIncrement()->primary();
            
            // Clave foranea
            $table->integer('id_usuario')->nullable(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            
            // Campos de datos
            $table->enum('metodo_pago', ['tarjeta', 'efectivo', 'transferencia', 'paypal', 'stripe'])->nullable(false);
            $table->string('referencia_transaccion', 150)->nullable();
            $table->decimal('monto', 10, 2)->nullable(false);
            $table->enum('estado', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            
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
        // Eliminar tabla pagos
        Schema::dropIfExists('pagos');
    }
};
