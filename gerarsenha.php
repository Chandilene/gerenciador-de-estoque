<?php
// A senha que você quer usar (ex: 'minhasenhaforte123')
$senha_pura = "SuaSenhaDeAdminAqui";

// A função password_hash() gera um hash seguro
$hash_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

echo "O hash seguro da sua senha é: " . $hash_senha . "\n";
