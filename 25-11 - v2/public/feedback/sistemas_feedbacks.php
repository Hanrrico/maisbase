
<?php require_once __DIR__ . '/../../view/helpers/header.php'; ?>
/assets/css/style.css

<section class="container" style="background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,.1); padding:24px;">
  <h2 style="color:#c86c7f; text-align:center;">Feedbacks dos Clientes</h2>
  <ul id="lista-feedbacks" style="list-style:none; padding:0; display:grid; gap:12px;"></ul>
  <hr style="margin:24px 0; border:none; border-top:1px solid #eee;" />
  <h3 style="color:#5a4a42;">Deixe seu Feedback</h3>
  <form id="form-feedback" class="form-card" style="max-width:520px;">
    <label>Seu feedback
      <textarea id="comentario" name="comentario" rows="4" maxlength="300" required></textarea>
    </label>
    <div id="contador" class="msg">0/300 caracteres</div>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
    <button type="submit" class="btn">Enviar</button>
    <p id="feedback-msg" class="msg"></p>
  </form>
</section>

/js/feedbacks.js</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    listarFeedbacks();
    enviarFeedback();
    atualizarContadorCaracteres();
  });
</script>
<?php require_once __DIR__ . '/../../view/helpers/footer.php'; ?>
