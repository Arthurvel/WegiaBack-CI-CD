<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especie;

class EspecieController extends BaseController
{
    public function index()
    {
        return response()->json(Especie::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $especie = Especie::create([
            'nome' => $request->nome
        ]);

        return response()->json($especie, 201);
    }

    public function update(Request $request, $id)
    {
        $especie = Especie::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $especie->update([
            'nome' => $request->nome
        ]);

        return response()->json($especie);
    }
}
