<?php
require_once '../config/conexao.php';
require_once '../model/modelCardsJogadores.php';

header('Content-Type: application/json');

try {
    $model = new CardsJogadoresModel($pdo);
    $jogadores = $model->buscarTodosJogadores();

    echo json_encode([
        "success" => true,
        "data" => $jogadores
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "data" => [],
        "message" => "Erro ao buscar jogadores: " . $e->getMessage()
    ]);
}
