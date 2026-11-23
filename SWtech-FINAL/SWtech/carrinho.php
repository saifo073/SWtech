<?php
session_start();
require_once 'app/cons.php';
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
$conn->set_charset('utf8mb4');
$id_sessao = session_id();
$stmt = $conn->prepare('SELECT c.id_produto, c.quantidade, p.nome, p.preco FROM carrinho c INNER JOIN produtos p ON p.id = c.id_produto WHERE c.id_sessao = ?');
$stmt->bind_param('s', $id_sessao); $stmt->execute(); $resultado = $stmt->get_result();
$itens = []; $total = 0;
while($linha=$resultado->fetch_assoc()){ $itens[]=$linha; $total += $linha['preco']*$linha['quantidade']; }
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Carrinho - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body>
<nav class="navbar"><div class="logo">SWtech</div><ul><li><form method="POST" action="index.php"><button class="btn btn-primary">Início</button></form></li><li><form method="POST" action="login.php"><button class="btn btn-primary">Login</button></form></li></ul></nav>
<main class="container"><h1 class="section-title">Meu Carrinho</h1>
<?php if(isset($_SESSION['erro_pedido'])){ ?><p style="color:#c53030;text-align:center"><?php echo htmlspecialchars($_SESSION['erro_pedido']); unset($_SESSION['erro_pedido']); ?></p><?php } ?>
<?php if(count($itens)===0){ ?><div class="card-form" style="max-width:600px;margin:auto;text-align:center"><h2>Seu carrinho está vazio.</h2><form method="POST" action="index.php"><button class="btn btn-primary">Voltar às compras</button></form></div>
<?php }else{ ?><table class="carrinho-tabela"><tr><th>Produto</th><th>Quantidade</th><th>Preço</th><th>Subtotal</th><th>Ação</th></tr>
<?php foreach($itens as $item){ $subtotal=$item['preco']*$item['quantidade']; ?><tr><td><?php echo htmlspecialchars($item['nome']); ?></td><td><form method="POST" action="banco.php"><input type="hidden" name="id_produto" value="<?php echo (int)$item['id_produto']; ?>"><input type="number" name="quantidade" min="1" max="99" value="<?php echo (int)$item['quantidade']; ?>" style="width:65px"><input type="hidden" name="B5" value="1"><button class="btn btn-primary">Atualizar</button></form></td><td>R$ <?php echo number_format($item['preco'],2,',','.'); ?></td><td>R$ <?php echo number_format($subtotal,2,',','.'); ?></td><td><form method="POST" action="banco.php"><input type="hidden" name="id_produto" value="<?php echo (int)$item['id_produto']; ?>"><input type="hidden" name="B7" value="1"><button class="btn btn-danger">Remover</button></form></td></tr><?php } ?></table>
<div class="total-box">Total: R$ <?php echo number_format($total,2,',','.'); ?></div><div class="botoes-carrinho"><form method="POST" action="index.php"><button class="btn btn-primary">Continuar comprando</button></form><form method="POST" action="confirmar.php"><button class="btn btn-success">Finalizar compra</button></form></div><?php } ?></main></body></html>
