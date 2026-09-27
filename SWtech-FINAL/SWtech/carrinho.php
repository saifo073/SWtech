<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

$id_sessao = session_id();

$consulta = "SELECT c.id_produto, c.quantidade, p.nome, p.preco
FROM carrinho c
INNER JOIN produtos p ON p.id = c.id_produto
WHERE c.id_sessao = '$id_sessao'";

$resultado = banco($server, $user, $password, $db, $consulta);

$itens_carrinho = [];
while($linha = $resultado->fetch_assoc()){
    $itens_carrinho[] = $linha;
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

        <?php if(count($itens_carrinho) == 0){ ?>
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

                <?php foreach($itens_carrinho as $item){ ?>
                    <?php $subtotal = $item['preco'] * $item['quantidade']; $total += $subtotal; ?>
                    <tr>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                        <td>
                            <form method="POST" action="banco.php">
                                <input type="hidden" name="id_produto" value="<?php echo $item['id_produto']; ?>">
                                <input type="hidden" name="B7" value="1">
                                <input type="submit" class="btn btn-danger" value="Remover">
                            </form>
                        </td>
                    </tr>
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
