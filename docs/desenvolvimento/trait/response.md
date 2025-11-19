# ⚡ Trait: Response

Esta seção descreve o Trait Response da API Wegia.

O Response fornece métodos padronizados para retorno de respostas JSON, garantindo consistência em toda a aplicação ao lidar com sucesso e erros.

!!! info "💡 Resumo"
O Trait Response atua como um ponto central de padronização de respostas HTTP, garantindo que todos os controllers retornem dados consistentes em formato JSON, tanto em operações bem-sucedidas quanto em falhas.

---

## 1. 🏗️ Estrutura

O Trait Response contém dois métodos principais:

1. `sucessoResponse()` – retorna respostas padronizadas para operações bem-sucedidas.
2. `errorResponse()` – retorna respostas padronizadas para erros, com tratamento de exceções comuns.

Ele pode ser utilizado por qualquer controller que necessite padronizar o retorno de APIs. Por padrão ele é chamado no `BaseController` para estar disponivel nos demais. É de boa prática todos os retornos da api utilizarem eles.

````php
trait Response
{
    protected function sucessoResponse($data, int $statusCode = 200, string $message = 'Operação realizada com sucesso!'): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(\Exception $exception = null, int $statusCode = 400, string $messageError = 'Ocorreu um erro na operação!'): JsonResponse
    {
        $status = $statusCode;
        $message = $exception->getMessage();

        if ($exception instanceof ModelNotFoundException) {
            $message = 'Não encontrado';
            $status = 404;
        }

        if ($exception instanceof ValidationException) {
            $message = $exception->validator->getMessageBag()->getMessages();
            $status = 422;
        }

        if($exception instanceof AuthorizationException) {
            $message = $exception->getMessage();
            $status = 403;
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
````

---

## 2. 📝 Responsabilidades do Trait Response

| Responsabilidade                 | Descrição                                                                                     |
|----------------------------------|-------------------------------------------------------------------------------------------------|
| Padronizar respostas de sucesso  | Garante que todas as respostas bem-sucedidas tenham o mesmo formato JSON.                     |
| Padronizar respostas de erro   | Garante consistência na resposta quando ocorre falha, incluindo tratamento de exceções.       |
| Tratar exceções comuns         | Lida com ModelNotFoundException, ValidationException, AuthorizationException e exceções gerais.|
| Simplificar controllers        | Evita repetição de código para criação de respostas HTTP em cada controller.                   |
| Facilitar integração com front-end | Permite que o front-end interprete facilmente mensagens, status e dados.                       |
|  Fornecer métodos reutilizáveis  | Permite que qualquer controller utilize `sucessoResponse` e `errorResponse` sem duplicação.  |
| Garantir consistência           | Mantém uniformidade em todos os retornos de API, facilitando debug e manutenção.             |

---

## 3. 💡 Exemplo de Uso

```php
class UsuarioController extends Controller
{
    use Response;

    public function buscarPorId(int $id)
    {
        try {
            $usuario = $this->service->buscarPorId($id);
            return $this->sucessoResponse($usuario);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
```

## 4.🏆 Boas práticas

1. Utilizar sucessoResponse() sempre que a operação for concluída com êxito.
2. Utilizar errorResponse() para capturar exceções, evitando duplicação de código em controllers.
3. Manter a consistência das mensagens retornadas para facilitar integração com front-end.
4. Tratar exceções específicas (ModelNotFoundException, ValidationException, AuthorizationException) para respostas HTTP corretas.
5. Evitar lógica de negócio no Trait – ele deve se concentrar apenas na padronização de respostas.
