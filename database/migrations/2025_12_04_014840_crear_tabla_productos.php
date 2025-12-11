<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

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
            $table->id('id_producto');

            // Campos de datos
            $table->string('nombre_producto', 150)->nullable(false);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->nullable(false);
            $table->integer('existencia')->nullable(false)->default(0);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Claves foraneas
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias');

            $table->unsignedBigInteger('id_marca');
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
     Schema::table('productos', function(Blueprint $table){
        $table->dropForeign(['id_categoria']);
        $table->dropForeign(['id_marca']);
    });
        // Eliminar tabla productos
        Schema::dropIfExists('productos');
    }
};
