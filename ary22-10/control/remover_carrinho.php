<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = intval($_POST['index']);
    
    if (isset($_SESSION['carrinho'][$index])) {
        array_splice($_SESSION['carrinho'], $index, 1);
    }
    
    header('Location: ../view/carrinho.php');
    exit();
} else {
    header('Location: ../view/carrinho.php');
    exit();
}
?>