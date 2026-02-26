# 📦 Módulos

Esta seção documenta o padrão de **módulos (Modules)** da API Wegia, definindo a organização, responsabilidades e integração com a arquitetura em camadas do projeto.

---

!!! info "💡 Resumo"
Módulos representam **domínios de negócio isolados** (bounded contexts).  
Cada módulo é **autônomo**, desacoplado e organizado em camadas, garantindo escalabilidade, manutenção e evolução independente do sistema.

---

## 1. 🏗️ Estrutura de um módulo

```text
Modules/
└── Saude/
    ├── Config/
    ├── Database/
    │   ├── Migrations/
    │   └── Seeders/
    ├── Http/
    │   ├── Controllers/
    │   ├── Requests/
    ├── DTOs/
    ├── Models/
    ├── Repositories/
    ├── Services/
    ├── Providers/
    ├── module.json
```

## 2. 🛠️ Comandos principais

### 📦 Criar módulo

```shell
php artisan module:make Saude
```

---

### 🗄️ Migration no módulo

```shell
php artisan module:make-migration Saude create_fichas_medicas_table
```

---

### 🌱 Seeder no módulo

```shell
php artisan module:make-seeder Saude FichaMedicaSeeder
```

---

### 🚀 Rodar migrations do módulo

```shell
php artisan module:migrate Saude
```

---

### 🌱 Rodar seeders do módulo

```shell
php artisan module:seed Saude
```

---

### 🌍 Rodar todos os módulos

```shell
php artisan module:migrate --all
php artisan module:seed --all
```

---

## 3. 🎯 Boas práticas

1. Cada módulo = um domínio de negócio;
2. Módulos não se acoplam entre si;
3. Nunca acessar Model de outro módulo direto;

---

!!! info "Importante"
Módulos são a base da escalabilidade do sistema.
Eles permitem crescimento sem acoplamento, versionamento de domínio e evolução independente.

---

Para mais informações técnicas:

🔗 [https://nwidart.com/laravel-modules](https://nwidart.com/laravel-modules)

