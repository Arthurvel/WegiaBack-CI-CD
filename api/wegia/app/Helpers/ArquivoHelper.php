<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArquivoHelper
{

    public static function processarArquivo(UploadedFile $arquivo): array
    {
        return [
            'nome_original' => $arquivo->getClientOriginalName(),
            'extensao' => $arquivo->getClientOriginalExtension(),
            'mime_type' => $arquivo->getMimeType(),
            'tamanho' => $arquivo->getSize(),
            'conteudo_base64' => base64_encode(file_get_contents($arquivo->getRealPath())),
        ];
    }


    public static function passarParaBase64($arquivo) 
    {
        $nome_arquivo = $arquivo->getClientOriginalName();
        $extensao_arquivo = $arquivo->getClientOriginalExtension();

        return base64_encode(file_get_contents($arquivo->getRealPath()));
    }
}