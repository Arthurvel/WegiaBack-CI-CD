<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers\WebHook;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoLogService;
use Modules\ContribuicaoSocios\app\Validations\WebHook\PagarMeWebHookValidation;

class PagarMeWebhookController extends BaseController
{

    protected ContribuicaoLogService $contribuicaoLogService;

    public function __construct(
        ContribuicaoLogService $contribuicaoLogService
    )
    {
        $this->contribuicaoLogService = $contribuicaoLogService;
    }

    public function handle(PagarMeWebHookValidation $request)
    {
        try {

            $validated = $request->validated();

            match (strtolower($validated->type)) {
                'charge.paid'    => $this->contribuicaoLogService->atualizarPagamento($validated->data->id)
            };

            return $this->sucessoResponse(['status' => 'success'], 204);

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
