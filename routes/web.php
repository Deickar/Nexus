<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// --- RUTA PARA EL PANEL DE ADMINISTRADOR ---
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// --- RUTAS PARA EL PERFIL DEL ADMINISTRADOR ---
Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

// Portada Nexus directamente en "/"
Route::get('/', function () {
    return view('home');   // usa resources/views/home.blade.php
})->name('home');

// Login (duplicado, pero lo dejamos igual que estaba)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ruta para olvide mi contraseña (versión simple original)
Route::get('/password', function () {
    return view('auth.password');
});

// ruta para creación de usuario
Route::get('/register', function () {
    return view('auth.register');
});

// Logout
Route::post('/logout', function () {
    session()->flush();

    return redirect('/login');
});

// Página de contacto
Route::get('/contacto', function () {
    return view('contact');
})->name('contact');

// Perfil usuario
Route::get('/mi-cuenta/perfil', [AccountController::class, 'profile'])
    ->name('account.profile');

Route::post('/mi-cuenta/perfil', [AccountController::class, 'updateProfile'])
    ->name('account.profile.update');

// Dirección usuario
Route::get('/mi-cuenta/direccion', [AccountController::class, 'address'])
    ->name('account.address');

Route::post('/mi-cuenta/direccion', [AccountController::class, 'updateAddress'])
    ->name('account.address.update');

// Órdenes usuario
Route::get('/mi-cuenta/ordenes', [AccountController::class, 'orders'])
    ->name('account.orders');

// reseñas de usuario
Route::get('/mi-cuenta/resenas', [AccountController::class, 'reviews'])->name('account.reviews');

// Favoritos de usuario
Route::get('/mi-cuenta/favoritos', [AccountController::class, 'favorites'])
    ->name('account.favorites');

// Ofertas del día
Route::get('/ofertas', function () {
    return view('offers');
})->name('offers');

// --- RUTAS NUEVAS DE TU COMPAÑERO (las conservamos completas) ---

// Olvidé contraseña → formulario de correo (esta sobrescribe la de arriba, y está bien)
Route::get('/password', function () {
    return view('auth.password');
})->name('auth.password.reset');

// Simulación: al enviar correo, redirige a cambiar contraseña
Route::post('/password', function () {
    // Aquí iría el envío real del correo, pero para prueba:
    return redirect('/reset-password')->with('status', 'Te enviamos un enlace por correo');
});

// Cambiar contraseña
Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

// Guardar nueva contraseña (falso, solo para prueba)
Route::post('/reset-password', function () {
    return redirect('/login')->with('status', '¡Contraseña cambiada con éxito!');
});

// Registro - crea cuenta y LOGUEA AUTOMÁTICO
Route::post('/register', function () {
    // Aquí iría el código real de crear usuario en base de datos
    // Pero para prueba rápida (login falso):

    session(['logged_in' => true, 'nombre' => request('name')]);

    return redirect('/home')->with('status', '¡Cuenta creada con éxito! Bienvenido');
});

// categorias
Route::get('/categorias', function () {
    return view('categories');
})->name('categories');

Route::get('/categorias/{slug}', function ($slug) {

    // Simulando productos por categoría
    $products = [

        'tecnologia' => [
            ['name' => 'Laptop HP', 'price' => 3500, 'img' => '/img/laptophp.jpg'],
            ['name' => 'Audífonos Sony', 'price' => 499, 'img' => '/img/audifonossony.jpg'],
        ],

        'ropa' => [
            ['name' => 'Camisa Casual', 'price' => 129, 'img' => '/img/camisa.jpg'],
            ['name' => 'Pantalón Jeans', 'price' => 199, 'img' => '/img/jeans.jpg'],
        ],

        'oficina' => [
            ['name' => 'Silla ergonómica', 'price' => 899, 'img' => '/img/silla.jpg'],
        ],
    ];

    return view('category-page', [
        'slug' => $slug,
        'products' => $products[$slug] ?? [],  // Si no existe la categoría → vacío
    ]);

})->name('category.show');
