<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProducteElaborat; // Importar correctamente el modelo
use App\Models\Empresa; // Importar modelo Empresa

class ProducteElaboratController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del frontend
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'preu' => 'required|numeric|min:0',
            'descripcio' => 'nullable|string',
            'tipus' => 'required|string|max:255',
            'empresa' => 'required|string', // Puede ser nombre o CIF
            'recepta' => 'nullable|array',
            'recepta.*.producte_id' => 'required_with:recepta|exists:productes,id',
            'recepta.*.quantitat' => 'required_with:recepta|numeric|min:1',
            'tipus_impositiu'=>'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('img', 'public'); // Guarda en storage/app/public/imatges
        }
    

        $empresa = \App\Models\Empresa::where('nom', $validatedData['empresa'])
        ->orWhere('CIFF', $validatedData['empresa'])
        ->first();

        if (!$empresa) {
            return response()->json([
                'message' => 'Empresa no trobada. Assegureu-vos que el nom o el CIF sigui correcte.'
            ], 404);
        }

        // Crear el producte elaborat
        $ProducteElaborat = ProducteElaborat::create([
            'nom' => $validatedData['nom'],
            'preu' => $validatedData['preu'],
            'descripcio' => $validatedData['descripcio'] ?? null,
            'tipus' => $validatedData['tipus'],
            'tipus_impositiu'=>$validatedData['tipus_impositiu'],
            'empresa_id' => $empresa->id, // Asociar la empresa
            'foto' => $fotoPath, // Guarda el path en la BD


        ]);

        // Asociar productos a la recepta si se proporcionan
        if (!empty($validatedData['recepta'])) {
            foreach ($validatedData['recepta'] as $producte) {
                $producteElaborat->recepta()->attach($producte['producte_id'], [
                    'quantitat' => $producte['quantitat']
                ]);
            }
        }

        return response()->json([
            'message' => 'Producte elaborat creat amb èxit',
            //'producteElaborat' => $ProducteElaborat->load('recepta'), // Cargar los productos relacionados
        ], 201);
    }


    //funció per a trobar els productes de cada empresa
    public function getProductesByEmpresa(Request $request){
        $validatedData=$request->validate([
            'empresa'=> 'required|string',
        ]);
        $empresa=\App\Models\Empresa::where('nom',$validatedData['empresa'])
                                    ->orWhere('CIFF',$validatedData['empresa'])
                                    ->first();
        if(!$empresa){
            return response()->json([
                'message'=>'error',
            ],404);
        }
        $productesEmpresa= \App\Models\ProducteElaborat::where('empresa_id', $empresa->id)->get();
         // Devolver los productos en la respuesta
         return response()->json([
        'message' => 'Productes elaborats trobats amb èxit',
        'empresa' => $empresa->nom,
        'productes_elaborats' => $productesEmpresa,
    ], 200);
    }

    public function getAllProductes(){
        $productes = \App\Models\ProducteElaborat::all();

         if($productes->isEmpty()){
            return response()->json(['message'=>'error al carregar els productes'],404);
         }
         return response()->json([
            'productes' => $productes,
        ], 200);
    }
    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'preu' => 'required|numeric|min:0',
            'descripcio' => 'nullable|string',
            'tipus' => 'required|string|max:255',
            'empresa' => 'required|string', // Puede ser nombre o CIF
            'recepta' => 'nullable|array',
            'recepta.*.producte_id' => 'required_with:recepta|exists:productes,id',
            'recepta.*.quantitat' => 'required_with:recepta|numeric|min:1',
            'tipus_impositiu'=>'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Buscar la empresa por su ID
            $producte = ProducteElaborat::findOrFail($id);

            // Actualizar los datos de la empresa
            $producte->update($validatedData);

            // Respuesta exitosa
            return response()->json([
                'message' => 'Empresa actualitzada correctament',
                'empresa' => $empresa,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error al actualitzar el producte',
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
        $productes = ProducteElaborat::where('nom', 'like', "%$searchTerm%")
            ->get();

        return response()->json([
            'message' => 'Resultats de la cerca',
            'productes' => $productes,
        ]);
    }
    public function getProducte($id)
    {
        try {
            // Buscar la empresa por ID
            $producte = ProducteElaborat::find($id);

            if (!$producte) {
                return response()->json([
                    'message' => 'producte trobat.',
                ], 404);
            }

            return response()->json([
                'message' => 'producte trobat.',
                'producte' => $producte,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
}
