
<?php require_once __DIR__ . '/../view/helpers/header.php'; ?>
/assets/css/cadastrar.css

<div class="register-box">
  <h2>Cadastrar</h2>
  <form id="form-register">
    <div class="form-group">
      <label>Nome:</label>
      <input type="text" name="nome" required />
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" required />
    </div>
    <div class="form-group">
      <label>Senha:</label>
      <input type="password" name="senha" required minlength="6" />
    </div>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
    <button type="submit">Cadastrar</button>
    <div class="login-link">
      <p>Já tem conta?</p>
      /login.phpEntrar</a>
    </div>
    <p id="register-msg" class="msg"></p>
  </form>
</div>

<script>
document.getElementById('form-register').addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append('acao', 'cadastrar');
  const res = await ajaxForm('/ajax/usuario_ajax.php', fd);
  const msg = document.getElementById('register-msg');
  if (res && res.success) {
    msg.textContent = 'Cadastro realizado! Você já pode entrar.';
    setTimeout(() => window.location.href = '/login.php', 800);
  } else {
    msg.textContent = 'Erro ao cadastrar (email já existe?)';
  }
});
</script>

<?php require_once __DIR__ . '/../view/helpers/footer.php'; ?>
