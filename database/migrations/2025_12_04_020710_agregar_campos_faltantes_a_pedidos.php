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
        // Agregar campos faltantes a tabla pedidos
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('direccion_envio', 255)->nullable()->after('estado');
            $table->string('telefono_contacto', 30)->nullable()->after('direccion_envio');
            $table->text('notas')->nullable()->after('telefono_contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar campos agregados a tabla pedidos
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['direccion_envio', 'telefono_contacto', 'notas']);
        });
    }
};
