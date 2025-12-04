
<?php require_once __DIR__ . '/../view/helpers/header.php'; ?>
/assets/css/index.css

<section class="hero">
  <h1>Ary Bordados e Costuras Criativas</h1>
  <p>Bem-vindo(a) ao meu cantinho, onde a agulha e a linha dançam para transformar sonhos e memórias em peças únicas e cheias de significado.</p>
</section>

<section class="products">
  <h2 class="section-title">Produtos</h2>
  <div id="produtos-grid" class="products-grid"></div>
</section>

/js/produtos.js</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    listarProdutos();
  });
</script>

<?php require_once __DIR__ . '/../view/helpers/footer.php'; ?>
