<?php
require_once '../config/conexao.php';

class JogadorModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM jogadores WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function atualizarJogador($dados) {
        $sql = "UPDATE jogadores SET 
            nome = :nome, 
            data_nascimento = :data_nascimento, 
            cpf = :cpf, 
            email = :email, 
            telefone = :telefone, 
            posicao = :posicao, 
            categoria = :categoria, 
            cidade = :cidade, 
            estado = :estado, 
            foto = :foto
        WHERE id = :id";
        
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
        $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}
