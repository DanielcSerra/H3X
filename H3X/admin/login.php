<?php
session_start();
if (isset($_SESSION["email"])) {
   header("location:../index.php");
   exit;
}
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
   <?php include '../require/head.php'; ?>
   <title>H3X - Login</title>
   <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="css/login.css">
</head>

<body>

   <div class="login-container">
      <a href="../index.php" class="back-arrow" title="Voltar à Página Inicial">
         <i class="ri-arrow-left-line"></i>
      </a>
      <img src="../uploads/logo.png" alt="Logo" class="logo">

      <h1 class="login-title" id="form-title">Iniciar Sessão</h1>


      <?php

      if (!empty($_SESSION["success"])) {
         echo "<div class='alert fade-out'>" . $_SESSION["success"] . "</div>";
         unset($_SESSION["success"]);
      }
      if (!empty($_SESSION["errors"])) {
         foreach ($_SESSION["errors"] as $valor) {
            echo "<div class='alert fade-out'>$valor</div>";
         }
         unset($_SESSION["errors"]);
      }
      ?>

      <form method="POST" action="verificarlogin.php" id="login-form" class="form-active">
         <div class="mb-3 text-start">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Digite o email" required>
         </div>
         <div class="mb-3 text-start">
            <label for="password" class="form-label">Palavra-passe</label>
            <input type="password" name="password" class="form-control" id="password"
               placeholder="Digite a palavra-passe" required>
         </div>
         <button type="submit" class="botao-custom pequeno px-4 py-2">Entrar</button>
         <div class="register-link">
            Ainda não tem conta? <a class="link-highlight" onclick="toggleForms()">Crie uma aqui</a>
         </div>
      </form>

      <form method="POST" action="registar.php" id="register-form" class="form-inactive">
         <div class="mb-3 text-start">
            <label for="nome-register" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" id="nome-register" placeholder="Digite o nome" required
               pattern="^[A-Za-zÀ-ÿ\s]{2,15}$" title="Nome deve conter apenas letras e pelo menos 2 caracteres.">
         </div>
         <div class="mb-3 text-start">
            <label for="email-register" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email-register" placeholder="Digite o email"
               required>
         </div>
         <div class="mb-3 text-start">
            <label for="telefone-register" class="form-label">Telefone <small>(Opcional)</small></label>
            <input type="tel" name="telefone" class="form-control" id="telefone-register"
               placeholder="Digite o telefone" pattern="[0-9]{9}"
               title="Telefone deve conter exatamente 9 dígitos numéricos.">
         </div>
         <div class="mb-3 text-start">
            <label for="data-nascimento-register" class="form-label">Data Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" id="data-nascimento-register" required>
         </div>
         <div class="mb-3 text-start">
            <label for="password-register" class="form-label">Palavra-passe</label>
            <input type="password" name="password" class="form-control" id="password-register"
               placeholder="Digite a palavra-passe" required minlength="6"
               title="A palavra-passe deve ter pelo menos 6 caracteres.">
         </div>
         <button type="submit" class="botao-custom pequeno px-4 py-2">Criar</button>
         <div class="register-link">
            Já tem conta? <a class="link-highlight" onclick="toggleForms()">Inicie sessão aqui</a>
         </div>
      </form>
   </div>

   <script src="js/login.js"></script>
</body>

</html>