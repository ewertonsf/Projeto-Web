<?php
require_once '../config/conexao.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, nome, email, posicao, categoria FROM jogadores ORDER BY nome ASC");
    $stmt->execute();
    $jogadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'jogadores' => $jogadores]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar jogadores: ' . $e->getMessage()]);
}
?>