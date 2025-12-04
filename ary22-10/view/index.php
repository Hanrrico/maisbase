<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// CONEXÃO - método um pouco mais seguro
try {
    $host = 'localhost';
    $dbname = 'aryloja';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Classe Produto
    require_once '../model/Produto.php';
    
    // Buscar produtos do banco de dados
    $produtoModel = new Produto($pdo);
    $produtos = $produtoModel->listarTodos();
    
} catch (PDOException $e) {
    die("Erro de conexão com o banco: " . $e->getMessage());
} catch (Exception $e) {
    $produtos = [];
    $erro = "Erro ao carregar produtos: " . $e->getMessage();
}

// Inicializar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/carrinho.css">
    <title>Ary Bordados</title>
</head>
<body>
    <header>
<nav>
    <div class="logo">Ary bordados</div>
    <ul class="nav-links">
        <li><a href="#hero">Início</a></li>
        <li><a href="carrinho.php">Carrinho (<?php echo count($_SESSION['carrinho']); ?>)</a></li>
        <?php if (isset($_SESSION['usuario_permissao']) && $_SESSION['usuario_permissao'] == 'admin'): ?>
            <li><a href="telaadmin.php">Administração</a></li>
        <?php endif; ?>
        <li><a href="../control/logout_controller.php">Sair</a></li>
    </ul>
</nav>
    </header>
    
    <main>
        <section class="hero" id="hero">
            <h1>Ary Bordados e Costuras Criativas</h1>
            <p>Bem-vinda(o) ao meu cantinho, onde a agulha e a linha dançam para transformar sonhos e memórias em peças únicas e cheias de significado. Aqui, a costura e o bordado vão além do simples: são uma forma de arte, de carinho e de expressão.</p>
        </section>
        
        <section class="products">
            <h2 class="section-title">Produtos</h2>
            
            <?php if (isset($erro)): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="sucesso"><?php echo htmlspecialchars($_GET['sucesso']); ?></div>
            <?php endif; ?>
            
            <div class="products-grid">
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($produto['imagem'])): ?>
                                    <img src="../uploads/<?php echo $produto['imagem']; ?>" 
                                        alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                <?php else: ?>
                                    <div class="placeholder-image">Imagem do Produto</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                <p class="product-description"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                                <p class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                <?php if ($produto['estoque'] > 0): ?>
                                    <p class="product-stock">Em estoque: <?php echo $produto['estoque']; ?> unidades</p>
                                    <form action="../control/adicionar_carrinho.php" method="post" class="carrinho-form">
                                        <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']; ?>">
                                        <input type="hidden" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>">
                                        <input type="hidden" name="preco" value="<?php echo $produto['preco']; ?>">
                                        <input type="hidden" name="imagem" value="<?php echo $produto['imagem']; ?>">
                                        <div class="quantidade-container">
                                            <label for="quantidade_<?php echo $produto['id_produto']; ?>">Quantidade:</label>
                                            <input type="number" id="quantidade_<?php echo $produto['id_produto']; ?>" 
                                                name="quantidade" value="1" min="1" max="<?php echo $produto['estoque']; ?>">
                                        </div>
                                        <button type="submit" class="btn-carrinho">Adicionar ao Carrinho</button>
                                    </form>
                                <?php else: ?>
                                    <p class="product-stock out-of-stock">Fora de estoque</p>
                                    <button class="btn-carrinho disabled" disabled>Indisponível</button>
                                <?php endif; ?>
                                <?php if (!empty($produto['categoria'])): ?>
                                    <p class="product-category">Categoria: <?php echo htmlspecialchars($produto['categoria']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-products">Nenhum produto cadastrado no momento.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    
<br>
<div id="contato"> 
    <h2>Entre em Contato</h2>
    <p>Fale comigo pelo WhatsApp, Instagram ou redes sociais abaixo.</p>
</div>

<footer>
    <div class="footer-content">
        <p>Ary Bordados &copy; 2025 - Todos os direitos reservados</p>
        <ul class="contato" style="list-style: none; padding: 0; margin: 0;">
            <li><a href="">Whatsapp</a></li>
            <li><a href="https://www.instagram.com/ary_bordadosgr">
                <img src="../img/insta.png" alt="Instagram Ary Bordados" width="40" height="40">
            </a></li>
            <li><a href="#contato">Facebook</a></li>
        </ul>
    </div>
</footer>

</body>
</html>