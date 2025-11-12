# DTOs (Data Transfer Objects)

Esta seção descreve como os **Data Transfer Objects (DTOs)**  são utilizados na aplicação, garantindo integridade e tipagem.

---


Os DTOs são objetos que carregam dados entre as camadas da aplicação. Eles ajudam a manter os **controllers magros** e facilitam a validação e transformação de dados.

## Exemplo de DTO

```php
namespace Modules\Memorando\app\DTO;

use App\DTOs\BaseDTO;

class DespachoCadastrarDTO extends BaseDTO
{
    public string $id_memorando;
    public string $id_remetente;
    public string $id_destinatario;
    public string $texto;
}
```

* **Responsabilidade**: Estruturar os dados recebidos pelo controller de forma tipada e segura.
* **BaseDTO**: fornece métodos úteis como `fromArray()`, `toArray()` e `toArrayUpdate()` para facilitar a conversão de arrays em objetos e vice-versa.

## Vantagens do uso de DTOs

* Mantém a tipagem dos dados.
* Facilita testes unitários.
* Centraliza a transformação de dados entre camadas.

## Exemplo de um dos seus usos na controller

```php

#Validação realizada no retorno dos dados
$validated = $request->validated();
$dto = SaudeEnfermidadeCadastrarDTO::fromArray($validated);

```

Com isso, garantimos integridade dos dados irão ser passados entre as camadas da aplicação.

## Boas práticas

1. Sempre use DTOs para transportar dados entre Controller → Service → Repository.
2. Mantenha os DTOs separados do controller, garantindo separação de responsabilidades.
3. Utilize os DTOs também para atualizar recursos, evitando sobreescrever campos desnecessários.
