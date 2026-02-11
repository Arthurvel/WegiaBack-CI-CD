# 🗄️ Migrations

Esta seção fornece uma visão geral das **Migrations** da API Wegia, explicando suas responsabilidades, estrutura, padrões e integração com a arquitetura em camadas.

---

!!! info " 💡 Resumo"
Migrations são responsáveis por **versionar a estrutura do banco de dados**, garantindo que o schema seja reproduzível, rastreável e consistente entre ambientes (dev, staging, produção).

---

## 1. 🏗️ Estrutura

### 📁 Organização por domínio

```md
database/migrations/
├── 2025_03_01_123131_cerate_peronsal_token.php
├── 2025_03_01_141231_cerate_pessoa_tabela.php
├── 2025_03_01_141231_cerate_funcionario_tabela.php
└── ...
```


## 2. 🧬 Estrutura base

```php
return new class extends Migration {

    public function up(): void
    {
        Schema::create('nome_tabela', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('nome', 150);
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nome_tabela');
    }
};
```

---

## 3. 🧩 Componentes principais

| Elemento     | Função                      |
| ------------ | --------------------------- |
| Schema       | Abstração do banco de dados |
| Blueprint    | Definição da tabela         |
| Migration    | Versionamento estrutural    |
| Foreign Keys | Integridade referencial     |
| Indexes      | Performance                 |

---

## 4. 📐 Padrões de campos

```php
$table->string('nome', 150);
$table->text('descricao')->nullable();
$table->boolean('status')->default(true);
$table->decimal('valor', 10, 2);
$table->json('config')->nullable();
$table->date('data');
$table->timestamps();
$table->softDeletes();
```

---

## 5. 🔗 Relacionamentos

```php
$table->foreignId('id_funcionario')->constrained();
$table->foreignId('id_pessoa')->references('id')->on('pessoa');
```

---

## 6. 🎯 Boas práticas

1. Nunca editar migration já aplicada
2. Alterações = nova migration
3. Sempre ter método `down()` funcional
4. Não inserir dados em migration
5. Nomes claros e semânticos
6. Separar por domínio
7. Sempre usar FK

---

!!! info "Importante"
Migrations são **infraestrutura**, não regra de negócio. Nenhuma lógica de domínio deve existir nelas.

Para mais informações técnicas: [https://laravel.com/docs/12.x/migrations](https://laravel.com/docs/12.x/migrations)
