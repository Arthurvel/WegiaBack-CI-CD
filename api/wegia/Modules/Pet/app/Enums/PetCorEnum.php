<?php

namespace Modules\Pet\app\Enums;

enum PetCorEnum : string
{
    case PRETO     = 'Preto';
    case BRANCO    = 'Branco';
    case CINZA     = 'Cinza';
    case MARROM    = 'Marrom';
    case CARAMELO  = 'Caramelo';
    case AMARELO   = 'Amarelo';
    case BEGE      = 'Bege';
    case DOURADO   = 'Dourado';
    case RUIVO     = 'Ruivo';
    case CREME     = 'Creme';
    case AZUL      = 'Azul';
    case CHOCOLATE = 'Chocolate';
    case BICOLOR   = 'Bicolor';
    case TRICOLOR  = 'Tricolor';

    static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
