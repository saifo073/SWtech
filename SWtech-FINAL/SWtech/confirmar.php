<?php
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){
    header('Location: login.php');
    exit();
}

include "app/cons.php";
require_once "app/DLL.php";

$id_sessao = session_id();

$consulta = "SELECT c.quantidade, p.nome, p.preco
FROM carrinho c
INNER JOIN produtos p ON p.id = c.id_produto
WHERE c.id_sessao = '$id_sessao'";

$resultado = banco($server, $user, $password, $db, $consulta);

$dados_usuario = isset($_SESSION['dados_usuario']) ? $_SESSION['dados_usuario'] : "Cadastro não localizado.";

$total_geral = 0;
$lista_itens = "";

while($linha = $resultado->fetch_assoc()){
    $sub = $linha['preco'] * $linha['quantidade'];
    $total_geral += $sub;
    $lista_itens .= $linha['nome'] . " (Qtd: " . $linha['quantidade'] . ") | ";
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
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Início</button>
                </form>
            </li>
            <li>
                <form method="POST" action="carrinho.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Carrinho</button>
                </form>
            </li>
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
