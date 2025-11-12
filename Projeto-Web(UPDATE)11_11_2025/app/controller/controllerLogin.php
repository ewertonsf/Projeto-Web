<?php
session_start();
require '../model/modelLogin.php';

$model = new LoginModel($pdo);

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($email) || empty($senha)) {
        $response = [
            'success' => false,
            'message' => 'Preencha todos os campos!'
        ];
    } else {
        $usuario = $model->buscarUsuario($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            $response = [
                'success' => true,
                'message' => 'Login realizado com sucesso!',
                'tipo_usuario' => $usuario['tipo_usuario']
            ];

        } else {
            $response = [
                'success' => false,
                'message' => 'E-mail ou senha incorretos.'
            ];
        }
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Método inválido.'
    ];
}

echo json_encode($response);
