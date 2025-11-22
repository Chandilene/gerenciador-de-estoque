<header>

    <nav class="navbar navbar-dark " style="background-color: rgb(67 112 157);">
        <div class="container-md header-navbar">

            <a class="navbar-brand" href="index.php">
                <img src="assets/logo_dourado.png"
                    alt="ALPHA Suplementos Logo"
                    height="60"
                    class="d-inline-block align-middle me-2">
                <strong>ALPHA</strong> Suplementos </a>

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <div class="navbar-buttons">

                    <a href="configuracoes_usuario.php" class="btn btn-secondary btn-sm me-2" title="Configurações de usuario">
                        <span class="bi bi-person-circle "></span>&nbsp;
                        Conta
                    </a>

                    <a href="logout.php"
                        class="btn btn-danger btn-sm"
                        title="Sair do Sistema">
                        <span class="bi bi-box-arrow-left "></span>&nbsp;
                        Sair
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </nav>
</header>