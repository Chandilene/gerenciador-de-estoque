<?php
// A senha que o usuário digitou no formulário de cadastro
$senha_pura = "alpha3085@!"; // Exemplo: Pegue esta senha de um $_POST

// 1. Geração da Hash
// PASSWORD_DEFAULT usará o algoritmo mais forte disponível (atualmente bcrypt)
// e cuidará da salt automaticamente.
$hash_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

// O valor em $hash_senha é o que você deve armazenar no campo 'senha' do seu banco de dados.

echo "Senha Pura: " . $senha_pura . "<br>";
echo "Hash Gerada (Para BD): " . $hash_senha . "<br>";

// --- Exemplo de Inserção no Banco de Dados ---
/*
// Supondo uma conexão $pdo
$username = "admin";
$stmt = $pdo->prepare("INSERT INTO usuarios (username, senha) VALUES (?, ?)");
$stmt->execute([$username, $hash_senha]);

echo "Usuário inserido com sucesso!";
*/
