<?php

namespace App\Services;

use App\Models\Carrito;
use App\Models\DetallePedido;
use App\Models\MovimientoInventario;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    public function listarPedidos($usuario = null, $filtros = [])
    {
        // Mantener Eloquent porque las vistas esperan objetos de modelo
        if (! $usuario || $usuario->id_rol == 1) {
            // Admin ve todos los pedidos
            $query = Pedido::with(['usuario']);

            if (isset($filtros['estado'])) {
                $query->where('estado', $filtros['estado']);
            }

            if (isset($filtros['usuario_id'])) {
                $query->where('id_usuario', $filtros['usuario_id']);
            }

            return $query->orderBy('fecha_creacion', 'desc')->paginate(15);
        } else {
            // Usuario normal solo ve sus pedidos
            return Pedido::with(['usuario'])
                ->where('id_usuario', $usuario->id_usuario)
                ->orderBy('fecha_creacion', 'desc')
                ->paginate(15);
        }
    }

    public function obtenerPedido($id, $usuario = null)
    {
        $pedido = Pedido::with(['usuario', 'detalles.producto', 'pagos'])->findOrFail($id);

        // Si hay usuario y no es admin, verificar permisos
        if ($usuario && $usuario->id_rol != 1 && $pedido->id_usuario != $usuario->id_usuario) {
            throw new \Exception('No tienes permiso para ver este pedido');
        }

        return $pedido;
    }

    public function crearPedido($idUsuario, $datos)
    {
        return DB::transaction(function () use ($idUsuario, $datos) {
            $carrito = Carrito::where('id_usuario', $idUsuario)
                ->where('estado', 'abierto')
                ->with(['detalles.producto'])
                ->first();

            if (! $carrito || $carrito->detalles->isEmpty()) {
                throw new \Exception('El carrito está vacío');
            }

            foreach ($carrito->detalles as $detalle) {
                if (! $detalle->producto->tieneStock($detalle->cantidad)) {
                    throw new \Exception('Stock insuficiente para: '.$detalle->producto->nombre_producto);
                }
            }

            $total = $carrito->calcularTotal();
            $numero_pedido = 'PED-'.date('Ymd').'-'.str_pad(Pedido::count() + 1, 6, '0', STR_PAD_LEFT);

            $pedido = Pedido::create([
                'id_usuario' => $idUsuario,
                'numero_pedido' => $numero_pedido,
                'monto_total' => $total,
                'estado' => 'pendiente',
                'id_pago' => 0,
                'direccion_envio' => $datos['direccion_envio'],
                'telefono_contacto' => $datos['telefono_contacto'],
                'notas' => $datos['notas'] ?? null,
            ]);

            foreach ($carrito->detalles as $detalle) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $detalle->id_producto,
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->producto->precio,
                    'subtotal' => $detalle->producto->precio * $detalle->cantidad,
                ]);

                $detalle->producto->reducirStock($detalle->cantidad);

                MovimientoInventario::create([
                    'id_producto' => $detalle->id_producto,
                    'tipo_movimiento' => 'salida',
                    'cantidad' => $detalle->cantidad,
                    'descripcion' => 'Venta - Pedido #'.$pedido->id_pedido,
                ]);
            }

            $carrito->update(['estado' => 'cerrado']);

            $pedido->load(['detalles.producto']);

            return $pedido;
        });
    }

    public function actualizarEstado($id, $estado)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => $estado]);

        return $pedido;
    }

    public function cancelarPedido($id, $usuario)
    {
        return DB::transaction(function () use ($id, $usuario) {
            $pedido = Pedido::with(['detalles.producto'])->findOrFail($id);

            if ($usuario->id_rol != 1 && $pedido->id_usuario != $usuario->id_usuario) {
                throw new \Exception('No tienes permiso para cancelar este pedido');
            }

            if (! $pedido->puedeCancelarse()) {
                throw new \Exception('No se puede cancelar un pedido en estado: '.$pedido->estado);
            }

            foreach ($pedido->detalles as $detalle) {
                $detalle->producto->aumentarStock($detalle->cantidad);

                MovimientoInventario::create([
                    'id_producto' => $detalle->id_producto,
                    'tipo_movimiento' => 'entrada',
                    'cantidad' => $detalle->cantidad,
                    'descripcion' => 'Devolución - Pedido #'.$pedido->id_pedido.' cancelado',
                ]);
            }

            $pedido->update(['estado' => 'cancelado']);

            return $pedido;
        });
    }
}
