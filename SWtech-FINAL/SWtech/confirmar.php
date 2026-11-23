<?php
session_start();
if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){ header('Location: login.php'); exit(); }
require_once 'app/cons.php';
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
$conn->set_charset('utf8mb4');
$id_sessao = session_id();
$stmt = $conn->prepare('SELECT c.quantidade, p.nome, p.preco FROM carrinho c INNER JOIN produtos p ON p.id=c.id_produto WHERE c.id_sessao=?');
$stmt->bind_param('s',$id_sessao); $stmt->execute(); $resultado=$stmt->get_result();
$total=0; $itens=[];
while($item=$resultado->fetch_assoc()){ $itens[]=$item; $total += $item['preco']*$item['quantidade']; }
if(count($itens)===0){ header('Location: carrinho.php'); exit(); }
$stmt=$conn->prepare('SELECT nome, cpf, endereco, bairro, cidade, estado, cep FROM usuarios WHERE id=?');
$stmt->bind_param('i',$_SESSION['id_usuario']); $stmt->execute(); $usuario=$stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Confirmar Pedido - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body>
<nav class="navbar"><div class="logo">SWtech</div><ul><li><form method="POST" action="index.php"><button class="btn btn-primary">Início</button></form></li><li><form method="POST" action="carrinho.php"><button class="btn btn-primary">Carrinho</button></form></li></ul></nav>
<main class="container"><div class="card-form" style="max-width:700px;margin:30px auto"><h2>Confirmar Pedido</h2><h3 style="color:#2c5282;margin-top:20px">Dados do cliente</h3><div class="dados-usuario-box"><?php echo htmlspecialchars("Nome: ".$usuario['nome']."\nCPF: ".$usuario['cpf']."\nEndereço: ".$usuario['endereco']."\nBairro: ".$usuario['bairro']."\nCidade: ".$usuario['cidade']."\nEstado: ".$usuario['estado']."\nCEP: ".$usuario['cep']); ?></div><h3 style="color:#2c5282;margin-top:20px">Itens da compra</h3><div class="dados-usuario-box"><?php foreach($itens as $item){ echo htmlspecialchars($item['nome'].' (Qtd: '.$item['quantidade'].')')."\n"; } ?></div><div class="total-box">Total: R$ <?php echo number_format($total,2,',','.'); ?></div>
<?php if(isset($_SESSION['erro_pedido'])){ ?><p style="color:#c53030"><?php echo htmlspecialchars($_SESSION['erro_pedido']); unset($_SESSION['erro_pedido']); ?></p><?php } ?>
<p style="background:#fffaf0;padding:12px;border-radius:6px;color:#975a16">Atenção: o pagamento é apenas uma simulação escolar. Nenhuma cobrança real será realizada.</p>
<form method="POST" action="banco.php"><div class="form-group"><label>Forma de pagamento simulada:</label><select name="forma_pagamento" id="forma_pagamento" required onchange="mostrarParcelas()"><option value="">Selecione</option><option value="Pix">Pix (simulado)</option><option value="Boleto">Boleto (simulado)</option><option value="Cartao de Credito">Cartão de Crédito (simulado)</option></select></div><div class="form-group" id="area_parcelas" style="display:none"><label>Parcelas:</label><select name="parcelas"><option value="1x">1x</option><option value="2x">2x</option><option value="3x">3x</option><option value="6x">6x</option><option value="12x">12x</option></select></div><input type="hidden" name="B4" value="1"><button class="btn btn-success" style="width:100%">Confirmar pedido simulado</button></form></div></main>
<script>function mostrarParcelas(){var f=document.getElementById('forma_pagamento').value;document.getElementById('area_parcelas').style.display=f==='Cartao de Credito'?'block':'none';}</script></body></html>
