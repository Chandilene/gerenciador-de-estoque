📚 Gerenciador de Estoque para Loja de Suplementos (CRUD)
Este projeto consiste em um sistema CRUD (Create, Read, Update, Delete) simples para gerenciar o estoque de produtos em uma loja de suplementos e itens de academia. O foco principal é na estrutura de dados e nas operações básicas de manipulação.

1. Visão Geral do Banco de Dados
O banco de dados foi modelado para armazenar e relacionar as três principais entidades do sistema: Produtos, suas Categorias e seus Fornecedores.

1.1. Estrutura de Tabelas (Modelo Lógico)
Tabela	Função	Chave Primária (PK)	Chaves Estrangeiras (FK)
CATEGORIAS	Agrupa produtos (ex: Proteínas, Creatinas).	id_categoria	Nenhuma
FORNECEDORES	Armazena dados de quem fornece os produtos.	id_fornecedor	Nenhuma
PRODUTOS	Armazena as informações do estoque.	id_produto	id_categoria, id_fornecedor


2. Diagrama Conceitual (MER)
O Diagrama Entidade-Relacionamento (MER) descreve o conceito e as regras de negócio do banco de dados.

2.1. Entidades e Atributos Principais
Entidade	Atributos Principais	Regras de Negócio
PRODUTOS	nome, quantidade_estoque (INT), preco_unitario (DECIMAL), url_foto, ativo	Campo Derivado: O valor total do estoque (quantidade * preço) será calculado pela aplicação.
CATEGORIAS	nome_categoria	Nome deve ser único.
FORNECEDORES	nome_fornecedor, telefone, email	


2.2. Relacionamentos e Cardinalidade
Os relacionamentos definem como as entidades se conectam, usando a notação (Mínimo, Máximo).

Produto ↔ Categoria (Relacionamento 1:N)
Lado do Produto (1): (1, 1)

Significado: Todo Produto DEVE estar associado a UMA e apenas UMA Categoria (Obrigatório).

Lado da Categoria (N): (0, N)

Significado: Uma Categoria pode ter MUITOS Produtos (N), mas também pode ter NENHUM (0) (Opcional, permite cadastrar a Categoria antes do primeiro produto).

Produto ↔ Fornecedor (Relacionamento 1:N)
Lado do Produto (1): (1, 1)

Significado: Todo Produto DEVE ser fornecido por UM e apenas UM Fornecedor (Obrigatório).

Lado do Fornecedor (N): (0, N)

Significado: Um Fornecedor pode fornecer MUITOS Produtos (N), mas pode ter NENHUM produto cadastrado inicialmente (0).