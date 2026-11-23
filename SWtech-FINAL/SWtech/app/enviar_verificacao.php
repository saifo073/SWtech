<?php
function enviarVerificacao($destinatario, $nome, $token){
    $config = require __DIR__ . '/../config/smtp.php';
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if(!file_exists($autoload)){
        return false;
    }
    require_once $autoload;

    $link = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/verificar_email.php?token=' . urlencode($token);
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Port = $config['port'];
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($destinatario, $nome);
        $mail->isHTML(true);
        $mail->Subject = 'Confirme seu e-mail - SWtech';
        $nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        $linkSeguro = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
        $mail->Body = '<div style="font-family:Arial;background:#f4f7f6;padding:30px"><div style="max-width:560px;margin:auto;background:white;padding:30px;border-radius:12px"><h1 style="color:#1a365d">SWtech</h1><h2>Olá, '.$nomeSeguro.'!</h2><p>Recebemos seu cadastro. Clique no botão abaixo para confirmar que este e-mail pertence a você.</p><p style="text-align:center;margin:30px"><a href="'.$linkSeguro.'" style="background:#3182ce;color:white;padding:14px 24px;border-radius:6px;text-decoration:none">Confirmar e-mail</a></p><p>Se você não realizou este cadastro, ignore esta mensagem.</p></div></div>';
        $mail->AltBody = 'Confirme seu e-mail acessando: ' . $link;
        $mail->send();
        return true;
    }catch(Exception $e){
        error_log('Erro ao enviar verificação SWtech: ' . $mail->ErrorInfo);
        return false;
    }
}
