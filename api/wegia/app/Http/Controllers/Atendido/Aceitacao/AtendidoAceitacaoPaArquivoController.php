<?php

namespace app\Http\Controllers\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Services\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoService;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoCadastrarValidation;

class AtendidoAceitacaoPaArquivoController extends BaseController
{

    protected AtendidoAceitacaoPaArquivoService $service;

    public function __construct(
        AtendidoAceitacaoPaArquivoService $service
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/atendido/aceitacao/{id_processo}/arquivo",
     *     summary="Cadastra um arquivo no processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_processo",
     *            in="path",
     *            description="Id da processo",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/AtendidoAceitacaoPaArquivoCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrar(AtendidoAceitacaoPaArquivoCadastrarValidation $request, int $id_processo)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoPaArquivoCadastrarDTO::fromArray([
                'id_processo'      => $id_processo,
                'arquivo'          => $validated['arquivo'],
                'arquivo_nome'     => $validated['arquivo']->getClientOriginalName(),
                'arquivo_extensao' => $validated['arquivo']->getClientOriginalExtension(),
            ]);

            $this->service->cadastrarArquivo($dto);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
