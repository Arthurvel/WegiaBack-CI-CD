# 🖥️ Controllers

Esta seção fornece uma visão geral dos **Controllers** da API Wegia, explicando suas responsabilidades, endpoints e integração com **DTOs** e **Validations**.

---

!!! info " 💡 Resumo"
   Controllers são responsáveis por **receber requisições HTTP**, coordenar a **validação e transformação dos dados** e encaminhar a execução para a camada de serviços.  
   Eles funcionam como o **ponto de entrada da API** e definem os **endpoints que serão consumidos** pelo frontend.

---

## 1. 🏗️ Estrutura

### 📜 Herança

Todos os controllers herdam de `BaseController`, que fornece:

- Traits para padronização de respostas (`Response`)
- Validação de dados (`Validador`)
- Regras de segurança e autenticação

### 🔄 Fluxo de um Controller

```text
[HTTP Request]
       ↓
 [Controller]
       ↓
 [Validation] → [DTO]
       ↓
   [Service]
       ↓
 [Repository]
       ↓
    [Model]
       ↓
  [Resource]
       ↓
[HTTP Response]
```

---

## 2. 🧩 Componentes principais

| Componente                  | Descrição                                                        |
|-----------------------------|------------------------------------------------------------------|
| DTOs                        | Objetos que transportam dados entre Controller e Service.       |
| FormRequests (Validations)  | Classe que valida e padroniza a entrada de dados.               |
| Services                    | Contêm a lógica de negócio.                                      |
| Repositories                | Responsáveis pelo acesso ao banco de dados.                     |
| Resources                   | Transformam entidades em formato JSON padronizado para resposta.|
| Middlewares                 | Gerenciam autenticação, permissões e outros filtros.            |

---

## 3. 🔧 Construtor

Dentro dos construtores, devemos instanciar nossas services que serão utilizadas. Além disso, tambem adicionamos as seguranças de rotas.

```php
class SaudeFichaMedicaController extends BaseController
{

    private SaudeFichaMedicaService $service;

    public function __construct(
        SaudeFichaMedicaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-ficha-medica'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-ficha-medica'])->only(['buscarPorId', 'buscarTodasFichasMedicas']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-saude-ficha-medica'])->only(['atualizarFichaMedica']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }
}
```

---

## 4. 📝 Exemplo Completo de Controller

```php
/**
     * @OA\Get(
     *     path="/saude/ficha-medica",
     *     summary="Buscar todas as fichas medicas paginadas",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          description="Texto para busca por nome",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação (nome)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"nome"})
     *      ),
     *      @OA\Parameter(
     *          name="tipoOrdenacao",
     *          in="query",
     *          description="Tipo de ordenação ASC ou DESC",
     *          required=false,
     *          @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *      ),
     *      @OA\Parameter(
     *          name="pagina",
     *          in="query",
     *          description="Número da página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
     *      @OA\Parameter(
     *          name="itensPorPagina",
     *          in="query",
     *          description="Quantidade de itens por página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
     *     @OA\Response(
     *         response=200,
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
    public function buscarTodasFichasMedicas(SaudeFichaMedicaParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaParamsDTO::fromArray($validated);

            $fichas = $this->service->buscarFichaMedica($dto);

            return $this->sucessoResponse( new PaginacaoResource($fichas, SaudeFichaMedicaResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
```

✅ **Observações importantes**

1. Todos os controllers precisam ter `try catch` para que ocorra a devida validação.
2. Uso do `sucessoResponse` e `errorResponse` para padronização de retorno
3. Validação da entrada de dados com o [FormRequest](validation.md).
4. Criação de dto para passagem de dados.
5. Utilização da camada service.
6. Utilização de um swagger com os dados de corretos para facilitação do front-end.

| Responsabilidade              | Descrição                                                                 |
|------------------------------|---------------------------------------------------------------------------|
| Receber requisições HTTP     | Mapeia rotas e métodos (GET, POST, PUT, DELETE)                           |
| Validar dados de entrada     | Usa FormRequest para garantir consistência antes de processar            |
| Criar DTOs                   | Converte arrays em objetos de transferência de dados                     |
| Invocar Services             | Encaminha lógica de negócio para a camada correta                        |
| Retornar respostas padronizadas | Utiliza Resources e Response helpers para formatar o retorno HTTP       |

---

## 5. 🎯 Boas práticas

1. **Validar entrada de dados** usando FormRequest (Validations).
2. **Converter dados para DTOs** antes de enviar para Services.
3. **Delegar lógica de negócio para Services**, mantendo controllers "magros".
4. **Usar Resources** para padronizar o formato de saída.
5. **Proteger endpoints** usando `middlewares` de autenticação e abilities do Laravel Sanctum.
6. **Documentar endpoints** com `Swagger/OpenAPI`. 

!!! info "Importante"
A documentação detalhada de cada endpoint (parâmetros, respostas, exemplos) está disponível no [Swagger](swagger.md). Esta seção tem como objetivo documentar a arquitetura dos controllers e as práticas recomendadas para sua implementação.

Para mais informações sobre os controllers, podemos buscar na sua [documentação](https://laravel.com/docs/12.x/controllers). Lembrando que apesar da documentação ser uma otima fonte de informação, ela nao vai trazer a padronização de projeto em camadas muitas das vezes.

