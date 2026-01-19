<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class UploadSeguroHelper
{

    public static function salvarImagem(UploadedFile $arquivo, String $pasta) : String
    {
        $extensao = $arquivo->getClientOriginalExtension();

        $hash = hash('sha256', $arquivo->getClientOriginalName() . Str::uuid());

        $nomeDoArquivo = $hash . '.' . $extensao;

        $conteudoEncriptado = Crypt::encrypt(file_get_contents($arquivo->path()));

        $ano = date('Y');

        $caminho = "uploads/{$ano}/{$pasta}/" . $nomeDoArquivo;

        Storage::disk('local_secure')->put($caminho, $conteudoEncriptado);

        return $caminho;
    }

    public static function salvarPdf(string $conteudoPdf, string $pasta, string $nomeArquivo = ''): string
    {
        $hash = hash('sha256', Str::uuid());
        $nomeDoArquivo = $nomeArquivo . '.pdf';

        if($nomeArquivo == '') {
            $nomeDoArquivo = $hash . '.pdf';
        }

        $conteudoEncriptado = Crypt::encrypt($conteudoPdf);

        $ano = date('Y');
        $caminho = "uploads/{$ano}/{$pasta}/{$nomeDoArquivo}";

        Storage::disk('local_secure')->put($caminho, $conteudoEncriptado);

        return $caminho;
    }

    public static function salvarArquivoRemoto(
        string $conteudo,
        string $extensao,
        string $pasta
    ): string {
        $hash = hash('sha256', Str::uuid());
        $nomeDoArquivo = $hash . '.' . $extensao;

        $conteudoEncriptado = Crypt::encrypt($conteudo);

        $ano = date('Y');
        $caminho = "uploads/{$ano}/{$pasta}/{$nomeDoArquivo}";

        Storage::disk('local_secure')->put($caminho, $conteudoEncriptado);

        return $caminho;
    }

    public static function urlTemporaria(String $caminho, Int $validadeURL = 10) : String
    {
        if (!Storage::disk('local_secure')->exists($caminho)) {
            return '';
        }

        $url = URL::temporarySignedRoute(
            'file.upload', now()->addMinutes($validadeURL), ['path' => $caminho], false
        );

        return $url;
    }

    public static function recuperarImagemBase64(string $caminho): ?string
    {
        if (!Storage::disk('local_secure')->exists($caminho)) {
            return null;
        }

        $conteudoCriptografado = Storage::disk('local_secure')->get($caminho);

        $conteudoImagem = Crypt::decrypt($conteudoCriptografado);

        $extensao = pathinfo($caminho, PATHINFO_EXTENSION);

        $base64 = base64_encode($conteudoImagem);

        return "data:image/{$extensao};base64,{$base64}";
    }

    public static function imagemPublicaParaBase64(string $arquivo): ?string
    {
        if (!Storage::disk('public')->exists($arquivo)) {
            return null;
        }

        $conteudoImagem = Storage::disk('public')->get($arquivo);
        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        $base64 = base64_encode($conteudoImagem);

        return "data:image/{$extensao};base64,{$base64}";
    }

    public static function excluirImagem(string $caminho): bool
    {
        if (Storage::disk('local_secure')->exists($caminho)) {
            return Storage::disk('local_secure')->delete($caminho);
        }

        return false;
    }


}
