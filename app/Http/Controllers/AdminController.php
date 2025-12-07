<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * Este método es el responsable de renderizar la vista principal del panel de administración.
     * En el futuro, se encargará de recopilar todos los datos necesarios de la base de datos
     * y pasarlos a la vista para su correcta visualización.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- Simulación de Datos de Productos ---
        // Este array simula los datos que normalmente vendrían de la base de datos.
        // Se utiliza para rellenar las secciones "Umbral de existencias" y "Productos más vendidos".
        // Las rutas de las imágenes son relativas al directorio `public`.
        $products = [
            [
                'image' => 'img/audifonos.jpg',
                'name' => 'Auriculares Inalámbricos',
                'description' => 'Auriculares con cancelación de ruido y alta fidelidad de sonido.',
                'price' => 79.99,
                'stock' => 15,
            ],
            [
                'image' => 'img/lenovolaptop.jpg',
                'name' => 'Laptop Lenovo',
                'description' => 'Portátil ultraligero con procesador de última generación y 16GB de RAM.',
                'price' => 899.99,
                'stock' => 8,
            ],
            [
                'image' => 'img/perfumehugoboss.jpg',
                'name' => 'Perfume Hugo Boss',
                'description' => 'Fragancia masculina con notas amaderadas y frescas, ideal para toda ocasión.',
                'price' => 59.50,
                'stock' => 3,
            ],
            [
                'image' => 'img/zapatozara.jpg',
                'name' => 'Zapatos de Cuero Zara',
                'description' => 'Zapatos de vestir elegantes, fabricados con cuero de alta calidad.',
                'price' => 120.00,
                'stock' => 25,
            ],
        ];

        // Se pasan los datos de los productos a la vista.
        // La vista `admin.index` recibirá una variable `$products` que podrá utilizar.
        return view('admin.index', ['products' => $products]);
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
