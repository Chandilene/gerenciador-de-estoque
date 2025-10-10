
🏋️‍♀️ **Gerenciador de Estoque para Loja de Suplementos (CRUD)**
======================================================================

💡*Sobre o Projeto*
-----------------------

Este projeto consiste no desenvolvimento de um sistema CRUD (Create, Read, Update, Delete) focado no gerenciamento de estoque para uma loja de suplementos e artigos de academia. O objetivo principal é demonstrar o domínio de operações básicas de manipulação de dados, estrutura do banco de dados e a integração entre frontend e backend.

O sistema permite o gerenciamento completo das três principais entidades: Produtos, suas Categorias e Fornecedores.

⚙️ *Tecnologias Utilizadas*
-------------------------------


| Tipo | Tecnologia | Uso Principal |
| :--- | :--- | :--- |
| **Backend** | PHP | Lógica de negócio e manipulação do banco de dados. |
| **Frontend** | HTML, CSS | Estrutura e estilo da interface do usuário. |
| **Framework** | Bootstrap | Design responsivo e componentes prontos. |
| **Banco de Dados** | MySQL | Armazenamento persistente dos dados do sistema. |
| **Diagramação** | Draw.io | Criação do Diagrama Entidade-Relacionamento (MER). |


📦 *Estrutura do Banco de Dados*
---------------------------------------

O banco de dados foi modelado para armazenar e relacionar as entidades centrais do sistema, garantindo a integridade e organização das informações.

1. *Entidades de Gerenciamento Central*

| Tabela | Função | Chave Primária (PK) | Chaves Estrangeiras (FK) |
| :--- | :--- | :--- | :--- |
| **CATEGORIAS** | Agrupa produtos (ex: Proteínas, Creatinas). | `id_categoria` | Nenhuma |
| **FORNECEDORES** | Armazena dados de quem fornece os produtos. | `id_fornecedor` | Nenhuma |
| **PRODUTOS** | Armazena as informações do estoque. | `id_produto` | `id_categoria`, `id_fornecedor` |

2. *Entidade de Acesso e Segurança (Login)*

Para controle de acesso ao sistema, foi implementada a entidade LOGIN.

Implementação Inicial: Em um primeiro momento, a tabela LOGIN será utilizada para armazenar um usuário e senha fixos (setados previamente) que permitirão o acesso à área administrativa do sistema de estoque.

Melhoria Futura: A próxima etapa de desenvolvimento será a criação de um módulo de Cadastro completo para permitir que múltiplos usuários gerenciem o sistema.

📐 *Modelagem de Dados (Diagrama Conceitual - MER)*
---------------------------------------------------------
O Diagrama Entidade-Relacionamento (MER) descreve o conceito e as regras de negócio que fundamentam a estrutura do banco de dados.

1. Entidades e Atributos Principais

| Entidade | Atributos Principais | Regras de Negócio |
| :--- | :--- | :--- |
| **PRODUTOS** | `nome`, `quantidade_estoque` (INT), `preco_unitario` (DECIMAL), `url_foto`, `ativo` | **Campo Derivado:** O valor total do estoque (`quantidade * preço`) é calculado pela aplicação (não armazenado). |
| **CATEGORIAS** | `nome_categoria` | O nome da categoria deve ser único. |
| **FORNECEDORES** | `nome_fornecedor`, `telefone`, `email` | - |

2. Relacionamentos e Cardinalidade

Os relacionamentos definem como as entidades se conectam, usando a notação **(Mínimo, Máximo)**.

#### Produto ↔ Categoria (Relacionamento 1:N)

* **Lado do Produto (1):** **(1, 1)**
    * ***Significado:*** Todo **Produto** DEVE estar associado a **UMA** e apenas **UMA Categoria** (Obrigatório).

* **Lado da Categoria (N):** **(0, N)**
    * ***Significado:*** Uma **Categoria** pode ter **MUITOS Produtos** (N), mas também pode ter **NENHUM** (0) (*Opcional, permite cadastrar a Categoria antes do primeiro produto*).

#### Produto ↔ Fornecedor (Relacionamento 1:N)

* **Lado do Produto (1):** **(1, 1)**
    * ***Significado:*** Todo **Produto** DEVE ser fornecido por **UM** e apenas **UM Fornecedor** (Obrigatório).

* **Lado do Fornecedor (N):** **(0, N)**
    * ***Significado:*** Um **Fornecedor** pode fornecer **MUITOS Produtos** (N), mas pode ter **NENHUM** produto cadastrado inicialmente (0).

🛠️ *Como Executar o Projeto*
-------------------------------------
Adicione aqui as instruções específicas: (Ex: "Clone o repositório, importe o script SQL, configure as credenciais do DB no arquivo conexao.php e execute em um servidor local como XAMPP ou WAMP.")
