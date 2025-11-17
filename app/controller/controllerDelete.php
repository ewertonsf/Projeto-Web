<?php
require_once '../config/conexao.php';
header('Content-Type: application/json');

// 1. Verifica se o ID veio via POST corretamente
if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID do jogador é inválido ou não foi enviado.'
    ]);
    exit;
}

$jogadorId = intval($_POST['id']);

try {
    // 2. Prepara e executa o DELETE com segurança
    $stmt = $pdo->prepare("DELETE FROM jogadores WHERE id = :id");
    $stmt->bindValue(':id', $jogadorId, PDO::PARAM_INT);
    $stmt->execute();

    // 3. Verifica se realmente deletou
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Jogador deletado com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nenhum jogador encontrado com esse ID.'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao excluir jogador: ' . $e->getMessage()
    ]);
}
