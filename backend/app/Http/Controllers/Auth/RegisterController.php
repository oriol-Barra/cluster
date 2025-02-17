<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // confirmed para confirmar contraseñas
        ]);

        // Si la validación falla, retornar errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->nom,
            'cognom' => $request->cognom,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar la contraseña
            'role' => User::ROLE_CLIENT, // Asignar rol de cliente

        ]);

        // Responder con el usuario recién creado (puedes incluir otros datos si lo necesitas)
        return response()->json([
            'message' => 'Usuari registrat amb èxit',
            'user' => $user
        ], 201);
    }
}
