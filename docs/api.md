# Documentação da API

Esta seção fornece informações essenciais sobre como interagir com a API Wegia, incluindo autenticação, estrutura de respostas e como acessar a documentação detalhada dos endpoints.

## Documentação com Swagger (OpenAPI)

A API Wegia é documentada utilizando o padrão **OpenAPI**, e a interface visual é gerada através do **Swagger UI**. Esta é a fonte de verdade para todos os endpoints, parâmetros, e schemas de resposta.

### Como Acessar

Após [instalar e executar o projeto](instalacao.md), a documentação da API principal pode ser acessada no seguinte endereço:

[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

Como o projeto utiliza uma arquitetura modular, é possível que cada módulo tenha sua própria documentação. Verifique os seguintes links:

*   **Módulo Principal:** `http://localhost:8000/api/documentation`
*   **Material:** `http://localhost:8000/api/documentation`
*   **Memorando:** `http://localhost:8000/api/documentation?urls.primaryName=API+Memorando`
*   **Pet:** `http://localhost:8000/api/documentation?urls.primaryName=API+Pet`
*   **Saude:** `http://localhost:8000/api/documentation?urls.primaryName=API+Saude`

É possível acessar cada link também escolhendo ele no select que aparece no canto superior direito quando o swagger é acessado.

## Autenticação

A API utiliza o **Laravel Sanctum** para autenticação baseada em tokens. Para acessar endpoints protegidos, você deve primeiro obter um token de acesso e, em seguida, incluí-lo em todas as requisições subsequentes.

#### Fluxo de Autenticação:

1.  **Login:** Envie uma requisição `POST` para o endpoint de login (`/api/login`) com as credenciais do usuário (cpf e senha).
2.  **Receber Token:** Se as credenciais forem válidas, a API retornará um token de acesso (Bearer Token).
3.  **Enviar Token:** Para cada requisição a um endpoint protegido, inclua o token no cabeçalho `Authorization`.

```http
Authorization: Bearer <SEU_TOKEN_DE_ACESSO>
```

## Paginação

Endpoints que retornam uma lista de recursos suportam paginação. Você pode controlar os resultados utilizando os seguintes parâmetros na query string:

*   `paginacao`: O número da página que você deseja acessar.
*   `itensPorPagina`: A quantidade de itens por página.

**Exemplo de Requisição:**

```http
GET /api/funcionarios?pagina=2&itensPorPagina=15
```

```json
{
  "status": 200,
  "message": "Operacação realizada com sucesso",
  "data": {
    "paginaAtual": 2,
    "totalPaginas": 5,
    "totalItens": 75,
    "itensPorPagina": 15,
    "items": [
      {
        "id": 16,
        "nome": "João Silva",
        ...
      }
    ]
  }
}
```

A resposta para uma requisição paginada será encapsulada em um objeto JSON contendo os dados e meta-informações sobre a paginação, como `paginaAtual`, `totalPaginas`, `totalItens`, `itensPorPagina` e `items`.

## Respostas de Erro

A API utiliza os códigos de status HTTP padrão para indicar o sucesso ou falha de uma requisição. O corpo da resposta de erro segue um formato JSON padronizado, graças ao `Trait/Response.php`.

| Código      | Significado                                         |
|-------------|-----------------------------------------------------|
| 400         | Bad Request – requisição malformada                 |
| 401         | Unauthorized – token inválido ou ausente            |
| 403         | Forbidden – usuário sem permissão                   |
| 404         | Not Found – recurso não encontrado                  |
| 422         | Unprocessable Entity – erros de validação           |
| 500         | Internal Server Error – erro inesperado no servidor |
