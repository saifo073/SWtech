USE swtech;

ALTER TABLE usuarios
    ADD COLUMN email VARCHAR(254) NULL UNIQUE,
    ADD COLUMN token_verificacao CHAR(64) NULL,
    ADD COLUMN email_verificado TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE vendas
    ADD COLUMN id_usuario INT NULL,
    ADD CONSTRAINT fk_vendas_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venda) REFERENCES vendas(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);
