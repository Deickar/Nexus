<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo DetalleCarrito
 *
 * Representa un item dentro del carrito de compras.
 * Cada detalle contiene un producto y su cantidad.
 */
class DetalleCarrito extends Model
{
    protected $table = 'detalle_carrito';

    protected $primaryKey = 'id_detalle_carrito';

    public $timestamps = false;

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relación con Carrito
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito', 'id_carrito');
    }

    /**
     * Relación con Producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    /**
     * Calcular subtotal del item
     */
    public function calcularSubtotal()
    {
        return $this->producto->precio * $this->cantidad;
    }
}
