
## Projeto API Carrinho de Compras (Case fictício)

Neste projeto, foi utilizado:

- Laravel 9
- MySQL
- Redis
- Fila
- Cache
- Docker (Laravel Sail)
- Repository Pattern
- Camada Service
- Testes Unitários

## Objetivo

O objetivo deste mini projeto é:
- Cadastrar/excluir um cartão de crédito, fazendo validações na hora da criação;
- Adicionar um carrinho de compras em cache para ser utilizado futuramente na transação;
- Realizar uma transação, criando método de soma dos (produtos * quantidade);
- Criar endpoints para a consulta de transações e transações feitas por um usuário específico;
- Após o término de uma transação, o cache do carrinho de compras deverá ser limpo;
- Após o término de uma transação, diminuir a quantidade disponível do produto. A ação deverá ser processada em uma fila;

## Regras

Cartão de crédito:
- Somente deverão ser aceitos as bandeiras: VISA, Mastercard e Diners;
- O cartão deve ter 16 dígitos, se for VISA ou Mastercard e 14 dígitos para cartões Diners;
- O código de segurança do cartão deve ter 3 dígitos;
- A data de validade de um cartão deve ser maior que a data atual;

Carrinho de compras:
- Adicionar a consulta em cache;
- Cada produto deverá apenas retornar na consulta, somente se a quantidade for maior ou igual a 1(um);

Transação:
- Para a criação de uma nova transação deverá obter da soma total dos produtos do carrinho de compras (cache do carrinho de compras);
- Após o término de uma transação, o cache do carrinho de compras deverá ser limpo;
- Após o término de uma transação, diminuir a quantidade disponível do produto. A ação deverá ser processada em uma fila;
