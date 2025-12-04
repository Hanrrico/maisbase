<?php
require_once '../model/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = intval($_POST['id']);
    // Primeiro, buscar o caminho da imagem para removê-lo do servidor
    $sql_image = "SELECT imagem FROM produtos WHERE id_produto = $id";
    $result_image = $conn->query($sql_image);
    if ($result_image->num_rows > 0) {
        $row_image = $result_image->fetch_assoc();
        if ($row_image['imagem'] && file_exists($row_image['imagem'])) {
            unlink($row_image['imagem']);
        }
    }

    // Agora, excluir o produto
    $sql = "DELETE FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Produto excluído com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir produto: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>