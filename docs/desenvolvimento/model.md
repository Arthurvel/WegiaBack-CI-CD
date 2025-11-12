# 🏛️ Model

As **Models** no Laravel representam as tabelas do banco de dados e são responsáveis por **mapear os dados, definir relações e permitir interações com o banco de forma estruturada**. Elas funcionam como o elo entre o **Repository** e o **banco de dados**, encapsulando a estrutura e regras de persistência.

!!! info "💡 Resumo"
A camada de Models abstrai o banco de dados, permitindo que Services e Repositories realizem operações CRUD de forma clara, organizada e padronizada. Além disso, as Models definem relacionamentos entre tabelas e regras específicas de cada entidade.

---

## 1. 🏗️ Estrutura

```php
class SaudeFichaMedica extends BaseModel
{
    protected $table = 'saude_fichamedica';
    protected $primaryKey = 'id_fichamedica';

    protected $fillable = [
        'id_pessoa',
        'prontuario'
    ];

    public function pessoa() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function historico() : HasMany
    {
        return $this->hasMany(SaudeFichaMedicaProntuarioHistorico::class, 'id_fichamedica')->orderBy('data', 'desc');
    }
}
```

✅ **Características principais:**

* Herda de um BaseModel, que encapsula configurações comuns (timestamps, traits etc.).
* Define $table e $primaryKey para mapear corretamente a tabela e chave primária.
* Especifica $fillable para permitir atribuição em massa segura.
* Define métodos para relacionamentos com outras tabelas (BelongsTo, HasMany).

---

## 2. 🎯 Responsabilidades de uma Model

| Responsabilidade              | Descrição |
|-------------------------------|-------------|
| Mapear tabela                 | Define a tabela associada e a chave primária no banco. |
| Permitir atribuição segura    | `$fillable` ou `$guarded` definem quais campos podem ser atribuídos em massa. |
| Definir relacionamentos       | Métodos como `hasMany`, `belongsTo` ou `belongsToMany` estruturam relações entre tabelas. |
| Facilitar consultas           | Permite usar Eloquent para construir queries de forma fluida e legível. |
| Encapsular regras específicas | Pode conter métodos auxiliares ou scopes para filtragens comuns. |
| Integrar com Repositories     | Serve como base para persistência e recuperação de dados via Repositories. |
| Preparar dados para Resources | Pode carregar relações para que Resources transformem a saída em JSON. |


---

## 3. 🔗 Exemplo de relacionamento

* BelongsTo (Pertence a outra tabela)

```php
public function pessoa() : BelongsTo
{
    return $this->belongsTo(Pessoa::class, 'id_pessoa');
}
```

* HasMany (Possui muitos registros relacionados)

```php
public function historico() : HasMany
{
    return $this->hasMany(SaudeFichaMedicaProntuarioHistorico::class, 'id_fichamedica')->orderBy('data', 'desc');
}
```

O laravel ainda possui outras diversas formas de relacionamento, para mais informações acesse a [documentação](https://laravel.com/docs/12.x/eloquent-relationships#main-content)

---

## 4. 🛠️ Boas práticas

| Prática                           | Descrição |
|-----------------------------------|------------|
| Definir `$fillable` ou `$guarded` | Sempre especifique campos permitidos para atribuição em massa. |
| Definir relacionamentos claros    | Sempre declare métodos para relações, facilitando consultas e carregamentos. |
| Usar scopes e helpers             | Para consultas frequentes, crie métodos ou scopes para simplificar chamadas. |
| Manter lógica de negócio fora     | Evite colocar regras de negócio complexas na Model; deixe para Services. |
| Preparar para Resources           | Utilize `with` ou `relationLoaded` para facilitar a transformação em Resources. |
| Padronizar BaseModel              | Utilize uma base comum (`BaseModel`) para atributos compartilhados e configurações padrão. |

Para mais informações acessa a [documentação do laravel](https://laravel.com/docs/12.x/eloquent#generating-model-classes).
