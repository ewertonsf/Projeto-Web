<?php
require_once '../config/conexao.php';

class CardsJogadoresModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarTodosJogadores() {
        $sql = "SELECT * FROM jogadores ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
