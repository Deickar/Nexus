<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Servicio para recuperacion de contrasena
 */
class PasswordResetService
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Solicitar recuperacion de contrasena
     * Genera un token y envia email
     */
    public function solicitarRecuperacion($email)
    {
        // Verificar que el usuario existe
        $usuario = User::where('correo_electronico', $email)->first();

        if (! $usuario) {
            throw new \Exception('No existe un usuario con ese correo electronico');
        }

        // Eliminar tokens anteriores del mismo usuario
        DB::table('password_resets')
            ->where('email', $email)
            ->delete();

        // Generar token unico
        $token = Str::random(60);

        // Guardar token en la base de datos
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Enviar email con el token
        $this->emailService->enviarRecuperacionPassword($usuario, $token);

        return [
            'message' => 'Se ha enviado un correo con las instrucciones para recuperar tu contrasena',
            'token' => $token, // Solo para desarrollo/testing
        ];
    }

    /**
     * Verificar si un token es valido
     */
    public function verificarToken($email, $token)
    {
        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (! $reset) {
            return false;
        }

        // Verificar que el token no haya expirado (1 hora)
        $createdAt = \Carbon\Carbon::parse($reset->created_at);
        if ($createdAt->addHour()->isPast()) {
            // Token expirado, eliminarlo
            DB::table('password_resets')
                ->where('email', $email)
                ->delete();

            return false;
        }

        // Verificar que el token coincida
        return Hash::check($token, $reset->token);
    }

    /**
     * Restablecer contrasena
     */
    public function restablecerContrasena($email, $token, $nuevaContrasena)
    {
        // Verificar token
        if (! $this->verificarToken($email, $token)) {
            throw new \Exception('El token es invalido o ha expirado');
        }

        // Buscar usuario
        $usuario = User::where('correo_electronico', $email)->first();

        if (! $usuario) {
            throw new \Exception('Usuario no encontrado');
        }

        // Actualizar contrasena
        $usuario->contrasena = $nuevaContrasena;
        $usuario->save();

        // Eliminar token usado
        DB::table('password_resets')
            ->where('email', $email)
            ->delete();

        return [
            'message' => 'Contrasena actualizada exitosamente',
        ];
    }
}
