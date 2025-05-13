<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location:../blog.php");
}
?>


<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <?php include '../require/head.php'; ?>
    <title>H3X - Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>

<div class="login-container">
    <img src="../uploads/logo.png" alt="Logo" class="logo">
    <h1 class="login-title">Iniciar Sessão</h1>

    <?php
    if (isset($_SESSION["errors"])) {
        foreach ($_SESSION["errors"] as $chave => $valor) {
            echo "<div class='alert alert-danger'>$valor</div>";
        }
    }
    ?>

    <form method="POST" action="verificarlogin.php">
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Digite o email" required>
        </div>
        <div class="mb-3 text-start">
            <label for="password" class="form-label">Palavra-passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Digite a palavra-passe" required>
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <div class="register-link">
        Ainda não tem conta? <a href="registar.php">Registe-se aqui</a>
    </div>
</div>

</body>
</html>
