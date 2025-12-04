
<?php require_once __DIR__ . '/../../view/helpers/header.php'; ?>
/assets/css/admin.css

<section class="container">
  <h2>Painel de Administração</h2>
  <div class="admin-cards">
    <div class="card">
      <h3>Gerenciar Produtos</h3>
      <p>Adicione, edite ou remova produtos do catálogo.</p>
      /admin/produtos.phpAdministrar Produtos</a>
    </div>
    <div class="card">
      <h3>Gerenciar Usuários</h3>
      <p>Visualize e gerencie os usuários do sistema.</p>
      /admin/usuarios.phpAdministrar Usuários</a>
    </div>
    <div class="card">
      <h3>Gerenciar Feedbacks</h3>
      <p>Visualize e gerencie os feedbacks dos clientes.</p>
      /admin/feedbacks.phpAdministrar Feedbacks</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../../view/helpers/footer.php'; ?>
