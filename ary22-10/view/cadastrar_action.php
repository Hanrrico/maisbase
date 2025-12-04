<?php
// Habilitar exibição de erros para debugging (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar ao banco
require_once '../model/conexao.php';

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar e sanitizar os dados
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = floatval($_POST['preco']);
    $estoque = intval($_POST['estoque']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
    
    // Processar upload da imagem
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
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload da imagem.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Formato de imagem não permitido. Use JPG, PNG ou GIF.']);
            exit;
        }
    }
    
    // Inserir no banco
    $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria, imagem) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssdiss", $nome, $descricao, $preco, $estoque, $categoria, $imagem);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Produto cadastrado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar produto: ' . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da query: ' . $conn->error]);
    }
    
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>