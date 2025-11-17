<?php
require_once '../config/conexao.php';

class JogadorModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorCpfOuEmail($cpf, $email) {
        $sql = "SELECT * FROM jogadores WHERE cpf = :cpf OR email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function cadastrarJogador($dados) {
        $sql = "INSERT INTO jogadores 
            (nome, data_nascimento, cpf, email, telefone, posicao, categoria, cidade, estado, foto)
            VALUES 
            (:nome, :data_nascimento, :cpf, :email, :telefone, :posicao, :categoria, :cidade, :estado, :foto)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':posicao', $dados['posicao']);
        $stmt->bindParam(':categoria', $dados['categoria']);
        $stmt->bindParam(':cidade', $dados['cidade']);
        $stmt->bindParam(':estado', $dados['estado']);
        $stmt->bindParam(':foto', $dados['foto']);

        return $stmt->execute();
    }
}