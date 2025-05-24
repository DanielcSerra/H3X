<?php
session_start();
require_once "../db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    $nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $telefone = isset($_POST["telefone"]) ? trim($_POST["telefone"]) : "";
    $data_nascimento = isset($_POST["data_nascimento"]) ? $_POST["data_nascimento"] : "";
    $senha = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    if (strlen($nome) == 0) {
        $_SESSION["errors"]["nome"] = "Nome inválido";
    }

    if (strlen($email) == 0) {
        $_SESSION["errors"]["email"] = "Email inválido";
    }

    if (strlen($data_nascimento) == 0) {
        $_SESSION["errors"]["data_nascimento"] = "Data de nascimento inválida";
    }

    if (strlen($senha) < 6) {
        $_SESSION["errors"]["password"] = "A palavra-passe deve ter pelo menos 6 caracteres";
    }

    if (count($_SESSION["errors"]) === 0) {
        $nome = mysqli_real_escape_string($conn, $nome);
        $email = mysqli_real_escape_string($conn, $email);
        $telefone = mysqli_real_escape_string($conn, $telefone);
        $data_nascimento = mysqli_real_escape_string($conn, $data_nascimento);
        $senha = mysqli_real_escape_string($conn, $senha);

        $sql = "SELECT email FROM utilizadores WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows != 0) {
            $_SESSION["errors"]["email"] = "Email já existe";
        } else {
            $senhaHash = hash("sha512", $senha);

            $tipo = 'c';
            $estado = 'd';

            $sql = "INSERT INTO utilizadores (nome, email, telefone, data_nascimento, pass, tipo, estado) 
                    VALUES ('$nome', '$email', '$telefone', '$data_nascimento', '$senhaHash', '$tipo', '$estado')";

            if ($conn->query($sql)) {
                $_SESSION["success"] = "Conta criada com sucesso!";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION["errors"]["db"] = "Erro ao criar utilizador: " . $conn->error;
            }
        }
    }

} else {
    $_SESSION["errors"] = [];
}

header("Location: login.php");
exit();
?>