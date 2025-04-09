<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Raca;

class RacaController extends BaseController
{
    public function index()
    {
        return response()->json(Raca::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $raca = Raca::create([
            'nome' => $request->nome
        ]);

        return response()->json($raca, 201);
    }

    public function update(Request $request, $id)
    {
        $raca = Raca::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $raca->update([
            'nome' => $request->nome
        ]);

        return response()->json($raca);
    }
}
