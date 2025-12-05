<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\DB;

//Pruebas de conexion a la base de datos
Route::get('/prueba-db', function () {
    try {
        $r1 = DB::connection()->select('SELECT 1 as ok');
    } catch (\Throwable $e) {
        $r1 = ['error' => $e->getMessage()];
    }

    try {
        $r2 = DB::connection('nexus_read')->select('SELECT 1 as ok');
    } catch (\Throwable $e) {
        $r2 = ['error' => $e->getMessage()];
    }

    return response()->json([
        'default_connection' => $r1,
        'nexus_read_connection' => $r2,
    ]);
});

// Portada Nexus directamente en "/"
Route::get('/', function () {
    return view('home');   // usa resources/views/home.blade.php
})->name('home');

// Login aparte
Route::get('/login', function () {
    return view('login');
})->name('login');

// Login
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // Login falso para prueba
    session(['logged_in' => true]);
    return redirect('/home');
});

//ruta para olvide mi contrasena
Route::get('/password', function () {
    return view('password');
});

//ruta para creacion de usuario
Route::get('/register', function () {
    return view('register');
});


// 3. Home (protegido)
Route::get('/home', function () {
    if (!session('logged_in')) {
        return redirect('/login');
    }
    return view('home');
})->name('home');

//. Logout
Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
});

// Página de contacto
Route::get('/contacto', function () {
    return view('contact');
})->name('contact');

//Perfil usuario
Route::get('/mi-cuenta/perfil', [AccountController::class, 'profile'])
    ->name('account.profile');

    Route::post('/mi-cuenta/perfil', [AccountController::class, 'updateProfile'])
    ->name('account.profile.update');
    