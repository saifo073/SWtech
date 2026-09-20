<?php
if(!isset($_SESSION)) session_start();
extract($_POST);

$_SESSION['temp_cpf'] = $cpf;

$conteudo = "Nome: $nome\nCPF: $cpf\nEndereco: $endereco\nBairro: $bairro\nCidade: $cidade\nEstado: $estado\nCEP: $cep\n";
$arq = fopen("usuarios/" . $cpf . ".dat", "w");
fwrite($arq, $conteudo);
fclose($arq);

header('Location: cadastro2.php');
exit;
?>