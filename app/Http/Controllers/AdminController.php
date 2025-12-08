<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * Este método es el responsable de renderizar la vista principal del panel de administración.
     * Ahora, en lugar de usar datos simulados, se conecta a la API para obtener los productos
     * y los pasa a la vista para su correcta visualización.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- Obtener Datos de Productos desde la API ---
        $productsResponse = Http::get('http://127.0.0.1:8000/admin/productos');
        $products = $productsResponse->successful() ? $productsResponse->json() : [];

        // --- Obtener Datos del Dashboard desde la API ---
        $dashboardResponse = Http::get('http://127.0.0.1:8000/admin/dashboard');
        $dashboardData = $dashboardResponse->successful() ? $dashboardResponse->json() : [];

        // Se pasan todos los datos a la vista.
        return view('admin.index', [
            'products' => $products,
            'dashboardData' => $dashboardData
        ]);
    }

    /**
     * Muestra la página de perfil del administrador.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // TODO: Obtener los datos del usuario autenticado
        $admin = (object)[
            'name' => 'Admin Nexus',
            'email' => 'admin@nexus.com'
        ];
        return view('admin.profile', ['admin' => $admin]);
    }

    /**
     * Actualiza el perfil del administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // TODO: Implementar la lógica de validación y actualización
        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
