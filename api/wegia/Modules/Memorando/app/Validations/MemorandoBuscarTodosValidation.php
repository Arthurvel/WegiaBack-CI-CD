<?php

namespace Modules\Memorando\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class MemorandoBuscarTodosValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'buscar'         => 'sometimes|string',
            'ordenacao'      => 'sometimes|string',
            'tipoOrdenacao'  => 'sometimes|string|in:ASC,asc,DESC,desc',
            'status'         => 'sometimes|string|in:Ativo,Lido,Não Lido,Importante,Pendente,Arquivado',
            'destinatario'   => 'sometimes|in:true,false,1,0',
            'remetente'      => 'sometimes|in:true,false,1,0',
            'pagina'         => 'sometimes|integer|min:1',
            'itensPorPagina' => 'sometimes|integer|min:1',
        ];
    }

    public function messages() : array
    {
        return [
            'string' => 'O campo :attribute deve ser um texto.',
            'integer' => 'O campo :attribute deve ser um inteiro.',
            'boolean' => 'O campo :attribute deve ser um booleano.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
            'min' => 'O campo :attribute tem valor minimo de :min.',
        ];
    }
}
