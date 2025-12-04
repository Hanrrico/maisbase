<?php

class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarTodos() {
        $sql = "SELECT id_produto, nome, descricao, preco, estoque, categoria, imagem, data_cadastro 
                FROM produtos 
                ORDER BY data_cadastro DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $descricao, $preco, $estoque, $categoria, $imagem = null) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria, imagem) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria, $imagem]);
    }

    public function atualizar($id_produto, $nome, $descricao, $preco, $estoque, $categoria, $imagem = null) {
        if ($imagem) {
            $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, categoria = ?, imagem = ? 
                    WHERE id_produto = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria, $imagem, $id_produto]);
        } else {
            $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, categoria = ? 
                    WHERE id_produto = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria, $id_produto]);
        }
    }

    public function excluir($id_produto) {
        $sql = "DELETE FROM produtos WHERE id_produto = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_produto]);
    }

    public function buscarPorId($id_produto) {
        $sql = "SELECT * FROM produtos WHERE id_produto = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_produto]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}