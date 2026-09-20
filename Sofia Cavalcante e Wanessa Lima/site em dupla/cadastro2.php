<?php
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['temp_cpf'])) { header('Location: cadastro1.php'); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Passo 2</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper-center">
        <div class="card-form">
            <div class="step-indicator">Passo 2 de 2</div>
            <h2>Dados de Acesso</h2>
            <p style="text-align: center; color: #718096; margin-bottom: 20px;">Crie suas credenciais de segurança</p>
            
            <form method="POST" action="salvar_login.php">
                <div class="form-group">
                    <label>Escolha um Login / Usuário:</label>
                    <input type="text" name="login" required placeholder="Ex: carlos_silva">
                </div>
                <div class="form-group">
                    <label>Defina uma Senha:</label>
                    <input type="password" name="senha" required placeholder="Crie sua senha">
                </div>
                <input type="submit" class="btn btn-primary" value="Concluir Cadastro" style="width: 100%; padding: 12px; margin-top: 10px;">
            </form>
        </div>
    </div>
</body>
</html>