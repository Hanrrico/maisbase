
<?php
// public/ajax/produto_ajax.php
header('Content-Type: application/json');
require_once '../../app/controllers/produto_controller.php';

$controller = new ProdutoController();

$acao = $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        $resultado = $controller->cadastrar($_POST);
        echo json_encode(['success' => $resultado]);
        break;

    case 'atualizar':
        $resultado = $controller->atualizar($_POST);
        echo json_encode(['success' => $resultado]);
        break;

    case 'excluir':
        $resultado = $controller->excluir($_POST['id']);
        echo json_encode(['success' => $resultado]);
        break;

    case 'listar':
        $produtos = $controller->listar();
        echo json_encode($produtos);
        break;

    default:
        echo json_encode(['error' => 'Ação inválida']);
}
