# Desenvolvimento

Esta seção fornece informações essenciais sobre como desenvolver novas funcionalidades na api, incluindo autenticação, perfil de usuário, estrutura de respostas e outras funcionalidades.

## Autenticação

Para gerarmos autenticação numa rota da nossa api, precisamos disponibilizar o seguinte trecho de código no nosso constructor do controller:

```php
$this->middleware(['auth:sanctum'])->except(['login']);
```

Esse trecho de código diz que todos os metodos daquela classe precisam receber a autenticação no cabeçalho da requisicao, exceto os metodos que tiverem escritos dentro do parentes, nesse caso, seria o login.

Entretanto, tem diversas outras classificações possiveis, para saber mais basta [clicar aqui](https://laravel.com/docs/12.x/sanctum)

Ainda possuimos uma forma mais completa de validar uma rota, por meio das `ability` do sanctum, nela é dito qual permissão é necessário para utilizar determinado endpoint. Para isso bastar colocar o seguinte comando:

```php
$this->middleware(['auth:sanctum', 'ability:atualizar-pet'])->only(['atualizar'])
```

Para um usuário possuir tal permissionamento, é preciso que seu perfil seja vinculado a um permissionamento e na hora de que for gerado seu token, ele identificara tal habilidade.

Na prática temos as seguitens tabelas que se comunicam:
