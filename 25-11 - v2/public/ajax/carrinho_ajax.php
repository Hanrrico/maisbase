
<?php
session_start();
header('Content-Type: application/json');

$acao = $_POST['acao'] ?? '';
if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho'] = [];

switch ($acao) {
  case 'adicionar':
    $id = $_POST['id_produto'] ?? null;
    $qtd = (int)($_POST['qtd'] ?? 1);
    if ($id) {
      $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + $qtd;
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'error' => 'ID inválido']);
    }
    break;

  case 'listar':
    echo json_encode($_SESSION['carrinho']);
    break;

  case 'remover':
    $id = $_POST['id_produto'] ?? null;
    unset($_SESSION['carrinho'][$id]);
    echo json_encode(['success' => true]);
    break;

  default:
    echo json_encode(['error' => 'Ação inválida']);
}
