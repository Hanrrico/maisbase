<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = intval($_POST['index']);
    $quantidade = intval($_POST['quantidade']);
    
    if (isset($_SESSION['carrinho'][$index]) && $quantidade > 0) {
        $_SESSION['carrinho'][$index]['quantidade'] = $quantidade;
    }
    
    header('Location: ../view/carrinho.php');
    exit();
} else {
    header('Location: ../view/carrinho.php');
    exit();
}
?>