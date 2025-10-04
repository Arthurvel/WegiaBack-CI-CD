# 📚 Resource de Paginação

O **PaginacaoResource** é um `Resource` especial da API Wegia, responsável por **padronizar a resposta paginada** de coleções, permitindo que o frontend receba dados consistentes e informações de paginação sem precisar processar manualmente.

!!! info "💡 Resumo"
Este Resource facilita a integração entre Controllers e frontend quando o retorno é uma coleção paginada. Ele encapsula os **itens da coleção, a página atual, total de páginas, total de itens e itens por página**, podendo opcionalmente transformar cada item usando outro Resource específico.

---

## 1. 🏗️ Estrutura

```php
class PaginacaoResource extends ResourceCollection
{
    protected $itemResource = null;

    public function __construct($resource, $itemResource = null)
    {
        parent::__construct($resource);
        $this->itemResource = $itemResource;
    }

    public function toArray($request) : array
    {
        $items = $this->itemResource
            ? call_user_func($this->itemResource . '::collection', $this->collection)
            : $this->collection;

        return [
            'items'          => $items,
            'paginaAtual'    => $this->currentPage(),
            'totalPaginas'   => $this->lastPage(),
            'totalItens'     => $this->total(),
            'itensPorPagina' => $this->perPage()
        ];
    }
}
```

✅ Características principais:

- Aceita qualquer coleção paginada do Laravel.
- Permite transformar os itens com outro Resource (`$itemResource`).
- Retorna JSON padronizado com todos os dados de paginação.

---

## 2. 🎯 Responsabilidades do PaginacaoResource

| Responsabilidade                  | Descrição                                                                 |
|-----------------------------------|---------------------------------------------------------------------------|
| Padronizar respostas paginadas    | Sempre retorna um JSON consistente para coleções paginadas.              |
| Incluir metadados de paginação    | Contém `paginaAtual`, `totalPaginas`, `totalItens` e `itensPorPagina`.  |
| Transformar itens com Resources   | Permite usar outro Resource para cada item da coleção, mantendo consistência. |
| Facilitar o consumo pelo frontend | Evita que o frontend precise calcular manualmente offsets, total de páginas ou manipular arrays. |
| Integrar facilmente com Controllers| Pode ser usado diretamente em Controllers após buscas paginadas.        |


---

## 3. 🛠️ Como usar

### 🔹 Com um Resource específico para os itens

```php
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\Http\Resources\SaudeFichaMedicaResource;

$fichas = SaudeFichaMedica::paginate(10);

return new PaginacaoResource($fichas, SaudeFichaMedicaResource::class);
```

✅ Nesse caso:

- Cada item da coleção será transformado pelo SaudeFichaMedicaResource.
- A resposta JSON incluirá automaticamente os metadados de paginação.


### 🔹 Sem Resource específico (apenas array de itens)

```php
$usuarios = User::paginate(10);

return new PaginacaoResource($usuarios);
```

✅ Aqui:

- Os itens serão retornados sem transformação extra.
- Continua incluindo todas as informações de paginação.
- **Não é recomendado e nem uma boa prática seu uso sem o resource auxiliar.**

---

## 4. 📄 Estrutura da resposta JSON

```json
{
  "items": [...],
  "paginaAtual": 1,
  "totalPaginas": 5,
  "totalItens": 50,
  "itensPorPagina": 10
}
```

---

## 5. 📝 Boas Práticas

| Prática                     | Descrição                                                                 |
|-----------------------------|---------------------------------------------------------------------------|
| Sempre usar Resource        | Mantém a padronização de todas as respostas paginadas.                    |
| Transformar itens           | Sempre que possível, passe um Resource específico para cada item.         |
| Evitar lógica extra no Controller| Não faça cálculos de paginação manualmente; deixe o Resource cuidar disso. |
| Reutilizar o mesmo Resource | Para todas as coleções paginadas, utilize o mesmo padrão.                 |
| Clareza no frontend         | Garante que frontend não precise adivinhar ou calcular informações de paginação. |

