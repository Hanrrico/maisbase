<?php
class Usuario {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function login($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario;
            }
        }
        return false;
    }
    
    public function cadastrar($nome, $email, $senha) {
        // Verificar se email já existe
        $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ?";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            return false; // Email já existe
        }
        
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha, permissao) VALUES (?, ?, ?, 'usuario')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha_hash);
        
        return $stmt->execute();
    }
    
    public function listarUsuarios() {
        $sql = "SELECT id_usuario, nome, email, permissao, data_cadastro FROM usuarios";
        $result = $this->conn->query($sql);
        $usuarios = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }
    
    public function excluirUsuario($id) {
        // Não permitir que o admin exclua a si mesmo
        if (isset($_SESSION['usuario_id']) && $id == $_SESSION['usuario_id']) {
            return false;
        }
        
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>