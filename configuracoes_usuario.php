<?php
require 'config_sessao.php';
require 'verificacao_seguranca_login.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configurações de Usuário - Alpha Suplementos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">

</head>

<body>
    <main class="container mt-5">
        <header>
            <h2>Alterar Credenciais</h2>
        </header>

        <div class="mensagem-alerta-container" role="alert">
            <?php include('mensagem.php'); ?>
        </div>

        <section class="p-4 border rounded shadow-sm">
            <form action="acoes.php" method="POST">

                <div class="row row-cols-1 row-cols-md-2 g-4">

                    <div class="col">
                        <fieldset class="h-100">
                            <legend class="h4 border-bottom pb-2">Dados do Usuário</legend>
                            <div class="mb-3">
                                <label for="novo_usuario" class="form-label">Novo Nome de Usuário:</label>
                                <input type="text" class="form-control" id="novo_usuario" name="novo_usuario"
                                    value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" required>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col">
                        <fieldset>
                            <legend class="h4 border-bottom pb-2">Alterar Senha</legend>
                            <p class="text-muted small">Preencha os campos abaixo apenas se desejar mudar sua senha.</p>

                            <div class="mb-3">
                                <label for="senha_atual" class="form-label">Senha Atual:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="senha_atual" name="senha_atual" autocomplete="current-password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="senha_atual">
                                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nova_senha" class="form-label">Nova Senha:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="nova_senha" name="nova_senha" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="nova_senha">
                                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="confirma_senha" class="form-label">Confirmar Nova Senha:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirma_senha" name="confirma_senha" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirma_senha">
                                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <hr class="mt-4">

                <div class="d-flex justify-content-start mt-4">
                    <button type="submit" name="update_credenciais" class="btn btn-primary me-2">Salvar Alterações</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/visibilidade_senha.js"></script>
</body>

</html>