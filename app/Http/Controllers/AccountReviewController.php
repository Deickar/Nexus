<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountReviewController extends Controller
{
    /**
     * Mostrar reseñas del usuario autenticado
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Reseñas del usuario con datos de producto
        $reviews = Review::with('producto')
            ->byUser($userId)
            ->orderBy('review_date', 'desc')
            ->paginate(10);

        // Productos para el formulario de nueva reseña
        // (por ahora todos los productos activos, luego se puede limitar a "comprados")
        $productos = Producto::activos()
            ->orderBy('nombre_producto')
            ->get(['id_producto', 'nombre_producto']);

        return view('account.reviews', [
            'reviews' => $reviews,
            'productos' => $productos,
        ]);
    }

    /**
     * Crear una nueva reseña desde el perfil (Mis reseñas)
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|integer|exists:productos,id_producto',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'id_producto.required' => 'Debes seleccionar un producto.',
            'id_producto.exists' => 'El producto seleccionado no existe.',
            'rating.required' => 'Debes seleccionar una valoración.',
            'rating.between' => 'La valoración debe ser entre 1 y 5 estrellas.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('account.reviews')
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar si ya hizo reseña de ese producto
        $existe = Review::where('id_usuario', $userId)
            ->where('id_producto', $request->id_producto)
            ->first();

        if ($existe) {
            return redirect()
                ->route('account.reviews')
                ->with('status_error', 'Ya has enviado una reseña para este producto.')
                ->withInput();
        }

        Review::create([
            'id_producto' => $request->id_producto,
            'id_usuario' => $userId,
            'review_date' => now(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => \App\Models\Review::STATUS_PENDING, // pendiente de aprobación
        ]);

        return redirect()
            ->route('account.reviews')
            ->with('status', 'Tu reseña fue enviada y está pendiente de aprobación.');
    }
}
