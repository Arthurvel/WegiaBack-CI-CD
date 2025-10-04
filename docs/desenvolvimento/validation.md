# DTOs e Validation

Esta seção descreve como as **Classes de Validação (FormRequests)** são utilizadas na aplicação validação de dados recebidos.

--- 

As classes de validação centralizam as regras de entrada de dados, garantindo consistência e reutilização do código.

## Exemplo de Validation

```php

<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeFichaMedicaCadastrarValidation",
 *     required={"id_pessoa", "prontuario"},
 *     @OA\Property(property="id_pessoa", type="string", description="id da pessoa"),
 *     @OA\Property(property="prontuario", type="string", description="Prontuario da pessoa")
 * )
 */
class SaudeFichaMedicaCadastrarValidation extends FormRequest
{
    protected function prepareForValidation() : void
    {
        // Busca os paths da rota
        $this->merge([
            'id_fichamedica' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_pessoa' => 'required|integer|exists:pessoa,id_pessoa|unique:saude_fichamedica,id_pessoa',
            'prontuario'  => 'required|string'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'exists'   => 'O :attribute informada não existe.',
        ];
    }
}



```

* **Responsabilidade**: Garantir que todos os dados recebidos estejam corretos antes de chegar na camada de serviço.
* **Integração com Swagger**: O FormRequest pode ser anotado com @OA\Schema para gerar a documentação automaticamente.

## Boas práticas

1. Valide dados via FormRequests antes de processá-los.
2. Use mensagens customizadas (messages()) para retornar erros claros ao cliente.
3. Mantenha a validação separado do controller, garantindo separação de responsabilidades.
4. Toda entrada de dados, independente de qual seja, deve receber uma validação. Utilize ela até mesmo pros `query params` que receber dos metodos `GET`.



