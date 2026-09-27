<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

$cat = isset($_POST['cat']) ? $_POST['cat'] : 'todos';

if($cat === 'todos'){
    $consulta = "SELECT * FROM produtos";
}else{
    $consulta = "SELECT * FROM produtos WHERE categoria = '$cat'";
}

$resultado = banco($server, $user, $password, $db, $consulta);

$id_sessao = session_id();

$consulta_qtd = "SELECT SUM(quantidade) AS total FROM carrinho WHERE id_sessao = '$id_sessao'";
$resultado_qtd = banco($server, $user, $password, $db, $consulta_qtd);
$linha_qtd = $resultado_qtd->fetch_assoc();
$quantidade_carrinho = $linha_qtd['total'] ? $linha_qtd['total'] : 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SWtech - Tecnologia</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <input type="hidden" name="cat" value="todos">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Início</button>
                </form>
            </li>
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <input type="hidden" name="cat" value="notebooks">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Notebooks</button>
                </form>
            </li>
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <input type="hidden" name="cat" value="celulares">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Celulares</button>
                </form>
            </li>
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <input type="hidden" name="cat" value="acessorios">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Acessórios</button>
                </form>
            </li>
            <li>
                <form method="POST" action="login.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Login</button>
                </form>
            </li>
            <li>
                <form method="POST" action="carrinho.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">🛒 Carrinho (<?php echo $quantidade_carrinho; ?>)</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="banner-container">
        <img src="img/Banner.png" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class="banner-placeholder"></div>'">
    </div>

    <main class="container">
        <h1 class="section-title">Produtos em destaque</h1>

        <div class="grid-produtos">
            <?php while($produto = $resultado->fetch_assoc()){ ?>
                <form method="POST" action="detalhes.php" style="margin:0;">
                    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                    <button type="submit" class="product-card" style="width:100%; border:1px solid #e2e8f0;">
                        <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" onerror="this.alt='Imagem do produto';">
                        <h3><?php echo $produto['nome']; ?></h3>
                        <p class="desc"><?php echo $produto['descricao']; ?></p>
                        <div class="price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                        <span class="btn btn-primary">Ver detalhes</span>
                    </button>
                </form>
            <?php } ?>
        </div>
    </main>
</body>
</html>
