# Arquitetura do Software

A API Wegia foi projetada com foco em manutenibilidade, escalabilidade e separação de responsabilidades. Utilizamos o framework Laravel e adotamos uma combinação de padrões de arquitetura, incluindo uma estrutura em camadas e uma abordagem modular.

## 1. Arquitetura em Camadas

O fluxo de uma requisição na nossa API segue um padrão de camadas bem definido, garantindo que cada componente tenha uma única responsabilidade.

`Middleware` → `Controller` → `Service` → `Repository` → `Model`

#### Middlewares
- Localização: `app/Http/Middleware/`
  - **Responsabilidade:** Interceptar requisições para garantir algum tratamento antes de entrar na Controller.
  - Usado na parte de perfil permissão.

#### **Controllers**
-   **Localização:** `app/Http/Controllers/`
  -   **Responsabilidade:** Receber as requisições HTTP, validar os dados de entrada (utilizando DTOs e classes de Validação) e orquestrar a execução da lógica de negócio, delegando a chamada para a camada de Serviço. Eles são responsáveis por formatar e retornar a resposta HTTP.
  -   **IMPORTANTE:** Cada metodo precisa, necessariamente, ser documentado utilizando o swagger.

#### **Services**
-   **Localização:** `app/Services/`
  -   **Responsabilidade:** Conter a lógica de negócio central da aplicação. Um serviço pode coordenar múltiplos repositórios ou outros serviços para executar uma tarefa complexa. Esta camada mantém os controllers "magros" e o código de negócio reutilizável.

#### **Repositories**
-   **Localização:** `app/Repositories/`
  -   **Responsabilidade:** Abstrair a lógica de acesso a dados. O padrão Repository isola a camada de negócio das consultas diretas ao banco de dados. Ele é responsável por toda a comunicação com os Models do Eloquent, executando queries e retornando os dados de forma estruturada.

#### **Models**
-   **Localização:** `app/Models/`
  -   **Responsabilidade:** Representar as tabelas do banco de dados através do Eloquent ORM. Os models definem os relacionamentos, atributos e escopos de consulta.

## 2. Arquitetura Modular

Para organizar as funcionalidades e domínios da aplicação, utilizamos o pacote `nwidart/laravel-modules`. Isso significa que a aplicação é dividida em módulos independentes, onde cada um representa um contexto de negócio específico.

-   **Localização:** `Modules/`

Atualmente, os módulos são:
*   `Material`
  *   `Memorando`
    *   `Pet`
    *   `Saude`

#### Vantagens da Abordagem Modular:
*   **Encapsulamento:** Cada módulo possui suas próprias rotas, controllers, models, services, etc.
  *   **Manutenibilidade:** É mais fácil dar manutenção ou adicionar novas funcionalidades a um módulo sem impactar o restante do sistema.
    *   **Escalabilidade:** Novos domínios de negócio podem ser adicionados como novos módulos, mantendo o core da aplicação limpo.

## 3. Outros Padrões e Conceitos

#### **DTOs (Data Transfer Objects)**
-   **Localização:** `app/DTOs/`
  -   **Utilização:** São objetos simples que carregam dados entre as camadas da aplicação. Usamos DTOs principalmente para transferir dados validados de uma requisição (Controller) para a camada de Serviço de forma segura e tipada.

#### **Classes de Validação**
-   **Localização:** `app/Validations/`
  -   **Utilização:** Contêm as regras de validação para os dados de entrada. São reutilizáveis e ajudam a manter os controllers limpos, centralizando a lógica de validação.

#### **Traits**
-   **Localização:** `app/Traits/`
  -   **Utilização:**
      *   `Response.php`: Padroniza as respostas JSON da API, garantindo consistência nos formatos de sucesso e erro.

#### **Helpers**
-   **Localização:** `app/Helpers/`
  -   **Utilização:** Contêm funções auxiliares e stateless que podem ser usadas em qualquer parte da aplicação.
      *   `UploadSeguroHelper.php`: Padroniza a manipulação de um arquivo, podendo salvar, excluir e criar uma rota de visualização para ele.

## 4. Documentação da API (Swagger)

- Pacote `L5-Swagger` gera documentação interativa.
- Necessário adicionar o comentário de documentação em cada metodo da Controller.
- Configuração: `config/l5-swagger.php`
- Para gerar:
  ```bash
    php artisan l5-swagger:generate --all
  ```
- Acesso: `/api/documentation`