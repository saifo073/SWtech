<?php
session_start();
$pedido = $_SESSION['pedido'] ?? '';
unset($_SESSION['pedido']);
unset($_SESSION['pagamento_simulado']);
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Pedido realizado - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body><div class="wrapper-center"><div class="card-form" style="text-align:center;border-top:5px solid #38a169"><span style="font-size:60px;color:#38a169">✔</span><h2 style="color:#2f855a;margin-top:10px">Pedido Gravado com Sucesso!</h2><p style="margin:15px 0;color:#4a5568">Sua compra foi registrada. O pagamento foi apenas simulado e nenhuma cobrança real foi realizada.</p><div style="background:#f7fafc;padding:12px;border-radius:6px;font-weight:bold;font-size:16px;margin-bottom:20px">Código do Pedido: #<?php echo htmlspecialchars((string)$pedido); ?></div><form method="POST" action="historico.php"><button class="btn btn-primary">Ver meus pedidos</button></form><form method="POST" action="index.php" style="margin-top:10px"><button class="btn btn-primary">Voltar à Página Inicial</button></form></div></div></body></html>
