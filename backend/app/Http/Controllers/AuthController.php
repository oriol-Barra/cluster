<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Método para el inicio de sesión
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credencials invàlides',
            ], 401);
        }

        // Obtener al usuario autenticado
        $user = Auth::user();

        // Crear un token de API
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver la respuesta
        return response()->json([
            'message' => 'Inici de sessió exitós',
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        // Revocar el token del usuario
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'sessió tancada',
        ]);
    }
}
