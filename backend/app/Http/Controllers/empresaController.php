<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    /**
     * Crear una nueva empresa con el ID del usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'CIFF' => 'required|string|max:20|unique:empreses',
            'direcció' => 'required|string|max:255',
            'descripcio' => 'nullable|string', // Campo de texto opcional
        ]);

        try {
            // Obtener el usuario autenticado
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.',
                ], 401);
            }

            // Crear la nueva empresa con el ID del usuario autenticado
            $empresa = Empresa::create([
                'nom' => $validatedData['nom'],
                'CIFF' => $validatedData['CIFF'],
                'direcció' => $validatedData['direcció'],
                'user_id' => $user->id,
                'descripcio'=> $validatedData['descripcio'],
            ]);

            // Devolver una respuesta exitosa
            return response()->json([
                'message' => 'Empresa creada exitosamente',
                'empresa' => $empresa,
            ], 201);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al crear la empresa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        // Validar el término de búsqueda
        if (empty($searchTerm)) {
            return response()->json([
                'message' => 'no pot estar buit el formulari.',
            ], 400);
        }

        // Buscar empresas que coincidan con el término
        $empreses = Empresa::where('nom', 'like', "%$searchTerm%")
            ->orWhere('CIFF', 'like', "%$searchTerm%")
            ->orWhere('direcció', 'like', "%$searchTerm%")
            ->get();

        return response()->json([
            'message' => 'Resultats de la cerca',
            'empreses' => $empreses,
        ]);
    }
    public function getEmpresa($id)
    {
        try {
            // Buscar la empresa por ID
            $empresa = Empresa::find($id);

            if (!$empresa) {
                return response()->json([
                    'message' => 'Empresa trobada.',
                ], 404);
            }

            return response()->json([
                'message' => 'Empresa trobada.',
                'empresa' => $empresa,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getEmpresesByUser(Request $request)
    {
        try {
            // Obtener el usuario autenticado a través del token
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuari no autenticat.',
                ], 401);
            }

            // Obtener las empresas asociadas al usuario autenticado
            $empreses = Empresa::where('user_id', $user->id)->get();

            return response()->json([
                'empreses' => $empreses,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al obtenir les empreses del usuari',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'CIFF' => 'required|string|max:20|unique:empreses,CIFF,' . $id,
            'direcció' => 'required|string|max:255',
            'descripcio' => 'nullable|string', // Campo opcional
        ]);

        try {
            // Buscar la empresa por su ID
            $empresa = Empresa::findOrFail($id);

            // Actualizar los datos de la empresa
            $empresa->update($validatedData);

            // Respuesta exitosa
            return response()->json([
                'message' => 'Empresa actualizada exitosamente',
                'empresa' => $empresa,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al actualizar la empresa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getEmpreses(){
        
       $empreses = \App\Models\Empresa::all();  // Obtener todas las empresas desde la base de datos

       if ($empreses->isEmpty()) {
        return response()->json(['message' => 'No hi ha empreses registrades.'], 404);
        }

          return response()->json([
                'empreses' => $empreses,
            ], 200);
    }
}
