
async function listarProdutos() {
    const fd = new FormData();
    fd.append('acao', 'listar');
    const res = await ajaxForm('/ajax/produto_ajax.php', fd);
    const grid = document.getElementById('produtos-grid');
    grid.innerHTML = '';
    (res || []).forEach(p => {
      const card = document.createElement('div');
      card.className = 'product-card';
      const imgSrc = p.imagem ? '/uploads/' + htmlescape(p.imagem) : '/img/placeholder.png';
      card.innerHTML = `
        <div class="product-image">${imgSrc}</div>
        <div class="product-info">
          <h3 class="product-title">${htmlescape(p.nome)}</h3>
          <p class="product-description">${htmlescape(p.descricao || '')}</p>
          <div class="product-price">R$ ${Number(p.preco).toFixed(2)}</div>
          <button class="btn" data-id="${p.id_produto}">Adicionar ao Carrinho</button>
        </div>`;
      card.querySelector('button').addEventListener('click', () => adicionarAoCarrinho(p.id_produto));
      grid.appendChild(card);
    });
  }
  
  async function adicionarAoCarrinho(id) {
    const fd = new FormData();
    fd.append('acao', 'adicionar');
    fd.append('id_produto', id);
    fd.append('qtd', 1);
    fd.append('csrf_token', csrfToken());
    const res = await ajaxForm('/ajax/carrinho_ajax.php', fd);
    alert(res && res.success ? 'Produto adicionado!' : 'Erro ao adicionar');
  }
  
  async function listarCarrinho() {
    // Implementar lógica para listar itens do carrinho via AJAX
  }
  