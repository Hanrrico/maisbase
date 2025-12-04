<?php
header('Content-Type: application/json');
header('Content-Type: application/json');

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'aryloja';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comentario = trim($_POST['comentario'] ?? '');
        
        // Validações
        if (empty($comentario)) {
            echo json_encode(['success' => false, 'error' => 'Comentário não pode estar vazio.']);
            exit;
        }
        
        if (strlen($comentario) > 300) {
            echo json_encode(['success' => false, 'error' => 'Comentário excede 300 caracteres.']);
            exit;
        }
        
        // Inserir no banco
        $stmt = $pdo->prepare("INSERT INTO feedbacks (comentario) VALUES (:comentario)");
        $stmt->bindParam(':comentario', $comentario);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados.']);
        }
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro de conexão: ' . $e->getMessage()]);
}
?>