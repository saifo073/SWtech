<?php
if(!isset($_SESSION)) session_start();
include "cons.php";
require_once "DLL.php";
extract($_POST);

$_SESSION['temp_cpf'] = $cpf;

$consulta = "INSERT INTO usuarios (nome, cpf, endereco, bairro, cidade, estado, cep) VALUES ('$nome', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep')";
banco($server, $user, $password, $db, $consulta);

header('Location: cadastro2.php');
exit;
?>
