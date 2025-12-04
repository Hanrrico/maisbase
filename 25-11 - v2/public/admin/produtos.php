
<?php require_once __DIR__ . '/../../view/helpers/header.php'; ?>
/assets/css/adminprod.css

<section class="container">
  <h2>Gerenciamento de Produtos</h2>
  <div class="tab-navigation">
    <button class="tab-button active" data-tab="tab-cadastrar">Cadastrar Produto</button>
    <button class="tab-button" data-tab="tab-lista">Lista de Produtos</button>
  </div>

  <div id="tab-cadastrar" class="tab-content active">
    <form id="form-produto">
      <input type="hidden" name="id" />
      <div class="form-group">
        <label>Nome:</label>
        <input type="text" name="nome" required />
      </div>
      <div class="form-group">
        <label>Descrição:</label>
        <textarea name="descricao"></textarea>
      </div>
      <div class="form-group">
        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" required />
      </div>
      <div class="form-group">
        <label>Estoque:</label>
        <input type="number" name="estoque" required />
      </div>
      <div class="form-group">
        <label>Categoria:</label>
        <input type="text" name="categoria" />
      </div>
      <div class="form-group">
        <label>Imagem:</label>
        <input type="file" name="imagem_file" accept="image/*" />
      </div>
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
      <button type="submit" class="btn">Salvar</button>
      <button type="button" id="btn-limpar" class="btn btn-secondary">Limpar</button>
      <p id="produto-msg" class="msg"></p>
    </form>
  </div>

  <div id="tab-lista" class="tab-content">
    <table>
      <thead>
        <tr>
          <th>Imagem</th><th>Nome</th><th>Preço</th><th>Estoque</th><th>Ações</th>
        </tr>
      </thead>
      <tbody id="tbody-produtos"></tbody>
    </table>
  </div>
</section>

/js/produtos.js</script>
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
  listarProdutosAdmin();
});

document.getElementById('form-produto').addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  const id = fd.get('id');
  const file = fd.get('imagem_file');
  if (file && file.name) fd.append('imagem', file.name);
  fd.delete('imagem_file');
  fd.append('acao', id ? 'atualizar' : 'cadastrar');
  const res = await ajaxForm('/ajax/produto_ajax.php', fd);
  const msg = document.getElementById('produto-msg');
  msg.textContent = res && res.success ? 'Produto salvo!' : (res.error || 'Erro ao salvar');
  if (res.success) {
    e.target.reset();
    listarProdutosAdmin();
  }
});

document.getElementById('btn-limpar').addEventListener('click', () => {
  document.getElementById('form-produto').reset();
  document.querySelector('#form-produto [name=id]').value = '';
});
</script>

<?php require_once __DIR__ . '/../../view/helpers/footer.php'; ?>
