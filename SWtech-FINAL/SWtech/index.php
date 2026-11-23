<?php
session_start();
require_once 'app/cons.php';
$conn = new mysqli($server,$user,$password,$db);
if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
$conn->set_charset('utf8mb4');
$cat = $_POST['cat'] ?? 'todos';
if($cat==='todos'){ $resultado=$conn->query('SELECT * FROM produtos ORDER BY id DESC'); }
else{ $stmt=$conn->prepare('SELECT * FROM produtos WHERE categoria=? ORDER BY id DESC'); $stmt->bind_param('s',$cat); $stmt->execute(); $resultado=$stmt->get_result(); }
$id_sessao=session_id();
$stmt=$conn->prepare('SELECT SUM(quantidade) AS total FROM carrinho WHERE id_sessao=?'); $stmt->bind_param('s',$id_sessao); $stmt->execute(); $qtd=$stmt->get_result()->fetch_assoc(); $quantidade_carrinho=$qtd['total'] ?? 0;
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>SWtech - Tecnologia</title><link rel="stylesheet" href="css/style.css"></head><body>
<nav class="navbar"><div class="logo">SWtech</div><ul>
<li><form method="POST" action="index.php"><input type="hidden" name="cat" value="todos"><button>Início</button></form></li>
<li><form method="POST" action="index.php"><input type="hidden" name="cat" value="notebooks"><button>Notebooks</button></form></li>
<li><form method="POST" action="index.php"><input type="hidden" name="cat" value="celulares"><button>Celulares</button></form></li>
<li><form method="POST" action="index.php"><input type="hidden" name="cat" value="acessorios"><button>Acessórios</button></form></li>
<li><form method="POST" action="login.php"><button>Login</button></form></li>
<li><form method="POST" action="carrinho.php"><button>🛒 Carrinho (<?php echo (int)$quantidade_carrinho; ?>)</button></form></li>
<?php if(isset($_SESSION['Logado']) && $_SESSION['Logado']==='ok'){ ?><li><form method="POST" action="historico.php"><button>Meus pedidos</button></form></li><li><form method="POST" action="cadastro_produto.php"><button>Cadastrar produto</button></form></li><li><form method="POST" action="logout.php"><button>Sair</button></form></li><?php } ?>
</ul></nav>
<div class="banner-container"><img src="img/Banner.png" style="width:100%;height:100%;object-fit:cover" alt="Banner SWtech"></div>
<main class="container"><h1 class="section-title">Produtos em destaque</h1><div class="grid-produtos">
<?php while($produto=$resultado->fetch_assoc()){ ?><form method="POST" action="detalhes.php" style="margin:0"><input type="hidden" name="id" value="<?php echo (int)$produto['id']; ?>"><button type="submit" class="product-card" style="width:100%;border:1px solid #e2e8f0"><img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>"><h3><?php echo htmlspecialchars($produto['nome']); ?></h3><p class="desc"><?php echo htmlspecialchars($produto['descricao']); ?></p><div class="price">R$ <?php echo number_format($produto['preco'],2,',','.'); ?></div><span class="btn btn-primary">Ver detalhes</span></button></form><?php } ?>
</div></main></body></html>
