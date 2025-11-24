<?php
session_start();
header('Content-Type: application/json');

require '../../vendor/autoload.php';

$serviceManager = require '../../zend/bootstrap.php';

use Auth\LoginService;
use Doctrine\ORM\EntityManager;

$em = $serviceManager->get(EntityManager::class);
$loginService = new LoginService($em);

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $loginService->autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_email'] = $usuario->getEmail();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos!']);
    }
    exit;
}
?>

