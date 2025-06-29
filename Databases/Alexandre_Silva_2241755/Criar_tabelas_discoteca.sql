CREATE DATABASE discoteca;

USE discoteca;

CREATE TABLE Utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    tipo ENUM('N', 'F', 'A') NOT NULL DEFAULT 'N',
    password VARCHAR(255) NOT NULL,
    estado ENUM('A', 'I') NOT NULL DEFAULT 'A',
    ultima_atividade TIMESTAMP NOT NULL,
    nif CHAR(9),
    telefone CHAR(9),
    morada VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE Djs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    tipo_musica VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    morada VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE Categorias_Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id)
) ENGINE=InnoDB;

CREATE TABLE Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    imagem VARCHAR(50) NOT NULL,
    descricao TEXT NOT NULL,
    data_publicacao DATETIME NOT NULL,
    id_utilizador INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id),
    FOREIGN KEY (id_categoria) REFERENCES Categorias_Posts(id)
) ENGINE=InnoDB;

CREATE TABLE Eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(60) NOT NULL,
    Data_Hora_Inicio DATETIME NOT NULL,
    Data_Hora_Fim DATETIME NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id)
) ENGINE=InnoDB;

CREATE TABLE Participacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Data_Hora DATETIME NOT NULL,
    id_dj INT NOT NULL,
    id_eventos INT NOT NULL,
    FOREIGN KEY (id_dj) REFERENCES Djs(id),
    FOREIGN KEY (id_eventos) REFERENCES Eventos(id)
) ENGINE=InnoDB;

CREATE TABLE Fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    tipo_arquivo VARCHAR(5) NOT NULL,
    data_upload DATETIME NOT NULL,
    confirmacao ENUM('S', 'N', 'PV') NOT NULL DEFAULT 'PV',
    id_utilizador INT NOT NULL,
    id_utilizador_aprovar INT,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id),
    FOREIGN KEY (id_utilizador_aprovar) REFERENCES Utilizadores(id)
) ENGINE=InnoDB;

CREATE TABLE Contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(40) NOT NULL,
    mensagem TEXT NOT NULL,
    assunto TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conteudo TEXT NOT NULL,
    titulo VARCHAR(100),
    data_criacao DATETIME NOT NULL,
    id_utilizador INT NOT NULL,
    id_post INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id),
    FOREIGN KEY (id_post) REFERENCES Posts(id)
) ENGINE=InnoDB;

CREATE TABLE Reservas_VIPs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL,
    data_reserva DATETIME NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id)
) ENGINE=InnoDB;






