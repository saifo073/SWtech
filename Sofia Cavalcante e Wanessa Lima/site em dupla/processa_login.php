<?php
if(!isset($_SESSION)) session_start();
extract($_POST);

$arquivo_login = "login/" . $login . ".dat";

if(file_exists($arquivo_login)) {
    $arq = fopen($arquivo_login, "r");
    $senha_salva = trim(fgets($arq, 1000));
    fclose($arq);
    
    if(md5($senha) === $senha_salva || password_verify($senha, $senha_salva)) {
        $_SESSION['Logado'] = 'ok';
        $_SESSION['Nome_Usuario'] = $login;
        header('Location: confirmar.php');
        exit;
    }
}
header('Location: login.php?erro=1');
exit;
?>