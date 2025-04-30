CREATE DATABASE IF NOT EXISTS h3x_db;
USE h3x_db;

CREATE TABLE IF NOT EXISTS utilizador (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(40) NOT NULL UNIQUE,
    tipo ENUM('cliente', 'funcionario', 'administrador') NOT NULL,
    estado ENUM('online', 'offline') NOT NULL,
    ultima_atividade TIMESTAMP,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS imagem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utilizador INT NOT NULL,
    titulo VARCHAR(25) NOT NULL,
    descricao TEXT(300),
    data_upload TIMESTAMP NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    comfirmado enum('sim','nao','espera') NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB;
 
CREATE TABLE IF NOT EXISTS categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(30)
) ENGINE=InnoDB;
 
CREATE TABLE IF NOT EXISTS post (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_upload DATE NOT NULL,
    texto VARCHAR(300) NOT NULL,
    id_categoria INT NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comentario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_upload DATE NOT NULL,
    texto VARCHAR(300) NOT NULL,
    id_post INT NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_post) REFERENCES post(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS evento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(300) NOT NULL,
    tipo_evento ENUM('rock', 'metal', 'techno') NOT NULL,
    id_utilizador INT NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vip (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sitio ENUM('mesa1', 'mesa2', 'mesa3', 'mesa4', 'mesa5') NOT NULL,
    num_pessoas INT NOT NULL,
    id_utilizador INT NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto VARCHAR(300) NOT NULL,
    email VARCHAR(40) NOT NULL,
    telef VARCHAR(9) NOT NULL,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS dj (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    tipo_musica ENUM('rock', 'metal', 'techno') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS participacao (
	id INT PRIMARY KEY AUTO_INCREMENT,
    id_evento INT NOT NULL,
    id_dj INT NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id),
    FOREIGN KEY (id_dj) REFERENCES dj(id)
) ENGINE=InnoDB;


INSERT INTO utilizador (nome, email, tipo, estado, ultima_atividade, password) VALUES
('Ana Sousa', 'ana.sousa@email.com', 'cliente', 'online', CURRENT_TIMESTAMP, 'password123'),
('Pedro Martins', 'pedro.m@email.com', 'funcionario', 'offline', '2023-06-10 09:00:00', 'func1234'),
('Admin', 'admin@h3x.com', 'administrador', 'online', CURRENT_TIMESTAMP, 'adminH3X!');

INSERT INTO categoria (nome) VALUES
('Eventos'),
('Fotografia');

INSERT INTO imagem (id_utilizador, titulo, descricao, data_upload, image_path) VALUES
(1, 'Festival Verão', 'Foto do palco principal', CURRENT_TIMESTAMP, 'galeria/festival1.jpg'),
(2, 'DJ Principal', 'Foto durante atuação', CURRENT_TIMESTAMP, 'galeria/dj1.jpg');

INSERT INTO post (data_upload, texto, id_categoria, id_utilizador) VALUES
('2023-06-15', 'Novo evento confirmado para Julho!', 1, 2),
('2023-06-16', 'Qual é o vosso artista favorito?', 2, 1);

INSERT INTO comentario (data_upload, texto, id_post, id_utilizador) VALUES
('2023-06-15', 'Este dj é muito bom!', 1, 1),
('2023-06-16', 'Não gostei deste Post.', 2, 3);

INSERT INTO evento (descricao, tipo_evento, data,id_utilizador) VALUES
('Festival de Verão 2023', 'techno', '2023-07-20',1),
('Noite de Rock Clássico', 'rock', '2023-08-05',3);

INSERT INTO dj (nome, tipo_musica) VALUES
('DJ Mark', 'techno'),
('Banda The Rocks', 'rock');

INSERT INTO participacao (id,id_evento, id_dj) VALUES
(1,1, 1),
(2,2, 2);

INSERT INTO vip (sitio, num_pessoas, id_utilizador, data) VALUES
('mesa1', 4, 1, '2023-07-20'),
('mesa2', 2, 3, '2023-08-05');

INSERT INTO contacto (id,texto,email,telef,nome) VALUES
(1,'Como fazer reserva vip?', 'rafaelsantos@gmail.com','123456789','Rafael Santos'),
(2,'Problema no upload de fotos', 'saramar@gmail.com','912503682','Sara Margarida');

CREATE OR REPLACE VIEW utilizadores_online AS
SELECT id, nome, email, tipo
FROM utilizador
WHERE estado = 'online'
ORDER BY nome DESC;

CREATE OR REPLACE VIEW ultimos_posts AS
SELECT texto, data_upload 
FROM post 
ORDER BY data_upload DESC ;

CREATE OR REPLACE VIEW eventos_futuros AS
SELECT id, descricao, tipo_evento, data
FROM evento
WHERE data >= CURDATE()
ORDER BY data;

CREATE OR REPLACE VIEW fotos_recentes AS
SELECT titulo, data_upload 
FROM imagem 
ORDER BY data_upload DESC;

CREATE OR REPLACE VIEW ultimos_comentarios AS
SELECT texto, data_upload 
FROM comentario 
ORDER BY data_upload DESC ;

SELECT * FROM utilizadores_online;
SELECT * FROM eventos_futuros;
SELECT * FROM utilizador;
SELECT * FROM imagem;
SELECT * FROM post;
SELECT * FROM comentario;
SELECT * FROM evento;
SELECT * FROM vip;
SELECT * FROM contacto; 
SELECT * FROM categoria;
SELECT * FROM dj;            