<?php
if(!isset($_SESSION)) session_start();

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00, "cat" => "notebooks", "img" => "img/n1.jpeg", "desc" => "Intel i7, 16GB RAM, SSD 512GB - Super rápido."],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00, "cat" => "celulares", "img" => "img/cel1.jpeg", "desc" => "Câmera de 200MP, Tela 120Hz, 512GB."],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00, "cat" => "acessorios", "img" => "img/fone.jpeg", "desc" => "Isolamento acústico ativo e bateria de 40h."],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00, "cat" => "notebooks", "img" => "img/n2.jpeg", "desc" => "RTX 3050, Ryzen 7, Perfeito para jogos."],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00, "cat" => "celulares", "img" => "img/cel2.jpeg", "desc" => "Titânio, Tela Super Retina XDR, Chip A17."]
];

$categoria_atual = isset($_GET['cat']) ? $_GET['cat'] : 'home';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Loja Aprimorada</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li><a href="index.php?cat=home" class="<?php echo $categoria_atual=='home'?'active':''; ?>">Home</a></li>
            <li><a href="index.php?cat=celulares" class="<?php echo $categoria_atual=='celulares'?'active':''; ?>">Celulares</a></li>
            <li><a href="index.php?cat=notebooks" class="<?php echo $categoria_atual=='notebooks'?'active':''; ?>">Notebooks</a></li>
            <li><a href="index.php?cat=acessorios" class="<?php echo $categoria_atual=='acessorios'?'active':''; ?>">Acessórios</a></li>
            <li><a href="carrinho.php" style="color: #ecc94b;">🛒 Carrinho (<?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0; ?>)</a></li>
        </ul>
    </nav>

    <div class="banner-container"> 
       <div class="banner-placeholder">

           <img src="img/banner.png" alt="Banner da loja">

      </div>
    </div>

    <div class="container">
        <?php if($categoria_atual == 'home'): ?>
            <h2 class="section-title">🔥 Destaques da Semana</h2>
        <?php else: ?>
            <h2 class="section-title">Categoria: <?php echo ucfirst($categoria_atual); ?></h2>
        <?php endif; ?>

        <div class="grid-produtos">
            <?php 
            foreach($produtos as $id => $p): 
                // Se não for 'home' e a categoria não bater, pula o produto
                if($categoria_atual != 'home' && $p['cat'] != $categoria_atual) continue;
            ?>
                <a href="detalhes.php?id=<?php echo $id; ?>" class="product-card">
                    <div>
                        <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['nome']; ?>" onerror="this.src='https://placehold.co/250x170?text='+encodeURIComponent('<?php echo $p['nome']; ?>');">
                        <h3><?php echo $p['nome']; ?></h3>
                        <p class="desc"><?php echo $p['desc']; ?></p>
                    </div>
                    <div>
                        <div class="price">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></div>
                        <span class="btn btn-primary" style="width: 100%;">Ver Informações</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>