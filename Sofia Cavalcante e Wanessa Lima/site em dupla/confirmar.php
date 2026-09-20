<?php
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok') { header('Location: login.php'); exit; }

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00]
];

$usuario_logado = $_SESSION['Nome_Usuario'];
$dados_usuario = "Cadastro não localizado.";

if(file_exists("login/" . $usuario_logado . "_relacao.dat")) {
    $arq_rel = fopen("login/" . $usuario_logado . "_relacao.dat", "r");
    $cpf_vinculado = trim(fgets($arq_rel, 100));
    fclose($arq_rel);
    if(file_exists("usuarios/" . $cpf_vinculado . ".dat")) {
        $dados_usuario = file_get_contents("usuarios/" . $cpf_vinculado . ".dat");
    }
}

$total_geral = 0;
$lista_itens = "";
if(isset($_SESSION['carrinho'])) {
    foreach($_SESSION['carrinho'] as $id => $qtd) {
        if(isset($produtos[$id])) {
            $sub = $produtos[$id]['preco'] * $qtd;
            $total_geral += $sub;
            $lista_itens .= $produtos[$id]['nome'] . " (Qtd: " . $qtd . ") | ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Pedido</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function gerenciarParcelas() {
            var pagamento = document.getElementById('forma_pagamento').value;
            var boxParcelas = document.getElementById('box_parcelas');
            if(pagamento === 'Cartao de Credito') {
                boxParcelas.style.display = 'block';
            } else {
                boxParcelas.style.display = 'none';
            }
        }
    </script>
</head>
<body>

    <div class="wrapper-center">
        <div class="card-form" style="max-width: 600px;">
            <h2>Confirmação e Pagamento</h2>
            
            <div style="margin-bottom: 20px;">
                <strong>Itens do seu Carrinho:</strong>
                <p style="background: #f7fafc; padding: 10px; border-radius:6px; font-size:14px; color:#4a5568; margin-top:5px; border-left:4px solid #3182ce;">
                    <?php echo rtrim($lista_itens, " | "); ?>
                </p>
                <div style="font-size: 18px; font-weight:bold; margin-top:10px; text-align:right;">
                    Total a pagar: <span style="color:#2f855a;">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                </div>
            </div>

            <strong>Endereço de Faturamento / Entrega:</strong>
            <div class="dados-usuario-box"><?php echo htmlspecialchars($dados_usuario); ?></div>

            <form method="POST" action="salvar_venda.php">
                <input type="hidden" name="total_venda" value="<?php echo $total_geral; ?>">
                <input type="hidden" name="descricao_itens" value="<?php echo htmlspecialchars($lista_itens); ?>">
                
                <div class="form-group">
                    <label id="label_pagamento">Selecione a Forma de Pagamento:</label>
                    <select name="forma_pagamento" id="forma_pagamento" onchange="gerenciarParcelas();" required>
                        <option value="Pix">Pix à vista</option>
                        <option value="Boleto Bancario">Boleto Bancário</option>
                        <option value="Cartao de Credito">Cartão de Crédito</option>
                    </select>
                </div>

                <div class="form-group" id="box_parcelas" style="display: none; background: #ebf8ff; padding: 12px; border-radius: 6px; border: 1px dashed #bee3f8;">
                    <label>Escolha o número de Parcelas:</label>
                    <select name="parcelas">
                        <option value="1x sem juros">1x de R$ <?php echo number_format($total_geral, 2, ',', '.'); ?> sem juros</option>
                        <option value="2x sem juros">2x de R$ <?php echo number_format($total_geral/2, 2, ',', '.'); ?> sem juros</option>
                        <option value="3x sem juros">3x de R$ <?php echo number_format($total_geral/3, 2, ',', '.'); ?> sem juros</option>
                        <option value="6x com juros de mercado">6x de R$ <?php echo number_format(($total_geral*1.05)/6, 2, ',', '.'); ?> (Com juros)</option>
                        <option value="12x com juros de mercado">12x de R$ <?php echo number_format(($total_geral*1.12)/12, 2, ',', '.'); ?> (Com juros)</option>
                    </select>
                </div>

                <input type="submit" class="btn btn-success" value="Concluir e Emitir Pedido" style="width:100%; padding:14px; font-size:16px; margin-top:15px;">
            </form>
        </div>
    </div>

</body>
</html>