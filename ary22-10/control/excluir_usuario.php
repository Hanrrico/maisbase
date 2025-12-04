<?php
session_start();
require_once '../model/conexao.php';
require_once '../model/Usuario.php';

// Somente admin pode excluir usuários
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_permissao'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Acesso negado.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    
    $usuarioModel = new Usuario($conn);
    $resultado = $usuarioModel->excluirUsuario($id);

    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Usuário excluído com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir usuário ou não é permitido excluir a si mesmo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>