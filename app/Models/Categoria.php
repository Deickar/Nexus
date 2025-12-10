<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
    ];

    /**
     * Relación con Productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }

    public function toArray()
    {
        return [
            'id' => $this->id_categoria,
            'nombre' => $this->nombre_categoria,
            'descripcion' => $this->descripcion,
            'total_productos' => $this->productos()->count(),
        ];
    }
}
