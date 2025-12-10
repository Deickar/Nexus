<?php

namespace App\Services;

use App\Models\MovimientoInventario;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductoService
{
    public function listarProductos($filtros, $perPage = 15)
    {
        // Mantener Eloquent porque las vistas esperan objetos de modelo
        $query = Producto::with(['categoria', 'marca', 'imagenes']);

        if (isset($filtros['buscar'])) {
            $query->buscar($filtros['buscar']);
        }

        if (isset($filtros['categoria'])) {
            $query->where('id_categoria', $filtros['categoria']);
        }

        if (isset($filtros['marca'])) {
            $query->where('id_marca', $filtros['marca']);
        }

        if (isset($filtros['precio_min'])) {
            $query->where('precio', '>=', $filtros['precio_min']);
        }

        if (isset($filtros['precio_max'])) {
            $query->where('precio', '<=', $filtros['precio_max']);
        }

        if (isset($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        } else {
            $query->activos();
        }

        $orden = $filtros['orden'] ?? 'recientes';
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'nombre':
                $query->orderBy('nombre_producto', 'asc');
                break;
            default:
                $query->orderBy('fecha_creacion', 'desc');
                break;
        }

        return $query->paginate($perPage);
    }

    public function obtenerProducto($id)
    {
        return Producto::with(['categoria', 'marca', 'imagenes'])->findOrFail($id);
    }

    public function crearProducto($datos)
    {
        return DB::transaction(function () use ($datos) {
            $producto = Producto::create([
                'nombre_producto' => $datos['nombre_producto'],
                'descripcion' => $datos['descripcion'] ?? null,
                'precio' => $datos['precio'],
                'existencia' => $datos['existencia'],
                'id_categoria' => $datos['id_categoria'],
                'id_marca' => $datos['id_marca'],
                'estado' => $datos['estado'] ?? 'activo',
            ]);

            if (isset($datos['imagenes'])) {
                foreach ($datos['imagenes'] as $url) {
                    $producto->imagenes()->create(['url_imagen' => $url]);
                }
            }

            MovimientoInventario::create([
                'id_producto' => $producto->id_producto,
                'tipo_movimiento' => 'entrada',
                'cantidad' => $datos['existencia'],
                'descripcion' => 'Stock inicial del producto',
            ]);

            $producto->load(['categoria', 'marca', 'imagenes']);

            return $producto;
        });
    }

    public function actualizarProducto($id, $datos)
    {
        return DB::transaction(function () use ($id, $datos) {
            $producto = Producto::findOrFail($id);
            $existenciaAnterior = $producto->existencia;

            $producto->update(array_filter($datos, function ($key) {
                return in_array($key, ['nombre_producto', 'descripcion', 'precio', 'existencia', 'id_categoria', 'id_marca', 'estado']);
            }, ARRAY_FILTER_USE_KEY));

            if (isset($datos['existencia']) && $datos['existencia'] != $existenciaAnterior) {
                $diferencia = $datos['existencia'] - $existenciaAnterior;
                MovimientoInventario::create([
                    'id_producto' => $producto->id_producto,
                    'tipo_movimiento' => $diferencia > 0 ? 'entrada' : 'salida',
                    'cantidad' => abs($diferencia),
                    'descripcion' => 'Ajuste de inventario',
                ]);
            }

            $producto->load(['categoria', 'marca', 'imagenes']);

            return $producto;
        });
    }

    public function eliminarProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update(['estado' => 'inactivo']);

        return $producto;
    }

    public function agregarImagen($idProducto, $urlImagen)
    {
        $producto = Producto::findOrFail($idProducto);

        return $producto->imagenes()->create(['url_imagen' => $urlImagen]);
    }

    public function eliminarImagen($idImagen)
    {
        $imagen = \App\Models\ImagenProducto::findOrFail($idImagen);

        // Si la imagen está almacenada localmente, eliminar el archivo físico
        if (str_contains($imagen->url_imagen, 'storage/productos/')) {
            $rutaArchivo = str_replace(asset('storage/'), '', $imagen->url_imagen);
            $rutaArchivo = str_replace(url('storage/'), '', $rutaArchivo);
            $rutaArchivo = 'public/'.basename(dirname($rutaArchivo)).'/'.basename($rutaArchivo);

            if (\Storage::exists($rutaArchivo)) {
                \Storage::delete($rutaArchivo);
            }
        }

        $imagen->delete();

        return true;
    }
}
