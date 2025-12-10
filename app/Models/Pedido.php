<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pedido
 * 
 * Representa una orden de compra realizada por un usuario.
 * Contiene información del pedido y su estado.
 */
class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'id_usuario',
        'numero_pedido',
        'monto_total',
        'estado',
        'id_pago'
    ];
    
    protected $casts = [
        'monto_total' => 'decimal:2',
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
     * Relación con Detalles del Pedido
     */
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
    
    /**
     * Relación con Pagos
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_pedido', 'id_pedido');
    }
    
    /**
     * Scopes para filtrar por estado
     */
    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }
    
    public function scopePagado($query)
    {
        return $query->where('estado', 'pagado');
    }
    
    public function scopeEnviado($query)
    {
        return $query->where('estado', 'enviado');
    }
    
    public function scopeEntregado($query)
    {
        return $query->where('estado', 'entregado');
    }
    
    public function scopeCancelado($query)
    {
        return $query->where('estado', 'cancelado');
    }
    
    /**
     * Verificar si el pedido puede ser cancelado
     */
    public function puedeCancelarse()
    {
        return in_array($this->estado, ['pendiente', 'pagado']);
    }
    
    /**
     * Calcular total del pedido
     */
    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->detalles as $detalle) {
            $total += $detalle->precio_unitario * $detalle->cantidad;
        }
        return $total;
    }
    
    /**
     * Serialización a JSON
     */
    public function toArray()
    {
        return [
            'id' => $this->id_pedido,
            'usuario' => [
                'id' => $this->usuario->id_usuario,
                'nombre' => $this->usuario->nombre_completo,
                'email' => $this->usuario->correo_electronico,
            ],
            'items' => $this->detalles->map(function($detalle) {
                return [
                    'id' => $detalle->id_detalle_pedido,
                    'producto' => [
                        'id' => $detalle->producto->id_producto,
                        'nombre' => $detalle->producto->nombre_producto,
                    ],
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => (float) $detalle->precio_unitario,
                    'subtotal' => (float) $detalle->subtotal
                ];
            }),
            'total' => (float) $this->monto_total,
            'estado' => $this->estado,
            'direccion_envio' => $this->direccion_envio,
            'telefono_contacto' => $this->telefono_contacto,
            'notas' => $this->notas,
            'created_at' => $this->fecha_creacion,
            'updated_at' => $this->fecha_actualizacion,
        ];
    }
}
