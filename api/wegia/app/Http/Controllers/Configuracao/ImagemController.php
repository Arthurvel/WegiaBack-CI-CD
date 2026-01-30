<?php

namespace app\Http\Controllers\Configuracao;

use app\DTOs\Configuracao\ImagemCadastrarDTO;
use app\DTOs\Configuracao\ImagemEmUmCampoAtualizarDTO;
use app\DTOs\Configuracao\ImagemEmUmCampoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Configuracao\ImagemResource;
use app\Services\Configuracao\ImagemService;
use app\Services\Configuracao\TabelaImagemCampoService;
use app\Validations\Configuracao\ImagemCadastrarValidation;
use app\Validations\Configuracao\ImagemEmUmCampoAtualizarValidation;
use app\Validations\Configuracao\ImagemEmUmCampoCadastrarValidation;
use Illuminate\Http\JsonResponse;

class ImagemController extends BaseController
{

    private ImagemService $service;
    private TabelaImagemCampoService $tabelaImagemCampoService;

    public function __construct(
        ImagemService $service,
        TabelaImagemCampoService $tabelaImagemCampoService
    )
    {
        $this->middleware('auth:sanctum')->except(['']);

        $this->service                  = $service;
        $this->tabelaImagemCampoService = $tabelaImagemCampoService;
    }

    /**
     * @OA\Get(
     *     path="/configuracao/imagem",
     *     summary="Buscar todas as imagens",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $imagens = $this->service->buscarTodos();

            return  $this->sucessoResponse( ImagemResource::collection($imagens));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/configuracao/imagem",
     *     summary="Cadastrar uma imagem de sistema",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ImagemCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(ImagemCadastrarValidation $request)
    {
        try {
            $request->validated();

            $nomeSemExtensao = pathinfo(
                $request->file('imagem')->getClientOriginalName(),
                PATHINFO_FILENAME
            );


            $dto = ImagemCadastrarDTO::fromArray([
                'imagem' => $request->file('imagem'),
                'nome'   => $nomeSemExtensao,
                'tipo'   => $request->file('imagem')->extension()
            ]);

            $this->service->criarComImagem($dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/configuracao/imagem/campo-imagem/{id_campo_imagem}",
     *     summary="Cadastrar uma imagem de sistema",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id_campo_imagem",
     *           in="path",
     *           description="ID do campo da imagem da instituicao",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *            required=true,
     *            @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(ref="#/components/schemas/ImagemEmUmCampoCadastrarValidation")
     *            )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrarImagemEmUmCampo(int $id_campo_imagem, ImagemEmUmCampoCadastrarValidation $request)
    {
        try {
            $request->validated();

            $dto = ImagemEmUmCampoCadastrarDTO::fromArray([
                'imagem'    => $request->file('imagem'),
                'id_imagem' => $request->id_imagem,
                'id_campo'  => $id_campo_imagem
            ]);

            $this->tabelaImagemCampoService->criarComOuSemImagem($dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/configuracao/imagem/{id_imagem}/campo-imagem/{id_campo_imagem}",
     *     summary="Substituir uma imagem de sistema",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_imagem",
     *            in="path",
     *            description="ID da imagem da instituicao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *      ),
     *     @OA\Parameter(
     *           name="id_campo_imagem",
     *           in="path",
     *           description="ID do campo da imagem da instituicao",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/ImagemEmUmCampoAtualizarValidation")
     *           )
     *      ),
     *     @OA\Response(
     *         response=204,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function substituirImagemEmUmCampo(int $id_imagem, int $id_campo_imagem, ImagemEmUmCampoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ImagemEmUmCampoAtualizarDTO::fromArray([
                'imagem'             => $request->file('imagem'),
                'id_imagem'          => $id_imagem,
                'id_campo'           => $id_campo_imagem,
                'id_imagem_nova'     => $request->id_imagem_nova
            ]);

            $this->tabelaImagemCampoService->substituirImagemEmUmCampo($dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/configuracao/imagem/{id}",
     *     summary="Deletar uma imagem de sistema",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *             name="id",
     *             in="path",
     *             description="ID da imagem da instituicao",
     *             required=true,
     *             @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function deletar(int $id)
    {
        try {
            $this->service->deletar($id);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

