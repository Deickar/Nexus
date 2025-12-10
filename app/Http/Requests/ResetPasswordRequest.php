<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validar el restablecimiento de contraseña
 *
 * Este Form Request valida los datos de entrada cuando un usuario
 * intenta restablecer su contraseña usando un token de recuperación.
 *
 * Campos validados:
 * - email: Email del usuario (formato válido)
 * - token: Token de recuperación (requerido)
 * - password: Nueva contraseña (mínimo 8 caracteres, con confirmación)
 *
 * El token se valida en el controlador para verificar que sea válido
 * y no haya expirado (60 minutos).
 *
 * @version Laravel 12.39.0
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición
     *
     * Para el restablecimiento de contraseña, cualquier usuario (incluso no autenticado)
     * puede hacer esta petición si tiene un token válido.
     */
    public function authorize(): bool
    {
        return true; // Cualquier usuario con token válido puede restablecer contraseña
    }

    /**
     * Obtener las reglas de validación que aplican a la petición
     *
     * Reglas de validación:
     * - email: Requerido, formato email válido
     * - token: Requerido, string
     * - password: Requerido, string, mínimo 8 caracteres, debe coincidir con password_confirmation
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Email del usuario
            // - required: Campo obligatorio
            // - email: Debe tener formato de email válido
            'email' => 'required|email',

            // Token de recuperación
            // - required: Campo obligatorio
            // - string: Debe ser una cadena de texto
            // Nota: La validez del token se verifica en el controlador
            'token' => 'required|string',

            // Nueva contraseña del usuario
            // - required: Campo obligatorio
            // - string: Debe ser una cadena de texto
            // - min:8: Mínimo 8 caracteres (seguridad básica)
            // - confirmed: Debe coincidir con el campo password_confirmation
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Obtener los mensajes de error personalizados para las reglas de validación
     *
     * Estos mensajes se muestran al usuario cuando la validación falla.
     * Todos los mensajes están en español para mejor comprensión.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Mensajes para el campo 'email'
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',

            // Mensajes para el campo 'token'
            'token.required' => 'El token de recuperación es obligatorio.',
            'token.string' => 'El token debe ser una cadena de texto.',

            // Mensajes para el campo 'password'
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    /**
     * Obtener los nombres de atributos personalizados para mensajes de validación
     *
     * Esto permite que Laravel use nombres más amigables en los mensajes de error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'correo electrónico',
            'token' => 'token de recuperación',
            'password' => 'contraseña',
        ];
    }
}
