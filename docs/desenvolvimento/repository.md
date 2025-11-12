# 🗄️ Repository

Esta seção descreve a camada de **Repository** da API Wegia.  
Os repositories são responsáveis por **encapsular a conexão com o banco de dados da aplicação**, funcionando como o elo entre as **Services**, **Models** e demais camadas do sistema.

---

!!! info " 💡 Resumo"
A camada de Repository atua como o **acesso direto aos dados da aplicação**, fornecendo métodos organizados e reutilizáveis para persistência e consulta, mantendo a camada de Service limpa e desacoplada da lógica de banco.

---

## 1. 🏗️ Estrutura

Cada módulo do sistema possui seu próprio service, que **herda de `BaseService`** e implementa os métodos específicos daquele contexto.

---

## 2. 🎯 Responsabilidades dos Repositories

| Responsabilidade                       | Descrição                                                                 |
|---------------------------------------|---------------------------------------------------------------------------|
| Encapsular acesso ao banco de dados   | Centralizam todas as operações de persistência e consulta.               |
| Isolar a lógica de queries            | Mantêm as consultas e filtros em um único lugar, facilitando a manutenção.|
| Trabalhar com Models                  | Utilizam as models Eloquent para manipular registros no banco.           |
| Abstrair a camada de persistência     | Permitem que Services trabalhem sem conhecer detalhes do banco.          |
| Reutilizar lógica de dados            | Evitam repetição de consultas em diferentes partes do sistema.           |
| Suportar DTOs como entrada            | Recebem dados já estruturados para criar ou atualizar registros.         |
| Aplicar filtros e paginação           | Implementam filtros, ordenações e paginações diretamente nas queries.   |
| Centralizar relacionamentos           | Controlam *eager loading* e *joins* quando necessário.                  |
| Padronizar operações CRUD             | Oferecem métodos genéricos reutilizáveis em todos os módulos.            |
| Facilitar testes                      | Podem ser facilmente simulados ou mockados em testes unitários.          |

---

## 3. 🏛️ Estrutura do BaseRepository

Todos os repositórios herdam de uma classe abstrata chamada **BaseRepository**, que oferece os métodos CRUD básicos prontos para uso em qualquer módulo:

```php
<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel da Model
 * @template TCriar objeto de dto
 * @template TAtualizar objeto de dto
 */
abstract class BaseRepository
{
    /** @var TModel */
    protected $model;

    /**
     * @param TModel $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param TCriar $data
     * @return TModel
     */
    public function criar(object $data)
    {
        return $this->model->create($data->toArray());
    }

    /**
     * @param array<int, TCriar|array> $dados
     * @return bool
     */
    public function criarEmMassa(array $dados): bool
    {
        $dadosFormatados = array_map(function ($item) {
            return is_object($item) && method_exists($item, 'toArray')
                ? $item->toArray()
                : (array) $item;
        }, $dados);

        return $this->model->insert($dadosFormatados);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function buscarTodos()
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return TModel
     */
    public function buscarPorId(int $id, Array $with = [])
    {
        return $this->model
            ->with($with)
            ->findOrFail($id);
    }

    /**
     * @param int $id
     * @param TAtualizar $data
     * @return TModel
     */
    public function atualizar(int $id, object $data)
    {
        $entity = $this->model->findOrFail($id);
        $entity->update($data->toArrayUpdate());
        return $entity;
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function deletar(int $id)
    {
        return $this->model->destroy($id);
    }
}
```

## 4. 🔧 Exemplo de Repository Específico

Um repository específico estende a classe base e implementa métodos adicionais para consultas personalizadas do módulo:

```php
<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeFichaMedicaParamsDTO;
use Modules\Saude\app\Models\SaudeFichaMedica;

class SaudeFichaMedicaRepository extends BaseRepository
{

    public function __construct(
        SaudeFichaMedica $model
    )
    {
        parent::__construct($model);
    }

    public function buscarFichaMedica(SaudeFichaMedicaParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->model
            ->select('saude_fichamedica.id_fichamedica', 'saude_fichamedica.id_pessoa')
            ->with(['pessoa:id_pessoa,nome'])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'nome') {
                    return $q->join('pessoa', 'saude_fichamedica.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                }
                return $q;
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}

```

---

## 5. 📌 Boas práticas

1. Manter queries centralizadas – evita duplicação de lógica em múltiplos serviços.
2. Nunca colocar regras de negócio – toda regra deve ficar nos services.
3. Sempre receber DTOs – mantém a estrutura de dados padronizada e clara.
4. Usar eager loading quando necessário – melhora performance e evita N+1 queries.
5. Criar métodos nomeados – nomes claros como `buscarComFiltros` ou `buscarPorNome` ajudam na legibilidade.
6. Evitar lógica complexa no Controller – sempre delegue consultas personalizadas ao repository.