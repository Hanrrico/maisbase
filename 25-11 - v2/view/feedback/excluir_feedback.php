<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_permissao'] != 'admin') {
    header('Location: ../view/login.php');
    exit();
}

require_once '../model/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario_id'])) {
    $comentario_id = filter_var($_POST['comentario_id'], FILTER_VALIDATE_INT);
    
    if ($comentario_id) {
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("DELETE FROM feedbacks WHERE id = ?");
            $stmt->execute([$comentario_id]);
            
            $pdo->commit();
            
            $_SESSION['mensagem_sucesso'] = 'Comentário excluído com sucesso!';
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $_SESSION['mensagem_erro'] = 'Erro ao excluir comentário: ' . $e->getMessage();
        }
    } else {
        $_SESSION['mensagem_erro'] = 'ID do comentário inválido.';
    }
} else {
    $_SESSION['mensagem_erro'] = 'Requisição inválida.';
}

header('Location: ../view/admin-comentarios.php');
exit();

// Exibir mensagens de sucesso/erro
if (isset($_SESSION['mensagem_sucesso'])) {
    echo '<div class="mensagem-sucesso">' . $_SESSION['mensagem_sucesso'] . '</div>';
    unset($_SESSION['mensagem_sucesso']);
}

if (isset($_SESSION['mensagem_erro'])) {
    echo '<div class="mensagem-erro">' . $_SESSION['mensagem_erro'] . '</div>';
    unset($_SESSION['mensagem_erro']);
}
?>