
<?php require_once __DIR__ . '/../../view/helpers/header.php'; ?>
/assets/css/admin.css

<section class="container">
  <h2>Gerenciamento de Usuários</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Nome</th><th>Email</th><th>Permissão</th><th>Data</th><th>Ações</th>
      </tr>
    </thead>
    <tbody id="tbody-usuarios"></tbody>
  </table>
</section>

<script>
document.addEventListener('DOMContentLoaded', async () => {
  const fd = new FormData();
  fd.append('acao', 'listar');
  const res = await ajaxForm('/ajax/usuario_ajax.php', fd);
  const tbody = document.getElementById('tbody-usuarios');
  tbody.innerHTML = '';
  (res || []).forEach(u => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${u.id_usuario}</td>
      <td>${htmlescape(u.nome)}</td>
      <td>${htmlescape(u.email)}</td>
      <td>${u.permissao}</td>
      <td>${u.data_cadastro}</td>
      <td><button class="btn btn-danger" data-id="${u.id_usuario}">Excluir</button></td>`;
    tr.querySelector('button').addEventListener('click', async () => {
      if (!confirm('Excluir usuário?')) return;
      const fdDel = new FormData();
      fdDel.append('acao', 'excluir');
      fdDel.append('id', u.id_usuario);
      fdDel.append('csrf_token', csrfToken());
      const r = await ajaxForm('/ajax/usuario_ajax.php', fdDel);
      if (r && r.success) tr.remove();
    });
    tbody.appendChild(tr);
  });
});
</script>

<?php require_once __DIR__ . '/../../view/helpers/footer.php'; ?>
