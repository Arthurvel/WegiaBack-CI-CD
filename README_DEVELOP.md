# 🎉 Bem-vindo ao README para Desenvolvedores

Este README oferece uma visão geral das tecnologias utilizadas, como rodar o projeto localmente e explicações técnicas detalhadas sobre a estrutura do projeto.

## 🛠️ Tecnologias utilizadas

* Laravel 12
* Nginx
* Swagger Documentation

## 🚀 Como rodar o projeto

Antes de rodarmos o [docker-compose.yml](./docker-compose.yml) é necessário configurar o `.env`. Caso ainda não tenha sido criado, basta criar o arquivo dentro da pasta wegia.

Após criado, copie tudo de dentro de **.env.example** para o **.env** e altere os seguintes valores:

```
DB_CONNECTION=mariadb
DB_HOST=db
DB_PORT=3306
DB_DATABASE=wegia
DB_USERNAME=wegiauser
DB_PASSWORD=senha
```

Agora, dentro do terminal execute os seguintes comandos:

``` bash
docker compose build
docker compose up
```

Apos isso, o projeto estara rodando na porta [8000](http://localhost:8000).

### 🔧 O que acontece ao rodar o projeto:

1. **Dockerfile**
    - Instala as dependências necessárias do ambiente.
    - Adiciona o arquivo o **script de entrada** [(custom-entrypoint.sh)](./wegia/config/custom-entrypoint.sh) no projeto.
    - Chama o script `custom-entrypoint.sh` para iniciar a aplicação de forma apropriada.
    - Adiciona as extensões do php no docker.
    
2. **Custom-entrypoint**
    - Gera a documentação do swagger.
    - Instala o otimizador do autoload.
    - inicia o php-fpm.

## 🗄️ Banco de dados

Ao iniciar o projeto via docker, o banco de dados será configurado automaticamente utilizando os scripts presentes na pasta [db](./db/).

As configurações do banco de dados são definidas por variáveis de ambiente dentro do serviço correspondente no arquivo `docker-compose.yml`:

``` docker-compose.yml
db:
    environment:
        MARIADB_ROOT_PASSWORD: secret
        MYSQL_DATABASE: wegia
        MYSQL_USER: wegiauser
        MYSQL_PASSWORD: senha  

```

## 🔐 Configuração de Hash de Senha

No projeto, utilizamos uma configuração de hash diferente da convencional do Laravel. Em vez de usar os algoritmos padrão (como `bcrypt` ou `argon`), configuramos o sistema para usar **SHA-256** como algoritmo de hash. Isso foi feito para garantir compatibilidade com o sistema.

Abaixo estão os arquivos e configurações necessárias para que isso funcione corretamente:

### **1️⃣ Arquivos configurados**
 
**🟢** [**Sha256HashProvider**](./api/wegia/app/Providers/Sha256HashProvider.php) 

* **Função:** Registra o driver de hash `sha256` no Laravel
    
* **O que ele faz?**    
    ✅ Registra `sha256` como um driver válido de hashing.    
    ✅ Define o `sha256` como padrão no sistema.

**🟢** [**Sha256Hasher**](./api/wegia/app/Hashing/Sha256Hasher.php)

* **Função**: Implementa a lógica do driver `sha256.`

* **O que ele faz?**    
    ✅ Gera hashes com **SHA-256**.    
    ✅ Valida se um hash corresponde a uma determinada string.    
    ✅ Retorna false para a necessidade de rehash (pois SHA-256 não suporta rehash).    

**🟢** [**hashing.php**](./api/wegia/config/hashing.php)

* **Função**: Define a configuração do sistema de hashing.

* **O que ele faz?**    
    ✅ Define `sha256` como driver padrão.     


### **⚙️ Como Funciona?**

Quando o sistema precisa gerar ou verificar um hash (por exemplo, ao criar ou autenticar um usuário), ele segue estas etapas:

1️⃣ O Laravel verifica o driver de hash configurado no arquivo [config/hashing.php](./api/wegia/config/hashing.php).    
2️⃣ Se o driver for `sha256`, o Laravel usa a classe `Sha256Hasher` para gerar ou verificar o hash.    
3️⃣ O hash é gerado usando o algoritmo **SHA-256**, e o resultado é armazenado no banco de dados.

### **🔧 Configuração no .env**

O driver de hash padrão pode ser sobrescrito no arquivo `.env`. Para isso, basta definir a variável `**HASH_DRIVER**`:

**➤ Altere o valor de HASH_DRIVER no .env para sha256:**

```
HASH_DRIVER=sha256
```

💡 O Laravel aplicará automaticamente esse algoritmo para novas senhas e verificações.

##  🔐 Configuração do Token Bearer

Este projeto utiliza a biblioteca **Sanctum** para gerar tokens personalizados de autenticação. Abaixo, explicamos como configurar e utilizar o sistema de geração de tokens, além de apresentar soluções para erros comuns.

### ⚙️ Arquivo de Configuração 

A configuração do Sanctum pode ser encontrada no arquivo [sanctum.php](./api/wegia/config/sanctum.php). Aqui, você pode ajustar as configurações padrão de como os tokens são gerados e gerenciados.

### 🎫 Geração de Tokens 

A função responsável pela geração de tokens está localizada no arquivo [authService.php](./api/wegia/config/sanctum.php). Nela, definimos o tempo de duração do token (por padrão, 1 hora) e retornamos um array formatado com as seguintes informações:

* **Token**: O token gerado.
* **Tipo**: O tipo de autenticação (Bearer).
* **Expiração**: O tempo de validade do token.

### ⚠️ Possiveis erros

**1. ⏰ Tempo de Expiracao Incorreto**

Se o tempo de expiração não estiver funcionando corretamente, é possível que o problema esteja relacionado ao fuso horário configurado no arquivo [app.php](./api/wegia/config/app.php).

**Solução**: Ajuste o parâmetro `timezone` para a sua região. Para o Brasil, a configuração correta é:

```php
'timezone' => 'America/Sao_Paulo',
```

**2. 🛑 Tabela de Tokens Não Encontrada**

O **Sanctum** utiliza uma tabela própria para armazenar os tokens gerados. Se você estiver recebendo um erro indicando que a tabela não foi encontrada, provavelmente você ainda não executou as migrations necessárias para criar a tabela.

**Solução**: Execute o seguinte comando no terminal para rodar as migrations:

```bash
php artisan migrate
```

Isso criará a tabela personal_access_tokens necessária para o armazenamento dos tokens.

## 🏗️ Estrutura do Projeto

O projeto segue uma estrutura modular, organizada da seguinte forma:

* **Model**: Representa as entidades do banco de dados.

* **Controller**: Lida com as requisições HTTP e respostas.

* **Service**: Contém a lógica de negócio e regras de aplicação.

* **Repository**: Responsável pela comunicação com o banco de dados.

## Documentação

- [Laravel](https://laravel.com/)
- [Hash Laravel](https://laravel.com/docs/12.x/hashing)
- [Sanctum](https://laravel.com/docs/11.x/sanctum#issuing-api-tokens)
- [Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki/Examples)                                                                                                                                                                                                                                                                                  