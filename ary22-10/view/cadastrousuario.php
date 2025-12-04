<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ary Bordados - Cadastro</title>
  <link rel="stylesheet" href="../css/cadastrar.css">
</head>
<body>

  <div class="register-box">
    <h2>Criar Conta</h2>
    
    <?php if (isset($_GET['erro'])): ?>
      <div style="color: red; margin-bottom: 15px; text-align: center;">
        Erro ao cadastrar. Email já existe ou dados inválidos.
      </div>
    <?php endif; ?>

    <form action="../control/cadastro_controller.php" method="post">
      <div class="form-group">
        <label for="nome">Nome completo:</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      <div class="form-group">
        <label for="confirmar_senha">Confirmar Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>
      </div>
      <button type="submit">Cadastrar</button>
    </form>

    <div class="login-link">
      <p>Já tem conta?</p>
      <a href="login.php" class="btn-login">Voltar ao Login</a>
    </div>
  </div>

  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      var senha = document.getElementById('senha').value;
      var confirmarSenha = document.getElementById('confirmar_senha').value;
      
      if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não coincidem!');
        return false;
      }
      
      if (senha.length < 6) {
        e.preventDefault();
        alert('A senha deve ter pelo menos 6 caracteres!');
        return false;
      }
    });
  </script>

</body>
</html>