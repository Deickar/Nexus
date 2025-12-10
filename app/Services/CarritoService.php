<?php

namespace App\Services;

use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class CarritoService
{
    /**
     * Obtener o crear carrito del usuario
     */
    public function obtenerCarritoUsuario($idUsuario)
    {
        $carrito = Carrito::where('id_usuario', $idUsuario)
            ->abierto()
            ->first();

        if (! $carrito) {
            $carrito = Carrito::create([
                'id_usuario' => $idUsuario,
                'estado' => 'abierto',
            ]);
        }

        return $carrito;
    }

    /**
     * Obtener carrito con sus detalles
     */
    public function obtenerCarritoConDetalles($idUsuario)
    {
        $carrito = $this->obtenerCarritoUsuario($idUsuario);
        $carrito->load(['detalles.producto.imagenes']);

        return $carrito;
    }

    /**
     * Agregar producto al carrito
     */
    public function agregarProducto($idUsuario, $idProducto, $cantidad)
    {
        return DB::transaction(function () use ($idUsuario, $idProducto, $cantidad) {
            $producto = Producto::findOrFail($idProducto);

            if ($producto->estado !== 'activo') {
                throw new \Exception('El producto no está disponible');
            }

            if (! $producto->tieneStock($cantidad)) {
                throw new \Exception('Stock insuficiente. Disponible: '.$producto->existencia);
            }

            $carrito = $this->obtenerCarritoUsuario($idUsuario);

            $detalle = DetalleCarrito::where('id_carrito', $carrito->id_carrito)
                ->where('id_producto', $idProducto)
                ->first();

            if ($detalle) {
                $nuevaCantidad = $detalle->cantidad + $cantidad;

                if (! $producto->tieneStock($nuevaCantidad)) {
                    throw new \Exception('Stock insuficiente. Ya tienes '.$detalle->cantidad.' en el carrito. Disponible: '.$producto->existencia);
                }

                $detalle->update(['cantidad' => $nuevaCantidad]);
                $mensaje = 'Cantidad actualizada en el carrito';
            } else {
                $detalle = DetalleCarrito::create([
                    'id_carrito' => $carrito->id_carrito,
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $producto->precio * $cantidad,
                ]);
                $mensaje = 'Producto agregado al carrito';
            }

            $carrito->load(['detalles.producto.imagenes']);

            return [
                'carrito' => $carrito,
                'mensaje' => $mensaje,
            ];
        });
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function actualizarCantidad($idUsuario, $idDetalle, $cantidad)
    {
        return DB::transaction(function () use ($idUsuario, $idDetalle, $cantidad) {
            $detalle = DetalleCarrito::findOrFail($idDetalle);
            $carrito = $this->obtenerCarritoUsuario($idUsuario);

            if ($detalle->id_carrito !== $carrito->id_carrito) {
                throw new \Exception('No tienes permiso para modificar este item');
            }

            if (! $detalle->producto->tieneStock($cantidad)) {
                throw new \Exception('Stock insuficiente. Disponible: '.$detalle->producto->existencia);
            }

            $detalle->update([
                'cantidad' => $cantidad,
                'subtotal' => $detalle->precio_unitario * $cantidad,
            ]);

            $carrito->load(['detalles.producto.imagenes']);

            return $carrito;
        });
    }

    /**
     * Eliminar un producto del carrito
     */
    public function eliminarProducto($idUsuario, $idDetalle)
    {
        return DB::transaction(function () use ($idUsuario, $idDetalle) {
            $detalle = DetalleCarrito::findOrFail($idDetalle);
            $carrito = $this->obtenerCarritoUsuario($idUsuario);

            if ($detalle->id_carrito !== $carrito->id_carrito) {
                throw new \Exception('No tienes permiso para eliminar este item');
            }

            $detalle->delete();

            $carrito->load(['detalles.producto.imagenes']);

            return $carrito;
        });
    }

    /**
     * Vaciar todo el carrito
     */
    public function vaciarCarrito($idUsuario)
    {
        $carrito = $this->obtenerCarritoUsuario($idUsuario);
        $carrito->vaciar();

        return $carrito;
    }
}
