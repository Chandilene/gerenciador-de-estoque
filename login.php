<?php
// require "connection.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Usuário</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="login-container">
        <div class="row g-0 login-panel" style="max-width: 80%; width: 90%;">
            <div class="col-lg-6 logo-side d-none d-lg-block ">
                <img src="./assets/logo_ALPHA_Suplementos.png" alt="Logo da Alpha Suplementos">
                <h2 class="mt-3">Alpha Suplementos</h2>
                <p>Gestão de Estoque</p>
            </div>

            <div class="col-lg-6 p-5">
                <h4 class="mb-4 text-center">Acesso ao Sistema</h4>

                <form id="loginForm">
                    <div class="mb-3">
                        <label for="inputUsuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputSenha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="inputSenha" name="senha" required>
                    </div>

                    <div id="alertMessage" class="alert alert-danger d-none" role="alert"></div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Entrar</button>
                </form>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>