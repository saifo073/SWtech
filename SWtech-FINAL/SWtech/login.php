<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - SWtech</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper-center">
        <div class="card-form">
            <h2>Entrar</h2>
            <p style="text-align: center; color: #718096; margin-bottom: 20px;">Acesse sua conta para finalizar a compra</p>

            <?php if(isset($_SESSION['erro_login'])){ ?>
                <p style="background:#fed7d7; color:#c53030; padding:10px; border-radius:6px; margin-bottom:15px; text-align:center;">
                    Login ou senha incorretos.
                </p>
                <?php unset($_SESSION['erro_login']); ?>
            <?php } ?>

            <form method="POST" action="banco.php">
                <div class="form-group">
                    <label>Login / Usuário:</label>
                    <input type="text" name="login" required>
                </div>
                <div class="form-group">
                    <label>Senha:</label>
                    <input type="password" name="senha" required>
                </div>
                <input type="hidden" name="B3" value="1">
                <input type="submit" class="btn btn-primary" value="Entrar" style="width:100%; padding:12px;">
            </form>

            <div style="text-align:center; margin-top:20px;">
                Ainda não possui conta?
                <form method="POST" action="cadastro1.php" style="display:inline;">
                    <button type="submit" style="background:none; border:none; color:#3182ce; cursor:pointer; font-size:16px;">Cadastre-se</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
