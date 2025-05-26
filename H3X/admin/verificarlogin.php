<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$_SESSION["errors"] = [];

if (isset($_POST["email"])) {
    $email = trim($_POST["email"]);
} else {
    $email = "";
}

if (strlen($email) == 0) {
    $_SESSION["errors"]["email"] = "Email inválido";
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
} else {
    $password = "";
}

if (strlen($password) == 0) {
    $_SESSION["errors"]["pass"] = "Password inválida";
}

if (count($_SESSION["errors"]) == 0) {
    require_once "../db_config.php";

    if ($conn->connect_errno) {
        $_SESSION["errors"]["auth"] = "Erro de ligação à base de dados";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT email, pass, tipo, foto, nome FROM utilizadores WHERE email = '$email'";

        $result = $conn->query($sql);
        if ($result && $result->num_rows != 0) {
            $user = $result->fetch_object();
            $password = trim($_POST["password"]);

            if ($user->pass == hash("sha512", $password)) {
                $_SESSION["authenticated"] = true;
                $_SESSION["email"] = $user->email;
                $_SESSION["nome"] = $user->nome;
                $_SESSION["foto"] = $user->foto;
                $_SESSION["tipo"] = $user->tipo;
                $_SESSION["errors"] = [];
                header("location:../index.php");
                exit();
            } else {
                $_SESSION["errors"]["pass"] = "Password inválida";
                header("location:login.php");
                exit();
            }
        } else {
            $_SESSION["errors"]["auth"] = "Email ou Password inválidos";
            header("location:login.php");
            exit();
        }
        }
       }
} else {
    header("location:login.php");
    exit();
}