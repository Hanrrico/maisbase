
<?php require_once __DIR__ . '/../../view/helpers/header.php'; ?>
/assets/css/admin.css
/assets/css/admin_feedbacks.css

<section class="container">
  <h2>Painel de Feedbacks</h2>
  <div id="feedback-admin"></div>
  <div class="tab-navigation">
    <button class="tab-button active" data-tab="tab-lista">Lista de Feedbacks</button>
    <button class="tab-button" data-tab="tab-novo">Novo Feedback</button>
  </div>
  <div id="tab-lista" class="tab-content active">
    <ul id="lista-feedbacks"></ul>
  </div>
  <div id="tab-novo" class="tab-content">
    <form id="form-feedback" class="form-card" style="max-width:520px;">
      <label>Seu feedback
        <textarea id="comentario" name="comentario" rows="4" maxlength="300" required></textarea>
      </label>
      <div id="contador" class="msg">0/300 caracteres</div>
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
      <button type="submit" class="btn">Enviar</button>
      <p id="feedback-msg" class="msg"></p>
    </form>
  </div>
</section>

/js/feedbacks.js</script>
<script>
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById(btn.dataset.tab).classList.add('active');
    });
  });
  document.addEventListener('DOMContentLoaded', () => {
    listarFeedbacks();
    enviarFeedback();
    atualizarContadorCaracteres();
  });
</script>
<?php require_once __DIR__ . '/../../view/helpers/footer.php'; ?>
