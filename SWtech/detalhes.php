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

if(!isset($produtos[$id])){
    header('Location: index.php');
    exit();
}

$produto = $produtos[$id];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $produto['nome']; ?> - SWtech</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SWtech</div>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="carrinho.php">🛒 Carrinho</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="card-form" style="max-width:700px; margin:30px auto; text-align:center;">
            <img src="<?php echo $produto['img']; ?>" alt="<?php echo $produto['nome']; ?>" style="width:100%; max-width:450px; height:300px; object-fit:contain; margin-bottom:20px;">
            <h2><?php echo $produto['nome']; ?></h2>
            <p style="color:#718096; line-height:1.6; margin-bottom:20px;"><?php echo $produto['desc']; ?></p>
            <div class="price" style="margin-bottom:20px;">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>

            <form method="POST" action="banco.php">
                <input type="hidden" name="id_produto" value="<?php echo $id; ?>">
                <input type="hidden" name="B6" value="1">
                <input type="submit" class="btn btn-primary" value="🛒 Adicionar ao Carrinho" style="width:100%;">
            </form>
        </div>
    </main>
</body>
</html>
