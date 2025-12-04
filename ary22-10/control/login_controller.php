<?php
session_start();
require_once '../model/conexao.php';
require_once '../model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new Usuario($conn);
    $usuario = $usuarioModel->login($email, $senha);
    
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_permissao'] = $usuario['permissao'];
        
        if ($usuario['permissao'] == 'admin') {
            header('Location: ../view/telaadmin.php');
        } else {
            header('Location: ../view/index.php');
        }
        exit();
    } else {
        header('Location: ../view/login.php?erro=1');
        exit();
    }
}
?>