<?php
require_once 'config/conexao.php';

$nome = "Administrador Geral";
$email = "admin@peneira.com";
$senha = password_hash("12345", PASSWORD_DEFAULT); // senha segura
$tipo = "admin";

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $email, $senha, $tipo]);

echo "Usuário admin criado com sucesso!";
