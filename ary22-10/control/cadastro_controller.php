<?php
session_start();
require_once '../model/conexao.php';
require_once '../model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new Usuario($conn);
    $resultado = $usuarioModel->cadastrar($nome, $email, $senha);
    
    if ($resultado) {
        // Se cadastrou com sucesso, faz login automático
        $usuario = $usuarioModel->login($email, $senha);
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_permissao'] = $usuario['permissao'];
            
            header('Location: ../view/index.php');
        } else {
            header('Location: ../view/login.php?sucesso=1');
        }
    } else {
        header('Location: ../view/cadastrousuario.php?erro=1');
    }
    exit();
}
?>