<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validar el registro de nuevos usuarios
 *
 * Este Form Request valida los datos de entrada cuando un usuario
 * intenta registrarse en el sistema. Asegura que todos los campos
 * cumplan con los requisitos de seguridad y formato.
 *
 * Campos validados:
 * - nombre_completo: Nombre completo del usuario (2-150 caracteres)
 * - correo_electronico: Email único y válido (máximo 150 caracteres)
 * - contrasena: Contraseña segura (mínimo 8 caracteres)
 * - telefono: Teléfono opcional (máximo 30 caracteres)
 * - direccion: Dirección opcional (máximo 255 caracteres)
 * - id_rol: ID del rol opcional (debe existir en tabla roles)
 *
 * @package App\Http\Requests
 * @version Laravel 12.39.0
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición
     *
     * Para el registro, cualquier usuario (incluso no autenticado) puede
     * hacer esta petición, por lo que siempre retornamos true.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Cualquier usuario puede registrarse
    }

    /**
     * Obtener las reglas de validación que aplican a la petición
     *
     * Reglas de validación:
     * - nombre_completo: Requerido, string, mínimo 2 caracteres, máximo 150
     * - correo_electronico: Requerido, formato email válido, único en tabla usuarios, máximo 150
     * - contrasena: Requerido, string, mínimo 8 caracteres
     * - telefono: Opcional, string, máximo 30 caracteres
     * - direccion: Opcional, string, máximo 255 caracteres
     * - id_rol: Opcional, entero, debe existir en tabla roles
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Nombre completo del usuario
            'nombre_completo' => 'required|string|min:2|max:150',

            // Email del usuario
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico|max:150',

            // Contraseña del usuario
            'contrasena' => 'required|string|min:8',

            // Campos opcionales
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'id_rol' => 'nullable|integer|exists:roles,id_rol',
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
            // Mensajes para el campo 'nombre_completo'
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
            'nombre_completo.min' => 'El nombre completo debe tener al menos :min caracteres.',
            'nombre_completo.max' => 'El nombre completo no puede tener más de :max caracteres.',

            // Mensajes para el campo 'correo_electronico'
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El correo electrónico debe tener un formato válido.',
            'correo_electronico.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'correo_electronico.max' => 'El correo electrónico no puede tener más de :max caracteres.',

            // Mensajes para el campo 'contrasena'
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.string' => 'La contraseña debe ser una cadena de texto.',
            'contrasena.min' => 'La contraseña debe tener al menos :min caracteres.',

            // Mensajes para campos opcionales
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de :max caracteres.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de :max caracteres.',
            'id_rol.integer' => 'El ID del rol debe ser un número entero.',
            'id_rol.exists' => 'El rol seleccionado no existe.',
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
            'nombre_completo' => 'nombre completo',
            'correo_electronico' => 'correo electrónico',
            'contrasena' => 'contraseña',
            'telefono' => 'teléfono',
            'direccion' => 'dirección',
            'id_rol' => 'rol',
        ];
    }
}
