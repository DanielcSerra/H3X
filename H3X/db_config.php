<?php 
$host = 'localhost';
$database = 'h3x_db';
$db_user = 'root';
$db_pass = '';

$conn = new mysqli($host, $db_user, $db_pass);

if ($conn->connect_error) {
    die("Erro de ligação à base de dados: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS h3x_db";
if ($conn->query($sql)) {
    echo "Banco de dados criado com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error . "<br>";
}

$conn->select_db($database);


$sql = "CREATE TABLE IF NOT EXISTS utilizador (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(40) NOT NULL UNIQUE,
    tipo ENUM('cliente', 'funcionario', 'administrador') NOT NULL,
    estado ENUM('online', 'offline') NOT NULL,
    ultima_atividade TIMESTAMP,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'utilizador' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'utilizador': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS imagem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utilizador INT NOT NULL,
    titulo VARCHAR(25) NOT NULL,
    descricao TEXT(300),
    data_upload TIMESTAMP NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    comfirmado ENUM('sim','nao','espera') NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'imagem' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'imagem': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(30)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'categoria' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'categoria': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS post (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_upload DATE NOT NULL,
    texto VARCHAR(300) NOT NULL,
    id_categoria INT NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'post' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'post': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS comentario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_upload DATE NOT NULL,
    texto VARCHAR(300) NOT NULL,
    id_post INT NOT NULL,
    id_utilizador INT NOT NULL,
    FOREIGN KEY (id_post) REFERENCES post(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'comentario' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'comentario': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS evento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(300) NOT NULL,
    tipo_evento ENUM('rock', 'metal', 'techno') NOT NULL,
    id_utilizador INT NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'evento' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'evento': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS vip (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sitio ENUM('mesa1', 'mesa2', 'mesa3', 'mesa4', 'mesa5') NOT NULL,
    num_pessoas INT NOT NULL,
    id_utilizador INT NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizador(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'vip' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'vip': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS contacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto VARCHAR(300) NOT NULL,
    email VARCHAR(40) NOT NULL,
    telef VARCHAR(9) NOT NULL,
    nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'contacto' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'contacto': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS dj (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    tipo_musica ENUM('rock', 'metal', 'techno') NOT NULL
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'dj' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'dj': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS participacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_evento INT NOT NULL,
    id_dj INT NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id),
    FOREIGN KEY (id_dj) REFERENCES dj(id)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Tabela 'participacao' criada com sucesso ou já existente.<br>";
} else {
    echo "Erro ao criar tabela 'participacao': " . $conn->error . "<br>";
}


$conn->close();
?>