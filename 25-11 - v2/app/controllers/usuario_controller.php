
<?php
// app/controllers/usuario_controller.php
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function login($email, $senha) {
        return $this->usuarioModel->login($email, $senha);
    }

    public function cadastrar($dados) {
        return $this->usuarioModel->cadastrar($dados['nome'], $dados['email'], $dados['senha']);
    }

    public function listar() {
        return $this->usuarioModel->listarUsuarios();
    }

    public function excluir($id) {
        return $this->usuarioModel->excluirUsuario($id);
    }
}
