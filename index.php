<?php
require 'config_sessao.php';
require 'verificacao_seguranca_login.php';
require "connection.php"
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque ALPHA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <?php include('navbar.php'); ?>
    <main class='container mt-4 ' >
        <?php include('mensagem.php'); ?>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card '>
                    <div class='card-header'>
                        <h4>Listas de Produtos
                            <a href='produto-create.php' class='btn btn-primary float-end'><span class="bi bi-plus-circle"></span>&nbsp; Adicionar</a>
                        </h4>
                    </div>
                    <div class='card-body'>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr class='linha'>
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
                                        <tr class='linha'>
                                            <td><?= $produto['id_produto'] ?></td>
                                            <td><?= $produto['nome'] ?></td>
                                            <td><?= $produto['quantidade_estoque'] ?></td>
                                            <td>R$ <?= number_format($produto['preco_unitario'], 2, ',', '.') ?></td>
                                            <td>
                                                <?php
                                                $status_ativo = $produto['ativo'];

                                                if ($status_ativo == 1) {
                                                    $classe_bootstrap = 'badge bg-success';
                                                    $texto_status = 'Disponível';
                                                } else {
                                                    $classe_bootstrap = 'badge bg-danger';
                                                    $texto_status = 'Indisponível';
                                                }
                                                ?>
                                                <span class="<?= $classe_bootstrap ?>"><?= $texto_status ?></span>
                                            </td>
                                            <td>
                                                <a href="detalhes_produto.php?id=<?= $produto['id_produto'] ?>" class='btn btn-secondary btn-sm'> <span class="bi bi-eye"></span>&nbsp; Visualizar</a>
                                                <a href="editar.php?id=<?= $produto['id_produto'] ?>" class='btn btn-success btn-sm'> <span class="bi bi-pencil"></span>&nbsp; Editar</a>


                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal"
                                                    data-produto-id="<?= $produto['id_produto'] ?>"
                                                    data-produto-nome="<?= htmlspecialchars($produto['nome']) ?>">
                                                    <span class="bi bi-trash3"></span>&nbsp;
                                                    Excluir
                                                </button>

                                                <form id="form-excluir-<?= $produto['id_produto'] ?>" action="acoes.php" method="POST" class="d-none">
                                                    <input type="hidden" name="delete_produto" value="<?= $produto['id_produto'] ?>">
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
    </main>
    </div> <?php include 'modal_confirmacao.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="js/acoes.js"></script>
</body>

</html>