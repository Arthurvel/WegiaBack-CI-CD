# 🗃️ Upload Seguro de Arquivos

A API utiliza o `UploadSeguroHelper`, que fornece métodos estáticos para manipulação segura de arquivos:

* salvarImagem()
* urlTemporaria()
* excluirImagem()

## 💾 Salvando arquivos

Para salvar um arquivo:

1. Informe o arquivo e a pasta destino.
2. O nome do arquivo é criptografado com SHA-256 e o conteúdo é criptografado com Laravel Crypt (AES-256-CBC, usando a chave APP_KEY do .env).
3. A estrutura final do caminho é:
    ```text
    uploads/{ano}/{pasta}/{arquivo_criptografado}
    ```

4. O arquivo é armazenado no disco seguro `local_secure`.

## 👀 Visualização segura

Para acessar arquivos de forma segura, geramos URLs temporárias:

* A URL expira após 10 minutos (configurável).
* O acesso é protegido mesmo que o link seja compartilhado.
* Adicione ele nas `Resource` para devolver corretamente a url pro usuário.

## 🚀 Utilização na prática

Nesse exemplo, iremos cadastrar um arquivo, utilizando a pasta **pessoa** como referência.

```php
public function cadastrarArquivo(PessoaArquivoComFileCadastrarDTO $dto)
{
    return DB::Transaction(function () use ($dto) {

        $url = UploadSeguroHelper::salvarImagem($dto->arquivo, 'pessoa');

        $fotoCadastrarDto = PessoaArquivoCadastrarDTO::fromArray([
            'arquivo'                => $url,
            'nome_arquivo'           => $dto->arquivo->getClientOriginalName(),
            'extensao_arquivo'       => $dto->arquivo->extension(),
            'id_pessoa_tipo_arquivo' => $dto->id_pessoa_tipo_arquivo,
            'id_pessoa'              => $dto->id_pessoa
        ]);

        return $this->repository->criar($fotoCadastrarDto);
    });
}
```
