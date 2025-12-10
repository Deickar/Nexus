<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\Admin\CategoriaAdminController;
use App\Http\Controllers\Admin\MarcaAdminController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\UsuarioAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\ImagenProductoController;  // nuevo controlador web de login
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Home (usa HomeController para que cargue reseñas reales, productos, etc.)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta para actualizar imágenes específicas
Route::get('/update/imagenes', function() {
    // Actualizar imagen del mouse gamer
    $mouseImg = \App\Models\ImagenProducto::where('id_producto', 1)->first();
    if ($mouseImg) {
        $mouseImg->url_imagen = '/img/audifonos.jpg';
        $mouseImg->save();
    }

    return response()->json([
        'mensaje' => 'Imagen del mouse actualizada',
        'imagen' => $mouseImg
    ]);
});// Categorías
// Ruta para actualizar imágenes específicas
Route::get('/update/imagenes', function() {
    // Actualizar imagen del mouse gamer
    $mouseImg = \App\Models\ImagenProducto::where('id_producto', 1)->first();
    if ($mouseImg) {
        $mouseImg->url_imagen = '/img/audifonos.jpg';
        $mouseImg->save();
    }

    return response()->json([
        'mensaje' => 'Imagen del mouse actualizada',
        'imagen' => $mouseImg
    ]);
});// Categorías
Route::get('/categories', function () {
    return view('categories');
})->name('categories');

// Ofertas
Route::get('/offers', function () {
    return view('offers');
})->name('offers');

// Contacto
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Rutas públicas (solo visualización)
Route::prefix('productos/{id_producto}/imagenes')->group(function () {
    Route::get('/', [ImagenProductoController::class, 'index']); // Ver imágenes de un producto
});

Route::get('/imagenes/{id_imagen}', [ImagenProductoController::class, 'show']); // Ver imagen específica

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN WEB (NO API)
|--------------------------------------------------------------------------
*/

// Login (formulario)
Route::get('/login', [WebAuthController::class, 'showLoginForm'])
    ->name('login');

// Login (procesar formulario)
Route::post('/login', [WebAuthController::class, 'login'])
    ->name('login.perform');

// Logout
Route::post('/logout', [WebAuthController::class, 'logout'])
    ->name('logout');

// Registro (solo vista, lógica la puedes hacer después)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Olvidé mi contraseña
Route::get('/password', function () {
    return view('auth.password');
})->name('password.request');

// Cambiar contraseña con token
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

/*
|--------------------------------------------------------------------------
| ZONA "MI CUENTA" (SOLO USUARIOS AUTENTICADOS)
|--------------------------------------------------------------------------
|
| Todas las rutas aquí ya tienen:
|   - prefijo URL:      /mi-cuenta/...
|   - nombre de ruta:   account.*
|   - middleware:       auth (usa la sesión web)
|
*/

Route::middleware('auth')->prefix('mi-cuenta')->name('account.')->group(function () {

    // PERFIL
    // GET /mi-cuenta  -> account.profile
    Route::get('/', [AccountController::class, 'profile'])->name('profile');

    // Actualizar perfil
    Route::post('/perfil', [AccountController::class, 'updateProfile'])
        ->name('profile.update');

    // DIRECCIÓN
    Route::get('/direccion', [AccountController::class, 'address'])
        ->name('address');

    Route::post('/direccion', [AccountController::class, 'updateAddress'])
        ->name('address.update');

    // ÓRDENES
    Route::get('/ordenes', [AccountController::class, 'orders'])
        ->name('orders');

    // RESEÑAS DEL USUARIO
    Route::get('/resenas', [AccountReviewController::class, 'index'])
        ->name('reviews');

    Route::post('/resenas', [AccountReviewController::class, 'store'])
        ->name('reviews.store');

    // FAVORITOS
    Route::get('/favoritos', [AccountController::class, 'favorites'])
        ->name('favorites');
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
        'products' => $products[$slug] ?? []  // Si no existe la categoría → vacío
    ]);

})->name('category.show');

Route::get('/test-sftp', function () {
    // Definimos el disco a probar
    $diskName = 'sftp';

    try {
        $disk = Storage::disk($diskName);
        
        // 1. Crear un archivo de prueba para confirmar la escritura
        $testContent = 'Conexión SFTP exitosa a ' . $disk->path('') . ' el ' . now();
        $testFilePath = 'test_connection_' . time() . '.txt';
        
        $disk->put($testFilePath, $testContent);

        // 2. Listar archivos para confirmar lectura y conectividad
        $files = $disk->files('/');

        // 3. Opcional: Eliminar el archivo de prueba
        $disk->delete($testFilePath);
        
        return "✅ **Conexión SFTP exitosa** al disco '$diskName'.<br>"
             . "Archivo '$testFilePath' creado y eliminado correctamente.<br>"
             . "Archivos encontrados en la raíz remota (primero 5): " . implode(', ', array_slice($files, 0, 5));

    } catch (\Exception $e) {
        // En caso de error, muestra el mensaje de excepción para diagnóstico
        return "❌ **Error de conexión SFTP** al disco '$diskName':<br>"
             . "Mensaje: " . $e->getMessage();
    }
});