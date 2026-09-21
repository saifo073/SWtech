<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

extract($_POST);


/* B1 - CADASTRAR USUARIO */
if(isset($B1)){

    $_SESSION['temp_cpf'] = $cpf;

    $consulta = "INSERT INTO usuarios
    (nome, cpf, endereco, bairro, cidade, estado, cep)
    VALUES
    ('$nome', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";

    banco($server, $user, $password, $db, $consulta);

    header('Location: cadastro2.php');
    exit();
}


/* B2 - CADASTRAR LOGIN */
if(isset($B2)){

    if(!isset($_SESSION['temp_cpf'])){
        header('Location: cadastro1.php');
        exit();
    }

    $cpf_vinculado = $_SESSION['temp_cpf'];
    $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

    $consulta = "INSERT INTO logins
    (login, senha, cpf)
    VALUES
    ('$login', '$senha_cripto', '$cpf_vinculado')";

    banco($server, $user, $password, $db, $consulta);

    unset($_SESSION['temp_cpf']);

    header('Location: login.php');
    exit();
}


/* B3 - VERIFICAR LOGIN */
if(isset($B3)){

    $consulta = "SELECT * FROM logins WHERE login = '$login'";

    $resultado = banco($server, $user, $password, $db, $consulta);
    $linha = $resultado->fetch_assoc();

    if($linha && password_verify($senha, $linha['senha'])){

        $_SESSION['Logado'] = 'ok';
        $_SESSION['Nome_Usuario'] = $login;

        $cpf_vinculado = $linha['cpf'];

        $consulta_usuario = "SELECT * FROM usuarios WHERE cpf = '$cpf_vinculado'";
        $resultado_usuario = banco($server, $user, $password, $db, $consulta_usuario);
        $dados = $resultado_usuario->fetch_assoc();

        if($dados){
            $_SESSION['dados_usuario'] =
            "Nome: " . $dados['nome'] . "\n" .
            "CPF: " . $dados['cpf'] . "\n" .
            "Endereco: " . $dados['endereco'] . "\n" .
            "Bairro: " . $dados['bairro'] . "\n" .
            "Cidade: " . $dados['cidade'] . "\n" .
            "Estado: " . $dados['estado'] . "\n" .
            "CEP: " . $dados['cep'];
        }else{
            $_SESSION['dados_usuario'] = "Cadastro não localizado.";
        }

        header('Location: confirmar.php');
        exit();
    }

    $_SESSION['erro_login'] = true;
    header('Location: login.php');
    exit();
}


/* B4 - SALVAR VENDA */
if(isset($B4)){

    if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){
        header('Location: login.php');
        exit();
    }

    $num_venda = rand(100000, 999999);
    $data_hora = date('Y-m-d H:i:s');
    $usuario = $_SESSION['Nome_Usuario'];
    $itens = htmlspecialchars_decode($descricao_itens);
    $total = (float)$total_venda;

    if(isset($parcelas) && $forma_pagamento === 'Cartao de Credito'){
        $detalhe_parcela = $parcelas;
    }else{
        $detalhe_parcela = "";
    }

    $consulta = "INSERT INTO vendas
    (numero_venda, usuario, descricao_itens, data_hora, total_venda, forma_pagamento, parcelas)
    VALUES
    ($num_venda, '$usuario', '$itens', '$data_hora', $total, '$forma_pagamento', '$detalhe_parcela')";

    banco($server, $user, $password, $db, $consulta);

    unset($_SESSION['carrinho']);
    $_SESSION['pedido'] = $num_venda;

    header('Location: sucesso.php');
    exit();
}


/* B5 - BUSCAR DADOS DO USUARIO */
if(isset($B5)){

    if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){
        header('Location: login.php');
        exit();
    }

    $usuario_logado = $_SESSION['Nome_Usuario'];

    $consulta = "SELECT u.* FROM usuarios u
    INNER JOIN logins l ON l.cpf = u.cpf
    WHERE l.login = '$usuario_logado'";

    $resultado = banco($server, $user, $password, $db, $consulta);
    $linha = $resultado->fetch_assoc();

    if($linha){
        $_SESSION['dados_usuario'] =
        "Nome: " . $linha['nome'] . "\n" .
        "CPF: " . $linha['cpf'] . "\n" .
        "Endereco: " . $linha['endereco'] . "\n" .
        "Bairro: " . $linha['bairro'] . "\n" .
        "Cidade: " . $linha['cidade'] . "\n" .
        "Estado: " . $linha['estado'] . "\n" .
        "CEP: " . $linha['cep'];
    }else{
        $_SESSION['dados_usuario'] = "Cadastro não localizado.";
    }

    header('Location: confirmar.php');
    exit();
}


/* B6 - ADICIONAR PRODUTO AO CARRINHO */
if(isset($B6)){

    if(!isset($_SESSION['carrinho'])){
        $_SESSION['carrinho'] = [];
    }

    if(isset($id_produto)){
        if(isset($_SESSION['carrinho'][$id_produto])){
            $_SESSION['carrinho'][$id_produto]++;
        }else{
            $_SESSION['carrinho'][$id_produto] = 1;
        }
    }

    header('Location: carrinho.php');
    exit();
}


/* B7 - REMOVER PRODUTO DO CARRINHO */
if(isset($B7)){

    if(isset($id_produto)){
        unset($_SESSION['carrinho'][$id_produto]);
    }

    header('Location: carrinho.php');
    exit();
}
?>
