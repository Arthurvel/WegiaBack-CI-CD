<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cor;

class CorController extends Controller
{
    public function index()
    {
        return response()->json(Cor::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $cor = Cor::create([
            'nome' => $request->nome
        ]);

        return response()->json($cor, 201);
    }

    public function update(Request $request, $id)
    {
        $cor = Cor::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $cor->update([
            'nome' => $request->nome
        ]);

        return response()->json($cor);
    }
}
