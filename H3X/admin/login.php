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
   <?php include '../partials/head.php'; ?>
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
               placeholder="Digite a palavra-passe" required minlength="6" maxlength="20"
               title="A palavra-passe deve ter entre 6 e 20 caracteres.">
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
               minlength="2" maxlength="15" title="Nome deve conter apenas letras e pelo menos 2 caracteres.">
         </div>
         <div class="mb-3 text-start">
            <label for="email-register" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email-register" placeholder="Digite o email"
               required>
         </div>
         <div class="mb-3 text-start">
            <label for="telefone-register" class="form-label">Telefone <small>(Opcional)</small></label>
            <input type="tel" name="telefone" class="form-control" id="telefone-register"
               placeholder="Digite o telefone" minlength="9" maxlength="9"
               title="Telefone deve conter exatamente 9 dígitos numéricos.">
         </div>
         <div class="mb-3 text-start">
            <label for="data-nascimento-register" class="form-label">Data Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" id="data-nascimento-register" required>
         </div>
         <div class="mb-3 text-start">
            <label for="password-register" class="form-label">Palavra-passe</label>
            <input type="password" name="password" class="form-control" id="password-register"
               placeholder="Digite a palavra-passe" required minlength="6" maxlength="20"
               title="A palavra-passe deve ter entre 6 e 20 caracteres.">
         </div>
         <button type="submit" class="botao-custom pequeno px-4 py-2">Criar</button>
         <div class="register-link">
            Já tem conta? <a class="link-highlight" onclick="toggleForms()">Inicie sessão aqui</a>
         </div>
      </form>
   </div>

   <script src="js/login.js"></script>

   <script>
      document.getElementById('login-form').addEventListener('submit', function (submitEvent) {
         const email = document.getElementById('email').value.trim();
         const password = document.getElementById('password').value;

         if (email === "" || email.length > 100) {
            alert("Preencha um email válido.");
            submitEvent.preventDefault();
            return;
         }

         if (password.length < 6 || password.length > 20) {
            alert("A palavra-passe deve ter entre 6 e 20 caracteres.");
            submitEvent.preventDefault();
            return;
         }
      });

      document.getElementById('register-form').addEventListener('submit', function (submitEvent) {
         const nome = document.getElementById('nome-register').value.trim();
         const email = document.getElementById('email-register').value.trim();
         const telefone = document.getElementById('telefone-register').value.trim();
         const dataNascimento = document.getElementById('data-nascimento-register').value;
         const password = document.getElementById('password-register').value;

         if (nome.length < 2 || nome.length > 15) {
            alert("O nome deve ter entre 2 e 15 caracteres.");
            submitEvent.preventDefault();
            return;
         }

         if (email === "") {
            alert("O email é obrigatório.");
            submitEvent.preventDefault();
            return;
         }

         if (email.length > 100) {
            alert("O email deve ter no máximo 100 caracteres.");
            submitEvent.preventDefault();
            return;
         }

         if (telefone !== "") {
            if (telefone.length !== 9 || isNaN(telefone)) {
               alert("O telefone deve conter exatamente 9 dígitos numéricos.");
               submitEvent.preventDefault();
               return;
            }
         }

         if (dataNascimento === "") {
            alert("Preencha a data de nascimento.");
            submitEvent.preventDefault();
            return;
         }

         if (password.length < 6 || password.length > 20) {
            alert("A palavra-passe deve ter entre 6 e 20 caracteres.");
            submitEvent.preventDefault();
            return;
         }
      });

   </script>
</body>

</html>