<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Listar todas las reseñas (filtradas por producto si se especifica)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Review::with(['producto', 'usuario']);

            // Filtrar por producto si se especifica
            if ($request->has('id_producto')) {
                $query->byProduct($request->id_producto);
            }

            // Solo mostrar reseñas aprobadas por defecto
            if (!$request->has('include_all')) {
                $query->approved();
            }

            $reviews = $query->orderBy('review_date', 'desc')->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $reviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las reseñas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva reseña
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_producto' => 'required|integer|exists:productos,id_producto',
                'rating' => 'required|integer|between:1,5',
                'comment' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userId = Auth::id();

            // Verificar si el usuario ya ha hecho una reseña de este producto
            $existingReview = Review::where('id_usuario', $userId)
                                  ->where('id_producto', $request->id_producto)
                                  ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya has enviado una reseña para este producto'
                ], 409);
            }

            $review = Review::create([
                'id_producto' => $request->id_producto,
                'id_usuario' => $userId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'review_date' => now(),
                'status' => Review::STATUS_PENDING
            ]);

            $review->load(['producto', 'usuario']);

            return response()->json([
                'success' => true,
                'message' => 'Reseña enviada exitosamente. Está pendiente de aprobación.',
                'data' => $review
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reseña: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una reseña específica
     */
    public function show(string $id): JsonResponse
    {
        try {
            $review = Review::with(['producto', 'usuario'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $review
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reseña no encontrada'
            ], 404);
        }
    }

    /**
     * Actualizar una reseña (solo el autor)
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);

            // Verificar que el usuario sea el autor de la reseña
            if ($review->id_usuario !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para editar esta reseña'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'rating' => 'sometimes|integer|between:1,5',
                'comment' => 'sometimes|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $review->update($request->only(['rating', 'comment']));
            $review->load(['producto', 'usuario']);

            return response()->json([
                'success' => true,
                'message' => 'Reseña actualizada exitosamente',
                'data' => $review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la reseña: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una reseña (solo el autor)
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);

            // Verificar que el usuario sea el autor de la reseña
            if ($review->id_usuario !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para eliminar esta reseña'
                ], 403);
            }

            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reseña eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la reseña: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener reseñas del usuario autenticado
     */
    public function myReviews(): JsonResponse
    {
        try {
            $reviews = Review::with(['producto'])
                           ->byUser(Auth::id())
                           ->orderBy('review_date', 'desc')
                           ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $reviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tus reseñas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las reseñas con datos de producto y usuario
     * Equivalente a la consulta SQL con JOINs
     */
    public function getAllReviewsData(Request $request): JsonResponse
    {
        try {
            $query = Review::with(['producto:id_producto,nombre_producto', 'usuario:id_usuario,nombre_completo'])
                          ->select([
                              'review_id',
                              'id_producto',
                              'id_usuario',
                              'review_date',
                              'rating',
                              'comment',
                              'status'
                          ]);

            // Filtros opcionales
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('rating')) {
                $query->where('rating', $request->rating);
            }

            if ($request->has('id_producto')) {
                $query->where('id_producto', $request->id_producto);
            }

            // Ordenamiento
            $orderBy = $request->get('order_by', 'review_date');
            $orderDirection = $request->get('order_direction', 'desc');
            $query->orderBy($orderBy, $orderDirection);

            // Paginación
            $perPage = $request->get('per_page', 15);
            $reviews = $query->paginate($perPage);

            // Transformar los datos para que coincidan exactamente con la consulta SQL
            $transformedData = $reviews->getCollection()->map(function ($review) {
                return [
                    'review_id' => $review->review_id,
                    'nombre_producto' => $review->producto->nombre_producto ?? null,
                    'nombre_completo' => $review->usuario->nombre_completo ?? null,
                    'review_date' => $review->review_date,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'status' => $review->status,
                    'status_text' => $this->getStatusText($review->status)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedData,
                'pagination' => [
                    'current_page' => $reviews->currentPage(),
                    'per_page' => $reviews->perPage(),
                    'total' => $reviews->total(),
                    'last_page' => $reviews->lastPage(),
                    'from' => $reviews->firstItem(),
                    'to' => $reviews->lastItem()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos de reseñas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener texto descriptivo del estado de la reseña
     */
    private function getStatusText($status): string
    {
        return match($status) {
            Review::STATUS_PENDING => 'Pendiente',
            Review::STATUS_APPROVED => 'Aprobada',
            Review::STATUS_REJECTED => 'Rechazada',
            default => 'Desconocido'
        };
    }
}
