<?php
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){
    header('Location: login.php');
    exit();
}

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00]
];

$dados_usuario = isset($_SESSION['dados_usuario']) ? $_SESSION['dados_usuario'] : "Cadastro não localizado.";

$total_geral = 0;
$lista_itens = "";

if(isset($_SESSION['carrinho'])){
    foreach($_SESSION['carrinho'] as $id => $qtd){
        if(isset($produtos[$id])){
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
    <title>Confirmar Pedido - SWtech</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="carrinho.php">Carrinho</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="card-form" style="max-width:700px; margin:30px auto;">
            <h2>Confirmar Pedido</h2>

            <h3 style="color:#2c5282; margin-top:20px;">Dados do cliente</h3>
            <div class="dados-usuario-box"><?php echo htmlspecialchars($dados_usuario); ?></div>

            <h3 style="color:#2c5282; margin-top:20px;">Itens da compra</h3>
            <div class="dados-usuario-box"><?php echo htmlspecialchars($lista_itens); ?></div>

            <div class="total-box">Total: R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></div>

            <form method="POST" action="banco.php">
                <input type="hidden" name="total_venda" value="<?php echo $total_geral; ?>">
                <input type="hidden" name="descricao_itens" value="<?php echo htmlspecialchars($lista_itens); ?>">

                <div class="form-group">
                    <label>Forma de pagamento:</label>
                    <select name="forma_pagamento" id="forma_pagamento" required onchange="mostrarParcelas()">
                        <option value="">Selecione</option>
                        <option value="Pix">Pix</option>
                        <option value="Boleto">Boleto</option>
                        <option value="Cartao de Credito">Cartão de Crédito</option>
                    </select>
                </div>

                <div class="form-group" id="area_parcelas" style="display:none;">
                    <label>Parcelas:</label>
                    <select name="parcelas">
                        <option value="1x">1x</option>
                        <option value="2x">2x</option>
                        <option value="3x">3x</option>
                        <option value="6x">6x</option>
                        <option value="12x">12x</option>
                    </select>
                </div>

                <input type="hidden" name="B4" value="1">
                <input type="submit" class="btn btn-success" value="Confirmar Pedido" style="width:100%; padding:12px;">
            </form>
        </div>
    </main>

    <script>
        function mostrarParcelas(){
            var forma = document.getElementById('forma_pagamento').value;
            var area = document.getElementById('area_parcelas');

            if(forma === 'Cartao de Credito'){
                area.style.display = 'block';
            }else{
                area.style.display = 'none';
            }
        }
    </script>
</body>
</html>
