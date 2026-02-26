# Guia de Instalação

Este guia descreve o processo para configurar e executar o ambiente de desenvolvimento da API Wegia utilizando Docker.

## Pré-requisitos

Antes de começar, garanta que você tenha as seguintes ferramentas instaladas em sua máquina:

*   [Git](https://git-scm.com/)
*   [Docker](https://www.docker.com/get-started)
*   [Docker Compose](https://docs.docker.com/compose/install/)

## Passo a Passo

### 1. Clonar o Repositório

Primeiro, clone o repositório do projeto para a sua máquina local:

```bash
git clone https://github.com/LabRedesCefetRJ/WeGIA-back.git
cd WeGIA-back
```

---

### 2. Configurar o Ambiente

O projeto utiliza um arquivo `.env` para configurar as variáveis de ambiente. Copie o arquivo de exemplo `.env.example` para criar o seu próprio.

```bash
# Navegue até o diretório da aplicação Laravel
cd api/wegia

# Copie o arquivo de exemplo
cp .env.example .env
```

Após copiar, abra o arquivo `.env` e configure as variáveis, especialmente as relacionadas à conexão com o banco de dados (`DB_*`), se necessário.

**Observação:** os valores padrão já funcionam com o `docker-compose.yml` fornecido, entretanto, caso queira algumas funcionalidades dos extras como envio de email e pagamento, é necessário preencher seu valor no .env.

---

### 3. Build e Execução dos Containers

Com o Docker e o Docker Compose instalados, suba os containers em modo "detached" (`-d`). O comando `--build` garante que as imagens Docker serão construídas a partir dos Dockerfiles.

```bash
# A partir do diretório raiz do projeto (WeGIA-back/)
docker-compose up -d --build
```

Este comando irá:

* Construir a imagem do container da API (api)
* Baixar a imagem do MariaDB (db)
* Criar e conectar os containers à rede wegia-network

**Dica:** Para ver logs em tempo real:
```bash
docker-compose logs -f
```

Este comando irá baixar as imagens necessárias (PHP, Nginx, MariaDB) e construir os containers para a aplicação.

---

### 4. Instalar Dependências do Composer (Opcional)

O composer é instalado automaticamente no entrypoint, mas caso queira instalar ou atualizar manualmente:

```bash
docker-compose exec api composer install --optimize-autoloader
```

---

### 5. Gerar a Chave da Aplicação

O Laravel requer uma chave de aplicação única, que pode ser gerada com o seguinte comando Artisan:

```bash
docker-compose exec app php artisan key:generate
```

Essa chave é usada em configurações internas do Laravel, incluindo criptografia e upload de arquivos. É necessário que seja guardada corretamente para que não perca acesso a esses dados.

Ela é referenciada dentro do .env como `APP_KEY`.

---

### 6. Executar as Migrations

O entrypoint do container já realiza as migrations automaticamente. Se precisar executar novamente manualmente:

```bash
docker-compose exec app php artisan migrate
```

---

### 7. Executar as Seeders

O entrypoint do container já realiza as seeds automaticamente. Toda inserção de dados necessária no banco é feita por dois comandos.

Seeders padrões:

```bash
docker-compose exec app php artisan db:seed
```

Seeders dos módulos:

```bash
docker-compose exec app php artisan module:seed --class=DatabaseSeeder --all
```

Cada Seeder é executada apenas uma vez para que não ocorra duplicação de dados

---

### 8. Acessar a Aplicação

Pronto! A API deve estar em execução e acessível em `http://localhost:8000` (ou na porta que você configurou no `docker-compose.yml`).

Para verificar se tudo está funcionando, você pode acessar um endpoint público ou a documentação da API.

---

### 9. Estrutura de Volumes e Permissões

O entrypoint já cria os diretórios de armazenamento e backups com permissões corretas:

```text
/var/www/html/storage/app/private
/var/www/html/storage/app/backups
```

Eles são persistidos no volume Docker db_data para o banco de dados e no diretório local ./db para dados inicias.

---

### 10. Parar os Containers

Para parar os containers sem removê-los:

```bash
docker-compose down
```

Para parar e remover volumes, redes e containers (limpeza completa):

```bash
docker-compose down -v
```

