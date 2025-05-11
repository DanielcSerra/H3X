<?php
session_start();
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/utils.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
<title>H3X - Login</title>
<link rel="stylesheet" href="../css/login.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<main class="d-flex align-items-center justify-content-center vh-100">
  <div class="container" style="max-width: 400px;">
    <div class="card shadow-lg p-4 text-white rounded-4 border-white">
      <div class="text-center mb-4">
        <img src="../img/logo.png" alt="Logo H3X" style="max-width: 120px; opacity: 0.8;">
      </div>
      <form method="POST" action="verifica_login.php">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control border-white bg-transparent text-white" id="email"
            placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input type="password" name="password" class="form-control border-white bg-transparent text-white" id="password"
            placeholder="Digite sua senha" required>
        </div>
        <button type="submit" class="btn btn-light w-100 py-2 fw-bold">Entrar</button>
      </form>

      <a href="registar.php" class="btn btn-outline-light w-100 mt-3">Registar</a>
      <a href="../blog.php" class="btn btn-outline-light w-100 mt-2">Voltar ao site</a>
    </div>
  </div>
</main>
</body>
</html>
