create database estoque_alpha_suplementos;
use estoque_alpha_suplementos;

create table usuario(
id_usuario int not null auto_increment primary key,
usuario varchar(100) not null unique,
senha varchar(255) 
);
create table categoria(
id_categoria int not null auto_increment primary key,
nome_categoria varchar(50) not null unique
);

create table fornecedor(
id_fornecedor int not null auto_increment primary key,
nome_fornecedor varchar(100) not null,
telefone varchar(20),
email varchar(100) unique
);
 create table produto(
 id_produto int not null auto_increment primary key,
 nome varchar(100) not null,
 descricao text,
 quantidade_estoque int not null default 0,
 preco_unitario decimal(10,2) not null,
 url_foto varchar(255),
 ativo boolean not null default true,
 id_categoria int not null,
 id_fornecedor int not null,
 foreign key (id_categoria) references categoria(id_categoria),
 foreign key (id_fornecedor) references fornecedor(id_fornecedor)
 );
 
 alter table usuario add column token varchar(255);
select * from usuario;
 
 select * from produto;
 insert into produto(nome,descricao, quantidade_estoque, preco_unitario, url_foto, id_categoria,id_fornecedor) values("Whey Protein", "Whey protein Growth fornece proteínas para quem deseja hipertrofia e definição muscular, e ele é totalmente sem blends ou adição de outras proteínas.Ideal porque é um suplemento de alto valor biológico com grande concentração de proteínas e aminoácidos essenciais é também rico em Glutamina, BCAA (incluindo Leucina).", 40, 124.90, "C:\xampp\htdocs\gerenciador-de-estoque\uploads\produtos\whey-protein", 1, 1);
 update produto set ativo = 1 where id_produto = 1;
 
 delete from usuario where id_usuario = 1;
insert into usuario(usuario,senha, token) values("admin", "$2y$10$e6e8It5e0ykxZ4TSf0mUJO7mHCHZf2arKoZ73sN.1qFnlkZJCB93C", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30");
select * from usuario;
  
insert into categoria(nome_categoria) values("Proteína");
update categoria set nome_categoria = "Proteína" where id_categoria = 1;
select * from categoria;
insert into categoria(nome_categoria) values("Aminoácidos");
insert into categoria(nome_categoria) values("Acessórios");
insert into categoria(nome_categoria) values("Carboidratos");
insert into categoria(nome_categoria) values("Vitaminas");
insert into categoria(nome_categoria) values("Snacks");

select * from fornecedor;
insert into fornecedor(nome_fornecedor,telefone,email) values("Pico Performance", "1147888888", "piperformance@gmail.com");
insert into fornecedor(nome_fornecedor,telefone,email) values("Impulso Atleta", "1147252525", "impulso10atleta@gmail.com");
insert into fornecedor(nome_fornecedor,telefone,email) values("Carga Total", "1147333333", "carga123total@gmail.com");
insert into fornecedor(nome_fornecedor,telefone,email) values("Nexus Suplementos", "1125878787", "nexusnexus@gmail.com");
insert into fornecedor(nome_fornecedor,telefone,email) values("Optima Care", "11985456545", "careoptima@gmail.com");
insert into fornecedor(nome_fornecedor,telefone,email) values("Grão de Ouro", "11936882222", "graoouro@gmail.com");