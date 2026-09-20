<?php
if(!isset($_SESSION)) session_start();

$produtos = [
    1 => ["nome" => "Notebook Ultra Pro 15", "preco" => 4399.00, "cat" => "notebooks", "img" => "img/n1.jpeg", "desc" => "Intel i7, 16GB RAM, SSD 512GB - Super rápido."],
    2 => ["nome" => "Smartphone Galaxy S24 Ultra", "preco" => 5999.00, "cat" => "celulares", "img" => "img/cel1.jpeg", "desc" => "Câmera de 200MP, Tela 120Hz, 512GB."],
    3 => ["nome" => "Fone Bluetooth Noise Cancelling", "preco" => 899.00, "cat" => "acessorios", "img" => "img/fone.jpeg", "desc" => "Isolamento acústico ativo e bateria de 40h."],
    4 => ["nome" => "Notebook Gamer Storm X", "preco" => 6799.00, "cat" => "notebooks", "img" => "img/n2.jpeg", "desc" => "RTX 3050, Ryzen 7, Perfeito para jogos."],
    5 => ["nome" => "iPhone 15 Pro Max", "preco" => 7899.00, "cat" => "celulares", "img" => "img/cel2.jpeg", "desc" => "Titânio, Tela Super Retina XDR, Chip A17."]
];

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
if(!isset($produtos[$id])) { header('Location: index.php'); exit; }
$p = $produtos[$id];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $p['nome']; ?> - Detalhes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li><a href="index.php">Voltar à Vitrine</a></li>
        </ul>
    </nav>

    <div class="container" style="max-width: 800px;">
        <div class="card-form" style="max-width: 100%; display: flex; flex-direction: column; align-items: center; text-align: center;">
            <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['nome']; ?>" style="max-width: 300px; height: auto;" onerror="this.src='https://placehold.co/300x200?text=Produto';">
            <h2 style="margin: 20px 0;"><?php echo $p['nome']; ?></h2>
            <p style="font-size: 16px; color:#4a5568; margin-bottom: 25px; line-height: 1.6; max-width: 600px;"><?php echo $p['desc']; ?></p>
            <div class="price" style="font-size: 28px; margin-bottom: 20px;">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></div>
            
            <a href="carrinho.php?add=<?php echo $id; ?>" class="btn btn-success" style="padding: 12px 40px; font-size: 18px;">🛒 Adicionar ao Carrinho</a>
        </div>
    </div>

</body>
</html>