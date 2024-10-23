# Engenharia de Software 2024.2 - Universidade Federal do Tocantins
 Bacharelado em Ciência da Computação, 4º semestre
 Professor: Edeilson Milhomem da Silva
 Grupo: Lauro, Vicente, Henrique, José Borges, André Victor

## Mundo Pet
### Descrição 
Protótipo de Tela:
![Tela de Inicial](./prototipos/index.png)

O Mundo Pet consiste em uma plataforma online para petshops, com funcionalidades de registro e acesso para clientes e administradores. O sistema oferece um catálogo abrangente de produtos e serviços, permitindo que os clientes agendem serviços e adicionem itens ao carrinho de compras. A plataforma também integra um sistema de pagamento online, garantindo uma experiência de compra prática e segura.

### Requisitos Funcionais do Projeto

1.  RF01 - Cadastro do Usuário
2.  RF02 - Login do Usuário 
3.  RF03 - Login de admin 
4.  RF04 - Catálogo Geral (serviços/produtos)
5.  RF05 - Catálogo de Produtos
6.  RF06 - Agendamento de Serviços
7.  RF07 - Checkout da compra do produto
8.  RF08 - Método de pagamento Online
9.  RF09 - Gerenciamento de agendamentos
10. RF10 - Gerenciamento de Produtos no catálogo
11. RF11 - Gerenciamento dos dados do usuário

### User Stories

**RF01 - Cadastro do Usuário** 
1. Como um cliente, quero poder criar uma conta no sistema para acessar os produtos e serviços oferecidos pelo petshop, registrando minhas informações pessoais, como nome, e-mail, telefone e endereço, para agilizar futuras compras e agendamentos. Para isso, na tela de login devo clicar em "Cadastre-se" logo abaixo do botão "Login". Ao clicar irá abrir o formulário de cadastro, no qual devo preencher todos os dados para concluir o cadastro.
 
 Protótipo de Tela:
 ![Tela de Login Usuário](./prototipos/cadastro.png)
 ![Tela de Cadastro]

 **RF02 - Login do Usuário e Administrador**
 1. Como um cliente cadastrado, quero poder acessar a plataforma utilizando meu e-mail e senha, para gerenciar minha conta e utilizar os serviços do petshop. Para isso, devo preencher os campos e-mail e senha com os dados cadastrados.
 2. Como um cliente cadastrado, desejo recuperar minha senha caso a esqueça, para garantir que possa acessar minha conta novamente. Para isso, devo clicar em "Esqueci minha senha" logo abaixo de "Cadastre-se", que abrirá uma página para recuperação de senha.
 3. Como um administrador, quero entrar no sistema usando minhas credenciais administrativas, para gerenciar o catálogo de produtos, serviços e usuários. Para isso, devo clicar em "Administrador" abaixo de "Esqueci minha senha" que irá alterar o login de usuário para administrador.
 
 Protótipo de Tela: 
 ![Tela de Login Usuário](./prototipos/login.png)
 ![Tela de Login]

**RF03 - Catálogo de Serviços/Produtos**
1. Como um cliente logado, quero poder visualizar o catálogo completo de produtos e serviços oferecidos pelo petshop, para que eu possa escolher o que desejo comprar ou agendar. Para isso, na tela principal, devo ter acesso a uma lista organizada com descrições, preços, e imagens dos produtos e serviços. 

2. Como um administrador, quero poder adicionar, editar ou remover produtos e serviços do catálogo, para que eu possa manter as informações atualizadas. Para isso, devo acessar a área de administração e utilizar as funcionalidades de gerenciamento do catálogo.

Protótipo de Tela:
 ![Tela de Login Usuário](./prototipos/serviços.png)
 ![Tela de Serviços]


**RF04 - Agendamento de Serviços**
1. Como um cliente Logado, quero poder agendar serviços do petshop que estão listados no catálogo, para isso, devo selecionar o serviço desejado, escolher uma data e horário disponíveis, e confirmar o agendamento

2. Como um administrador, quero gerenciar os agendamentos de serviços, para organizar a agenda do petshop. Para isso, devo acessar a área de adm e visualizar, editar ou cancelar agendamentos conforme necessário.

Protótipo de Tela:
 ![Tela de Login Usuário](./prototipos/Agendamento.png)
 ![Tela de Agendamento]

**RF05 - Carrinho de Compras**
1. Como um cliente logado, quero poder adicionar produtos ao carrinho de compras, para que eu possa revisar minhas escolhas antes de finalizar a compra. Para isso, devo clicar em "Adicionar ao carrinho" nos itens selecionados e acessar o carrinho para ver o resumo da minha compra. 

2. Como um cliente logado, quero poder remover itens do meu carrinho de compras, para que eu possa ajustar minha seleção antes de efetuar o pagamento. Para isso, devo acessar o carrinho, identificar o item que desejo remover e clicar em "Remover". 

3. Como um cliente logado, quero poder visualizar o total da minha compra, incluindo produtos e possíveis taxas, para que eu saiba o valor total antes de prosseguir para o pagamento. Para isso, ao acessar o carrinho, devo ver o valor total automaticamente calculado. 

Protótipo de Tela:
 ![Tela de Login Usuário](./prototipos/Carrinho.png)
 ![Tela de Carrinho]

**RF06 - Pagamento Online**
1. Como um cliente logado, quero poder finalizar a compra dos produtos no meu carrinho de forma segura, utilizando diferentes métodos de pagamento online, como cartão de crédito, débito ou outras opções disponíveis, para que eu possa concluir a transação com facilidade. Para isso, após revisar o carrinho, devo clicar em "Finalizar compra" e ser redirecionado para a página de pagamento que tem aprovação em tempo real. 

2. Como um administrador, quero poder visualizar um relatório de todas as transações realizadas na plataforma, para que eu possa monitorar as vendas. Para isso, devo acessar a área de administração e ter a opção de gerar relatórios filtrados por data, método de pagamento, ou cliente. 

Protótipo de Tela:
![Tela de Login Usuário](./prototipos/Pagamento.png)
![Tela de Pagamento]

### Iteração 1 - Catálogos
*Valor da Sprint*: Permitir que o administrador gerencie os produtos que serão oferecidos no catálogo do petshop, adicionando, removendo ou editando, além de permitir que o usuário acesse o catálogo de produtos.

*Objetivo*: Como administrador, quero fazer login no sistema do petshop para gerenciar o catálogo geral.
Como usuário, quero poder visualizar os produtos disponíveis no catálogo, com opção de pesquisa e filtros por categoria.

*Requisitos*:

RF03 - Login de Admin
RF05 - Catálogo de Produtos     
RF10 - Gerenciamento de Produtos 

[Link para o Relatório](Relatorio.md)

### Iteração 2: Login e agendamento do usuário.

*Valor da Sprint:* Permitir o usuário fazer login agendar algum serviço do petshop, visando maior rentabilidade para o petshop e a satisfação do cliente

*Objetivo*: Como usuário quero poder fazr login e agendar serviços do petshop.

*Requisitos*:

RF06 - Agendamento de Serviços

*Features:*
1. Login e Cadastro de usuário
2. Permitir o usuário ler, atualizar e deletar seus agendamento
3. Implementar as telas de cada serviço para agendamento
4. Implementar a tela de seleção de datas e horários

*Objetivo*: Como admin quero gerenciar os agendamentos de todos os usuários

*Requisitos*: 

RF09 - Gerenciamento de agendamentos

*Features:*
1. Permitir o admin visualizar todos os agendamentos e editar ou cancelar agendamentos de um usuário específico

[Link para o Relatório](Relatorio.md)

### Iteração 3: Gerencimento do carrinho de compras 

*Valor da Sprint*: Proporcionar aos usuários a capacidade de adicionar, remover e visualizar produtos em um carrinho de compras, facilitando o processo de compra e aumentando a satisfação do cliente.

*Objetivo*: Como usuário, quero poder gerenciar meus itens em um carrinho de compras para facilitar a finalização da compra de produtos do pet shop.

*Requisitos*:

RF05 - Carrinho de Compras

*Features:*

1. Permitir ao usuário adicionar produtos ao carrinho de compras a partir do catálogo.
2. Permitir ao usuário visualizar os itens em seu carrinho de compras com detalhes.
3. Permitir ao usuário atualizar a quantidade de produtos no carrinho.
4. Permitir ao usuário remover produtos do carrinho de compras.
5. Implementar uma funcionalidade de checkout para finalizar a compra dos produtos.

### Iteração 4: Gerenciamento de Usuários

**Valor da Sprint:** Permitir que os usuários atualizem suas informações pessoais e gerenciem suas consultas marcadas, garantindo que os dados estejam corretos e melhorando a experiência do cliente.

*Objetivo*
Como usuário, quero poder atualizar minhas informações pessoais e gerenciar minhas consultas marcadas para garantir que minha conta e agendamentos estejam sempre atualizados.

*Requisitos*

- RF11 - Gerenciamento dos dados do usuário.

*Features*

1. Tela de Atualização de Dados: Criar uma tela onde os usuários podem facilmente editar suas informações pessoais, como nome, e-mail e telefone.

2. Visualização de Informações: Implementar uma funcionalidade que permita aos usuários visualizar suas informações antes de confirmar qualquer alteração.

3. Gerenciar Consultas Marcadas: Criar uma área onde os usuários possam visualizar suas consultas marcadas, com opções para cancelar ou solicitar mudanças.

4. Permitir o usuário cancelar um agendamento dentro da area de gerenciamento de consultas marcadas

5. Notificações por E-mail: Enviar um e-mail de confirmação aos usuários após qualquer atualização em suas informações ou consultas.


