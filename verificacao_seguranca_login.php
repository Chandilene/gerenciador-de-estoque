<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {

    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';

    header('Location: login.php');
    exit;
}
