<?php

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Storage;

public function salvarImagem(Request $request, $id)
{
    $pet = Pet::find($id);

    if (!$pet) {
        return response()->json(['erro' => 'Pet não encontrado.'], 404);
    }

    if (!$request->hasFile('imagem')) {
        return response()->json(['erro' => 'Nenhuma imagem enviada.'], 400);
    }

    $arquivo = $request->file('imagem');

    if ($pet->imagem && Storage::exists($pet->imagem)) {
        Storage::delete($pet->imagem);
    }

    $caminho = $arquivo->store('public/imagens');
    $pet->imagem = $caminho;
    $pet->save();

    return response()->json([
        'mensagem' => 'Imagem salva com sucesso.',
        'caminho' => $caminho
    ]);
}
