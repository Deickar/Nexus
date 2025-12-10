<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto
 *
 * Representa un producto en el catálogo del e-commerce.
 * Incluye información básica, precio, stock y relaciones con categorías y marcas.
 */
class Producto extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'productos';

    // Clave primaria
    protected $primaryKey = 'id_producto';

    // Timestamps personalizados
    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio',
        'existencia',
        'id_categoria',
        'id_marca',
        'estado',
    ];

    // Campos ocultos en JSON
    protected $hidden = [];

    // Casteo de tipos
    protected $casts = [
        'precio' => 'decimal:2',
        'existencia' => 'integer',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Relación con Categoría
     * Un producto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    /**
     * Relación con Marca
     * Un producto pertenece a una marca
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    /**
     * Relación con Imágenes
     * Un producto puede tener múltiples imágenes
     */
    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto', 'id_producto');
    }

    /**
     * Relación con Movimientos de Inventario
     * Un producto puede tener múltiples movimientos
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_producto', 'id_producto');
    }

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para productos con stock
     */
    public function scopeConStock($query)
    {
        return $query->where('existencia', '>', 0);
    }

    /**
     * Scope para buscar productos
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre_producto', 'like', "%{$termino}%")
            ->orWhere('descripcion', 'like', "%{$termino}%");
    }

    /**
     * Verificar si el producto tiene stock suficiente
     */
    public function tieneStock($cantidad = 1)
    {
        return $this->existencia >= $cantidad;
    }

    /**
     * Reducir stock del producto
     */
    public function reducirStock($cantidad)
    {
        if ($this->tieneStock($cantidad)) {
            $this->existencia -= $cantidad;
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Aumentar stock del producto
     */
    public function aumentarStock($cantidad)
    {
        $this->existencia += $cantidad;
        $this->save();

        return true;
    }

    /**
     * Serialización a JSON para API
     */
    public function toArray()
    {
        return [
            'id' => $this->id_producto,
            'nombre' => $this->nombre_producto,
            'descripcion' => $this->descripcion,
            'precio' => (float) $this->precio,
            'stock' => $this->existencia,
            'categoria' => $this->categoria ? [
                'id' => $this->categoria->id_categoria,
                'nombre' => $this->categoria->nombre_categoria,
            ] : null,
            'marca' => $this->marca ? [
                'id' => $this->marca->id_marca,
                'nombre' => $this->marca->nombre_marca,
            ] : null,
            'imagenes' => $this->imagenes->map(function ($imagen) {
                return [
                    'id' => $imagen->id_imagen,
                    'url' => $imagen->url_imagen,
                ];
            }),
            'estado' => $this->estado,
            'created_at' => $this->fecha_creacion,
            'updated_at' => $this->fecha_actualizacion,
        ];
    }
}
