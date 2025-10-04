# 🌐 Swagger / OpenAPI

O Swagger (agora parte do OpenAPI Specification) é uma ferramenta que permite documentar e testar APIs RESTful de forma padronizada.

Na API Wegia, utilizamos o Swagger para gerar uma documentação interativa, que facilita a integração entre backend e frontend, além de servir como referência oficial da API.

!!! info "💡 Resumo"
O Swagger transforma comentários no código em uma interface visual, mostrando endpoints, parâmetros, respostas, exemplos e autenticação. Ele também permite testar chamadas diretamente no navegador.

---

## 1. 🏗️ Estrutura do Swagger

Um endpoint documentado com Swagger geralmente possui:

| Elemento                    | Descrição                                                      |
|-----------------------------|----------------------------------------------------------------|
| `@OA\Get`, `@OA\Post`, etc. | Define o método HTTP do endpoint (GET, POST, PUT, DELETE).     |
| `path`                      | URL do endpoint.                                               |
| `summary`                   | Breve descrição do endpoint.                                   |
| `tags`                      | Categoria do endpoint (usada para organizar na interface).     |
| `security`                  | Regras de autenticação (por exemplo `bearerAuth`).             |
| `@OA\Parameter`             | Define parâmetros de query, path ou header.                    |
| `@OA\RequestBody`           | Define o corpo da requisição (usado em POST ou PUT).           |
| `@OA\Response`              | Define respostas possíveis com código HTTP e exemplos de JSON. |
| `@OA\Schema`                | Define o tipo de dado, enumerações ou estrutura de objetos.    |

---

## 2. 🏗️ Estrutura de um endpoint

Exemplo de endpoint documentado:

!!! warning "IMPORTANTE"

Dentro do body do **POST** e **PUT** recebemos os valores que vem dos [FormRequests](validation.md).



### 🔹 GET

```php
/**
 * @OA\Get(
 *     path="/saude/ficha-medica",
 *     summary="Buscar todas as fichas médicas paginadas",
 *     tags={"Saude Ficha Medica"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *          name="pagina",
 *          in="query",
 *          description="Número da página",
 *          required=false,
 *          @OA\Schema(type="integer", minimum=1)
 *      ),
 *     @OA\Response(response=200, description="Operação realizada com sucesso")
 * )
 */
```

### 🔹 POST

```php
/**
 * @OA\Post(
 *     path="/saude/ficha-medica",
 *     summary="Criar nova ficha médica",
 *     tags={"Saude Ficha Medica"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/SaudeFichaMedicaCadastrarValidation")
 *     ),
 *     @OA\Response(response=201, description="Ficha médica criada com sucesso")
 * )
 */
```

### 🔹 PUT

```php
/**
 * @OA\Put(
 *     path="/saude/ficha-medica/{id}",
 *     summary="Atualizar ficha médica existente",
 *     tags={"Saude Ficha Medica"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/SaudeFichaMedicaCadastrarValidation")
 *     ),
 *     @OA\Response(response=200, description="Ficha médica atualizada com sucesso")
 * )
```

### 🔹 DELETE

```php
/**
 * @OA\Delete(
 *     path="/saude/ficha-medica/{id}",
 *     summary="Deletar ficha médica",
 *     tags={"Saude Ficha Medica"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *     @OA\Response(response=200, description="Ficha médica deletada com sucesso")
 * )
 */
```

---

## 3. 🧩 Dividino a api em modulos

Para organizar a API em módulos, podemos configurar o Swagger para gerar documentação separada para cada módulo. Isso facilita a manutenção e melhora a leitura da documentação.

**Passo a passo**

1. Abra o arquivo de configuração do L5 Swagger:
    ```bash
    config/l5-swagger.php
    ```
2. Dentro do array principal, adicione a configuração do módulo desejado. Exemplo para o módulo memorando:

    ```php
    'memorando' => [
        'api' => [
            'title' => 'API Memorando', // 🎯 Título do módulo na documentação
        ],
        'routes' => [
            'api' => 'api/memorando/documentation', // 🌐 URL para acessar a documentação via browser
            'docs' => 'api/memorando/docs'          // 📄 URL para download dos arquivos JSON/YAML
        ],
        'paths' => [
            'docs' => storage_path('memorando-api-docs'), // 💾 Diretório onde os arquivos gerados serão salvos
    
            'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true), // 🛣️ Usa caminhos absolutos para links internos
    
            'docs_json' => 'memorando-api-docs.json', // 📄 Nome do arquivo JSON gerado
            'docs_yaml' => 'memorando-api-docs.yaml', // 📄 Nome do arquivo YAML gerado
            'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'), // ⚙️ Formato padrão para a documentação (JSON ou YAML)
    
            'annotations' => [
                base_path('Modules/Memorando'), // 📝 Caminho para onde o Swagger irá buscar os comentários para gerar a documentação
            ],
        ],
    ],
    
    ```

| Configuração                     | Descrição                                                                 |
|---------------------------------|---------------------------------------------------------------------------|
| `api.title`                      | Define o título do módulo que aparecerá no Swagger UI.                  |
| `routes.api`                     | Caminho público para acessar a documentação pelo navegador.            |
| `routes.docs`                    | Caminho público para acessar os arquivos JSON/YAML gerados.            |
| `paths.docs`                     | Diretório local onde os arquivos de documentação serão salvos.         |
| `use_absolute_path`              | Define se os links internos da documentação usarão caminho absoluto.  |
| `docs_json` / `docs_yaml`        | Nomes dos arquivos de documentação que serão gerados.                  |
| `format_to_use_for_docs`         | Formato padrão para exportação (JSON ou YAML).                         |
| `annotations`                    | Diretórios onde o Swagger busca os comentários para gerar a documentação.|

---

## 4. 🎯 Boas práticas do Swagger / OpenAPI

| Prática                       | Descrição                                                                       |
|-------------------------------|---------------------------------------------------------------------------------|
| Documentar todos os endpoints | Cada rota deve ter sua documentação completa, incluindo parâmetros e respostas. |
| Usar tags para organizar      | Agrupa endpoints por módulo ou funcionalidade, facilitando a navegação.         |
| Informar tipos corretos       | Definir `integer`, `string`, `boolean`, `arrays` ou `objetos` nos parâmetros.       |
| Exemplos claros               | Fornecer exemplos reais nos parâmetros e respostas.                             |
| Manter atualizada             | Atualizar a documentação sempre que endpoints forem alterados.                  |
| Definir códigos de resposta   | Documentar códigos como 200, 201, 400, 401, 403, 422, 500, etc.                 |
| Incluir autenticação          | Informar métodos de autenticação e tokens necessários.                          |
| Testar via Swagger UI         | Validar endpoints diretamente na interface sem precisar do frontend.            |

---

## 5. Gerando a documentação

Após a criação dos comentários do Swagger, precisamos executar o seguinte comando:

```bash
php artisan l5-swagger:generate --all
```

No nosso caso, como estamos trabalhando em cima de container do docker, podemos executar o seguinte comando:

```bash
docker exec -it api php artisan l5-swagger:generate --all
```