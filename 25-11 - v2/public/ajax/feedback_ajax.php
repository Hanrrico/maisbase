
<?php
header('Content-Type: application/json');
require_once '../../app/controllers/feedback_controller.php';
session_start();

$acao = $_POST['acao'] ?? '';

if (in_array($acao, ['salvar','excluir'], true)) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'error' => 'CSRF inválido']);
        exit;
    }
}

$controller = new FeedbackController();

switch ($acao) {
    case 'listar':
        echo json_encode($controller->listar());
        break;

    case 'salvar':
        echo json_encode($controller->salvar($_POST));
        break;

    case 'excluir':
        if (($_SESSION['usuario_permissao'] ?? '') !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'Sem permissão']);
            break;
        }
        echo json_encode($controller->excluir($_POST['id'] ?? null));
        break;

    default:
        echo json_encode(['error' => 'Ação inválida']);
}
