<?php
if(!isset($_SESSION)) session_start();
extract($_POST);

if(!isset($_SESSION['temp_cpf'])) { header('Location: cadastro1.php'); exit; }
$cpf_vinculado = $_SESSION['temp_cpf'];

$senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

$arq = fopen("login/" . $login . ".dat", "w");
fwrite($arq, $senha_cripto);
fclose($arq);

$arq_rel = fopen("login/" . $login . "_relacao.dat", "w");
fwrite($arq_rel, $cpf_vinculado);
fclose($arq_rel);

unset($_SESSION['temp_cpf']);
header('Location: login.php');
exit;
?>