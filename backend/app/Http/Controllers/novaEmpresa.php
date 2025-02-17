<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class novaEmpresa extends Controller
{
    public function store(Request $request){
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'CIFF'=>'required|string|max:9',
            'direcció'=>'required|string|max:255',
            'user_id'=>'required|numerix',
        ]);
        $empresa= Empresa::create([
            'nom' => $validatedData['nom'],
            'CIFF' => $validatedData['CIFF'],
            'direccio' => $validatedData['direccio'],
            'tipus' => $validatedData['tipus'],
            'user_id'=>$validatedData['user_id'],

        ]);
        return response()->json([
            'message' => 'empresa creada amb èxit',
        ], 201);


    }
}
