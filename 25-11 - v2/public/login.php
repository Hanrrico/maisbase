
<?php require_once __DIR__ . '/../view/helpers/header.php'; ?>
/assets/css/login.css

<div class="login-box">
  <h2>Login</h2>
  <form id="form-login">
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" required />
    </div>
    <div class="form-group">
      <label>Senha:</label>
      <input type="password" name="senha" required />
    </div>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
    <button type="submit">Acessar</button>
    <div class="register-link">
      <p>Não tem conta?</p>
      /cadastrar.phpCadastre-se</a>
    </div>
    <p id="login-msg" class="msg"></p>
  </form>
</div>

<script>
document.getElementById('form-login').addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append('acao', 'login');
  const res = await ajaxForm('/ajax/usuario_ajax.php', fd);
  const msg = document.getElementById('login-msg');
  if (res && res.success) {
    msg.textContent = 'Login realizado!';
    setTimeout(() => window.location.href = '/index.php', 800);
  } else {
    msg.textContent = res?.error || 'Erro ao logar';
  }
});
</script>

<?php require_once __DIR__ . '/../view/helpers/footer.php'; ?>
