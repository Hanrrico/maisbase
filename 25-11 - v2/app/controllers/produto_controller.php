
<?php
// app/controllers/produto_controller.php
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/produto.php';

class ProdutoController {
    private $produtoModel;

    public function __construct() {
        $this->produtoModel = new Produto();
    }

    public function listar() {
        return $this->produtoModel->listarTodos();
    }

    public function cadastrar($dados) {
        return $this->produtoModel->cadastrar(
            $dados['nome'],
            $dados['descricao'],
            $dados['preco'],
            $dados['estoque'],
            $dados['categoria'],
            $dados['imagem'] ?? null
        );
    }

    public function atualizar($dados) {
        return $this->produtoModel->atualizar(
            $dados['id'],
            $dados['nome'],
            $dados['descricao'],
            $dados['preco'],
            $dados['estoque'],
            $dados['categoria'],
            $dados['imagem'] ?? null
        );
    }

    public function excluir($id) {
        return $this->produtoModel->excluir($id);
    }
}
