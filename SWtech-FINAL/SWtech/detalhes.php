<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$consulta = "SELECT * FROM produtos WHERE id = $id";
$resultado = banco($server, $user, $password, $db, $consulta);

if($resultado->num_rows == 0){
    header('Location: index.php');
    exit();
}

$produto = $resultado->fetch_assoc();
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
            <li>
                <form method="POST" action="index.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">Início</button>
                </form>
            </li>
            <li>
                <form method="POST" action="carrinho.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#e2e8f0; font-weight:500; cursor:pointer; font-size:16px;">🛒 Carrinho</button>
                </form>
            </li>
        </ul>
    </nav>

    <main class="container">
        <div class="card-form" style="max-width:700px; margin:30px auto; text-align:center;">
            <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" style="width:100%; max-width:450px; height:300px; object-fit:contain; margin-bottom:20px;">
            <h2><?php echo $produto['nome']; ?></h2>
            <p style="color:#718096; line-height:1.6; margin-bottom:20px;"><?php echo $produto['descricao']; ?></p>
            <div class="price" style="margin-bottom:20px;">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>

            <form method="POST" action="banco.php">
                <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                <input type="hidden" name="B6" value="1">
                <input type="submit" class="btn btn-primary" value="🛒 Adicionar ao Carrinho" style="width:100%;">
            </form>
        </div>
    </main>
</body>
</html>
