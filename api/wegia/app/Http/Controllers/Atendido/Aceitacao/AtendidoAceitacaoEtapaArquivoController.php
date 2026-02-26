<?php

namespace app\Http\Controllers\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoEtapaArquivoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Services\Atendido\Aceitacao\AtendidoAceitacaoEtapaArquivoService;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoEtapaArquivoCadastrarValidation;

class AtendidoAceitacaoEtapaArquivoController extends BaseController
{

    protected AtendidoAceitacaoEtapaArquivoService $service;

    public function __construct(
        AtendidoAceitacaoEtapaArquivoService $service
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/atendido/aceitacao/etapa/{id_etapa}/arquivo",
     *     summary="Cadastra um arquivo no processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_etapa",
     *            in="path",
     *            description="Id da etapa",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/AtendidoAceitacaoEtapaArquivoCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrar(AtendidoAceitacaoEtapaArquivoCadastrarValidation $request, int $id_etapa)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoEtapaArquivoCadastrarDTO::fromArray([
                'etapa_id'      => $id_etapa,
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
