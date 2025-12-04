
<?php
// public/ajax/usuario_ajax.php
header('Content-Type: application/json');
require_once '../../app/controllers/usuario_controller.php';

$controller = new UsuarioController();
$acao = $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        $resultado = $controller->cadastrar($_POST);
        echo json_encode(['success' => $resultado]);
        break;

    case 'login':
        $usuario = $controller->login($_POST['email'], $_POST['senha']);
        if ($usuario) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_permissao'] = $usuario['permissao'];
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciais inválidas']);
        }
        break;

    case 'listar':
        $usuarios = $controller->listar();
        echo json_encode($usuarios);
        break;

    case 'excluir':
        $resultado = $controller->excluir($_POST['id']);
        echo json_encode(['success' => $resultado]);
        break;

    default:
        echo json_encode(['error' => 'Ação inválida']);
}
