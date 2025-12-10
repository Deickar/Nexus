<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;
    protected $passwordResetService;

    public function __construct(AuthService $authService, PasswordResetService $passwordResetService)
    {
        $this->authService = $authService;
        $this->passwordResetService = $passwordResetService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $resultado = $this->authService->registrarUsuario($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'data' => $resultado,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $resultado = $this->authService->iniciarSesion($request->correo_electronico, $request->contrasena);

            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'data' => $resultado,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->cerrarSesion($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente',
        ], 200);
    }

    /**
     * Solicitar recuperacion de contrasena
     * POST /api/password/forgot
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'El correo electronico es requerido',
            'email.email' => 'El correo electronico no es valido'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validacion',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $resultado = $this->passwordResetService->solicitarRecuperacion($request->email);

            return response()->json([
                'success' => true,
                'message' => $resultado['message'],
                'token' => $resultado['token'] ?? null // Solo para desarrollo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Restablecer contrasena
     * POST /api/password/reset
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'email.required' => 'El correo electronico es requerido',
            'email.email' => 'El correo electronico no es valido',
            'token.required' => 'El token es requerido',
            'password.required' => 'La contrasena es requerida',
            'password.min' => 'La contrasena debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contrasenas no coinciden'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validacion',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $resultado = $this->passwordResetService->restablecerContrasena(
                $request->email,
                $request->token,
                $request->password
            );

            return response()->json([
                'success' => true,
                'message' => $resultado['message']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
