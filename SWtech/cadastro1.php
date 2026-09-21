<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Passo 1</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper-center">
        <div class="card-form">
            <div class="step-indicator">Passo 1 de 2</div>
            <h2>Dados Pessoais</h2>
            <p style="text-align: center; color: #718096; margin-bottom: 20px;">Entre com as informações para faturamento</p>

            <form method="POST" action="banco.php" onsubmit="return validarForm();">
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" required>
                </div>
                <div class="form-group">
                    <label>CPF (Apenas os 11 números):</label>
                    <input type="text" name="cpf" id="cpf" required maxlength="11">
                </div>
                <div class="form-group">
                    <label>Endereço Residencial:</label>
                    <input type="text" name="endereco" required>
                </div>
                <div class="form-row">
                    <div class="col form-group">
                        <label>Bairro:</label>
                        <input type="text" name="bairro" required>
                    </div>
                    <div class="col form-group">
                        <label>Cidade:</label>
                        <input type="text" name="cidade" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col form-group">
                        <label>Estado (UF):</label>
                        <input type="text" name="estado" required maxlength="2" placeholder="Ex: SP">
                    </div>
                    <div class="col form-group">
                        <label>CEP:</label>
                        <input type="text" name="cep" required maxlength="9" placeholder="00000-000">
                    </div>
                </div>
                <input type="hidden" name="B1" value="1">
                <input type="submit" class="btn btn-success" value="Avançar para Etapa 2" style="width: 100%; padding: 12px; margin-top: 10px;">
            </form>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>
