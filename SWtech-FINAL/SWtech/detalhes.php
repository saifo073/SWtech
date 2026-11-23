<?php
session_start();
require_once 'app/cons.php';
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
$conn->set_charset('utf8mb4');
$id = (int)($_POST['id'] ?? 0);
$stmt = $conn->prepare('SELECT * FROM produtos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
if($resultado->num_rows === 0){ header('Location: index.php'); exit(); }
$produto = $resultado->fetch_assoc();
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title><?php echo htmlspecialchars($produto['nome']); ?> - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body>
<nav class="navbar"><div class="logo">SWtech</div><ul><li><form method="POST" action="index.php"><button>Início</button></form></li><li><form method="POST" action="carrinho.php"><button>🛒 Carrinho</button></form></li></ul></nav>
<main class="container"><div class="card-form" style="max-width:700px;margin:30px auto;text-align:center">
<img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" style="width:100%;max-width:450px;height:300px;object-fit:contain;margin-bottom:20px">
<h2><?php echo htmlspecialchars($produto['nome']); ?></h2><p style="color:#718096;line-height:1.6;margin-bottom:20px"><?php echo htmlspecialchars($produto['descricao']); ?></p><div class="price" style="margin-bottom:20px">R$ <?php echo number_format($produto['preco'],2,',','.'); ?></div>
<form method="POST" action="banco.php"><input type="hidden" name="id_produto" value="<?php echo (int)$produto['id']; ?>"><input type="hidden" name="B6" value="1"><button class="btn btn-primary" style="width:100%">🛒 Adicionar ao Carrinho</button></form>
</div></main></body></html>
