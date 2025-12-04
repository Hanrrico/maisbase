
<?php
// app/models/Usuario.php
class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function login($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function cadastrar($nome, $email, $senha) {
        // Verificar se email já existe
        $sqlCheck = "SELECT id_usuario FROM usuarios WHERE email=?";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([$email]);

        if ($stmtCheck->rowCount() > 0) {
            return false; // Email já existe
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha, permissao) VALUES (?, ?, ?, 'usuario')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $senhaHash]);
    }

    public function listarUsuarios() {
        $sql = "SELECT id_usuario, nome, email, permissao, data_cadastro FROM usuarios";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
