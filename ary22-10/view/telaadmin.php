<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_permissao'] != 'admin') {
    header('Location: login.php');
    exit();
}
require_once '../model/conexao.php';
require_once '../model/Usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ary Bordados - Administração</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .admin-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .admin-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .admin-card h3 {
            color: #c86c7f;
            margin-bottom: 15px;
        }
        .admin-card p {
            color: #666;
            margin-bottom: 20px;
        }
        .btn-admin {
            background-color: #c86c7f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-admin:hover {
            background-color: #a44f62;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="navbar-brand">Ary Bordados</a>
    <ul>
        <li><a href="index.php">Ver Catálogo</a></li>
        <li><a href="../control/logout_controller.php">Sair</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Painel de Administração</h2>
    <p>Bem-vinda, <?php echo $_SESSION['usuario_nome']; ?>!</p>
    
    <div class="admin-dashboard">
        <div class="admin-card">
            <h3>Gerenciar Produtos</h3>
            <p>Adicione, edite ou remova produtos do catálogo.</p>
            <a href="admin-produtos.php" class="btn-admin">Administrar Produtos</a>
        </div>
        
        <div class="admin-card">
            <h3>Gerenciar Usuários</h3>
            <p>Visualize e gerencie os usuários do sistema.</p>
            <a href="admin-usuarios.php" class="btn-admin">Administrar Usuários</a>
        </div>
    </div>
</div>

</body>
</html>