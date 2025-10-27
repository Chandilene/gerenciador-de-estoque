<?php
require 'config_sessao.php';
require 'verificacao_seguranca_login.php';
require 'connection.php';

// 1. Obter o ID do produto da URL (via GET)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireciona se o ID estiver faltando ou for inválido
    $_SESSION['mensagem'] = 'ID do produto inválido ou não fornecido.';
    header("Location: index.php");
    exit;
}

// Escapa a string para segurança (contra SQL Injection)
$produto_id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Query SQL (usando LEFT JOIN para garantir que o produto seja listado)
$query = "
    SELECT 
        p.*, 
        c.nome_categoria, 
        f.nome_fornecedor
    FROM 
        produto p
    LEFT JOIN 
        categoria c ON p.id_categoria = c.id_categoria
    LEFT JOIN 
        fornecedor f ON p.id_fornecedor = f.id_fornecedor
    WHERE 
        p.id_produto = '$produto_id'
    LIMIT 1
";

$resultado = mysqli_query($conn, $query);

// VERIFICAÇÃO DE ERRO NO BANCO (MANTENHA PARA DEBUG, REMOVA DEPOIS)
if (!$resultado) {
    die("Erro na Query: " . mysqli_error($conn));
}

// 3. Verifica se o produto foi encontrado
if (mysqli_num_rows($resultado) == 0) {
    // Produto não existe, redireciona
    $_SESSION['mensagem'] = 'Produto não encontrado.';
    header("Location: index.php");
    exit;
}

// Armazena os dados do produto
$produto = mysqli_fetch_assoc($resultado);

// 4. Cálculos e Formatação
$preco_unitario = (float)$produto['preco_unitario'];
$quantidade = (int)$produto['quantidade_estoque'];
$valor_total_estoque = $preco_unitario * $quantidade;

// Formatação para R$ (Ajuste a vírgula e o ponto conforme seu idioma)
$preco_formatado = 'R$ ' . number_format($preco_unitario, 2, ',', '.');
$total_estoque_formatado = 'R$ ' . number_format($valor_total_estoque, 2, ',', '.');

// Define classes e texto de status
$status_ativo = ($produto['ativo'] == 1);
$status_texto = $status_ativo ? 'Disponível' : 'Indisponível';
$status_classe = $status_ativo ? 'bg-success' : 'bg-danger';

// Pega o nome do Fornecedor e Categoria (Se o LEFT JOIN não achou, será NULL, então usamos um fallback)
$categoria_nome = $produto['nome_categoria'] ?? 'N/A';
$fornecedor_nome = $produto['nome_fornecedor'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalhes do Produto: <?= htmlspecialchars($produto['nome']) ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./styles/detalhes_produto.css">
</head>

<body>
    <?php include('navbar.php'); ?>
    <main class="container my-5">
        <header>
            <h1 class="mb-4 border-bottom pb-2">Detalhes do Produto</h1>
        </header>


        <div class="row">
            <section class="col-lg-4 mb-4">
                <figure class="card shadow-sm">
                    <img
                        src="./<?= htmlspecialchars($produto['url_foto']) ?>"
                        class="card-img-top"
                        alt="Foto do Produto" />
                </figure>
            </section>

            <section class="col-lg-8">
                <h2 class="display-5 mb-3"><?= htmlspecialchars($produto['nome']) ?></h2>

                <section>

                    <h4>Descrição completa:</h4>
                    <p class="lead text-muted mb-4">
                        <?= nl2br(htmlspecialchars($produto['descricao'])) ?>
                    </p>
                </section>
                <section class="mb-4">
                    <dl class="row">
                        <dt class="col-sm-3 info-label">ID Produto:</dt>
                        <dd class="col-sm-9 info-value"><?= $produto['id_produto'] ?></dd>

                        <dt class="col-sm-3 info-label">Categoria:</dt>
                        <dd class="col-sm-9 info-value"><?= htmlspecialchars($produto['nome_categoria']) ?></dd>

                        <dt class="col-sm-3 info-label">Fornecedor:</dt>
                        <dd class="col-sm-9 info-value"><?= htmlspecialchars($produto['nome_fornecedor']) ?></dd>

                        <dt class="col-sm-3 info-label">Status:</dt>
                        <dd class="col-sm-9 info-value">
                            <span class="badge <?= $status_classe ?>"><?= $status_texto ?></span>
                        </dd>
                    </dl>
                </section>


                <hr class="my-4" />
                <section class="card card-estoque shadow-lg p-3">

                    <div class="card-body">
                        <h4 class="card-title text-info mb-3">Informações de Estoque</h4>

                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0 border-end">
                                <p class="mb-1 info-label">Preço Unitário:</p>
                                <p class="h4 text-dark"><?= $preco_formatado ?></p>

                                <p class="mb-1 mt-3 info-label">Quantidade em Estoque:</p>
                                <p class="h3 text-primary"><?= $quantidade ?> unidades</p>
                            </div>

                            <div class="col-md-6 text-center">
                                <p class="mb-0 info-label">
                                    Valor Total do Estoque:
                                </p>
                                <div class="valor-total-estoque"><?= $total_estoque_formatado ?></div>
                            </div>
                        </div>
                    </div>
                </section>



                <div class="mt-4">
                    <a href="#" class="btn btn-primary me-2">Editar Produto</a>
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>