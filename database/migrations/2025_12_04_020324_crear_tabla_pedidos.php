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
        // Crear tabla pedidos
        Schema::create('pedidos', function (Blueprint $table) {
            // Clave primaria
            $table->integer('id_pedido')->autoIncrement()->primary();

            // Claves foraneas
            $table->integer('id_usuario')->nullable(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');

            $table->integer('id_pago')->nullable(false);
            $table->foreign('id_pago')->references('id_pago')->on('pagos');

            // Campos de datos
            $table->string('numero_pedido', 50)->nullable(false)->unique();
            $table->decimal('monto_total', 10, 2)->nullable(false);
            $table->enum('estado', ['pendiente', 'pagado', 'enviado', 'entregado', 'cancelado'])->default('pendiente');

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
        // Eliminar tabla pedidos
        Schema::dropIfExists('pedidos');
    }
};
