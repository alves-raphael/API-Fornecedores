# API Teste Convenia
Todos os envios de dados são por meio de form data ou query string

## Cadastro de usuário
Para cadastrar um usuário, é necessário enviar uma requisição **POST** para /api/user da seguinte maneira
```
curl -X POST -H "Accept: application/json"
-F "name=nobody" -F "password=secret",
-F "email=nobody@email.com" -F "address=Rua São Tomé"
-F "cep=03676011" -F "phone=11948384051"
-F "cnpj=15803436000196"
/api/user
```

Em caso de sucesso, será retornado um JSON com o status "Created" e um "api_token", esse token será sua chave de acesso da API

```JSON
{
    "status": "Created",
    "api_token": "6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA"
}
```
Em caso de erro de validação, será retornado uma mensagem semelhante a seguinte
```JSON
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email must be a valid email address."
        ]
    }
}
```
## Cadastro de fornecedor
Com o api token em mãos, cadastrar um novo fornecedor é feito da seguinte forma
```
curl -X POST -H "Accept: application/json"
-F "name=Super provider"
-F "email=provider@email.com"
-F "monthly_payment=500.00"
-F "api_token=6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA"
/api/provider
```
Em caso de sucesso, será recebido uma mensagem semelhante a
```JSON
{
    "status": "Created"
}
```

## Consulta de fornecedor
A consulta de fornecedor é feito da seguinte maneira
```
curl -X GET -H "Accept: application/json"
/api/providers?api_token=6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA
```
O resultado é semelhente ao exibido abaixo
```JSON
[
    {
        "id": 3,
        "name": "joseph",
        "email": "provider@email.com",
        "monthly_payment": "500.00",
        "user_id": 4,
        "created_at": "2019-06-29 23:25:52",
        "updated_at": "2019-06-30 01:11:27"
    },
    {
        "id": 4,
        "name": "ultra provider",
        "email": "ultraprovider@email.com",
        "monthly_payment": "800.00",
        "user_id": 4,
        "created_at": "2019-07-01 14:08:02",
        "updated_at": "2019-07-01 14:08:02"
    }
]
```

## Deletar fornecedor
Deletar um fornecedor é necessário passar o token e o id do forncedor que deseja excluir, tudo em query string, da seguinte maneira:
```
curl -X DELETE -H "Accept: application/json"
/api/provider?api_token=6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA&id=1
```
## Atualizar fornecedor
Para atualizar o fornecedor, é necessário passar o token e o campo que deseja editar com seu respectivo valor, logo em seguida.
Tudo isso em query string, como feito na hora deletar.
No exemplo abaixo, eu editei apenas o nome, mas é possível eidtar vários campos de uma vez só.
```
curl -X PUT -H "Accept: application/json"
/api/provider?api_token=6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA&name=MegaProvider
```
## Soma da mensalidade de todos os fornecedores
Caso queira saber a soma da mensalidade de todos os seu fornecedores, basta fazer da seguinte forma

```
curl -X GET -H "Accept: application/json"
/api/payment/total?api_token=6MFuCRQBCkd7GR9GXIs9eq0gSwVQ4ha4hQjZjJd4E3jM56JrbAysIChYPxwA
```
Resultado semelhante a
```JSON
[
    1300
]
```
