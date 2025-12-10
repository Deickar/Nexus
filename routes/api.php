<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ImagenProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de API - Sistema de Autenticación Nexus
 *
 * Este archivo define todas las rutas de la API REST para el sistema de autenticación.
 * Las rutas están organizadas en dos grupos:
 * - Rutas públicas: No requieren autenticación
 * - Rutas protegidas: Requieren token de autenticación (middleware auth:sanctum)
 *
 * Todas las rutas tienen el prefijo /api automáticamente.
 *
 * @version Laravel 12.39.0
 */

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Sin autenticación)
|--------------------------------------------------------------------------
|
| Estas rutas son accesibles sin token de autenticación.
| Incluyen registro, login y recuperación de contraseña.
|
*/

// Grupo de rutas públicas
// Nota: Rate limiting deshabilitado temporalmente para testing
Route::group([], function () {

    /**
     * POST /api/register
     * Registrar un nuevo usuario en el sistema
     *
     * Body (JSON):
     * {
     *   "name": "Juan Pérez",
     *   "email": "juan@example.com",
     *   "password": "password123",
     *   "password_confirmation": "password123"
     * }
     *
     * Response 201: Usuario creado con token
     * Response 422: Error de validación
     */
    Route::post('/register', [AuthController::class, 'register'])
    ->name('api.register');

    /**
     * POST /api/login
     * Iniciar sesión de usuario
     *
     * Body (JSON):
     * {
     *   "email": "juan@example.com",
     *   "password": "password123"
     * }
     *
     * Response 200: Login exitoso con token
     * Response 401: Credenciales incorrectas
     * Response 422: Error de validación
     */

    Route::post('/login', [AuthController::class, 'login']);

    /**
     * POST /api/password/forgot
     * Solicitar recuperación de contraseña
     *
     * Body (JSON):
     * {
     *   "email": "juan@example.com"
     * }
     *
     * Response 200: Mensaje genérico (por seguridad)
     * Response 422: Error de validación
     */
    Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);

    /**
     * POST /api/password/reset
     * Restablecer contraseña con token
     *
     * Body (JSON):
     * {
     *   "email": "juan@example.com",
     *   "token": "abc123def456...",
     *   "password": "newpassword123",
     *   "password_confirmation": "newpassword123"
     * }
     *
     * Response 200: Contraseña restablecida
     * Response 400: Token inválido o expirado
     * Response 422: Error de validación
     */
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren autenticación)
|--------------------------------------------------------------------------
|
| Estas rutas requieren un token de autenticación válido en el header:
| Authorization: Bearer {token}
|
| El middleware 'auth:sanctum' valida el token automáticamente.
|
*/

// Grupo de rutas protegidas con autenticación Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    /**
     * POST /api/logout
     * Cerrar sesión del usuario
     *
     * Headers:
     * Authorization: Bearer {token}
     *
     * Response 200: Sesión cerrada exitosamente
     * Response 401: Token inválido o expirado
     */
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * GET /api/user
     * Obtener información del usuario autenticado
     *
     * Headers:
     * Authorization: Bearer {token}
     *
     * Response 200: Datos del usuario
     * Response 401: Token inválido o expirado
     */
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });
});


// API de Imágenes de Productos
Route::get('/imagenes/test-controller', [\App\Http\Controllers\Api\ImagenProductoController::class, 'test']);
Route::get('/imagenes/test', function() {
    return response()->json(['message' => 'Test ruta funcionando']);
});

Route::get('/imagenes/producto/{id}/principal', [\App\Http\Controllers\Api\ImagenProductoController::class, 'getMainImage']);
Route::get('/imagenes/producto/{id}', [\App\Http\Controllers\Api\ImagenProductoController::class, 'getByProduct']);
Route::get('/imagenes', [\App\Http\Controllers\Api\ImagenProductoController::class, 'index']);

// Ruta de prueba
Route::get('/test-imagenes', function () {
    return response()->json(['message' => 'API de imágenes funcionando']);
});

// Ruta simple para test directo
Route::get('/test-simple', function () {
    return ['status' => 'ok', 'time' => now()];
});
