<?php
session_start();
require_once 'app/cons.php';
require_once 'app/enviar_verificacao.php';

$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Erro ao conectar ao banco de dados.'); }
$conn->set_charset('utf8mb4');

$id_sessao = session_id();

/* B1 - PRIMEIRA ETAPA DO CADASTRO */
if(isset($_POST['B1'])){
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = strtoupper(trim($_POST['estado'] ?? ''));
    $cep = trim($_POST['cep'] ?? '');

    if($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($cpf) !== 11 || $endereco === '' || $bairro === '' || $cidade === '' || strlen($estado) !== 2 || $cep === ''){
        $_SESSION['erro_cadastro'] = 'Confira os dados informados.';
        header('Location: cadastro1.php'); exit();
    }

    $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, cpf, endereco, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssssss', $nome, $email, $cpf, $endereco, $bairro, $cidade, $estado, $cep);
    if(!$stmt->execute()){
        $_SESSION['erro_cadastro'] = $stmt->errno == 1062 ? 'Este CPF ou e-mail já está cadastrado.' : 'Não foi possível salvar os dados.';
        header('Location: cadastro1.php'); exit();
    }
    $_SESSION['temp_id_usuario'] = $conn->insert_id;
    header('Location: cadastro2.php'); exit();
}

/* B2 - SEGUNDA ETAPA DO CADASTRO E ENVIO DO E-MAIL */
if(isset($_POST['B2'])){
    if(!isset($_SESSION['temp_id_usuario'])){ header('Location: cadastro1.php'); exit(); }
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if($login === '' || strlen($senha) < 6){
        $_SESSION['erro_cadastro2'] = 'Informe um login e uma senha com pelo menos 6 caracteres.';
        header('Location: cadastro2.php'); exit();
    }

    $id_usuario = (int)$_SESSION['temp_id_usuario'];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO logins (login, senha, id_usuario) VALUES (?, ?, ?)');
    $stmt->bind_param('ssi', $login, $senha_hash, $id_usuario);
    if(!$stmt->execute()){
        $_SESSION['erro_cadastro2'] = $stmt->errno == 1062 ? 'Este login já está em uso.' : 'Não foi possível concluir o cadastro.';
        header('Location: cadastro2.php'); exit();
    }

    $stmt = $conn->prepare('SELECT nome, email FROM usuarios WHERE id = ?');
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();

    $token = bin2hex(random_bytes(32));
    $token_hash = hash('sha256', $token);
    $stmt = $conn->prepare('UPDATE usuarios SET token_verificacao = ? WHERE id = ?');
    $stmt->bind_param('si', $token_hash, $id_usuario);
    $stmt->execute();

    $enviado = enviarVerificacao($usuario['email'], $usuario['nome'], $token);
    unset($_SESSION['temp_id_usuario']);
    $_SESSION['aviso_cadastro'] = $enviado ? 'Cadastro concluído! Enviamos um link para confirmar seu e-mail.' : 'Cadastro concluído, mas não foi possível enviar o e-mail. Confira a configuração SMTP.';
    header('Location: login.php'); exit();
}

/* B3 - ENTRAR */
if(isset($_POST['B3'])){
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $stmt = $conn->prepare('SELECT id, senha, id_usuario FROM logins WHERE login = ?');
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $linha = $stmt->get_result()->fetch_assoc();

    if($linha && password_verify($senha, $linha['senha'])){
        $id_antigo = session_id();
        session_regenerate_id(true);
        $id_novo = session_id();
        $stmt = $conn->prepare('UPDATE carrinho SET id_sessao = ? WHERE id_sessao = ?');
        $stmt->bind_param('ss', $id_novo, $id_antigo);
        $stmt->execute();

        $_SESSION['Logado'] = 'ok';
        $_SESSION['Nome_Usuario'] = $login;
        $_SESSION['id_usuario'] = (int)$linha['id_usuario'];
        header('Location: confirmar.php'); exit();
    }
    $_SESSION['erro_login'] = true;
    header('Location: login.php'); exit();
}

/* B4 - REGISTRAR PEDIDO SIMULADO */
if(isset($_POST['B4'])){
    if(!isset($_SESSION['Logado']) || $_SESSION['Logado'] !== 'ok'){ header('Location: login.php'); exit(); }
    $id_usuario = (int)$_SESSION['id_usuario'];
    $forma = $_POST['forma_pagamento'] ?? '';
    $parcelas = $_POST['parcelas'] ?? '';
    $formas_validas = ['Pix', 'Boleto', 'Cartao de Credito'];
    if(!in_array($forma, $formas_validas, true)){ $_SESSION['erro_pedido'] = 'Selecione uma forma de pagamento válida.'; header('Location: confirmar.php'); exit(); }
    if($forma !== 'Cartao de Credito'){ $parcelas = ''; }

    $stmt = $conn->prepare('SELECT c.id_produto, c.quantidade, p.nome, p.preco FROM carrinho c INNER JOIN produtos p ON p.id = c.id_produto WHERE c.id_sessao = ?');
    $stmt->bind_param('s', $id_sessao);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $itens = [];
    $total = 0;
    $descricao = '';
    while($item = $resultado->fetch_assoc()){
        $itens[] = $item;
        $total += $item['preco'] * $item['quantidade'];
        $descricao .= $item['nome'] . ' (Qtd: ' . $item['quantidade'] . ') | ';
    }
    if(count($itens) === 0){ $_SESSION['erro_pedido'] = 'Não é possível finalizar um carrinho vazio.'; header('Location: carrinho.php'); exit(); }

    $conn->begin_transaction();
    try{
        $numero = random_int(100000, 999999);
        $data = date('Y-m-d H:i:s');
        $stmt = $conn->prepare('INSERT INTO vendas (numero_venda, usuario, descricao_itens, data_hora, total_venda, forma_pagamento, parcelas, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isssdssi', $numero, $_SESSION['Nome_Usuario'], $descricao, $data, $total, $forma, $parcelas, $id_usuario);
        $stmt->execute();
        $id_venda = $conn->insert_id;

        $stmt_item = $conn->prepare('INSERT INTO itens_venda (id_venda, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)');
        foreach($itens as $item){
            $produto_id = (int)$item['id_produto'];
            $quantidade = (int)$item['quantidade'];
            $preco = (float)$item['preco'];
            $stmt_item->bind_param('iiid', $id_venda, $produto_id, $quantidade, $preco);
            $stmt_item->execute();
        }
        $stmt = $conn->prepare('DELETE FROM carrinho WHERE id_sessao = ?');
        $stmt->bind_param('s', $id_sessao);
        $stmt->execute();
        $conn->commit();
        $_SESSION['pedido'] = $numero;
        $_SESSION['pagamento_simulado'] = true;
        header('Location: sucesso.php'); exit();
    }catch(Exception $e){
        $conn->rollback();
        error_log('Erro ao registrar pedido SWtech: ' . $e->getMessage());
        $_SESSION['erro_pedido'] = 'Não foi possível registrar o pedido. Tente novamente.';
        header('Location: confirmar.php'); exit();
    }
}

/* B5 - ATUALIZAR QUANTIDADE DO CARRINHO */
if(isset($_POST['B5'])){
    $id_produto = (int)($_POST['id_produto'] ?? 0);
    $quantidade = (int)($_POST['quantidade'] ?? 1);
    if($id_produto > 0 && $quantidade > 0 && $quantidade <= 99){
        $stmt = $conn->prepare('UPDATE carrinho SET quantidade = ? WHERE id_sessao = ? AND id_produto = ?');
        $stmt->bind_param('isi', $quantidade, $id_sessao, $id_produto);
        $stmt->execute();
    }
    header('Location: carrinho.php'); exit();
}

/* B6 - ADICIONAR PRODUTO AO CARRINHO */
if(isset($_POST['B6'])){
    $id_produto = (int)($_POST['id_produto'] ?? 0);
    $stmt = $conn->prepare('SELECT id FROM produtos WHERE id = ?');
    $stmt->bind_param('i', $id_produto);
    $stmt->execute();
    if($id_produto > 0 && $stmt->get_result()->num_rows === 1){
        $stmt = $conn->prepare('SELECT quantidade FROM carrinho WHERE id_sessao = ? AND id_produto = ?');
        $stmt->bind_param('si', $id_sessao, $id_produto);
        $stmt->execute();
        $atual = $stmt->get_result()->fetch_assoc();
        if($atual){
            $nova = min(99, (int)$atual['quantidade'] + 1);
            $stmt = $conn->prepare('UPDATE carrinho SET quantidade = ? WHERE id_sessao = ? AND id_produto = ?');
            $stmt->bind_param('isi', $nova, $id_sessao, $id_produto);
        }else{
            $stmt = $conn->prepare('INSERT INTO carrinho (id_sessao, id_produto, quantidade) VALUES (?, ?, 1)');
            $stmt->bind_param('si', $id_sessao, $id_produto);
        }
        $stmt->execute();
    }
    header('Location: carrinho.php'); exit();
}

/* B7 - REMOVER PRODUTO */
if(isset($_POST['B7'])){
    $id_produto = (int)($_POST['id_produto'] ?? 0);
    $stmt = $conn->prepare('DELETE FROM carrinho WHERE id_sessao = ? AND id_produto = ?');
    $stmt->bind_param('si', $id_sessao, $id_produto);
    $stmt->execute();
    header('Location: carrinho.php'); exit();
}

header('Location: index.php');
exit();
