<?php

$senha_pura = "SuaSenhaDeAdminAqui";

$hash_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

echo "O hash seguro da sua senha é: " . $hash_senha . "\n";
