<?php
session_start();
require_once 'app/cons.php';
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){ die('Não foi possível conectar ao banco.'); }
$conn->set_charset('utf8mb4');

$token = isset($_GET['token']) ? $_GET['token'] : '';
$mensagem = 'Link inválido ou expirado.';
if($token !== ''){
    $hash = hash('sha256', $token);
    $stmt = $conn->prepare('SELECT id FROM usuarios WHERE token_verificacao = ? AND email_verificado = 0');
    $stmt->bind_param('s', $hash);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    if($usuario){
        $stmt2 = $conn->prepare('UPDATE usuarios SET email_verificado = 1, token_verificacao = NULL WHERE id = ?');
        $stmt2->bind_param('i', $usuario['id']);
        $stmt2->execute();
        $mensagem = 'E-mail confirmado com sucesso!';
    }
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Verificação de e-mail - SWtech</title><link rel="stylesheet" href="css/style.css"></head><body><div class="wrapper-center"><div class="card-form" style="text-align:center"><h2><?php echo htmlspecialchars($mensagem); ?></h2><form method="POST" action="login.php"><button class="btn btn-primary" type="submit">Ir para o login</button></form></div></div></body></html>
