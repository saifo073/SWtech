CREATE DATABASE swtech;

USE swtech;

CREATE TABLE usuarios (
    cpf VARCHAR(11) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(150) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(9) NOT NULL
);

CREATE TABLE logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    FOREIGN KEY (cpf) REFERENCES usuarios(cpf)
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_venda INT NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    descricao_itens TEXT NOT NULL,
    data_hora DATETIME NOT NULL,
    total_venda DECIMAL(10,2) NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    parcelas VARCHAR(50)
);