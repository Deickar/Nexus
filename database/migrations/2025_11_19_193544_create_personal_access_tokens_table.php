<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla de tokens de acceso personal (Laravel Sanctum)
 * 
 * Esta migración crea la tabla que almacena los tokens de autenticación
 * generados por Laravel Sanctum para usuarios autenticados.
 * 
 * Cada token permite a un usuario acceder a la API de forma segura
 * sin necesidad de enviar credenciales en cada petición.
 * 
 * @package Database\Migrations
 * @version Laravel 12.39.0 + Sanctum 4.2.0
 * @date 2025-11-19
 */
return new class extends Migration
{
    /**
     * Ejecutar las migraciones
     * 
     * Crea la tabla personal_access_tokens para Laravel Sanctum.
     * Esta tabla gestiona todos los tokens de autenticación del sistema.
     * 
     * @return void
     */
    public function up(): void
    {
        // Tabla: personal_access_tokens
        // Propósito: Almacena los tokens de autenticación de Laravel Sanctum
        // Cada token representa una sesión activa de un usuario en un dispositivo
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // ID único del token (bigint unsigned, auto-incremental)
            
            $table->morphs('tokenable'); // Relación polimórfica (tokenable_type, tokenable_id)
                                        // tokenable_type: Nombre de la clase del modelo (ej: "App\Models\User")
                                        // tokenable_id: ID del registro en la tabla del modelo
                                        // Permite asociar el token con cualquier modelo del sistema
                                        // Crea índice compuesto automáticamente para búsquedas rápidas
            
            $table->text('name'); // Nombre descriptivo del token (text)
                                 // Ejemplos: "auth-token", "mobile-app", "web-session"
                                 // Útil para identificar el propósito o dispositivo del token
            
            $table->string('token', 64)->unique(); // Token hasheado único (varchar 64)
                                                  // Se almacena hasheado con SHA-256
                                                  // El token en texto plano solo está disponible al crearlo
                                                  // Índice único para búsquedas rápidas y prevenir duplicados
            
            $table->text('abilities')->nullable(); // Permisos del token en formato JSON (text, nullable)
                                                  // Ejemplo: ["admin:read", "admin:write"]
                                                  // NULL = sin restricciones de permisos
                                                  // Permite implementar autorización granular
            
            $table->timestamp('last_used_at')->nullable(); // Fecha de último uso del token (timestamp, nullable)
                                                          // Se actualiza automáticamente en cada petición
                                                          // Útil para auditoría y limpieza de tokens inactivos
            
            $table->timestamp('expires_at')->nullable()->index(); // Fecha de expiración (timestamp, nullable, indexada)
                                                                 // NULL = token sin expiración
                                                                 // Indexado para limpiar tokens expirados eficientemente
                                                                 // Recomendado: establecer expiración para mayor seguridad
            
            $table->timestamps(); // created_at y updated_at (timestamps)
                                 // created_at: Fecha de creación del token
                                 // updated_at: Fecha de última modificación
                                 // Gestionados automáticamente por Laravel
        });
    }

    /**
     * Revertir las migraciones
     * 
     * Elimina la tabla personal_access_tokens.
     * ADVERTENCIA: Esto invalidará todos los tokens activos del sistema.
     * 
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
