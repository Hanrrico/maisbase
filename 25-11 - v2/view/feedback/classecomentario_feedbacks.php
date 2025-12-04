<?php
class Comentario {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM feedbacks ORDER BY data_criacao DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM feedbacks WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM feedbacks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>