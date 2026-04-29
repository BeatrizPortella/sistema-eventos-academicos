CREATE DATABASE IF NOT EXISTS sistema_eventos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_eventos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    data DATE NOT NULL,
    local VARCHAR(150) NOT NULL
);

CREATE TABLE palestrantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    especialidade VARCHAR(150)
);

CREATE TABLE apresentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    evento_id INT NOT NULL,
    palestrante_id INT NOT NULL,
    horario TIME NOT NULL,
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (palestrante_id) REFERENCES palestrantes(id) ON DELETE CASCADE
);

-- Inserindo usuário administrador padrão
-- A senha '123456' será verificada e pode ser atualizada para hash na aplicação se necessário
-- Para simplificar a instalação, estamos inserindo em texto puro que o sistema de login vai aceitar e tratar
INSERT INTO usuarios (nome, email, senha) VALUES ('Administrador', 'admin@admin.com', '123456');
