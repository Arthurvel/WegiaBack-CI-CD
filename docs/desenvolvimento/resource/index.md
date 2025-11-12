# 🎨 Resources 

Esta seção descreve a camada de Resources da API Wegia.

Os resources são responsáveis por transformar os modelos Eloquent em JSON padronizado para retorno das APIs, garantindo que a saída seja consistente e adequada para o front-end.

!!! info "💡 Resumo"
Os Resources atuam como camada de apresentação da API, permitindo que os dados dos Models sejam formatados e transformados antes de serem enviados como resposta.
Eles ajudam a manter a consistência do JSON, evitando que detalhes internos do banco sejam expostos diretamente.

--- 

## 1. 🏗️ Estrutura

Todos os resources extendem a classe `JsonResource` do Laravel e implementam o método `toArray($request)`.
Dentro desse método, você pode:

1. Selecionar apenas os campos que quer expor.
2. Incluir relações usando outros resources.
3. Transformar ou formatar os dados conforme necessário.

### Exemplo

```php
<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Pessoa\PessoaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeFichaMedicaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_fichamedica' => $this->id_fichamedica,
            'id_pessoa'      => $this->id_pessoa,
            'prontuario'     => $this->prontuario,
            'pessoa'         => $this->relationLoaded('pessoa') ? new PessoaResource($this->pessoa) : null,
            'historico'      => $this->relationLoaded('historico') ? SaudeFichaMedicaProntuarioHistoricoResource::collection($this->historico) : null,
        ];
    }
}
```

Nesse exemplo:

1. O resource transforma os campos do model SaudeFichaMedica em JSON.
2. Inclui relações com Pessoa e Historico apenas se estiverem carregadas (`relationLoaded`).
3. Permite que outras camadas (como controllers e services) não precisem formatar os dados manualmente.
4. Facilita o versionamento e padronização da API.

---

## 3. 🛠️ Como usar Resources

Os Resources do Laravel permitem transformar os modelos e coleções em respostas JSON padronizadas. Eles devem ser usados sempre que for necessário enviar dados para o frontend de forma organizada e consistente

### 🔹 Instanciando um Resource Individual

Para retornar um único registro:

```php
use Modules\Saude\app\Http\Resources\SaudeFichaMedicaResource;
use Modules\Saude\app\Models\SaudeFichaMedica;

$ficha = SaudeFichaMedica::findOrFail(1);

// Retorno em controller
return new SaudeFichaMedicaResource($ficha);
```

✅ Nesse caso:

- O Resource transforma os campos do modelo conforme definido no `toArray()`.
- Inclui automaticamente relacionamentos carregados (pessoa, historico, etc.).
- Mantém a padronização de resposta da API.

### 🔹 Retornando uma Coleção de Recursos

Para retornar vários registros de uma vez:

```php
use Modules\Saude\app\Http\Resources\SaudeFichaMedicaResource;

$fichas = SaudeFichaMedica::paginate(10);

// Retorno em controller
return SaudeFichaMedicaResource::collection($fichas);
```

✅ Benefícios:

- Gera um JSON padronizado para cada item da coleção.
- Suporta paginação nativa do Laravel.
- Evita criar loops manuais para transformar cada registro.

### 🔹 Retornando listas paginadas

Para retornar listas paginadas foi criado na aplicação um resource específico. Para mais informações acesse [paginação](paginacao.md)

---

## 4. 📝 Responsabilidades dos Resources

| Responsabilidade                   | Descrição                                                                 |
|-----------------------------------|---------------------------------------------------------------------------|
| Padronizar saída da API         | Todos os responses seguem o mesmo formato JSON.                          |
| Transformar relacionamentos     | Permite incluir relações Eloquent usando outros resources.               |
| Proteger dados sensíveis         | Evita expor campos que não devem ir para o front-end.                    |
| Transformar dados                | Modifica ou formata campos antes de enviar (ex: datas, valores, enums). |
| Reutilização                    | Resources podem ser reutilizados em diferentes endpoints.               |
| Suporte a coleções               | Pode retornar um resource individual ou uma coleção usando `Resource::collection()`. |

### 5. Boas práticas

1. Sempre criar resources específicos por módulo – mantém organização.
2. Evitar lógica de negócio dentro do resource – apenas transformar dados.
3. Incluir apenas os campos necessários para o consumidor da API.
4. Garantir consistência entre endpoints – todos os resources do mesmo tipo devem seguir o mesmo padrão.
5. Proteger dados sensíveis ou internos do banco antes de retornar.
6. Todo retorno da api deve utilizar um resource.

Para mais informações, acesse a [documentação do laravel](https://laravel.com/docs/12.x/eloquent-resources#main-content)