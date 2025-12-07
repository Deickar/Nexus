<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function profile()
    {
        // Aquí se cargarán datos reales del usuario
        return view('account.profile');
    }

    public function updateProfile(Request $request)
    {
        // Aquí se validará y guardará en la BD.
        // Por ahora solo valida y muestra un mesnaje.

        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_date'    => 'required|date',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email',
        ]);

        // Aquí:
        // auth()->user()->update([...]);

        return back()->with('status', 'Perfil actualizado (modo demo, sin guardar en BD).');
    }
    public function address()
{
    // Aquí se cargará la dirección real del usuario
    return view('account.address');
}

public function updateAddress(Request $request)
{
    $request->validate([
        'street'      => 'required|string|max:255',
        'number'      => 'nullable|string|max:50',
        'city'        => 'required|string|max:255',
        'department'  => 'required|string|max:255',
        'postal_code' => 'nullable|string|max:20',
        'reference'   => 'nullable|string|max:500',
    ]);

    // Aquí se coloca: auth()->user()->address()->updateOrCreate([...])

    return back()->with('status', 'Dirección actualizada (modo demo, sin guardar en BD).');
}

public function orders()
    {
        // Datos de ejemplo 
        $orders = [
            [
                'code'   => 'NX-10234',
                'date'   => '24/10/2025',
                'status' => 'Completada',
                'total'  => 'Q 950.00',
            ],
            [
                'code'   => 'NX-10235',
                'date'   => '10/11/2025',
                'status' => 'En proceso',
                'total'  => 'Q 1,800.00',
            ],
            [
                'code'   => 'NX-10236',
                'date'   => '15/11/2025',
                'status' => 'Cancelada',
                'total'  => 'Q 420.00',
            ],
        ];

        return view('account.orders', compact('orders'));
    }

    public function reviews()
{
    // Datos de ejemplo de reseñas
    $reviews = [
        [
            'product' => 'Tab K10 Lenovo',
            'date'    => '24/10/2025',
            'rating'  => 5,
            'comment' => 'Excelente tablet, rápida y con pantalla muy nítida.',
            'status'  => 'Publicado',
        ],
        [
            'product' => 'Audífonos JBL Tune 760NC',
            'date'    => '10/11/2025',
            'rating'  => 4,
            'comment' => 'Muy buen sonido y batería, un poco grandes para mi gusto.',
            'status'  => 'Publicado',
        ],
        [
            'product' => 'Bailarina efecto terciopelo',
            'date'    => '15/11/2025',
            'rating'  => 3,
            'comment' => 'Bonitas, pero la talla viene un poco reducida.',
            'status'  => 'Pendiente',
        ],
    ];

    return view('account.reviews', compact('reviews'));
}

public function favorites()
{
    // Datos dde ejemplo para los favoritos
    $favorites = [
        [
            'name'      => 'Tab K10 Lenovo',
            'category'  => 'Tecnología',
            'price'     => 'Q 1,800.00',
            'image'     => '/img/tabk10.jpg',
            'added_at'  => '20/11/2025',
        ],
        [
            'name'      => 'Audífonos JBL Tune 760NC',
            'category'  => 'Audio',
            'price'     => 'Q 950.00',
            'image'     => '/img/audifonos.jpg',
            'added_at'  => '05/11/2025',
        ],
        [
            'name'      => 'Boss Bottled 100ml',
            'category'  => 'Perfumes',
            'price'     => 'Q 1,500.00',
            'image'     => '/img/perfumehugoboss.jpg',
            'added_at'  => '12/11/2025',
        ],
    ];

    return view('account.favorites', compact('favorites'));
}

}

