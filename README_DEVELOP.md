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


## 🏗️ Estrutura do Projeto

O projeto segue uma estrutura modular, organizada da seguinte forma:

* **Model**: Representa as entidades do banco de dados.

* **Controller**: Lida com as requisições HTTP e respostas.

* **Service**: Contém a lógica de negócio e regras de aplicação.

* **Repository**: Responsável pela comunicação com o banco de dados.

# Documentação

- [Laravel](https://laravel.com/)
- [Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki/Examples)