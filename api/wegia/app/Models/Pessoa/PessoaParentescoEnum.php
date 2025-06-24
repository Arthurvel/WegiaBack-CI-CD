<?php

namespace App\Models\Pessoa;

enum PessoaParentescoEnum: string
{
    case COMPANHEIRO = 'Companheiro(a)';
    case CONJUGE = 'Cônjuge';
    case ENTEADO = 'Enteado(a)';
    case EX_CONJUGE = 'Ex-cônjuge';
    case FILHO = 'Filho(a)';
    case IRMAO = 'Irmão(ã)';
    case NETO = 'Neto(a)';
    case PAIS = 'Pais';
    case OUTRO = 'Outra relação de dependência';
}
