<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Mostrar formulario de login (vista que ya tienes)
     */
    public function showLoginForm()
    {
        // Ajusta el nombre de la vista si es diferente
        return view('auth.login');
    }

    /**
     * Procesar login desde el formulario web
     */
    public function login(LoginRequest $request)
    {
        try {
            // Usamos tu mismo servicio para validar credenciales
            $resultado = $this->authService
                ->iniciarSesion($request->correo_electronico, $request->contrasena);

            /**
             * IMPORTANTE:
             * Asumo que $resultado contiene la clave 'user' con el modelo User.
             * Si tu AuthService devuelve otra estructura,
             * ajusta esta línea para obtener el usuario correcto.
             */
            $user = $resultado['user'] ?? null;

            if (!$user) {
                // Fallback por si no trae 'user'
                return back()
                    ->withErrors(['correo_electronico' => 'No se pudo obtener el usuario desde AuthService'])
                    ->withInput();
            }

            // Iniciar sesión web
            Auth::login($user);

            // Regenerar la sesión para mayor seguridad
            $request->session()->regenerate();

            // Redirigir al perfil
            return redirect()->route('account.profile');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['correo_electronico' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Cerrar sesión web
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home'); // o '/'
    }
}
