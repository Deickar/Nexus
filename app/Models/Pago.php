<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pago
 * 
 * Representa un pago realizado por un usuario.
 * Soporta múltiples métodos de pago: PayPal, Stripe, Tarjeta, Efectivo, Transferencia
 */
class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'id_usuario',
        'metodo_pago',
        'referencia_transaccion',
        'monto',
        'estado'
    ];
    
    protected $casts = [
        'monto' => 'decimal:2',
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
     * Relación con Pedido (a través de pedidos.id_pago)
     */
    public function pedido()
    {
        return $this->hasOne(Pedido::class, 'id_pago', 'id_pago');
    }
    
    /**
     * Scopes para filtrar por estado
     */
    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }
    
    public function scopeCompletado($query)
    {
        return $query->where('estado', 'completado');
    }
    
    public function scopeFallido($query)
    {
        return $query->where('estado', 'fallido');
    }
    
    public function scopeReembolsado($query)
    {
        return $query->where('estado', 'reembolsado');
    }
    
    /**
     * Verificar si el pago está completado
     */
    public function estaCompletado()
    {
        return $this->estado === 'completado';
    }
    
    /**
     * Marcar pago como completado
     */
    public function marcarCompletado($referencia = null)
    {
        $this->update([
            'estado' => 'completado',
            'referencia_transaccion' => $referencia ?? $this->referencia_transaccion
        ]);
    }
    
    /**
     * Marcar pago como fallido
     */
    public function marcarFallido($motivo = null)
    {
        $this->update([
            'estado' => 'fallido',
            'referencia_transaccion' => $motivo ? 'FALLIDO: ' . $motivo : 'FALLIDO'
        ]);
    }
}
