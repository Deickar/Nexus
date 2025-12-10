<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Productos nuevos (si aún no los usas, igual puedes dejarlos listos)
        $productosNuevos = Producto::activos()
            ->conStock()
            ->with('imagenes')
            ->orderByDesc('fecha_creacion')
            ->take(10)
            ->get();

        // ⭐ Reseñas aprobadas para el home (4 más recientes)
        $reviewsHome = Review::with(['producto', 'usuario'])
            ->approved()
            ->orderByDesc('review_date')
            ->take(4)
            ->get();

        // IMPORTANTE: pasar ambas variables a la vista
        return view('home', compact('productosNuevos', 'reviewsHome'));
    }
}
