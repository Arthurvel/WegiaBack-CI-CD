<?php

namespace Modules\Memorando\app\DTO;

use App\DTOs\BaseDTO;
use Modules\Memorando\app\Enums\StatusMemorando;

class MemorandoAtualizarDTO extends BaseDTO
{
    public string $status_memorando;
}
