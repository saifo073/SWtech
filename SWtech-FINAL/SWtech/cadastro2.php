<?php
session_start();
if(!isset($_SESSION['temp_id_usuario'])){ header('Location: cadastro1.php'); exit(); }
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Cadastro - Passo 2</title><link rel="stylesheet" href="css/style.css"></head>
<body><div class="wrapper-center"><div class="card-form"><div class="step-indicator">Passo 2 de 2</div><h2>Dados de Acesso</h2><p style="text-align:center;color:#718096;margin-bottom:20px;">Crie suas credenciais de segurança</p>
<?php if(isset($_SESSION['erro_cadastro2'])){ ?><p style="color:#c53030;text-align:center"><?php echo htmlspecialchars($_SESSION['erro_cadastro2']); unset($_SESSION['erro_cadastro2']); ?></p><?php } ?>
<form method="POST" action="banco.php"><div class="form-group"><label>Escolha um Login / Usuário:</label><input type="text" name="login" required></div><div class="form-group"><label>Defina uma Senha (mínimo 6 caracteres):</label><input type="password" name="senha" required minlength="6"></div><input type="hidden" name="B2" value="1"><input type="submit" class="btn btn-primary" value="Concluir Cadastro" style="width:100%;padding:12px;margin-top:10px"></form></div></div></body></html>
