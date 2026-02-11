# 🌱 Seeders

Esta seção fornece uma visão geral dos **Seeders** da API Wegia, explicando suas responsabilidades, padrões de organização e integração com a arquitetura em camadas.

---

!!! info " 💡 Resumo"
Seeders são responsáveis por **popular o banco de dados com dados iniciais**, dados de teste e dados estruturais essenciais para funcionamento do sistema.

---

## 1. 🏗️ Estrutura

### 📁 Organização por domínio

```md
database/seeders/
├── CoreSeeder.php
├── AuthSeeder.php
├── FinanceiroSeeder.php
├── SaudeSeeder.php
├── EstoqueSeeder.php
└── DatabaseSeeder.php
```

## 2. 🧬 Estrutura base

```php
class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'email' => 'admin@sistema.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
```

---

## 3. 🧩 Componentes principais

| Elemento      | Função                       |
| ------------- | ---------------------------- |
| Seeder        | Classe de população de dados |
| DB Facade     | Inserção direta              |
| Model Factory | Geração automática           |
| Faker         | Dados falsos                 |

---

## 4. 🔗 Relacionamentos

```php
$userId = DB::table('users')->insertGetId([
    'name' => 'Admin',
    'email' => 'admin@sistema.com',
    'password' => bcrypt('123456'),
]);

DB::table('perfis')->insert([
    'nome' => 'Administrador',
    'user_id' => $userId,
]);
```

---

## 5. 🧠 DatabaseSeeder (orquestrador)

```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
           UserSeeder::class,
           PermissaoSeeder::class,
           ContaSeeder::class,
        ]);
    }
}
```

---

## 6. 🧠 Comandos necessários

### 6.1 🛠️ Geração dos arquivos

Criação na raiz do projeto:

```shell
php artisan make:seeder CriarPessoaSeeder
```

Criação dentro de modulos:

```shell
php artisan module:make-seeder Saude FichaMedicaSeeder
```

### 6.2 🚀 Geração dos dados

Raiz do projeto:

```shell
php artisan db:seed
```

Modulos do projeto:

```shell
php artisan module:seed --class=DatabaseSeeder --all
```

---

Para mais informações técnicas: [https://laravel.com/docs/12.x/seeding](https://laravel.com/docs/12.x/seeding)
