# ⚡ Traits

Esta seção descreve os Traits da API Wegia.

Traits são conjuntos de métodos reutilizáveis que podem ser incluídos em qualquer classe (Controllers, Services etc.) para padronizar comportamentos comuns sem precisar herdar de uma classe base.

!!! info "💡 Resumo"
Traits permitem evitar duplicação de código, fornecer funcionalidades compartilhadas e manter as classes mais enxutas.
Eles são ideais para comportamentos que não se encaixam perfeitamente em Services ou Controllers, mas que precisam ser reutilizados em múltiplos lugares.

## 1. 🏗️ Estrutura dos Traits

Traits podem conter métodos públicos, protegidos ou privados, e podem ser combinados em qualquer classe usando a palavra-chave `use`:

```php
trait NomeDoTrait
{
    public function metodoPublico()
    {
        // lógica reutilizável
    }

    protected function metodoProtegido()
    {
        // lógica acessível apenas dentro da classe que usar o trait
    }

    private function metodoPrivado()
    {
        // lógica interna do trait
    }
}
```

---

## 2. ✅ Benefícios de utilizar Traits

| Benefício                          | Descrição                                                                 |
|-----------------------------------|---------------------------------------------------------------------------|
| Reutilização de código             | Métodos comuns podem ser usados em múltiplas classes sem duplicação.      |
| Organização de responsabilidades   | Permite separar comportamentos específicos sem criar herança complexa.    |
| Flexibilidade                      | Uma classe pode usar múltiplos traits simultaneamente.                    |
| Manutenção simplificada            | Alterações em um trait afetam todas as classes que o utilizam.            |
| Modularidade                       | Funcionalidades podem ser adicionadas ou removidas facilmente.            |
| Evita classes “inchadas”           | Reduz a necessidade de colocar métodos auxiliares em classes principais. |

---

## 3. 🔄 Boas práticas ao criar Traits

1. Criar traits com foco único – cada trait deve encapsular uma responsabilidade clara.
2. Evitar dependências fortes – traits não devem depender de classes específicas.
3. Usar nomes descritivos – facilite identificar a funcionalidade que o trait oferece.
4. Documentar métodos – explique claramente entrada, saída e efeito colateral de cada método.
5. Combinar com interfaces quando necessário – garante que a classe que usa o trait implemente métodos obrigatórios.
6. Evitar lógica complexa – traits devem complementar, não substituir Services ou Repositories.