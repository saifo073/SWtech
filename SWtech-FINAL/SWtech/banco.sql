CREATE DATABASE swtech;

USE swtech;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    imagem VARCHAR(150) NOT NULL,
    descricao VARCHAR(255) NOT NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(11) NOT NULL UNIQUE,
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
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sessao VARCHAR(100) NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
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

INSERT INTO produtos (nome, preco, categoria, imagem, descricao) VALUES
('Notebook Ultra Pro 15', 4399.00, 'notebooks', 'img/n1.jpeg', 'Intel i7, 16GB RAM, SSD 512GB - Super rápido.'),
('Smartphone Galaxy S24 Ultra', 5999.00, 'celulares', 'img/cel1.jpeg', 'Câmera de 200MP, Tela 120Hz, 512GB.'),
('Fone Bluetooth Noise Cancelling', 899.00, 'acessorios', 'img/fone.jpeg', 'Isolamento acústico ativo e bateria de 40h.'),
('Notebook Gamer Storm X', 6799.00, 'notebooks', 'img/n2.jpeg', 'RTX 3050, Ryzen 7, Perfeito para jogos.'),
('iPhone 15 Pro Max', 7899.00, 'celulares', 'img/cel2.jpeg', 'Titânio, Tela Super Retina XDR, Chip A17.');
