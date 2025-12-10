<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * PERFIL
     */
    public function profile()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        // Separar nombre en nombre y apellido(s) a partir de nombre_completo
        $nameParts = preg_split('/\s+/', $user->nombre_completo ?? '');
        $firstName = $nameParts[0] ?? '';
        $lastName = implode(' ', array_slice($nameParts, 1));

        return view('account.profile', compact('user', 'firstName', 'lastName'));
    }

    /**
     * ACTUALIZAR PERFIL
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        // Validación basada en tu tabla `usuarios`
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:150|unique:usuarios,correo_electronico,'.$user->id_usuario.',id_usuario',
            // 'birth_date' => 'nullable|date', // no existe campo en BD, por eso NO lo guardamos
        ]);

        // Guardar en la BD
        $user->nombre_completo = trim($request->first_name.' '.$request->last_name);
        $user->telefono = $request->phone;
        $user->correo_electronico = $request->email;
        // Si algún día agregas fecha_nacimiento en la tabla, aquí se guardaría:
        // $user->fecha_nacimiento   = $request->birth_date;

        $user->save();

        return back()->with('status', 'Perfil actualizado correctamente.');
    }

    /**
     * DIRECCIÓN
     */
    public function address()
    {
        return view('account.address');
    }

    /**
     * ÓRDENES
     */
    public function orders()
    {
        return view('account.orders');
    }

    /**
     * FAVORITOS
     */
    public function favorites()
    {
        return view('account.favorites');
    }

    /**
     * RESEÑAS DEL USUARIO
     */
    public function reviews()
    {
        $userId = Auth::id();

        if (! $userId) {
            return redirect()->route('login');
        }

        $reviews = Review::with('producto')
            ->byUser($userId)
            ->orderByDesc('review_date')
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->review_id,
                    'product' => $review->producto->nombre_producto ?? 'Producto no disponible',
                    'date' => optional($review->review_date)->format('d/m/Y'),
                    'rating' => $review->rating,
                    'comment' => $review->comment ?: 'Sin comentario',
                    'status' => $review->status == Review::STATUS_APPROVED ? 'Publicado' : 'Pendiente',
                ];
            });

        return view('account.reviews', compact('reviews'));
    }
}
