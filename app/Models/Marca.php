<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';

    protected $primaryKey = 'id_marca';

    public $timestamps = false;

    protected $fillable = [
        'nombre_marca',
        'descripcion',
    ];

    /**
     * Relación con Productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_marca', 'id_marca');
    }

    public function toArray()
    {
        return [
            'id' => $this->id_marca,
            'nombre' => $this->nombre_marca,
            'descripcion' => $this->descripcion,
            'total_productos' => $this->productos()->count(),
        ];
    }
}
