<?php
session_start();
require_once '../model/conexao.php';
require_once '../model/Usuario.php';

// Somente admin pode listar usuários
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_permissao'] != 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

header('Content-Type: application/json');

$usuarioModel = new Usuario($conn);
$usuarios = $usuarioModel->listarUsuarios();

echo json_encode($usuarios);

$conn->close();
?>