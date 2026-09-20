<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Autenticação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper-center">
        <div class="card-form">
            <h2>Identificação</h2>
            <p style="text-align: center; color: #718096; margin-bottom: 20px;">Faça login para processar seus itens</p>
            
            <?php if(isset($_GET['erro'])): ?>
                <div style="background:#fff5f5; color:#c53030; padding:10px; border-radius:6px; font-size:14px; text-align:center; margin-bottom:15px;">Usuário ou senha incorretos!</div>
            <?php endif; ?>

            <form method="POST" action="processa_login.php">
                <div class="form-group">
                    <label>Nome de Usuário / Login:</label>
                    <input type="text" name="login" required placeholder="Digite seu usuário">
                </div>
                <div class="form-group">
                    <label>Senha de Acesso:</label>
                    <input type="password" name="senha" required placeholder="Digite sua senha">
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Entrar" style="width: 100%; padding: 12px; margin-top: 10px;">
            </form>
            <div class="link-footer" style="text-align: center; margin-top: 20px;">
                <a href="cadastro1.php">Não possui conta? Cadastre-se aqui</a>
            </div>
        </div>
    </div>
</body>
</html>