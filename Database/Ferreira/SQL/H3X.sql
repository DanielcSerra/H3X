CREATE DATABASE IF NOT EXISTS h3x;
USE h3x;

CREATE TABLE utilizadores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(15),
    tipo ENUM('cliente','funcionário','administrador') NOT NULL,
    estado ENUM('online','offline') NOT NULL,
    ultima_atividade DATETIME
);

CREATE TABLE categorias_post (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomecat VARCHAR(50) NOT NULL
);

CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(50) NOT NULL,
    conteudo TEXT NOT NULL,
    data DATETIME,
    aprovadoreprovado VARCHAR(20),
    id_utilizador INT,
    id_categoria INT,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_categoria) REFERENCES categorias_post(id)
);

CREATE TABLE contactos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(15),
    id_utilizador INT,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE comentarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    conteudo TEXT NOT NULL,
    data DATETIME,
    id_post INT,
    id_utilizador INT,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE galeria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150),
    imagem VARCHAR(255) NOT NULL,
    data_upload DATETIME,
	id_utilizador INT,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE mesa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(15) NOT NULL UNIQUE,
    capacidade INT
);

CREATE TABLE vip (
    id INT PRIMARY KEY AUTO_INCREMENT,
    instagram VARCHAR(100),
    data_nasc DATE,
    mensagem TEXT,
    mesa_preferida INT,
    id_utilizador INT,
    FOREIGN KEY (mesa_preferida) REFERENCES mesa(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE categoria_evento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomecat VARCHAR(50) NOT NULL
);

CREATE TABLE dj (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    video VARCHAR(255)
);

CREATE TABLE eventos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100),
    descricao TEXT,
    hora_inicio DATETIME,
    hora_fim DATETIME,
    data_inicio DATETIME,
    data_fim DATETIME,
    id_categoria INT,
	id_dj INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria_evento(id),
	FOREIGN KEY (id_dj) REFERENCES dj(id)
);