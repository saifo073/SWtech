<?php
if(!isset($_SESSION)) session_start();

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00, "cat" => "notebooks", "img" => "img/n1.jpeg", "desc" => "Intel i7, 16GB RAM, SSD 512GB - Super rápido."],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00, "cat" => "celulares", "img" => "img/cel1.jpeg", "desc" => "Câmera de 200MP, Tela 120Hz, 512GB."],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00, "cat" => "acessorios", "img" => "img/fone.jpeg", "desc" => "Isolamento acústico ativo e bateria de 40h."],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00, "cat" => "notebooks", "img" => "img/n2.jpeg", "desc" => "RTX 3050, Ryzen 7, Perfeito para jogos."],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00, "cat" => "celulares", "img" => "img/cel2.jpeg", "desc" => "Titânio, Tela Super Retina XDR, Chip A17."]
];

if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - SWtech</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Início</button>
                </form>
            </li>
            <li>
                <form method="POST" action="login.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Login</button>
                </form>
            </li>
        </ul>
    </nav>

    <main class="container">
        <h1 class="section-title">Meu Carrinho</h1>

        <?php if(count($_SESSION['carrinho']) == 0){ ?>
            <div class="card-form" style="max-width:600px; margin:auto; text-align:center;">
                <h2>Seu carrinho está vazio.</h2>
                <form method="POST" action="index.php">
                    <button type="submit" class="btn btn-primary">Voltar às compras</button>
                </form>
            </div>
        <?php }else{ ?>
            <table class="carrinho-tabela">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>

                <?php foreach($_SESSION['carrinho'] as $id => $qtd){ ?>
                    <?php if(isset($produtos[$id])){ ?>
                        <?php $subtotal = $produtos[$id]['preco'] * $qtd; $total += $subtotal; ?>
                        <tr>
                            <td><?php echo $produtos[$id]['nome']; ?></td>
                            <td><?php echo $qtd; ?></td>
                            <td>R$ <?php echo number_format($produtos[$id]['preco'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                            <td>
                                <form method="POST" action="banco.php">
                                    <input type="hidden" name="id_produto" value="<?php echo $id; ?>">
                                    <input type="hidden" name="B7" value="1">
                                    <input type="submit" class="btn btn-danger" value="Remover">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>

            <div class="total-box">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></div>

            <div class="botoes-carrinho">
                <form method="POST" action="index.php">
                    <button type="submit" class="btn btn-primary">Continuar comprando</button>
                </form>
                <form method="POST" action="login.php">
                    <button type="submit" class="btn btn-success">Finalizar compra</button>
                </form>
            </div>
        <?php } ?>
    </main>
</body>
</html>
