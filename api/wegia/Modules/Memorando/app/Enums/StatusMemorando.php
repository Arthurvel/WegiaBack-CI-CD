<?php

namespace Modules\Memorando\app\Enums;

enum StatusMemorando: string
{
    case ATIVO = 'Ativo';
    case LIDO = 'Lido';
    case NAO_LIDO = 'Não Lido';
    case IMPORTANTE = 'Importante';
    case PENDENTE = 'Pendente';
    case ARQUIVADO = 'Arquivado';
}
