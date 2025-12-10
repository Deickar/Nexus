<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    protected $primaryKey = 'id_movimiento';

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_producto',
        'tipo_movimiento',
        'cantidad',
        'descripcion',
    ];

    /**
     * Relación con Producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function toArray()
    {
        return [
            'id' => $this->id_movimiento,
            'producto' => $this->producto ? [
                'id' => $this->producto->id_producto,
                'nombre' => $this->producto->nombre_producto,
            ] : null,
            'tipo' => $this->tipo_movimiento,
            'cantidad' => $this->cantidad,
            'descripcion' => $this->descripcion,
            'fecha' => $this->fecha_creacion,
        ];
    }
}
