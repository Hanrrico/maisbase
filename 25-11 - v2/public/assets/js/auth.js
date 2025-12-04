
(function(){
    const sair = document.getElementById('btn-sair');
    if (sair) {
      sair.addEventListener('click', async (e) => {
        e.preventDefault();
        const fd = new FormData();
        fd.append('acao', 'logout');
        fd.append('csrf_token', csrfToken());
        await ajaxForm('/ajax/usuario_ajax.php', fd);
        window.location.href = '/index.php';
      });
    }
  })();
  