CREATE DATABASE IF NOT EXISTS H3X;
USE H3X;

CREATE TABLE Utilizadores (
    id_utilizador INT PRIMARY KEY,
    nome_utilizador VARCHAR(100) NOT NULL,
    tipo ENUM('cliente', 'funcionario', 'admin') NOT NULL
);

CREATE TABLE Contactos (
    telefone VARCHAR(9) NOT NULL,
    email VARCHAR(100) NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id_utilizador)
);


CREATE TABLE Posts (
    id_post INT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    conteudo TEXT NOT NULL,
    data DATETIME NOT NULL,
    aprovado_reprovado BOOLEAN NOT NULL,
    id_utilizador INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id_utilizador),
    FOREIGN KEY (id_categoria) REFERENCES Categoriapost(id_categoria)
);

CREATE TABLE Categoriapost (
    id_categoria INT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL,
    id_post INT,
    FOREIGN KEY (id_post) REFERENCES Posts(id_post)
);

CREATE TABLE Galeria (
    id_galeria INT PRIMARY KEY,
    imagem VARCHAR(250) NOT NULL,
    data DATETIME NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id_utilizador)
);

CREATE TABLE Comentarios (
    id_comentario INT PRIMARY KEY,
    conteudo TEXT NOT NULL,
    id_utilizador INT NOT NULL,
    id_post INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id_utilizador),
    FOREIGN KEY (id_post) REFERENCES Posts(id_post)
);

CREATE TABLE DJS (
    ID_djs INT PRIMARY KEY,
    Video VARCHAR(200) NOT NULL,
    Foto VARCHAR(200) NOT NULL,
    nome_dj VARCHAR(100) NOT NULL
);

CREATE TABLE Eventos (
    id_evento INT PRIMARY KEY,
    Data INT NOT NULL,
    Horas INT NOT NULL,
    Imagem VARCHAR(200) NOT NULL,
    nome_evento VARCHAR(100) NOT NULL
);

CREATE TABLE DJS_Eventos (
    Id_djs INT,
    Id_eventos INT,
    PRIMARY KEY (Id_djs, Id_eventos),
    FOREIGN KEY (Id_djs) REFERENCES DJS(ID_djs),
    FOREIGN KEY (Id_eventos) REFERENCES Eventos(id_evento)
);

CREATE TABLE Categoriaevento (
    id_categoria INT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL
);

CREATE TABLE Evento_Categoria (
    Id_evento INT,
    Id_categoria INT,
    PRIMARY KEY (Id_evento, Id_categoria),
    FOREIGN KEY (Id_evento) REFERENCES Eventos(id_evento),
    FOREIGN KEY (Id_categoria) REFERENCES Categoriaevento(id_categoria)
);

CREATE TABLE Mesas (
    id_mesa INT PRIMARY KEY,
    nome VARCHAR(15) NOT NULL,
    capacidade INT NOT NULL
);

CREATE TABLE Vip (
    id_vip INT PRIMARY KEY,
    mensagem TEXT NOT NULL,
    id_utilizador INT NOT NULL,
    id_mesa INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id_utilizador),
    FOREIGN KEY (id_mesa) REFERENCES Mesas(id_mesa)
);

CREATE TABLE VIP_Mesas (
    Id_vip INT,
    Id_mesa INT,
    PRIMARY KEY (Id_vip, Id_mesa),
    FOREIGN KEY (Id_vip) REFERENCES Vip(id_vip),
    FOREIGN KEY (Id_mesa) REFERENCES Mesas(id_mesa)
);