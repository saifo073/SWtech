<?php
session_start();
if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){ header('Location: login.php'); exit(); }
$mensagem = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'app/cons.php';
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){ die('Erro ao conectar ao banco.'); }
    $nome = trim($_POST['nome'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    if($nome === '' || $preco <= 0 || $categoria === '' || $descricao === '' || !isset($_FILES['imagem'])){
        $mensagem = 'Preencha todos os campos corretamente.';
    }elseif($_FILES['imagem']['error'] !== UPLOAD_ERR_OK){
        $mensagem = 'Não foi possível enviar a imagem.';
    }else{
        $tipo = mime_content_type($_FILES['imagem']['tmp_name']);
        $tipos = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if(!isset($tipos[$tipo]) || $_FILES['imagem']['size'] > 3*1024*1024){
            $mensagem = 'Envie uma imagem JPG, PNG ou WEBP de até 3 MB.';
        }else{
            $pasta = __DIR__ . '/img/produtos/';
            if(!is_dir($pasta)){ mkdir($pasta, 0755, true); }
            $arquivo = bin2hex(random_bytes(12)) . '.' . $tipos[$tipo];
            if(move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta . $arquivo)){
                $caminho = 'img/produtos/' . $arquivo;
                $stmt = $conn->prepare('INSERT INTO produtos (nome, preco, categoria, imagem, descricao) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('sdsss', $nome, $preco, $categoria, $caminho, $descricao);
                if($stmt->execute()){ $mensagem = 'Produto cadastrado com sucesso!'; }
                else{ unlink($pasta . $arquivo); $mensagem = 'Erro ao salvar o produto.'; }
            }else{ $mensagem = 'Falha ao guardar a imagem.'; }
        }
    }
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Cadastrar produto - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body><div class="wrapper-center"><div class="card-form"><h2>Cadastrar produto</h2><?php if($mensagem !== ''){ ?><p><?php echo htmlspecialchars($mensagem); ?></p><?php } ?><form method="POST" enctype="multipart/form-data"><div class="form-group"><label>Nome</label><input name="nome" required></div><div class="form-group"><label>Preço</label><input type="number" name="preco" min="0.01" step="0.01" required></div><div class="form-group"><label>Categoria</label><input name="categoria" required></div><div class="form-group"><label>Descrição</label><input name="descricao" required></div><div class="form-group"><label>Imagem do produto</label><input type="file" name="imagem" accept="image/jpeg,image/png,image/webp" required></div><button class="btn btn-primary" type="submit">Salvar produto</button></form></div></div></body></html>
