<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImagenProducto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ImagenProductoController extends Controller
{
    /**
     * Obtener todas las imágenes de un producto específico
     */
    public function getByProduct($idProducto): JsonResponse
    {
        try {
            $imagenes = ImagenProducto::where('id_producto', $idProducto)
                                   ->get()
                                   ->map(function ($imagen) {
                                       return [
                                           'id_imagen' => $imagen->id_imagen,
                                           'id_producto' => $imagen->id_producto,
                                           'url_imagen' => $imagen->url_imagen,
                                           'url_completa' => $this->buildImageUrl($imagen->url_imagen)
                                       ];
                                   });

            return response()->json([
                'success' => true,
                'data' => $imagenes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener imagen principal de un producto (la primera)
     */
    public function getMainImage($idProducto): JsonResponse
    {
        try {
            // Debug: verificar parámetro
            if (!$idProducto) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de producto no proporcionado'
                ], 400);
            }

            // Debug: buscar imagen
            $imagen = ImagenProducto::where('id_producto', $idProducto)->first();

            if (!$imagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró imagen para el producto ' . $idProducto,
                    'data' => [
                        'url_imagen' => '/img/placeholder.png',
                        'url_completa' => url('/img/placeholder.png')
                    ]
                ], 404);
            }

            // Debug: construir respuesta
            $urlCompleta = $this->buildImageUrl($imagen->url_imagen);

            return response()->json([
                'success' => true,
                'debug' => [
                    'id_producto_recibido' => $idProducto,
                    'imagen_encontrada' => true,
                    'url_original' => $imagen->url_imagen
                ],
                'data' => [
                    'id_imagen' => $imagen->id_imagen,
                    'id_producto' => $imagen->id_producto,
                    'url_imagen' => $imagen->url_imagen,
                    'url_completa' => $urlCompleta
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener imagen principal: ' . $e->getMessage(),
                'debug' => [
                    'id_producto' => $idProducto,
                    'exception' => $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Listar todas las imágenes
     */
    public function index(): JsonResponse
    {
        try {
            $imagenes = ImagenProducto::with('producto:id_producto,nombre_producto')
                                    ->get()
                                    ->map(function ($imagen) {
                                        return [
                                            'id_imagen' => $imagen->id_imagen,
                                            'id_producto' => $imagen->id_producto,
                                            'producto' => $imagen->producto->nombre_producto ?? 'Sin producto',
                                            'url_imagen' => $imagen->url_imagen,
                                            'url_completa' => $this->buildImageUrl($imagen->url_imagen)
                                        ];
                                    });

            return response()->json([
                'success' => true,
                'data' => $imagenes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear nueva imagen para un producto
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_producto' => 'required|integer|exists:productos,id_producto',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Subir imagen al servidor SFTP
            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();

            // Subir directamente a la raíz de nexus_storage (sin subcarpeta productos)
            Storage::disk('sftp_remote')->put($nombreArchivo, file_get_contents($imagen->getPathname()));

            // La URL que guardaremos en la BD será la ruta del servidor remoto
            $urlImagen = '/var/www/nexus_storage/' . $nombreArchivo;            // Guardar en base de datos
            $imagenProducto = ImagenProducto::create([
                'id_producto' => $request->id_producto,
                'url_imagen' => $urlImagen
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida exitosamente al servidor remoto',
                'data' => [
                    'id_imagen' => $imagenProducto->id_imagen,
                    'id_producto' => $imagenProducto->id_producto,
                    'url_imagen' => $imagenProducto->url_imagen,
                    'url_completa' => $this->buildImageUrl($imagenProducto->url_imagen)
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar imagen
     */
    public function destroy($id): JsonResponse
    {
        try {
            $imagen = ImagenProducto::findOrFail($id);

            // Eliminar archivo físico si existe
            if (Storage::disk('public')->exists(str_replace('/storage/', '', $imagen->url_imagen))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $imagen->url_imagen));
            }

            $imagen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método de prueba para verificar que el controlador funciona
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Controlador ImagenProductoController funcionando',
            'timestamp' => now()
        ]);
    }

    /**
     * Construir URL completa de la imagen
     */
    private function buildImageUrl($urlImagen): string
    {
        // Si ya es una URL completa, devolverla tal como está
        if (str_starts_with($urlImagen, 'http')) {
            return $urlImagen;
        }

        // Si es una ruta del servidor remoto, construir URL correcta
        if (str_starts_with($urlImagen, '/var/www/nexus_storage/')) {
            // Extraer solo el nombre del archivo
            $fileName = basename($urlImagen);
            // Construir URL apuntando directamente a nexus_storage
            return 'http://' . env('SFTP_HOST') . ':8000/' . $fileName;
        }

        // Si es una ruta local, construir URL local
        return url($urlImagen);
    }

    /**
     * Obtener imágenes de múltiples productos (para el home)
     */
    public function getImagesByProducts(Request $request): JsonResponse
    {
        try {
            $productIds = $request->input('product_ids', []);

            if (empty($productIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se proporcionaron IDs de productos'
                ], 400);
            }

            $imagenes = ImagenProducto::whereIn('id_producto', $productIds)
                                   ->get()
                                   ->groupBy('id_producto')
                                   ->map(function ($imagenesProducto) {
                                       return $imagenesProducto->map(function ($imagen) {
                                           return [
                                               'id_imagen' => $imagen->id_imagen,
                                               'url_imagen' => $imagen->url_imagen,
                                               'url_completa' => $this->buildImageUrl($imagen->url_imagen)
                                           ];
                                       });
                                   });

            return response()->json([
                'success' => true,
                'data' => $imagenes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener imágenes: ' . $e->getMessage()
            ], 500);
        }
    }
}
