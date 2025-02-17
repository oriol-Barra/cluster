<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Encriptar la contraseña
        ]);

        // Retornar respuesta
        return response()->json([
            'message' => 'Usuari creat amb èxit',
            'user' => $user,
        ], 201);
    }
    public function getDetallsUsuari(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Usuari no autenticat.'], 401);
    }

    $empreses = $user->empreses()->get();

    return response()->json([
        'user' => [
            'nom' => $user->name,
            'cognoms' => $user->cognoms,
            'email' => $user->email,
            'rol'=> $user->role,
        ],
        'empreses' => $empreses,
    ]);
}
}
