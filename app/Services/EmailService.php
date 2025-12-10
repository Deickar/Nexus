<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Servicio para envío de emails
 *
 * Centraliza toda la lógica de envío de correos electrónicos
 * usando Gmail API a través de Laravel Mail
 */
class EmailService
{
    /**
     * Enviar email de bienvenida al registrarse
     */
    public function enviarBienvenida($usuario)
    {
        try {
            Mail::send('emails.bienvenida', ['usuario' => $usuario], function ($message) use ($usuario) {
                $message->to($usuario->correo_electronico, $usuario->nombre_completo)
                    ->subject('Bienvenido a Nexus E-commerce');
            });

            Log::info('Email de bienvenida enviado', ['usuario_id' => $usuario->id_usuario]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email de bienvenida', [
                'usuario_id' => $usuario->id_usuario,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Enviar confirmación de pedido
     */
    public function enviarConfirmacionPedido($pedido)
    {
        try {
            $usuario = $pedido->usuario;

            Mail::send('emails.pedido-confirmacion', [
                'pedido' => $pedido,
                'usuario' => $usuario,
            ], function ($message) use ($usuario, $pedido) {
                $message->to($usuario->correo_electronico, $usuario->nombre_completo)
                    ->subject('Confirmación de Pedido #'.$pedido->numero_pedido);
            });

            Log::info('Email de confirmación de pedido enviado', [
                'pedido_id' => $pedido->id_pedido,
                'usuario_id' => $usuario->id_usuario,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación de pedido', [
                'pedido_id' => $pedido->id_pedido,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Enviar notificación de cambio de estado de pedido
     */
    public function enviarCambioEstadoPedido($pedido, $estadoAnterior)
    {
        try {
            $usuario = $pedido->usuario;

            Mail::send('emails.pedido-estado', [
                'pedido' => $pedido,
                'usuario' => $usuario,
                'estadoAnterior' => $estadoAnterior,
            ], function ($message) use ($usuario, $pedido) {
                $message->to($usuario->correo_electronico, $usuario->nombre_completo)
                    ->subject('Actualización de Pedido #'.$pedido->numero_pedido);
            });

            Log::info('Email de cambio de estado enviado', [
                'pedido_id' => $pedido->id_pedido,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $pedido->estado,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email de cambio de estado', [
                'pedido_id' => $pedido->id_pedido,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Enviar confirmación de pago
     */
    public function enviarConfirmacionPago($pago)
    {
        try {
            $usuario = $pago->usuario;

            Mail::send('emails.pago-confirmacion', [
                'pago' => $pago,
                'usuario' => $usuario,
            ], function ($message) use ($usuario) {
                $message->to($usuario->correo_electronico, $usuario->nombre_completo)
                    ->subject('Confirmación de Pago - Nexus');
            });

            Log::info('Email de confirmación de pago enviado', [
                'pago_id' => $pago->id_pago,
                'usuario_id' => $usuario->id_usuario,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación de pago', [
                'pago_id' => $pago->id_pago,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Enviar email de recuperación de contraseña
     */
    public function enviarRecuperacionPassword($usuario, $token)
    {
        try {
            $url = url('/reset-password?token='.$token);

            Mail::send('emails.recuperar-password', [
                'usuario' => $usuario,
                'url' => $url,
            ], function ($message) use ($usuario) {
                $message->to($usuario->correo_electronico, $usuario->nombre_completo)
                    ->subject('Recuperación de Contraseña - Nexus');
            });

            Log::info('Email de recuperación de contraseña enviado', [
                'usuario_id' => $usuario->id_usuario,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar email de recuperación', [
                'usuario_id' => $usuario->id_usuario,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
