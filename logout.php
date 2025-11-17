<?php
require 'config_sessao.php';

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

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

session_destroy();

$_SESSION['mensagem'] = 'Você saiu do sistema com sucesso.';

header("Location: login.php");
exit;
