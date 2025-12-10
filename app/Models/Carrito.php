<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Carrito
 *
 * Representa el carrito de compras de un usuario.
 * Un usuario puede tener un carrito activo a la vez.
 */
class Carrito extends Model
{
    protected $table = 'carritos';

    protected $primaryKey = 'id_carrito';

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_usuario',
        'estado',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Relación con Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con Detalles del Carrito
     */
    public function detalles()
    {
        return $this->hasMany(DetalleCarrito::class, 'id_carrito', 'id_carrito');
    }

    /**
     * Scope para carritos abiertos
     */
    public function scopeAbierto($query)
    {
        return $query->where('estado', 'abierto');
    }

    /**
     * Calcular total del carrito
     */
    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->detalles as $detalle) {
            $total += $detalle->producto->precio * $detalle->cantidad;
        }

        return $total;
    }

    /**
     * Contar items en el carrito
     */
    public function contarItems()
    {
        return $this->detalles->sum('cantidad');
    }

    /**
     * Vaciar carrito
     */
    public function vaciar()
    {
        $this->detalles()->delete();

        return true;
    }

    /**
     * Serialización a JSON
     */
    public function toArray()
    {
        return [
            'id' => $this->id_carrito,
            'usuario_id' => $this->id_usuario,
            'estado' => $this->estado,
            'items' => $this->detalles->map(function ($detalle) {
                return [
                    'id' => $detalle->id_detalle_carrito,
                    'producto' => [
                        'id' => $detalle->producto->id_producto,
                        'nombre' => $detalle->producto->nombre_producto,
                        'precio' => (float) $detalle->producto->precio,
                        'imagen' => $detalle->producto->imagenes->first()->url_imagen ?? null,
                    ],
                    'cantidad' => $detalle->cantidad,
                    'subtotal' => (float) ($detalle->producto->precio * $detalle->cantidad),
                ];
            }),
            'total_items' => $this->contarItems(),
            'total' => (float) $this->calcularTotal(),
            'created_at' => $this->fecha_creacion,
            'updated_at' => $this->fecha_actualizacion,
        ];
    }
}
