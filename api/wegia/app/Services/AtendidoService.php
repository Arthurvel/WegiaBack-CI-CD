<?php

namespace App\Services;

use App\DTOs\Atendido\AtendidoDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaDTO;
use App\DTOs\Atendido\CriarOcorrenciaDocDTO;
use App\DTOs\Atendido\CriarOcorrenciaDTO;
use App\DTOs\PaginacaoDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Atendido\Atendido;
use App\Repositories\AtendimentoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AtendidoService
{

    protected $atendimentoRepository;

    public function __construct(AtendimentoRepository $atendimentoRepository)
    {
        $this->atendimentoRepository = $atendimentoRepository;
    }

    public function buscarAtendimentos(array $parametros = []) 
    {
        $atendimentos = $this->atendimentoRepository->buscarAtendimentos($parametros);

        $itens = collect($atendimentos->items())->map(function ($atendimento) {
            return AtendidoDTO::fromArray($atendimento->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $atendimentos->currentPage(),
            $atendimentos->lastPage(),
            $atendimentos->total(),
            $atendimentos->perPage()
        );
    }

    public function buscarAtendidoPorId(int $id, $with) : AtendidoDTO
    {
        $withArray = isset($with) ? explode(',', $with) : [];

        $atendido = $this->atendimentoRepository->buscarAtendidoPorId($id, $withArray);

        return AtendidoDTO::fromArray($atendido->toArray());
    }

    public function cadastrarAtendido(array $dados) : Atendido
    {
        $atendido = new Atendido([
            'pessoa_id_pessoa' => $dados['pessoa_id_pessoa'],
            'atendido_tipo_idatendido_tipo' => $dados['atendido_tipo_idatendido_tipo'],
            'atendido_status_idatendido_status' => $dados['atendido_status_idatendido_status']
        ]);

        return $this->atendimentoRepository->cadastrarAtendido($atendido);
    }

    public function buscarTipoAtendimento() : Collection
    {
        return $this->atendimentoRepository->buscarTipoAtendimento();
    }

    public function buscarStatusAtendimento() : Collection
    {
        return $this->atendimentoRepository->buscarStatusAtendimento();
    }

    //Ocorrencia

    public function buscarOcorrencias(int $id_atendido, array $parametros)
    {
        $ocorrencias = $this->atendimentoRepository->buscarOcorrencias($id_atendido, $parametros);

        $itens = collect($ocorrencias->items())->map(function ($ocorrencia) {
            return AtendidoOcorrenciaDTO::fromArray($ocorrencia->toArray())->toArray();
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $ocorrencias->currentPage(),
            $ocorrencias->lastPage(),
            $ocorrencias->total(),
            $ocorrencias->perPage()
        );
    }

    public function buscarOcorrenciaTipos() : Collection
    {
        return $this->atendimentoRepository->buscarOcorrenciaTipos();
    }

    public function cadastrarOcorrencia(int $id_atendido, array $dados)
    {
        DB::beginTransaction();

        try {
            $dados['atendido_idatendido'] = $id_atendido;
            $ocorrenciaDTO = CriarOcorrenciaDTO::fromArray($dados);
            $ocorrencia = $this->atendimentoRepository->cadastrarOcorrencia($ocorrenciaDTO);

            if($dados['arquivo']) {
                $url = UploadSeguroHelper::salvarImagem($dados['arquivo'], 'atendido/ocorrencias');
                $nomeOriginal = $dados['arquivo']->getClientOriginalName(); 
                $extensao = $dados['arquivo']->getClientOriginalExtension();
    
                $dados['arquivo_nome'] = $nomeOriginal;
                $dados['arquivo_extensao'] = $extensao; 
                $dados['atentido_ocorrencia_idatentido_ocorrencias'] = $ocorrencia->idatendido_ocorrencias;

                $dados['arquivo'] = $url;
                $ocorrenciaDocDTO = CriarOcorrenciaDocDTO::fromArray($dados);
                $this->atendimentoRepository->cadastrarAtendimentoDoc($ocorrenciaDocDTO);
            }

            DB::commit();
            return $ocorrencia;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}