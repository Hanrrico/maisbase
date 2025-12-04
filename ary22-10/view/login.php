<?php
session_start();
// Se já estiver logado, redireciona para a página apropriada
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['usuario_permissao'] == 'admin') {
        header('Location: telaadmin.php');
    } else {
        header('Location: index.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ary Bordados - Login</title>
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>
    
    <?php if (isset($_GET['erro'])): ?>
      <div style="color: red; margin-bottom: 15px; text-align: center;">
        Email ou senha incorretos!
      </div>
    <?php endif; ?>

    <!-- MUDEI A ACTION AQUI -->
    <form action="../control/login_controller.php" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      <div class="checkbox">
        <label><input type="checkbox" name="lembrar"> Lembre de mim</label>
      </div>
      <button type="submit">Acessar</button>
    </form>

    <div class="register-link">
      <p>Não tem conta?</p>
      <a href="cadastrousuario.php" class="btn-cadastrar">Cadastre-se</a>
    </div>
  </div>

</body>
</html>