<?php
session_start();
require "connection.php"
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque ALPHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class='container mt-4'>
        <?php include('mensagem.php'); ?>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='card-header'>
                        <h4>Listas de Produtos - Suplementos
                            <a href='produto-create.php' class='btn btn-primary float-end'>Adicionar Produto</a>
                        </h4>
                    </div>
                    <div class='card-body'>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = 'SELECT * FROM produto';
                                $lista_produtos = mysqli_query($conn, $query);
                                if (mysqli_num_rows($lista_produtos) > 0) {
                                    foreach ($lista_produtos as $produto) {

                                ?>
                                        <tr>
                                            <td><?= $produto['id_produto'] ?></td>
                                            <td><?= $produto['nome'] ?></td>
                                            <td><?= $produto['quantidade_estoque'] ?></td>
                                            <td><?= $produto['preco_unitario'] ?></td>
                                            <td><?= $produto['ativo'] ?></td>
                                            <td>
                                                <a href="" class='btn btn-secondary btn-sm'>Visualizar</a>
                                                <a href="" class='btn btn-success btn-sm'>Editar</a>
                                                <form action="" method='POST' class='d-inline'>
                                                    <button type='submit' name='delete_produto' value='1' class='btn btn-danger btn-sm'>
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<h5>Nenhum produto encontrado</h5>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>