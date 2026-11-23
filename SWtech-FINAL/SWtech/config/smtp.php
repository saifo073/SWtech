<?php
// Copie este arquivo para config/smtp.php e preencha os dados do Gmail.
// Nunca envie sua senha de aplicativo ao GitHub.
return [
    'host' => 'smtp.gmail.com',
    'username' => getenv('SWTECH_EMAIL') ?: 'SEU_EMAIL@gmail.com',
    'password' => getenv('SWTECH_EMAIL_PASSWORD') ?: 'SUA_SENHA_DE_APLICATIVO',
    'port' => 587,
    'encryption' => 'tls',
    'from_email' => getenv('SWTECH_EMAIL') ?: 'SEU_EMAIL@gmail.com',
    'from_name' => 'SWtech'
];
