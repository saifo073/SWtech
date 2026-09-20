<?php
if(!isset($_SESSION)) session_start();

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00]
];

if(!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if(isset($_GET['add'])) {
    $id_add = intval($_GET['add']);
    if(isset($produtos[$id_add])) {
        if(isset($_SESSION['carrinho'][$id_add])) {
            $_SESSION['carrinho'][$id_add]++;
        } else {
            $_SESSION['carrinho'][$id_add] = 1;
        }
    }
    header('Location: carrinho.php');
    exit;
}

if(isset($_GET['del'])) {
    $id_del = intval($_GET['del']);
    unset($_SESSION['carrinho'][$id_del]);
    header('Location: carrinho.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">SWtech - Seu Carrinho</div>
        <ul>
            <li><a href="index.php">Continuar Comprando</a></li>
        </ul>
    </nav>

    <div class="container" style="max-width: 900px;">
        <h2 class="section-title">Produtos Selecionados</h2>

        <?php if(empty($_SESSION['carrinho'])): ?>
            <div class="card-form" style="max-width: 100%; text-align: center; padding: 40px;">
                <p style="font-size: 18px; color:#718096;">Seu carrinho está vazio no momento.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px; width: auto;">Voltar para a Vitrine</a>
            </div>
        <?php else: ?>
            <table class="carrinho-tabela">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço Unitário</th>
                        <th>Qtd</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_geral = 0;
                    foreach($_SESSION['carrinho'] as $id => $qtd): 
                        $prod = $produtos[$id];
                        $subtotal = $prod['preco'] * $qtd;
                        $total_geral += $subtotal;
                    ?>
                    <tr>
                        <td><strong><?php echo $prod['nome']; ?></strong></td>
                        <td>R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo $qtd; ?></td>
                        <td><strong>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></strong></td>
                        <td><a href="carrinho.php?del=<?php echo $id; ?>" class="btn btn-danger" style="padding: 5px 10px; font-size:12px;">Remover</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                Total do Pedido: <span style="color:#2f855a;">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
            </div>

            <div class="botoes-carrinho">
                <a href="index.php" class="btn btn-ver" style="width: auto; padding:12px 25px;">➕ Adicionar Mais Itens</a>
                <a href="login.php" class="btn btn-success" style="width: auto; padding:12px 35px; font-size: 16px;">Finalizar Pedido ➔</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>