<?php
session_start();
if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){ header('Location: login.php'); exit(); }
require_once 'app/cons.php';
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
$conn->set_charset('utf8mb4');
$id_usuario = (int)$_SESSION['id_usuario'];
$stmt = $conn->prepare('SELECT id, numero_venda, data_hora, total_venda, forma_pagamento FROM vendas WHERE id_usuario = ? ORDER BY data_hora DESC');
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$pedidos = $stmt->get_result();
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Meus pedidos - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body><nav class="navbar"><div class="logo">SWtech</div><ul><li><form method="POST" action="index.php"><button class="btn btn-primary">Início</button></form></li><li><form method="POST" action="logout.php"><button class="btn btn-danger">Sair</button></form></li></ul></nav><main class="container"><h1 class="section-title">Histórico de pedidos</h1><?php if($pedidos->num_rows === 0){ ?><p>Você ainda não realizou pedidos.</p><?php }else{ ?><table class="carrinho-tabela"><tr><th>Pedido</th><th>Data</th><th>Total</th><th>Pagamento</th></tr><?php while($p=$pedidos->fetch_assoc()){ ?><tr><td>#<?php echo (int)$p['numero_venda']; ?></td><td><?php echo htmlspecialchars($p['data_hora']); ?></td><td>R$ <?php echo number_format($p['total_venda'],2,',','.'); ?></td><td><?php echo htmlspecialchars($p['forma_pagamento']); ?></td></tr><?php } ?></table><?php } ?></main></body></html>
