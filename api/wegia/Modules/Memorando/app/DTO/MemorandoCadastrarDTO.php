<?php

    namespace Modules\Memorando\app\DTO;

    use App\DTOs\BaseDTO;

    class MemorandoCadastrarDTO extends BaseDTO
    {

        public string $id_pessoa;
        public string $titulo;
        public string $status_memorando = 'Ativo';

    }
