<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produto = $_POST['id_produto'];
    $nome = $_POST['nome'];
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);
    $imagem = $_POST['imagem'];
    
    // Inicializar carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    // Verificar se o produto já está no carrinho
    $produto_existente = false;
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['id_produto'] == $id_produto) {
            $item['quantidade'] += $quantidade;
            $produto_existente = true;
            break;
        }
    }
    
    // Se não existe, adicionar novo item
    if (!$produto_existente) {
        $_SESSION['carrinho'][] = [
            'id_produto' => $id_produto,
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade,
            'imagem' => $imagem
        ];
    }
    
    // Redirecionar de volta para a página de produtos com mensagem de sucesso
    header('Location: ../view/index.php?sucesso=Produto adicionado ao carrinho!');
    exit();
} else {
    header('Location: ../view/index.php');
    exit();
}
?>