<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Inicializar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Calcular total
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/carrinho.css">
    <title>Carrinho de Compras - Ary Bordados</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Ary bordados</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="#contato">Contato</a></li>
                <li><a href="carrinho.php">Carrinho (<?php echo count($_SESSION['carrinho']); ?>)</a></li>
                <?php if (isset($_SESSION['usuario_permissao']) && $_SESSION['usuario_permissao'] == 'admin'): ?>
                    <li><a href="telaadmin.php">Administração</a></li>
                <?php endif; ?>
                <li><a href="../control/logout_controller.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    
    <main class="carrinho-container">
        <h1>Seu Carrinho de Compras</h1>
        
        <?php if (count($_SESSION['carrinho']) > 0): ?>
            <?php foreach ($_SESSION['carrinho'] as $index => $item): ?>
                <div class="carrinho-item">
                    <div class="carrinho-item-imagem">
                        <?php if (!empty($item['imagem'])): ?>
                            <img src="../uploads/<?php echo $item['imagem']; ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                        <?php else: ?>
                            <div class="placeholder-imagem-carrinho">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carrinho-item-info">
                        <div class="carrinho-item-nome"><?php echo htmlspecialchars($item['nome']); ?></div>
                        <div class="carrinho-item-preco">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?> cada</div>
                        <div class="carrinho-item-subtotal">
                            Subtotal: R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?>
                        </div>
                        
                        <form action="../control/atualizar_carrinho.php" method="post" class="carrinho-controles">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            
                            <div class="quantidade-controle">
                                <label for="quantidade_<?php echo $index; ?>">Quantidade:</label>
                                <input type="number" id="quantidade_<?php echo $index; ?>" 
                                       name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1">
                            </div>
                            
                            <button type="submit" class="btn-atualizar">Atualizar</button>
                        </form>
                    </div>
                    
                    <form action="../control/remover_carrinho.php" method="post">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="btn-remover">Remover</button>
                    </form>
                </div>
            <?php endforeach; ?>
            
            <div class="carrinho-total">
                <h2>Resumo do Pedido</h2>
                
                <div class="resumo-valores">
                    <div class="linha-resumo total-geral">
                        <span><strong>Total dos produtos:</strong></span>
                        <span><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></span>
                    </div>
                </div>
                
                <div class="instrucoes-finalizacao">
                    <p>💳 <strong>Formas de pagamento aceitas:</strong> PIX, Cartão de Crédito/Débito ou Dinheiro</p>
                    <p>📦 <strong>Frete e prazo de entrega:</strong> Serão combinados diretamente no WhatsApp</p>
                    <p>🎁 <strong>Embalagem especial:</strong> Todos os produtos são entregues com cuidado e carinho</p>
                </div>
                
                <div class="acoes-carrinho">
                    <a href="index.php" class="btn-continuar">Continuar Comprando</a>
                    <a href="../control/finalizar_pedido.php" class="btn-finalizar">
                        <span class="whatsapp-icon">📱</span> Finalizar Pedido via WhatsApp
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="carrinho-vazio">
                <h2>Seu carrinho está vazio</h2>
                <p>Que tal dar uma olhada nos nossos produtos?</p>
                <a href="index.php" class="btn-continuar" style="margin-top: 1rem;">Ver Produtos</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>