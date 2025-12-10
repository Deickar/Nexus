<?php

namespace App\Services;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PagoService
{
    public function listarPagosUsuario($idUsuario, $perPage = 15)
    {
        return Pago::where('id_usuario', $idUsuario)
            ->with(['pedido'])
            ->orderBy('fecha_creacion', 'desc')
            ->paginate($perPage);
    }

    public function obtenerPago($id, $usuario)
    {
        $pago = Pago::with(['pedido', 'usuario'])->findOrFail($id);

        if ($pago->id_usuario != $usuario->id_usuario && $usuario->id_rol != 1) {
            throw new \Exception('No tienes permiso para ver este pago');
        }

        return $pago;
    }

    public function crearPago($idUsuario, $idPedido, $metodoPago)
    {
        return DB::transaction(function () use ($idUsuario, $idPedido, $metodoPago) {
            $pedido = Pedido::findOrFail($idPedido);

            if ($pedido->id_usuario != $idUsuario) {
                throw new \Exception('No tienes permiso para pagar este pedido');
            }

            $pagoExistente = Pago::where('id_pedido', $pedido->id_pedido)
                ->where('estado', 'completado')
                ->first();

            if ($pagoExistente) {
                throw new \Exception('Este pedido ya ha sido pagado');
            }

            $pago = Pago::create([
                'id_usuario' => $idUsuario,
                'metodo_pago' => $metodoPago,
                'monto' => $pedido->monto_total,
                'estado' => 'pendiente',
            ]);

            $pedido->update(['id_pago' => $pago->id_pago]);

            return $pago;
        });
    }

    public function confirmarPago($idPago, $idUsuario, $referenciaTransaccion, $datosAdicionales = [])
    {
        return DB::transaction(function () use ($idPago, $idUsuario, $referenciaTransaccion, $datosAdicionales) {
            $pago = Pago::findOrFail($idPago);

            if ($pago->id_usuario != $idUsuario) {
                throw new \Exception('No tienes permiso para confirmar este pago');
            }

            $pago->update([
                'estado' => 'completado',
                'referencia_transaccion' => $referenciaTransaccion,
                'datos_pago' => $datosAdicionales,
            ]);

            $pago->pedido->update(['estado' => 'pagado']);

            return $pago;
        });
    }

    public function generarDatosPago($pago, $metodo)
    {
        switch ($metodo) {
            case 'paypal':
                return $this->generarPayPal($pago);

            case 'stripe':
                return $this->generarStripe($pago);

            case 'tarjeta':
            case 'efectivo':
            case 'transferencia':
                return [
                    'tipo' => $metodo,
                    'instrucciones' => $this->obtenerInstrucciones($metodo),
                    'referencia' => 'PAY-'.$pago->id_pago.'-'.time(),
                ];

            default:
                return ['tipo' => 'desconocido'];
        }
    }

    private function generarPayPal($pago)
    {
        return [
            'tipo' => 'paypal',
            'client_id' => env('PAYPAL_CLIENT_ID', 'TU_PAYPAL_CLIENT_ID'),
            'amount' => $pago->monto,
            'currency' => 'USD',
            'description' => 'Pedido #'.$pago->id_pedido,
            'return_url' => url('/api/pagos/paypal/success'),
            'cancel_url' => url('/api/pagos/paypal/cancel'),
            'webhook_url' => url('/api/pagos/paypal/webhook'),
            'instrucciones' => [
                '1. El frontend debe cargar el SDK de PayPal',
                '2. Usar el client_id proporcionado',
                '3. Crear el botón de PayPal con el monto',
                '4. Al completar, llamar a /api/pagos/confirmar con el payment_id',
            ],
            'ejemplo_frontend' => [
                'sdk_url' => 'https://www.paypal.com/sdk/js?client-id='.env('PAYPAL_CLIENT_ID', 'TU_CLIENT_ID'),
                'metodo' => 'paypal.Buttons().render("#paypal-button-container")',
            ],
        ];
    }

    private function generarStripe($pago)
    {
        return [
            'tipo' => 'stripe',
            'publishable_key' => env('STRIPE_PUBLISHABLE_KEY', 'TU_STRIPE_PUBLISHABLE_KEY'),
            'amount' => $pago->monto * 100,
            'currency' => 'usd',
            'description' => 'Pedido #'.$pago->id_pedido,
            'success_url' => url('/api/pagos/stripe/success'),
            'cancel_url' => url('/api/pagos/stripe/cancel'),
            'webhook_url' => url('/api/pagos/stripe/webhook'),
            'instrucciones' => [
                '1. El frontend debe cargar Stripe.js',
                '2. Usar la publishable_key proporcionada',
                '3. Crear el formulario de pago con Stripe Elements',
                '4. Al completar, llamar a /api/pagos/confirmar con el payment_intent_id',
            ],
            'ejemplo_frontend' => [
                'sdk_url' => 'https://js.stripe.com/v3/',
                'metodo' => 'stripe.confirmCardPayment(clientSecret)',
            ],
        ];
    }

    private function obtenerInstrucciones($metodo)
    {
        $instrucciones = [
            'tarjeta' => 'Proporciona los datos de tu tarjeta para procesar el pago',
            'efectivo' => 'Realiza el pago en efectivo al recibir tu pedido',
            'transferencia' => 'Realiza una transferencia bancaria a la cuenta proporcionada',
        ];

        return $instrucciones[$metodo] ?? 'Sigue las instrucciones para completar el pago';
    }
}
