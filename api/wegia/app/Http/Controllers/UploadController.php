<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UploadController extends BaseController
{
    public function retornarImagem(String $path) {
        try {
            if (!request()->hasValidSignature()) {
                return  response()->json([
                    'error' => 'Link inválido ou expirado'
                ], 403);
            }

            $caminho = urldecode($path);

            $caminho = str_replace(["\n", "\r", "\t"], '', $caminho);

            if (!Storage::disk('local_secure')->exists($caminho)) {
                $diretorio = dirname($caminho);
                $arquivo = Storage::disk('local_secure')->files($diretorio);
                 
                return response()->json([
                    'error' => 'Arquivo não encontrado. Disponíveis: ' . implode(', ', $arquivo)
                ], 404);
            }

            $encriptado = Storage::disk('local_secure')->get($caminho);
            $descriptado = Crypt::decrypt($encriptado);

            $nomeArquivo = str_replace(["\n", "\r", "\t"], '', basename($caminho));

            $headers = [
                'Content-Type' => Storage::disk('local_secure')->mimeType($caminho) 
                               ?? 'application/octet-stream',
                'Content-Disposition' => 'inline; filename="' . $nomeArquivo . '"'
            ];
    

            return response($descriptado, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao retornar imagem: ' . $e->getMessage()
            ], 500);
        }
    }
}