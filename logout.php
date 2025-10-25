<?php
// Inclui o arquivo de configuração de sessão.
// Isso garante que session_start() seja chamado, o que é necessário antes de session_destroy().
require 'config_sessao.php';

// 1. Destrói todas as variáveis de sessão no array $_SESSION
$_SESSION = array();

// 2. Se estiver usando cookies de sessão, destrói o cookie no navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    // Seta o cookie de sessão para o passado para que o navegador o delete
    setcookie(
        session_name(), // PHPSESSID
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3. Destrói a sessão no servidor
session_destroy();

// Opcional: Define uma mensagem de sucesso para ser exibida no login
// Note que esta variável de sessão é criada *antes* do header e será lida pelo login.php
$_SESSION['mensagem'] = 'Você saiu do sistema com sucesso.';

// 4. Redireciona o usuário para a página de login
header("Location: login.php");
exit;
