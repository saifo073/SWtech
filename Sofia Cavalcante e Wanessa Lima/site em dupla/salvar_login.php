<?php
if(!isset($_SESSION)) session_start();
include "cons.php";
require_once "DLL.php";
extract($_POST);

if(!isset($_SESSION['temp_cpf'])) { header('Location: cadastro1.php'); exit; }
$cpf_vinculado = $_SESSION['temp_cpf'];

$senha_cripto = password_hash($senha, PASSWORD_DEFAULT);

$consulta = "INSERT INTO logins (login, senha, cpf) VALUES ('$login', '$senha_cripto', '$cpf_vinculado')";
banco($server, $user, $password, $db, $consulta);

unset($_SESSION['temp_cpf']);
header('Location: login.php');
exit;
?>
