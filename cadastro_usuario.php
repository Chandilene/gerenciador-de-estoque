<?php
$senha_pura = "alpha3085@!"; 

$hash_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

echo "Senha Pura: " . $senha_pura . "<br>";
echo "Hash Gerada (Para BD): " . $hash_senha . "<br>";


