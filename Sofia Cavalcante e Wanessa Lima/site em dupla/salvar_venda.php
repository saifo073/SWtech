<?php
if(!isset($_SESSION)) session_start();
extract($_POST);

if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok') { header('Location: login.php'); exit; }

$num_venda = rand(100000, 999999);
$data_hora = date('d/m/Y H:i:s');
$usuario = $_SESSION['Nome_Usuario'];

$detalhe_parcela = (isset($parcelas) && $forma_pagamento === 'Cartao de Credito') ? " ($parcelas)" : "";

$conteudo_venda = "Numero da Venda: $num_venda\n" .
                 "Usuario: $usuario\n" .
                 "Itens Comprados: " . htmlspecialchars_decode($descricao_itens) . "\n" .
                 "Data e Hora: $data_hora\n" .
                 "Valor Pago Total: R$ " . number_format($total_venda, 2, ',', '.') . "\n" .
                 "Forma de Pagamento: " . $forma_pagamento . $detalhe_parcela . "\n";

$arq = fopen("vendas/venda_" . $num_venda . ".txt", "w");
fwrite($arq, $conteudo_venda);
fclose($arq);

unset($_SESSION['carrinho']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sucesso!</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper-center">
        <div class="card-form" style="text-align: center; border-top: 5px solid #38a169;">
            <span style="font-size: 60px; color:#38a169;">✔</span>
            <h2 style="color:#2f855a; margin-top:10px;">Pedido Gravado com Sucesso!</h2>
            <p style="margin: 15px 0; color:#4a5568;">Sua transação foi homologada. O arquivo local foi gerado em <strong>/vendas/venda_<?php echo $num_venda; ?>.txt</strong>.</p>
            
            <div style="background: #f7fafc; padding: 12px; border-radius:6px; font-weight:bold; font-size:16px; margin-bottom:20px;">
                Código Local: #<?php echo $num_venda; ?>
            </div>

            <a href="index.php" class="btn btn-primary" style="width: auto; padding:10px 30px;">Voltar à Página Inicial</a>
        </div>
    </div>
</body>
</html>