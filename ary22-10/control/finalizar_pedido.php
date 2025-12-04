<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    header('Location: ../view/carrinho.php');
    exit();
}

// Calcular total
$total = 0;
$itens_pedido = "";

foreach ($_SESSION['carrinho'] as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
    $itens_pedido .= "• {$item['nome']} - Quantidade: {$item['quantidade']} - R$ " . number_format($item['preco'], 2, ',', '.') . " cada\n";
}

// Nome do usuário (pegando da sessão)
$nome_usuario = $_SESSION['usuario_nome'] ?? 'Cliente';

// Criar mensagem para WhatsApp
$mensagem = "🛍️ *PEDIDO - ARY BORDADOS* 🛍️\n\n";
$mensagem .= "*Cliente:* $nome_usuario\n\n";
$mensagem .= "*ITENS DO PEDIDO:*\n$itens_pedido\n";
$mensagem .= "*VALOR TOTAL: R$ " . number_format($total, 2, ',', '.') . "*\n\n";
$mensagem .= "💳 *Formas de pagamento aceitas:* PIX, Cartão ou Dinheiro\n\n";
$mensagem .= "🚚 *Frete e prazo de entrega:* Serão combinados após confirmação do endereço\n\n";
$mensagem .= "--- *DADOS PARA ENTREGA* ---\n";
$mensagem .= "📬 *Endereço de Entrega:*\n";
$mensagem .= "   Rua: _________________\n";
$mensagem .= "   Número: ______________\n";
$mensagem .= "   Bairro: ______________\n";
$mensagem .= "   Complemento: __________\n";
$mensagem .= "   Ponto de referência: __\n\n";
$mensagem .= "📞 *Telefone para contato:* _________________\n\n";
$mensagem .= "💬 *Observações:* __________________________";

// Codificar a mensagem para URL
$mensagem_codificada = urlencode($mensagem);

// Número do WhatsApp (substitua pelo número real da Ary Bordados)
$numero_whatsapp = "5511932624664"; // EXEMPLO: substitua pelo número correto

// Redirecionar para WhatsApp
header("Location: https://wa.me/$numero_whatsapp?text=$mensagem_codificada");
exit();
?>