<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validar el inicio de sesión de usuarios
 *
 * Este Form Request valida los datos de entrada cuando un usuario
 * intenta iniciar sesión en el sistema. Valida que se proporcionen
 * las credenciales necesarias en el formato correcto.
 *
 * Campos validados:
 * - email: Email del usuario (formato válido)
 * - password: Contraseña del usuario (requerida)
 *
 * Nota: No validamos si las credenciales son correctas aquí,
 * eso se hace en el controlador después de la validación de formato.
 *
 * @version Laravel 12.39.0
 */
class LoginRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición
     *
     * Para el login, cualquier usuario (incluso no autenticado) puede
     * hacer esta petición, por lo que siempre retornamos true.
     */
    public function authorize(): bool
    {
        return true; // Cualquier usuario puede intentar hacer login
    }

    /**
     * Obtener las reglas de validación que aplican a la petición
     *
     * Reglas de validación:
     * - email: Requerido, formato email válido
     * - password: Requerido, string
     *
     * Nota: No validamos longitud mínima de password aquí porque
     * el usuario podría haber registrado su cuenta con requisitos
     * diferentes en el pasado.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Email del usuario
            // - required: Campo obligatorio
            // - email: Debe tener formato de email válido
            'correo_electronico' => 'required|email',

            // Contraseña del usuario
            // - required: Campo obligatorio
            // - string: Debe ser una cadena de texto
            'contrasena' => 'required|string',
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
            // Mensajes para el campo 'correo_electronico'
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El correo electrónico debe tener un formato válido.',

            // Mensajes para el campo 'contrasena'
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.string' => 'La contraseña debe ser una cadena de texto.',
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
            'correo_electronico' => 'correo electrónico',
            'contrasena' => 'contraseña',
        ];
    }
}
