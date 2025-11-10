<?php
require 'config_sessao.php';

require 'connection.php';

function criar_mensagem_de_erro($mensagem, $pagina_redirecionamento)
{

    $_SESSION['mensagem'] = $mensagem;
    header("Location: $pagina_redirecionamento");
    exit;
}

if (isset($_POST['login'])) {
    $senha_digitada = trim($_POST['senha'] ?? '');
    $usuario_digitado = trim($_POST['usuario'] ?? '');

    if (empty($usuario_digitado) || empty($senha_digitada)) {
        criar_mensagem_de_erro('Por favor, preencha todos os campos.', 'login.php');
    }


    $usuario_digitado = mysqli_real_escape_string($conn, $usuario_digitado);
    $query_usuario = "SELECT * FROM usuario WHERE usuario = '$usuario_digitado'";
    $resultado_query = mysqli_query($conn, $query_usuario);
    $usuario = mysqli_fetch_assoc($resultado_query);

    if (!$usuario) {
        criar_mensagem_de_erro('Usuário ou senha inválidos.', 'login.php');
    }

    $hash_do_banco = $usuario['senha'];

    if (!password_verify($senha_digitada, $hash_do_banco)) {
        criar_mensagem_de_erro('Usuário ou senha inválidos.', 'login.php');
    }

    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['usuario'] = $usuario['usuario'];

    header(('Location: index.php'));
    exit;
}

if (isset($_POST['create_produto'])) {
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $descricao = mysqli_real_escape_string($conn, trim($_POST['descricao']));
    $quantidade_estoque = mysqli_real_escape_string($conn, trim($_POST['quantidade_estoque']));
    $preco = mysqli_real_escape_string($conn, trim($_POST['preco_unitario']));
    // $ativo = mysqli_real_escape_string($conn, trim($_POST['ativo']));
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

    $ativo  = 0;
    $quantidade = (int) $quantidade_estoque;

    if ($quantidade > 0) {
        $ativo = 1;
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

if (isset($_POST['delete_produto'])) {
    require 'verificacao_seguranca_login.php';
    $produto_id = mysqli_real_escape_string($conn, $_POST['delete_produto']);
    $query_delete = "DELETE FROM produto WHERE id_produto = '$produto_id'";
    mysqli_query($conn, $query_delete);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['mensagem'] = 'Produto deletado com sucesso!';
        header('Location: index.php');
    } else {
        $_SESSION['mensagem'] = 'Produto não foi deletado!';
        header('Location: index.php');
        exit;
    }
}

// NOVO MÉTODO: ATUALIZAR PRODUTO (UPDATE)
// =================================================================
if (isset($_POST['acao']) && $_POST['acao'] == 'update_produto') {
    require 'verificacao_seguranca_login.php';

    // 1. Coleta e sanitização de dados, incluindo o ID do produto e a URL da foto atual
    $id_produto = mysqli_real_escape_string($conn, trim($_POST['id_produto'] ?? ''));
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $descricao = mysqli_real_escape_string($conn, trim($_POST['descricao']));
    $quantidade_estoque = mysqli_real_escape_string($conn, trim($_POST['quantidade_estoque']));
    $preco = mysqli_real_escape_string($conn, trim($_POST['preco_unitario']));
    $id_categoria = mysqli_real_escape_string($conn, trim($_POST['id_categoria']));
    $id_fornecedor = mysqli_real_escape_string($conn, trim($_POST['id_fornecedor']));
    // Este campo hidden vem do formulário e guarda a URL da foto se o usuário não enviar uma nova
    $url_foto_atual = mysqli_real_escape_string($conn, trim($_POST['url_foto_atual'] ?? '')); 

    if (empty($id_produto)) {
        criar_mensagem_de_erro('ID do produto inválido para atualização.', 'index.php');
    }

    $preco_unitario = str_replace(',', '.', $preco);

    // 2. Lógica de Upload de Foto (Muito parecido com o create_produto)
    $url_foto = $url_foto_atual; // Mantém a foto atual por padrão

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK && $_FILES['foto']['size'] > 0) {
        $file = $_FILES['foto'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];

        $uploadDir = 'uploads/produtos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid('', true) . "." . $fileExt;
        $fileDestination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $url_foto = $fileDestination;
            // Opcional: Aqui você poderia adicionar a lógica para deletar a foto antiga
        } else {
            criar_mensagem_de_erro('Erro ao fazer upload da nova imagem.', 'editar_produto.php?id=' . $id_produto);
        }
    }

    // 3. Lógica de Ativação/Inativação
    $ativo  = 0;
    $quantidade = (int) $quantidade_estoque;

    if ($quantidade > 0) {
        $ativo = 1;
    }

    // 4. Preparação e Execução do UPDATE (Prepared Statement)
    $query = "UPDATE produto SET
                nome = ?,
                descricao = ?,
                quantidade_estoque = ?,
                preco_unitario = ?,
                url_foto = ?,
                ativo = ?,
                id_categoria = ?,
                id_fornecedor = ?
              WHERE id_produto = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        $_SESSION['mensagem'] = "Erro na preparação do UPDATE: " . mysqli_error($conn);
        header('Location: index.php');
        exit;
    }

    // Tipo de parâmetros: s (string), s (string), i (int), d (double), s (string), i (int), i (int), i (int), i (int)
    mysqli_stmt_bind_param($stmt, "ssidsiiii", 
        $nome, 
        $descricao, 
        $quantidade_estoque, 
        $preco_unitario, 
        $url_foto, 
        $ativo, 
        $id_categoria, 
        $id_fornecedor,
        $id_produto
    );
    
    $query_run = mysqli_stmt_execute($stmt);

    // 5. Verificação e Redirecionamento
    if ($query_run) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Nenhuma alteração foi realizada (Dados idênticos).";
        }
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar Produto: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    header('Location: index.php');
    exit;
}
