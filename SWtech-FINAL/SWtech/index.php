<?php
if(!isset($_SESSION)) session_start();

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00, "cat" => "notebooks", "img" => "img/n1.jpeg", "desc" => "Intel i7, 16GB RAM, SSD 512GB - Super rápido."],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00, "cat" => "celulares", "img" => "img/cel1.jpeg", "desc" => "Câmera de 200MP, Tela 120Hz, 512GB."],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00, "cat" => "acessorios", "img" => "img/fone.jpeg", "desc" => "Isolamento acústico ativo e bateria de 40h."],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00, "cat" => "notebooks", "img" => "img/n2.jpeg", "desc" => "RTX 3050, Ryzen 7, Perfeito para jogos."],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00, "cat" => "celulares", "img" => "img/cel2.jpeg", "desc" => "Titânio, Tela Super Retina XDR, Chip A17."]
];

$cat = isset($_POST['cat']) ? $_POST['cat'] : 'todos';
$quantidade_carrinho = 0;

if(isset($_SESSION['carrinho'])){
    foreach($_SESSION['carrinho'] as $qtd){
        $quantidade_carrinho += $qtd;
    }
}
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
            <?php foreach($produtos as $id => $produto){ ?>
                <?php if($cat === 'todos' || $cat === $produto['cat']){ ?>
                    <form method="POST" action="detalhes.php" style="margin:0;">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" class="product-card" style="width:100%; border:1px solid #e2e8f0;">
                            <img src="<?php echo $produto['img']; ?>" alt="<?php echo $produto['nome']; ?>" onerror="this.alt='Imagem do produto';">
                            <h3><?php echo $produto['nome']; ?></h3>
                            <p class="desc"><?php echo $produto['desc']; ?></p>
                            <div class="price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                            <span class="btn btn-primary">Ver detalhes</span>
                        </button>
                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
</body>
</html>
