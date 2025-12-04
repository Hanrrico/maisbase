
<?php
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/feedback.php';

class FeedbackController {
    private $model;

    public function __construct() {
        $this->model = new Feedback();
    }

    public function listar() {
        return $this->model->listarTodos();
    }

    public function salvar($dados) {
        $comentario = $dados['comentario'] ?? '';
        $comentario = trim($comentario);

        if ($comentario === '') {
            return ['success' => false, 'error' => 'Comentário não pode estar vazio.'];
        }
        if (mb_strlen($comentario) > 300) {
            return ['success' => false, 'error' => 'Comentário excede 300 caracteres.'];
        }

        $ok = $this->model->salvar($comentario);
        return ['success' => $ok];
    }

    public function excluir($id) {
        if (!is_numeric($id)) {
            return ['success' => false, 'error' => 'ID inválido'];
        }
        $ok = $this->model->excluir((int)$id);
        return ['success' => $ok];
    }
}
