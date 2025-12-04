
<?php
require_once __DIR__ . '/database.php';

class Feedback {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function listarTodos() {
        $sql = "SELECT id, comentario, data_criacao FROM feedbacks ORDER BY data_criacao DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($comentario) {
        $sql = "INSERT INTO feedbacks (comentario) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([trim($comentario)]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM feedbacks WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
