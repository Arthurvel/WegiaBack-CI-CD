# 🔒 Autenticação

Esta seção fornece informações essenciais sobre como foi implementada a autenticação e o controle de acesso da aplicação.

## 1. Autenticação com Laravel Sanctum

A API Wegia utiliza o [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
para autenticação baseada em tokens, garantindo que apenas usuários autenticados e com permissões adequadas possam acessar determinados recursos.

### 🛠️ Fluxo de autenticação

1. **Login**: `POST /api/login` com CPF e senha.
2. **Geração do Token**: se válido, a API emite um Bearer Token associado ao usuário e às suas permissões (`abilities`).
3. **Envio nas requisições**: incluir o token no cabeçalho:

```http
Authorization: Bearer <SEU_TOKEN>
```

4. **Validação**: o middleware `auth:sanctum` verifica a autenticidade do token e suas abilities.

!!! warning "IMPORTANTE"
Tokens expiram após 1 hora; após isso, o usuário precisa realizar login novamente.

### ⚙️ Abilities

As abilities permitem controlar de forma refinada o acesso a endpoints específicos.

No construtor do controller, adicionamos:

```php
public function __construct()
{
    // Exige autenticação e a habilidade 'atualizar-pet' para acessar o método 'update'
    $this->middleware(['auth:sanctum', 'ability:atualizar-pet'])->only(['update']);
}
```
Isso significa que, para executar update, o usuário precisa:

* Estar autenticado (`auth:sanctum`)
* Possuir a permissão `Atualizar pet` registrada na tabela `permissao`.

### 🗂️ Relação entre as tabelas de permissionamento

| Tabela             | Relação | Próxima Tabela     |
|--------------------|---------|--------------------|
| `pessoa`           | 1 → 1   | `funcionario`      |
| `funcionario`      | 1 → 1   | `perfil`           |
| `perfil`           | 1 → n   | `perfil_permissao` |
| `perfil_permissao` | n → 1   | `permissao`        | 

### 🚫 Revogação de Token

Tokens emitidos podem ser revogados a qualquer momento removendo-os da tabela `personal_access_tokens`.  
Isso é útil, por exemplo, ao invalidar acessos de usuários desligados ou redefinir permissões.