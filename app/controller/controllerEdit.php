<?php
require_once '../config/conexao.php';
require '../model/modelEdit.php';
header('Content-Type: application/json');

$response = [];
$model = new JogadorModel($pdo);

// Recebe o método e ação
$method = $_SERVER['REQUEST_METHOD'];
$action = $_POST['action'] ?? $_POST['action'] ?? '';

switch ($action) {

    case 'buscar':
        if ($method !== 'POST') {
            $response = [
                'success' => false,
                'message' => 'Método inválido. Use POST.'
            ];
            break;
        }
        
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $response = [
                'success' => false,
                'message' => 'ID do jogador não informado.'
            ];
            break;
        }

        $jogador = $model->buscarPorId($id);

        if ($jogador) {
            $response = [
                'success' => true,
                'jogador' => $jogador
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Jogador não encontrado.'
            ];
        }
        break;

    case 'editar':
        if ($method !== 'POST') {
            $response = [
                'success' => false,
                'message' => 'Método inválido. Use POST.'
            ];
            break;
        }

        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $data_nascimento = $_POST['data_nascimento'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $posicao = $_POST['posicao'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $foto = null;

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $response = ['success' => false, 'message' => 'ID não enviado'];
            exit;
        }

        $jogadorAtual = $model->buscarPorId($id);
        $fotoAtual = $jogadorAtual['foto'] ?? null;

        $foto = $fotoAtual;
        $uploadDir = '../uploads/';

        if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $novoNomeFoto = $uploadDir . uniqid() . "_" . basename($_FILES['foto']['name']);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $novoNomeFoto)) {
                $foto = $novoNomeFoto;
            }
        }

        $dados = [
            'id' => $id,
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

        if ($model->atualizarJogador($dados)) {
            $response =[
                'success' => true,
                'message' => 'Jogador atualizado com sucesso!',
                'jogador' => $dados
            ];
        } else {
            $response =[
                'success' => false,
                'message' => 'Erro ao atualizar jogador.'
            ];
        }
        break;

    default:
        $response = [
            'success' => false,
            'message' => 'Ação inválida.'
        ];
        break;
}

echo json_encode($response);
