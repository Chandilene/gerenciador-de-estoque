<?php
session_start();
require 'connection.php';

if (isset($_POST['create_produto'])) {
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $descricao = mysqli_real_escape_string($conn, trim($_POST['descricao']));
    $quantidade_estoque = mysqli_real_escape_string($conn, trim($_POST['quantidade_estoque']));
    $preco = mysqli_real_escape_string($conn, trim($_POST['preco_unitario']));
    $ativo = mysqli_real_escape_string($conn, trim($_POST['ativo']));
    $id_categoria = mysqli_real_escape_string($conn, trim($_POST['id_categoria']));
    $id_fornecedor = mysqli_real_escape_string($conn, trim($_POST['id_fornecedor']));

    $preco_unitario = str_replace(',', '.', $preco);

    $url_foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['foto'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];

        // Define o diretório onde as fotos serão salvas no servidor
        $uploadDir = 'uploads/produtos/';

        // Garante que o diretório exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Cria um nome de arquivo único para evitar colisões
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid('', true) . "." . $fileExt;
        $fileDestination = $uploadDir . $newFileName;

        // Move o arquivo temporário para o destino final no seu servidor
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Se o upload for bem-sucedido, armazena o caminho relativo no banco
            $url_foto = $fileDestination;
        } else {
            // Lógica para tratar falha no upload
            echo "Erro ao fazer upload da imagem.";
            exit();
        }
    }

    $query = "INSERT INTO produto (nome, descricao, quantidade_estoque, preco_unitario, url_foto, ativo, id_categoria, id_fornecedor) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        $_SESSION['mensagem'] = "Erro ao cadastrar produto: " . mysqli_error($conn);
        header('Location: index.php');
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ssidsiii", $nome, $descricao, $quantidade_estoque, $preco_unitario, $url_foto, $ativo, $id_categoria, $id_fornecedor);
    $query_run = mysqli_stmt_execute($stmt);

    if ($query_run) {
        $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar Produto: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    header('Location: index.php');
    exit;
}
