<?php

namespace Modules\ContribuicaoSocios\app\Traits;

trait GerarCodigoTrait
{
    public function gerarCodigo(int $tamanho = 16)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracteresTamanho = strlen($caracteres);
        $codigoString = '';

        for ($i = 0; $i < $tamanho; $i++) {
            $codigoString .= $caracteres[random_int(0, $caracteresTamanho - 1)];
        }

        return $codigoString;
    }

    public static function gerarNumeroDocumento($tamanho) : int
    {
        $numeroDocumento = '';

        for ($i = 0; $i < $tamanho; $i++) {
            $numeroDocumento .= rand(0, 9);
        }

        return intval($numeroDocumento);
    }
}
