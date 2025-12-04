<?php
session_start();
require_once '../model/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = floatval($_POST['preco']);
    $estoque = intval($_POST['estoque']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);

    // Se uma nova imagem foi enviada, processá-la
    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($extensao, $extensoesPermitidas)) {
            $nomeImagem = uniqid() . '.' . $extensao;
            $caminhoImagem = $uploadDir . $nomeImagem;
            
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                $imagem = $caminhoImagem;
                // Remover a imagem antiga se existir
                $sql_old_image = "SELECT imagem FROM produtos WHERE id_produto = $id";
                $result_old_image = $conn->query($sql_old_image);
                if ($result_old_image->num_rows > 0) {
                    $row_old_image = $result_old_image->fetch_assoc();
                    if ($row_old_image['imagem'] && file_exists($row_old_image['imagem'])) {
                        unlink($row_old_image['imagem']);
                    }
                }
            }
        }
    }

    // Montar a query de update
    if ($imagem) {
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria=?, imagem=? WHERE id_produto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdissi", $nome, $descricao, $preco, $estoque, $categoria, $imagem, $id);
    } else {
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria=? WHERE id_produto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nome, $descricao, $preco, $estoque, $categoria, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar produto: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>