<?php

$servidor = "localhost";      // localhost
$usuario  = "root";           // usuário
$senha    = "";               // senha
$banco    = "projeto_web"; // nome do banco de dados

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    echo "Erro ao conectar ao banco de dados: " . $erro->getMessage();
    exit;
}
