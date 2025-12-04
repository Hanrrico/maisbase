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
    <title>Admin - Usuários</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<nav class="navbar">
    <a href="telaadmin.php" class="navbar-brand">Ary Bordados</a>
    <ul>
        <li><a href="telaadmin.php">Voltar</a></li>
        <li><a href="index.php">Ver Catálogo</a></li>
        <li><a href="../control/logout_controller.php">Sair</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Gerenciamento de Usuários</h2>
    
    <div id="alertBox" class="alert"></div>

    <table id="usersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Permissão</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os usuários serão carregados aqui via JavaScript -->
        </tbody>
    </table>
</div>

<script>
// Função para carregar os usuários na tabela
function loadUsers() {
    fetch('../control/listar_usuarios.php')
        .then(response => response.json())
        .then(users => {
            const tbody = document.querySelector('#usersTable tbody');
            tbody.innerHTML = '';
            
            users.forEach(user => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${user.id_usuario}</td>
                    <td>${user.nome}</td>
                    <td>${user.email}</td>
                    <td>${user.permissao}</td>
                    <td>${new Date(user.data_cadastro).toLocaleDateString()}</td>
                    <td class="action-buttons">
                        <button class="btn-danger" onclick="deleteUser(${user.id_usuario})">Excluir</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Erro ao carregar usuários:', error);
        });
}

// Função para excluir usuário
function deleteUser(id) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('../control/excluir_usuario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadUsers();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao excluir usuário:', error);
        });
    }
}

// Carregar usuários quando a página for carregada
document.addEventListener('DOMContentLoaded', loadUsers);
</script>

</body>
</html>