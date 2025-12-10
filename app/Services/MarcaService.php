<?php

namespace App\Services;

use App\Models\Marca;

class MarcaService
{
    public function listarMarcas($filtros = [], $perPage = null)
    {
        $query = Marca::withCount('productos');
        
        // Filtro por búsqueda de nombre
        if (isset($filtros['buscar']) && !empty($filtros['buscar'])) {
            $query->where('nombre_marca', 'like', '%' . $filtros['buscar'] . '%');
        }
        
        $query->orderBy('nombre_marca', 'asc');
        
        if ($perPage) {
            return $query->paginate($perPage);
        }
        
        return $query->get();
    }
    
    public function obtenerMarca($id)
    {
        return Marca::withCount('productos')->findOrFail($id);
    }
    
    public function crearMarca($datos)
    {
        return Marca::create($datos);
    }
    
    public function actualizarMarca($id, $datos)
    {
        $marca = Marca::findOrFail($id);
        $marca->update($datos);
        
        return $marca;
    }
    
    public function eliminarMarca($id)
    {
        $marca = Marca::findOrFail($id);
        
        if ($marca->productos()->count() > 0) {
            throw new \Exception('No se puede eliminar la marca porque tiene productos asociados');
        }
        
        $marca->delete();
        
        return true;
    }
    
    public function obtenerProductosMarca($id)
    {
        $marca = Marca::findOrFail($id);
        
        $productos = $marca->productos()
                          ->with(['categoria', 'imagenes'])
                          ->where('estado', 'activo')
                          ->get();
        
        return [
            'marca' => $marca,
            'productos' => $productos
        ];
    }
}
