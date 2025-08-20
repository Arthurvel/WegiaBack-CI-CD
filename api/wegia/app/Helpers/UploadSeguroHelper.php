<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UploadSeguroHelper
{

    public static function salvarImagem(UploadedFile $arquivo, String $pasta) : String
    {
        
        $nomeDoArquivo = $arquivo->getClientOriginalName();
        
        $conteudoEncriptado = Crypt::encrypt(file_get_contents($arquivo->path()));
        
        $ano = date('Y');

        $caminho = "uploads/{$ano}/{$pasta}/" . $nomeDoArquivo;
        
        Storage::disk('local_secure')->put($caminho, $conteudoEncriptado);
        
        return $caminho;
    }

    public static function urlTemporaria(String $caminho, Int $validadeURL = 30) : String
    {
        if (!Storage::disk('local_secure')->exists($caminho)) {
            return '';
        }

        $url = URL::temporarySignedRoute(
            'file.upload', now()->addMinutes($validadeURL), ['path' => $caminho]
        );

        return $url;
    }


}