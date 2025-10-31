<?php
require 'config_sessao.php';
require 'verificacao_seguranca_login.php';
require "connection.php";

// -----------------------------------------------------------
// 1. Inicialização e Busca de Produto
// -----------------------------------------------------------

$produto_id = $_GET['id'] ?? null;
$produto = null;
$titulo_pagina = "Cadastrar Novo Produto";
$acao_formulario = "create_produto";
$texto_botao = "Cadastrar Produto";
$url_foto_atual = null;


if ($produto_id) {
  // Modo de EDIÇÃO: Busca simples do produto
  // NOTA: Usando query direta para simplificar. O ideal é usar prepared statements.
  $query_produto = "SELECT * FROM produto WHERE id_produto = '{$produto_id}'";
  $resultado = mysqli_query($conn, $query_produto);
  $produto = mysqli_fetch_assoc($resultado);

  if ($produto) {
    $titulo_pagina = "Editar Produto: " . htmlspecialchars($produto['nome']);
    $acao_formulario = "update_produto";
    $texto_botao = "Salvar Alterações";
    $url_foto_atual = $produto['url_foto'] ?? null;
  } else {
    // Se o ID não for válido, volta para o index
    $_SESSION['mensagem'] = "Produto não encontrado.";
    header('Location: index.php');
    exit;
  }
}

// -----------------------------------------------------------
// 2. Busca de Categorias e Fornecedores
// -----------------------------------------------------------
// Busca categorias
$query_categoria = "SELECT * FROM categoria ORDER BY nome_categoria ASC";
$lista_categorias = mysqli_query($conn, $query_categoria);

// Busca fornecedores
$query_fornecedor = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
$lista_fornecedores = mysqli_query($conn, $query_fornecedor);

// Função auxiliar para obter valor, simplificando o código HTML
function get_value($field, $produto)
{
  return htmlspecialchars($produto[$field] ?? '');
}

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $titulo_pagina ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
  <?php include('navbar.php'); ?>
  <main class='container mt-5'>
    <div class='row'>
      <div class='col-md-12'>
        <section class='card'>
          <header class='card-header'>
            <h1><?= $titulo_pagina ?>
              <a href="index.php" class='btn btn-secondary float-end'>Voltar</a>
            </h1>
          </header>
          <div class='card-body'>
            <form action="acoes.php" method='POST' enctype="multipart/form-data">
              <input type="hidden" name="acao" value="<?= $acao_formulario ?>">
              <?php if ($produto): ?>
                <input type="hidden" name="id_produto" value="<?= get_value('id_produto', $produto) ?>">
              <?php endif; ?>
              <fieldset>
                <legend class="h5 mb-3 border-bottom pb-2">Detalhes do Produto</legend>
                <div class="row">
                  <div class="col-md-6">

                    <div class='mb-3'>
                      <label>Nome:</label>
                      <input type="text" name='nome' class='form-control' required value="<?= get_value('nome', $produto) ?>">
                    </div>
                  </div>

                  <div class="col-md-6">

                    <div class='mb-3'>
                      <label>Descrição:</label>
                      <textarea name='descricao' class='form-control' rows="3"><?= get_value('descricao', $produto) ?></textarea>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mt-4">
                <legend class="h5 mb-3 border-bottom pb-2">Estoque e Preço</legend>
                <div class="row">
                  <div class="col-md-6">

                    <div class='mb-3'>
                      <label>Quantidade:</label>
                      <input type="number" name='quantidade_estoque' class='form-control' required value="<?= get_value('quantidade_estoque', $produto) ?>">
                    </div>
                  </div>
                  <div class="col-md-6">

                    <div class='mb-3'>
                      <label>Valor:</label>
                      <input type="number" step="any" name='preco_unitario' class='form-control' required>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mt-4">
                <legend class="h5 mb-3 border-bottom pb-2">Mídia do Produto</legend>
                <div class="row">
                  <div class="col-md-6">
                    <div class='mb-3'>
                      <label for="inputFoto" class='form-label'>Foto do Produto:</label>
                      <input type="file"
                        name='foto'
                        class='form-control'
                        id="inputFoto"
                        accept="image/*"
                        onchange="previewImagem(event)">
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class='mb-3'>
                      <label class='form-label'>Pré-visualização:</label>
                      <figure class="image-preview-container border p-2 text-center border p-4 text-center d-flex flex-column justify-content-center align-items-center">
                        <img id="imagemPreview"
                          src="#"
                          alt="Pré-visualização da Imagem"
                          style="display: none; max-width: 100%; max-height: 200px; object-fit: contain;">
                        <figcaption id="textoPlaceholder">Nenhuma imagem selecionada.</figcaption>
                      </figure>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mt-4">
                <legend class="h5 mb-3 border-bottom pb-2">Associações</legend>
                <div class="row">
                  <div class="col-md-6">

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
                  </div>

                  <div class="col-md-6">

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
                  </div>
                </div>
              </fieldset>

              <input type="hidden" name="ativo" value="1">
              <button type='submit' name='create_produto' class='btn btn-primary'>Salvar</button>
          </div>
          </form>
        </section>
      </div>
    </div>
  </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="./js/pre_visualizacao_imagem.js"></script>
</body>

</html>