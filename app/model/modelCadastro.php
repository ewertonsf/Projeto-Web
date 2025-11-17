<?php
require_once '../config/conexao.php';

class JogadorModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorCpfOuEmail($cpf, $email, $id = null) {
        $sql = "SELECT * FROM jogadores WHERE (cpf = :cpf OR email = :email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();

        if ($id !== null) {
            $sql .= " AND id != :id";
        }
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        
        if ($id !== null) {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetch();

        $sql .= " LIMIT 1";
    }
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
        $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT); // ID é crucial para o WHERE

        return $stmt->execute();
    }
}
