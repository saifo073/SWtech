<?php
// Use variáveis de ambiente para não publicar credenciais no GitHub.
return [
    'host' => 'smtp.gmail.com',
    'username' => getenv('SWTECH_EMAIL') ?: 'SEU_EMAIL@gmail.com',
    'password' => getenv('SWTECH_EMAIL_PASSWORD') ?: 'SUA_SENHA_DE_APLICATIVO',
    'port' => 587,
    'encryption' => 'tls',
    'from_email' => getenv('SWTECH_EMAIL') ?: 'SEU_EMAIL@gmail.com',
    'from_name' => 'SWtech',
    'base_url' => getenv('SWTECH_BASE_URL') ?: 'http://localhost/SWtech'
];
