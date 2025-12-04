
<?php
// app/models/Produto.php
class Produto {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function listarTodos() {
        $sql = "SELECT id_produto, nome, descricao, preco, estoque, categoria, imagem, data_cadastro FROM produtos ORDER BY data_cadastro DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $descricao, $preco, $estoque, $categoria, $imagem = null) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria, imagem) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria, $imagem]);
    }

    public function atualizar($id, $nome, $descricao, $preco, $estoque, $categoria, $imagem = null) {
        if ($imagem) {
            $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria=?, imagem=? WHERE id_produto=?";
            $params = [$nome, $descricao, $preco, $estoque, $categoria, $imagem, $id];
        } else {
            $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria=? WHERE id_produto=?";
            $params = [$nome, $descricao, $preco, $estoque, $categoria, $id];
        }
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function excluir($id) {
        $sql = "DELETE FROM produtos WHERE id_produto=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM produtos WHERE id_produto=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
