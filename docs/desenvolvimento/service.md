# ⚙️ Services

Esta seção descreve a camada de **Services** da API Wegia.  
Os services são responsáveis por **encapsular a lógica de negócio da aplicação**, funcionando como o elo entre os **Controllers**, **Repositories** e demais camadas do sistema.

---

!!! info " 💡 Resumo"
A camada de Service atua como o **cérebro da aplicação**, centralizando as regras de negócio e garantindo que o Controller permaneça simples e focado apenas em orquestrar a requisição.

---

## 1. 🏗️ Estrutura

Cada módulo do sistema possui seu próprio service, que **herda de `BaseService`** e implementa os métodos específicos daquele contexto.  

---

## 2. 🎯 Responsabilidades dos Services

| Responsabilidade                    | Descrição                                                                 |
|------------------------------------|---------------------------------------------------------------------------|
| Encapsular regras de negócio       | Centralizam as operações e validações que não pertencem ao controller.   |
| Interagir com o repositório        | Chamam métodos de persistência e consulta de dados.                      |
| Transformar e validar dados        | Podem complementar validações antes de enviar dados ao repositório.     |
| Coordenar fluxos complexos         | Orquestram chamadas a múltiplos repositórios ou serviços externos.      |
| Facilitar manutenção e testes      | Com a lógica isolada, fica mais fácil alterar ou testar o comportamento.|
| Trabalhar com DTOs                 | Garante desacoplamento entre a camada HTTP e a lógica de negócio.       |
| Delegar persistência ao Repository | Mantém a separação de responsabilidades entre lógica e acesso a dados.  |
| Criar métodos específicos          | Permite encapsular fluxos que vão além do CRUD básico.                  |
| Centralizar integrações externas   | Ideal para interações com APIs externas sem acoplar controllers.       |
| Aplicar logs e eventos             | Registra ações importantes e aciona eventos do domínio quando necessário. |


---

## 3. 🏛️ Estrutura do BaseService

Todos os services herdam de uma classe abstrata chamada BaseService, que fornece os métodos CRUD básicos e padronizados, perfeito para controllers simples que não possuem regras de negócio:

```php
abstract class BaseService
{
protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function criar(object $dto)
    {
        return $this->repository->criar($dto);
    }

    public function atualizar(int $id, object $dto)
    {
        return $this->repository->atualizar($id, $dto);
    }

    public function buscarTodos()
    {
        return $this->repository->buscarTodos();
    }

    public function buscarPorId(int $id, array $with = [])
    {
        return $this->repository->buscarPorId($id, $with);
    }

    public function deletar(int $id)
    {
        return $this->repository->deletar($id);
    }
}
```
---

## 4. 🔧 Exemplo de Service Específico

Um service específico estende a classe base e pode sobrescrever ou adicionar métodos conforme as regras de negócio do módulo:

```php
namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeFichaMedicaParamsDTO;
use Modules\Saude\app\Repositories\SaudeFichaMedicaRepository;

class SaudeFichaMedicaService extends BaseService
{
    public function __construct(SaudeFichaMedicaRepository $repository)
    {
    parent::__construct($repository);
    }
    
    public function buscarFichaMedica(SaudeFichaMedicaParamsDTO $dto)
    {
        return $this->repository->buscarFichaMedica($dto);
    }
}
```

---

## 5. 📌 Boas práticas

1. Manter Services “puros” – toda lógica de negócio deve estar aqui, e não no Controller.
2. Evitar dependências desnecessárias – injete apenas os repositórios ou serviços necessários.
3. Trabalhar sempre com DTOs – evita acoplamento direto com requisições HTTP.
4. Delegar persistência ao Repository – nunca acesse diretamente o banco de dados no service.
5. Criar métodos específicos – para fluxos de negócio que vão além do CRUD padrão.
6. Adicionar logs ou eventos aqui – caso precise auditar operações críticas.