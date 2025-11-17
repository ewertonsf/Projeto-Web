<?php
require_once '../config/conexao.php';
require '../model/modelCadastro.php';
header('Content-Type: application/json');

$response = [];
$model = new JogadorModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? 'create';
    $id     = $_POST['id'] ?? null;

    $nome           = $_POST['nome'] ?? '';
    $data_nascimento= $_POST['data_nascimento'] ?? '';
    $cpf            = $_POST['cpf'] ?? '';
    $email          = $_POST['email'] ?? '';
    $telefone       = $_POST['telefone'] ?? '';
    $posicao        = $_POST['posicao'] ?? '';
    $categoria      = $_POST['categoria'] ?? '';
    $cidade         = $_POST['cidade'] ?? '';
    $estado         = $_POST['estado'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $foto = null;
    $uploadDir = '../uploads/';

if ($action === 'update' && $id) {
        $jogadorExistente = $model->buscarPorId($id);
        $foto = $jogadorExistente['foto'] ?? null;
    }

if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0){
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }
        $novoNomeFoto = $uploadDir . basename($_FILES['foto']['name']);
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $novoNomeFoto)){
            $foto = $novoNomeFoto; // Atualiza a foto com o novo caminho
            $fotoStatus = 'Arquivo enviado: ' . basename($_FILES['foto']['name']);
        } else {
            $fotoStatus = 'Erro ao enviar arquivo.';
        }
    }

if ($action === 'create') {

if ($model->buscarPorCpfOuEmail($cpf, $email)) {
            $response = [
                'success' => false,
                'message' => 'Jogador já cadastrado com esse CPF ou e-mail.'
            ];
            echo json_encode($response);
            exit;
        }

        $dados = [
            'nome' => $nome,
            'data_nascimento' => $data_nascimento,
            'cpf' => $cpf,
            'email' => $email,
            'telefone' => $telefone,
            'posicao' => $posicao,
            'categoria' => $categoria,
            'cidade' => $cidade,
            'estado' => $estado,
            'foto' => $foto
        ];

        if ($model->cadastrarJogador($dados)) {
            $response = [
                'success' => true,
                'message' => 'Jogador cadastrado com sucesso!',
                'dados_recebidos' => $dados
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Erro ao cadastrar jogador.'
            ];
        }    

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0){
        $uploadDir = '../uploads/';
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }
        $foto = $uploadDir . basename($_FILES['foto']['name']);
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $foto)){
            $fotoStatus = 'Arquivo enviado: ' . basename($_FILES['foto']['name']);
        } else {
            $fotoStatus = 'Erro ao enviar arquivo.';
        }
    }

    if ($model->buscarPorCpfOuEmail($cpf, $email)) {
        $response = [
            'success' => false,
            'message' => 'Jogador já cadastrado com esse CPF ou e-mail.'
        ];
        echo json_encode($response);
        exit;
    }

    $dados = [
        'nome' => $nome,
        'data_nascimento' => $data_nascimento,
        'cpf' => $cpf,
        'email' => $email,
        'telefone' => $telefone,
        'posicao' => $posicao,
        'categoria' => $categoria,
        'cidade' => $cidade,
        'estado' => $estado,
        'foto' => $foto
    ];

    if ($model->cadastrarJogador($dados)) {
        $response = [
            'success' => true,
            'message' => 'Jogador cadastrado com sucesso!',
            'dados_recebidos' => $dados
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Erro ao cadastrar jogador.'
        ];
    }

} else {
    $response = [
        'success' => false,
        'message' => 'Método não permitido. Use POST.'
    ];
}

echo json_encode($response);
