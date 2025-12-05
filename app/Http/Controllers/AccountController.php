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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        // Más adelante aquí:
        // auth()->user()->update([...]);

        return back()->with('status', 'Perfil actualizado (modo demo, sin guardar en BD).');
    }
}
