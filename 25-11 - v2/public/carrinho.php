
<?php require_once __DIR__ . '/../view/helpers/header.php'; ?>
/assets/css/carrinho.css

<section class="carrinho-container">
  <h2>Seu Carrinho de Compras</h2>
  <div id="carrinho-itens"></div>
  <div id="carrinho-total"></div>
</section>

/js/produtos.js</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  listarCarrinho();
});
</script>

<?php require_once __DIR__ . '/../view/helpers/footer.php'; ?>
