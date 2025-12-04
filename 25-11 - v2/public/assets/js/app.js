
function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
  }
  
  async function ajaxForm(url, formData) {
    if (!formData.has('csrf_token')) formData.append('csrf_token', csrfToken());
    try {
      const res = await fetch(url, { method: 'POST', body: formData });
      return await res.json();
    } catch (e) {
      console.error('ajaxForm error', e);
      return { success: false, error: 'Erro de rede' };
    }
  }
  
  function htmlescape(str) {
    const div = document.createElement('div');
    div.textContent = (str ?? '').toString();
    return div.innerHTML;
  }
  