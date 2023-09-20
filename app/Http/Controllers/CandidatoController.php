<?php

namespace App\Http\Controllers;

use App\Models\candidato;
use App\Models\User;
use Illuminate\Http\Request;

class CandidatoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtiene el usuario autenticado
        $user = auth()->user();

        // Verifica el rol del usuario
        if ($user->role === 'manager') {
            // Si es un "manager", obtén todos los candidatos
            $candidatos = candidato::all();
        } else {
            // Si es un agente, obtén los candidatos asignados a él
            $candidatos = Candidato::where('owner', $user->id)->get();
        }

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => $candidatos
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        //
        // Verifica el rol del usuario
        if ($user->role === 'manager') {
            // Si es un "manager", obtén todos los candidatos
            $candidato = Candidato::where('id', $id)->get();
        } else {
            // Si es un agente, obtén los candidatos asignados a él
            $candidato = Candidato::where(['owner' => $user->id, 'id' => $id])->get();
        }

        if (!$candidato) {
            # code...
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ["No lead found"]
                ]
            ], 200);
        }

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => $candidato
        ], 200);

    }

    /**
     * New resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Verifica el rol del usuario
        if ($user->role != 'manager') {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token expirado']
                ]
            ], 401);
        }
        //
        $input = $request->all();
        $candidato = new Candidato;
        $candidato->name = $input['name'];
        $candidato->source = $input['source'];
        $candidato->owner = $input['owner'];
        $candidato->created_at = now();
        $candidato->created_by = $user->id;
        $candidato->save();

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => $candidato
        ], 200);
    }
}