<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_permissao'] != 'admin') {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ary Bordados - Gerenciar Comentários</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .comentarios-container {
            margin-top: 30px;
        }
        .comentario-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 4px solid #c86c7f;
        }
        .comentario-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
        }
        .comentario-data {
            color: #666;
            font-size: 14px;
        }
        .comentario-texto {
            color: #333;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .btn-excluir {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-excluir:hover {
            background-color: #c82333;
        }
        .sem-comentarios {
            text-align: center;
            color: #666;
            padding: 40px;
            background: white;
            border-radius: 10px;
        }
        .admin-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="navbar-brand">Ary Bordados</a>
    <ul>
        <li><a href="admin.php">Painel Admin</a></li>
        <li><a href="index.php">Ver Catálogo</a></li>
        <li><a href="../control/logout_controller.php">Sair</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Gerenciar Comentários</h2>
    <p>Bem-vinda, <?php echo $_SESSION['usuario_nome']; ?>! Aqui você pode gerenciar os comentários dos clientes.</p>
    
    <div class="comentarios-container">
        <?php
        try {
            // Buscar todos os comentários
            $stmt = $pdo->query("SELECT * FROM feedbacks ORDER BY data_criacao DESC");
            $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($comentarios) > 0) {
                foreach ($comentarios as $comentario) {
                    echo '
                    <div class="comentario-card">
                        <div class="comentario-header">
                            <div class="comentario-data">
                                ' . date('d/m/Y H:i', strtotime($comentario['data_criacao'])) . '
                            </div>
                            <div class="admin-actions">
                                <button class="btn-excluir" onclick="confirmarExclusao(' . $comentario['id'] . ')">
                                    Excluir Comentário
                                </button>
                            </div>
                        </div>
                        <div class="comentario-texto">
                            ' . htmlspecialchars($comentario['comentario']) . '
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="sem-comentarios">
                    <h3>Nenhum comentário encontrado</h3>
                    <p>Não há comentários para exibir no momento.</p>
                </div>';
            }
        } catch (PDOException $e) {
            echo '<div class="sem-comentarios">
                <h3>Erro ao carregar comentários</h3>
                <p>Ocorreu um erro ao carregar os comentários. Tente novamente.</p>
            </div>';
        }
        ?>
    </div>
</div>

<script>
function confirmarExclusao(comentarioId) {
    if (confirm('Tem certeza que deseja excluir este comentário? Esta ação não pode ser desfeita.')) {
        excluirComentario(comentarioId);
    }
}

function excluirComentario(comentarioId) {
    // Criar um formulário dinâmico para enviar via POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../control/excluir_comentario_controller.php';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'comentario_id';
    input.value = comentarioId;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>

</body>
</html>