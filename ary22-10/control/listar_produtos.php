<?php
session_start();
require_once '../model/conexao.php';

header('Content-Type: application/json');

// Debug: verificar se está conectando
error_log("Listar produtos: Conexão estabelecida");

$sql = "SELECT id_produto, nome, descricao, preco, estoque, categoria, imagem FROM produtos";
$result = $conn->query($sql);

error_log("Listar produtos: Query executada, num_rows: " . $result->num_rows);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    error_log("Listar produtos: " . count($products) . " produtos encontrados");
} else {
    error_log("Listar produtos: Nenhum produto encontrado");
}

echo json_encode($products);

$conn->close();
?>