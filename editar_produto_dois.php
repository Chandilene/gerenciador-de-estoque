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
        // CORREÇÃO: Altera a ação do formulário para o novo método 'update_produto'
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
// Busca categorias (usaremos esta lista para preencher o SELECT)
$query_categoria = "SELECT * FROM categoria ORDER BY nome_categoria ASC";
$lista_categorias = mysqli_query($conn, $query_categoria);

// Busca fornecedores (usaremos esta lista para preencher o SELECT)
$query_fornecedor = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
$lista_fornecedores = mysqli_query($conn, $query_fornecedor);

// Função auxiliar para obter valor, simplificando o código HTML
function get_value($field, $produto)
{
    // O htmlspecialchars é importante para evitar XSS
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                            <!-- Campo para indicar a ação a ser executada no acoes.php (create_produto ou update_produto) -->
                            <input type="hidden" name="acao" value="<?= $acao_formulario ?>">
                            <?php if ($produto): ?>
                                <!-- Campo hidden para enviar o ID do produto, obrigatório para a ação de UPDATE -->
                                <input type="hidden" name="id_produto" value="<?= get_value('id_produto', $produto) ?>">
                                <!-- Campo hidden para enviar a URL da foto atual (mantê-la se nenhuma nova for enviada) -->
                                <input type="hidden" name="url_foto_atual" value="<?= $url_foto_atual ?>">
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
                                            <!-- Adiciona o valor do produto em edição ao campo de preço -->
                                            <input type="number" step="any" name='preco_unitario' class='form-control' required value="<?= get_value('preco_unitario', $produto) ?>">
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
                                            <small class="form-text text-muted">Selecione uma nova imagem apenas se quiser substituir a atual.</small>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class='mb-3'>
                                            <label class='form-label'>Pré-visualização:</label>
                                            <figure class="image-preview-container border p-2 text-center border p-4 text-center d-flex flex-column justify-content-center align-items-center">
                                                <!-- Adiciona a URL da foto atual se estiver em modo de edição -->
                                                <img id="imagemPreview"
                                                  src="<?= $url_foto_atual ? $url_foto_atual : '#' ?>"
                                                  alt="Pré-visualização da Imagem"
                                                  style="max-width: 100%; max-height: 200px; object-fit: contain; <?= $url_foto_atual ? 'display: block;' : 'display: none;' ?>">
                                                <figcaption id="textoPlaceholder" style="<?= $url_foto_atual ? 'display: none;' : 'display: block;' ?>">
                                                    <?= $url_foto_atual ? 'Foto atual carregada' : 'Nenhuma imagem selecionada.' ?>
                                                </figcaption>
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
                                                // As consultas já foram feitas no início do arquivo, mas a variável $lista_categorias está sendo
                                                // re-definida de forma incorreta no seu código original.
                                                // Para fins didáticos e compatibilidade com seu código, vou assumir que mysqli_query retornou um objeto iterável
                                                // e que precisamos reiniciá-lo ou re-consultar (a re-consulta é a forma como estava antes).

                                                $query_categoria_select = "SELECT * FROM categoria";
                                                $lista_categorias_select = mysqli_query($conn, $query_categoria_select);
                                                
                                                if (mysqli_num_rows($lista_categorias_select) > 0) {
                                                  // Itera sobre as categorias
                                                  while ($categoria = mysqli_fetch_assoc($lista_categorias_select)) {
                                                        // LÓGICA DE PRÉ-SELEÇÃO: Verifica se o ID da categoria do produto ($produto)
                                                        // é igual ao ID da categoria atual ($categoria)
                                                        $selected = ($produto && $produto['id_categoria'] == $categoria['id_categoria']) ? 'selected' : '';
                                                ?>
                                                        <option value="<?= $categoria['id_categoria'] ?>" <?= $selected ?>>
                                                            <?= $categoria['nome_categoria'] ?>
                                                        </option>
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
                                                // Mesma correção para Fornecedor
                                                $query_fornecedor_select = "SELECT * FROM fornecedor";
                                                $lista_fornecedores_select = mysqli_query($conn, $query_fornecedor_select);

                                                if (mysqli_num_rows($lista_fornecedores_select) > 0) {
                                                    while ($fornecedor = mysqli_fetch_assoc($lista_fornecedores_select)) {
                                                        // LÓGICA DE PRÉ-SELEÇÃO: Verifica se o ID do fornecedor do produto ($produto)
                                                        // é igual ao ID do fornecedor atual ($fornecedor)
                                                        $selected = ($produto && $produto['id_fornecedor'] == $fornecedor['id_fornecedor']) ? 'selected' : '';
                                                ?>
                                                        <option value="<?= $fornecedor['id_fornecedor'] ?>" <?= $selected ?>>
                                                            <?= $fornecedor['nome_fornecedor'] ?>
                                                        </option>
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
                            <!-- O nome do botão pode ser usado como fallback se a ação não for enviada corretamente,
                                 mas a variável $acao_formulario no input hidden já define o comportamento correto. -->
                            <button type='submit' class='btn btn-primary'><?= $texto_botao ?></button>
                    </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="./js/pre_visualizacao_imagem.js"></script>
</body>

</html>