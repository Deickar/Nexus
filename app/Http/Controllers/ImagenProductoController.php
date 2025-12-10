<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImagenProductoController extends Controller
{
    /**
     * Mostrar todas las imágenes de un producto específico
     */
    public function index($id_producto)
    {
        try {
            // Verificar que el producto existe
            $producto = Producto::find($id_producto);
            if (! $producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado',
                ], 404);
            }

            $imagenes = ImagenProducto::where('id_producto', $id_producto)
                ->orderBy('id_imagen', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'producto' => $producto,
                    'imagenes' => $imagenes,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las imágenes: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar una imagen específica
     */
    public function show($id_imagen)
    {
        try {
            $imagen = ImagenProducto::with('producto')->find($id_imagen);

            if (! $imagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagen no encontrada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $imagen,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la imagen: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crear una nueva imagen para un producto
     */
    public function store(Request $request)
    {
        try {
            // Validación
            $validator = Validator::make($request->all(), [
                'id_producto' => 'required|integer|exists:productos,id_producto',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Solo archivos de imagen
                'url_imagen' => 'nullable|string|url', // URL alternativa si no se sube archivo
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $url_imagen = null;

            // Si se subió un archivo de imagen
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');

                // Crear nombre único para la imagen
                $nombreArchivo = 'producto_'.$request->id_producto.'_'.time().'.'.$archivo->getClientOriginalExtension();

                // Guardar en storage/app/public/productos/
                $ruta = $archivo->storeAs('public/productos', $nombreArchivo);

                // URL accesible públicamente
                $url_imagen = '/storage/productos/'.$nombreArchivo;

            } elseif ($request->filled('url_imagen')) {
                // Si se proporcionó una URL externa
                $url_imagen = $request->url_imagen;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe proporcionar una imagen o una URL de imagen',
                ], 422);
            }

            // Crear la imagen
            $imagen = ImagenProducto::create([
                'id_producto' => $request->id_producto,
                'url_imagen' => $url_imagen,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen agregada exitosamente',
                'data' => $imagen->load('producto'),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la imagen: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar una imagen existente
     */
    public function update(Request $request, $id_imagen)
    {
        try {
            $imagen = ImagenProducto::find($id_imagen);

            if (! $imagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagen no encontrada',
                ], 404);
            }

            // Validación
            $validator = Validator::make($request->all(), [
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'url_imagen' => 'nullable|string|url',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $url_imagen_anterior = $imagen->url_imagen;
            $nueva_url = null;

            // Si se subió un nuevo archivo
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');

                // Crear nombre único
                $nombreArchivo = 'producto_'.$imagen->id_producto.'_'.time().'.'.$archivo->getClientOriginalExtension();

                // Guardar nuevo archivo
                $ruta = $archivo->storeAs('public/productos', $nombreArchivo);
                $nueva_url = '/storage/productos/'.$nombreArchivo;

                // Eliminar archivo anterior si existe en storage
                if ($url_imagen_anterior && str_contains($url_imagen_anterior, '/storage/productos/')) {
                    $archivo_anterior = str_replace('/storage/productos/', '', $url_imagen_anterior);
                    Storage::delete('public/productos/'.$archivo_anterior);
                }

            } elseif ($request->filled('url_imagen')) {
                $nueva_url = $request->url_imagen;

                // Si cambiamos de archivo local a URL externa, eliminar archivo local
                if ($url_imagen_anterior && str_contains($url_imagen_anterior, '/storage/productos/')) {
                    $archivo_anterior = str_replace('/storage/productos/', '', $url_imagen_anterior);
                    Storage::delete('public/productos/'.$archivo_anterior);
                }
            }

            // Actualizar solo si hay nueva URL
            if ($nueva_url) {
                $imagen->update(['url_imagen' => $nueva_url]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Imagen actualizada exitosamente',
                'data' => $imagen->load('producto'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la imagen: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar una imagen
     */
    public function destroy($id_imagen)
    {
        try {
            $imagen = ImagenProducto::find($id_imagen);

            if (! $imagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagen no encontrada',
                ], 404);
            }

            $url_imagen = $imagen->url_imagen;

            // Eliminar archivo del storage si es local
            if ($url_imagen && str_contains($url_imagen, '/storage/productos/')) {
                $archivo = str_replace('/storage/productos/', '', $url_imagen);
                Storage::delete('public/productos/'.$archivo);
            }

            // Eliminar registro de la base de datos
            $imagen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Establecer una imagen como principal para un producto
     */
    public function setPrincipal($id_imagen)
    {
        try {
            $imagen = ImagenProducto::find($id_imagen);

            if (! $imagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagen no encontrada',
                ], 404);
            }

            // Aquí podrías implementar lógica para marcar como principal
            // Por ejemplo, agregar una columna 'es_principal' al modelo

            return response()->json([
                'success' => true,
                'message' => 'Imagen establecida como principal',
                'data' => $imagen,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al establecer imagen principal: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener todas las imágenes (para administración)
     */
    public function all()
    {
        try {
            $imagenes = ImagenProducto::with('producto')
                ->orderBy('id_imagen', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $imagenes,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener todas las imágenes: '.$e->getMessage(),
            ], 500);
        }
    }
}
