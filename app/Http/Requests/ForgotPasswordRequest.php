<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validar solicitud de recuperación de contraseña
 *
 * Este Form Request valida los datos de entrada cuando un usuario
 * solicita recuperar su contraseña olvidada. Solo requiere el email
 * del usuario para enviar el token de recuperación.
 *
 * Campos validados:
 * - email: Email del usuario (formato válido)
 *
 * Nota de seguridad: Por razones de seguridad, no revelamos si el email
 * existe o no en el sistema. Esto se maneja en el controlador.
 *
 * @version Laravel 12.39.0
 */
class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición
     *
     * Para la recuperación de contraseña, cualquier usuario (incluso no autenticado)
     * puede hacer esta petición, por lo que siempre retornamos true.
     */
    public function authorize(): bool
    {
        return true; // Cualquier usuario puede solicitar recuperación de contraseña
    }

    /**
     * Obtener las reglas de validación que aplican a la petición
     *
     * Reglas de validación:
     * - email: Requerido, formato email válido
     *
     * No validamos si el email existe en la base de datos aquí por seguridad.
     * Esto previene que atacantes puedan enumerar emails válidos del sistema.
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
        ];
    }
}
