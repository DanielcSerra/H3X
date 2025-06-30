CREATE DATABASE IF NOT EXISTS H3X;
USE H3X;

CREATE TABLE utilizadores (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(9) NOT NULL,
    password VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    tipo ENUM('c','f','a') NOT NULL DEFAULT 'c',
    estado ENUM('a','d') NOT NULL DEFAULT 'd',
    ultima_atividade TIMESTAMP
);

CREATE TABLE categorias_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    conteudo TEXT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    aprovado BOOLEAN DEFAULT FALSE,
    id_utilizador INT UNSIGNED NOT NULL,
    id_categoria INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_categoria) REFERENCES categorias_posts(id)
);

CREATE TABLE comentarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    conteudo TEXT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_post INT UNSIGNED NOT NULL,
    id_utilizador INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE imagens_galeria (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150),
    imagem VARCHAR(255) NOT NULL,
    aprovado BOOLEAN DEFAULT FALSE,
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_utilizador INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE contactos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(9),
    mensagem TEXT NOT NULL,
    id_utilizador INT UNSIGNED,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE mesas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(15) NOT NULL,
    capacidade INT UNSIGNED
);

CREATE TABLE vip (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_mesa INT UNSIGNED NOT NULL,
    mensagem TEXT,
    data_reserva DATE NOT NULL,
    id_utilizador INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_mesa) REFERENCES mesas(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE vip_mesas (
    id_vip INT UNSIGNED,
    id_mesas INT UNSIGNED,
    PRIMARY KEY (id_vip, id_mesas),
    FOREIGN KEY (id_vip) REFERENCES vip(id),
    FOREIGN KEY (id_mesas) REFERENCES mesas(id)
);

CREATE TABLE djs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    video VARCHAR(255) NOT NULL
);

CREATE TABLE eventos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    id_utilizador INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE categorias_eventos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE eventos_djs (
    id_evento INT UNSIGNED,
    id_dj INT UNSIGNED,
    PRIMARY KEY (id_evento, id_dj),
    FOREIGN KEY (id_evento) REFERENCES eventos(id),
    FOREIGN KEY (id_dj) REFERENCES djs(id)
);

CREATE TABLE eventos_categorias (
    id_evento INT UNSIGNED,
    id_categoria INT UNSIGNED,
    PRIMARY KEY (id_evento, id_categoria),
    FOREIGN KEY (id_evento) REFERENCES eventos(id),
    FOREIGN KEY (id_categoria) REFERENCES categorias_eventos(id)
);