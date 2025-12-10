<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registrarUsuario($datos)
    {
        $user = User::create([
            'nombre_completo' => $datos['nombre_completo'],
            'correo_electronico' => $datos['correo_electronico'],
            'contrasena' => $datos['contrasena'], // El mutator del modelo ya lo hashea automáticamente
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'id_rol' => $datos['id_rol'] ?? 3, // Rol por defecto: cliente
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function iniciarSesion($email, $password)
    {
        $user = User::where('correo_electronico', $email)->first();

        if (! $user || ! Hash::check($password, $user->contrasena)) {
            throw new \Exception('Las credenciales proporcionadas son incorrectas');
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function cerrarSesion($user)
    {
        $user->currentAccessToken()->delete();

        return true;
    }
}
