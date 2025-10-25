<header>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">

            <a class="navbar-brand" href="index.php">
                <img src="assets/logo_dourado.png"
                    alt="ALPHA Suplementos Logo"
                    height="60"
                    class="d-inline-block align-middle me-2">
                <strong>ALPHA</strong> Suplementos </a>

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>

                <a href="logout.php"
                    class="btn btn-outline-light btn-sm ms-auto"
                    title="Sair do Sistema">
                    <span class="bi bi-box-arrow-left text-danger"></span>&nbsp;
                    Sair
                </a>

            <?php endif; ?>

        </div>
    </nav>
</header>