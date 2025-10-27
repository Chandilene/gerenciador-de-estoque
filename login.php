<?php
require 'config_sessao.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Usuário - Alpha Suplementos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/login.css">
</head>

<body>
    <main class="login-container">

        <section class="row g-0 login-panel" style="max-width: 80%; width: 90%;">

            <aside class="col-lg-6 logo-side d-none d-lg-block">
                <figure> <img src="./assets/logo_ALPHA_Suplementos.png" alt="Logo da Alpha Suplementos">
                </figure>
                <h2 class="mt-3">Alpha Suplementos</h2>
                <p>Gestão de Estoque</p>
            </aside>

            <section class="col-lg-6 p-5">
                <header>
                    <h1 class="mb-4 text-center">Acesso ao Sistema</h1>
                </header>

                <form id="loginForm" action="acoes.php" method="POST">
                    <div class="mb-3">
                        <label for="inputUsuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>

                        <div class="input-group">
                            <input type="password" class="form-control" id="senha" name="senha" required>

                            <button class="btn btn-outline-secondary" type="button" id="toggleSenha">
                                <i class="bi bi-eye-slash" id="iconeOlho"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mensagem-alerta-container" role="alert">
                        <?php include('mensagem.php'); ?>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 mt-3">Entrar</button>
                </form>
            </section>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="./js/visibilidade_senha.js"></script>
</body>

</html>