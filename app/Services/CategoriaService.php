<?php

namespace App\Services;

use App\Models\Categoria;

class CategoriaService
{
    public function listarCategorias($filtros = [], $perPage = null)
    {
        $query = Categoria::withCount('productos');
        
        // Filtro por búsqueda de nombre
        if (isset($filtros['buscar']) && !empty($filtros['buscar'])) {
            $query->where('nombre_categoria', 'like', '%' . $filtros['buscar'] . '%');
        }
        
        $query->orderBy('nombre_categoria', 'asc');
        
        if ($perPage) {
            return $query->paginate($perPage);
        }
        
        return $query->get();
    }
    
    public function obtenerCategoria($id)
    {
        return Categoria::withCount('productos')->findOrFail($id);
    }
    
    public function crearCategoria($datos)
    {
        return Categoria::create($datos);
    }
    
    public function actualizarCategoria($id, $datos)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($datos);
        
        return $categoria;
    }
    
    public function eliminarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        if ($categoria->productos()->count() > 0) {
            throw new \Exception('No se puede eliminar la categoría porque tiene productos asociados');
        }
        
        $categoria->delete();
        
        return true;
    }
    
    public function obtenerProductosCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        $productos = $categoria->productos()
                              ->with(['marca', 'imagenes'])
                              ->where('estado', 'activo')
                              ->get();
        
        return [
            'categoria' => $categoria,
            'productos' => $productos
        ];
    }
}
