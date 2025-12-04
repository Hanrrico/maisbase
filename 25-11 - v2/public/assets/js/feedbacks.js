
async function listarFeedbacks() {
  const fd = new FormData();
  fd.append('acao', 'listar');
  const res = await ajaxForm('/ajax/feedback_ajax.php', fd);
  const list = document.getElementById('lista-feedbacks');
  if (!list) return;
  list.innerHTML = '';
  if (!res || res.length === 0) {
    list.innerHTML = '<li>Nenhum feedback ainda.</li>';
    return;
  }
  res.forEach(f => {
    const li = document.createElement('li');
    li.className = 'feedback-item';
    const data = new Date(f.data_criacao);
    const dataFmt = isNaN(data) ? f.data_criacao : data.toLocaleString();
    li.innerHTML = `
      <div class="feedback-text">${htmlescape(f.comentario)}</div>
      <div class="feedback-meta">${htmlescape(dataFmt)}</div>`;
    if (document.getElementById('feedback-admin')) {
      const del = document.createElement('button');
      del.textContent = 'Excluir';
      del.className = 'btn btn-danger btn-excluir-feedback';
      del.addEventListener('click', () => excluirFeedback(f.id));
      li.appendChild(del);
    }
    list.appendChild(li);
  });
}

async function enviarFeedback(formId = 'form-feedback') {
  const form = document.getElementById(formId);
  if (!form) return;
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    fd.append('acao', 'salvar');
    const res = await ajaxForm('/ajax/feedback_ajax.php', fd);
    const msg = document.getElementById('feedback-msg');
    if (res && res.success) {
      msg.className = 'mensagem-sucesso';
      msg.textContent = 'Feedback enviado com sucesso!';
      form.reset();
      listarFeedbacks();
      atualizarContadorCaracteres();
    } else {
      msg.className = 'mensagem-erro';
      msg.textContent = res?.error || 'Erro ao enviar feedback';
    }
  });
}

async function excluirFeedback(id) {
  if (!confirm('Excluir este feedback?')) return;
  const fd = new FormData();
  fd.append('acao', 'excluir');
  fd.append('id', id);
  fd.append('csrf_token', csrfToken());
  const res = await ajaxForm('/ajax/feedback_ajax.php', fd);
  if (res && res.success) listarFeedbacks();
  else alert(res?.error || 'Erro ao excluir');
}

function atualizarContadorCaracteres(textareaId = 'comentario', contadorId = 'contador') {
  const ta = document.getElementById(textareaId);
  const c = document.getElementById(contadorId);
  if (!ta || !c) return;
  const max = 300;
  const len = ta.value.length;
  c.textContent = `${len}/${max} caracteres`;
}

document.addEventListener('input', (e) => {
  if ((e.target).id === 'comentario') atualizarContadorCaracteres();
});
