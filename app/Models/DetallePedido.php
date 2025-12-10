<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo DetallePedido
 * 
 * Representa un item dentro de un pedido.
 * Guarda el precio al momento de la compra.
 */
class DetallePedido extends Model
{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id_detalle_pedido';
    
    public $timestamps = false;
    
    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];
    
    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];
    
    /**
     * Relación con Pedido
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
    
    /**
     * Relación con Producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
