<?php
session_start();
require "connection.php"
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adicionar Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class='container mt-5'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='card'>
          <div class='card-header'>
            <h4>Adicionar um Produto
              <a href="index.php" class='btn btn-danger float-end'>Voltar</a>
            </h4>
          </div>
          <div class='card-body'>
            <form action="acoes.php" method='POST' enctype="multipart/form-data">
              <div class='mb-3'>
                <label>Nome:</label>
                <input type="text" name='nome' class='form-control' required>
              </div>
              <div class='mb-3'>
                <label>Descrição:</label>
                <textarea name='descricao' class='form-control' rows="3"></textarea>
              </div>
              <div class='mb-3'>
                <label>Quantidade:</label>
                <input type="number" name='quantidade_estoque' class='form-control' required>
              </div>
              <div class='mb-3'>
                <label>Valor:</label>
                <input type="number" step="any" name='preco_unitario' class='form-control' required>
              </div>
              <div class='mb-3'>
                <label>Foto do Produto:</label>
                <input type="file" name='foto' class='form-control'>
              </div>
              <div class='mb-3'>
                <label>Categoria:</label>
                <select name='id_categoria' class='form-select' required>
                  <option value="">Selecione a Categoria</option>
                  <?php
                  $query_categoria = "SELECT * FROM categoria";
                  $lista_categorias = mysqli_query($conn, $query_categoria);
                  if (mysqli_num_rows($lista_categorias) > 0) {
                    foreach ($lista_categorias as $categoria) {
                  ?>
                      <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nome_categoria'] ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class='mb-3'>
                <label>Fornecedor:</label>
                <select name='id_fornecedor' class='form-select' required>
                  <option value="">Selecione o Fornecedor</option>
                  <?php
                  $query_fornecedor = "SELECT * FROM fornecedor";
                  $lista_fornecedores = mysqli_query($conn, $query_fornecedor);
                  if (mysqli_num_rows($lista_fornecedores) > 0) {
                    foreach ($lista_fornecedores as $fornecedor) {
                  ?>
                      <option value="<?= $fornecedor['id_fornecedor'] ?>"><?= $fornecedor['nome_fornecedor'] ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <input type="hidden" name="ativo" value="1">
              <button type='submit' name='create_produto' class='btn btn-primary'>Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>