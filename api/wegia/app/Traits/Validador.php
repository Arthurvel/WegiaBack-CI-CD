<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait Validador
{

    /**
     * Valida o request
     *
     * @param Request $request
     * @param array $regras
     * @param array $mensagem
     * @return void
    */
    protected function validarRequest(array $dados, array $regras, array $mensagem) : void 
    {
        $validator = Validator::make(
            $dados,
            $regras,
            $mensagem
        );
       
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
