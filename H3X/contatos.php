<?php
session_start();
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <?php include 'partials/head.php'; ?>
  <title>H3X - Contactos</title>

  <link rel="stylesheet" href="css/contato.css">
  <?php
  $success = "";
  $errors = [];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (empty($nome)) {
      $errors[] = "O campo nome é obrigatório.";
    }
    if (empty($assunto)) {
      $errors[] = "Por favor escolha um assunto.";
    }
    if (empty($email)) {
      $errors[] = "O campo email é obrigatório.";
    }
    if (empty($telefone)) {
      $errors[] = "O campo telefone é obrigatório.";
    }
    if (empty($mensagem)) {
      $errors[] = "O campo telefone é mensagem é obrigatorio.";
    }

    if (empty($errors)) {
      $stmt = $conn->prepare("INSERT INTO contactos (nome,assunto, email, telefone, mensagem,data_envio) VALUES (?,?, ?, ?, ?, NOW() )");
      $stmt->bind_param("sssss", $nome, $assunto, $email, $telefone, $mensagem);

      if ($stmt->execute()) {
        $success = "Mensagem enviada com sucesso!";
        $nome = $assunto = $email = $telefone = $mensagem = '';
      } else {
        $errors[] = "Erro ao enviar a mensagem. Tente novamente.";
      }
      $stmt->close();
    }
  }


  ?>


</head>

<body>
  <?php include 'partials/navbar.php'; ?>

  <div class="Banner">
    <img src="img/bannercontacto.png" alt="Banner Contactos">
    <h1>Contactos</h1>
  </div>
  <div class="barra">
    <img src="img/barrabranca.png" class="barra_branca" alt="">
  </div>
  <section class="contact-section">
    <div class="contact-container">
      <div class="contact-info">
        <div class="contact-item">
          <div class="icon-box">
            <img src="img/Group 244.png" alt="Telefone">
          </div>
          <div class="contact-text">
            <span class="contact-label">TELEFONE</span>
            <span class="contact-detail">959 888 888</span>
          </div>
        </div>

        <div class="contact-item">
          <div class="icon-box">
            <img src="img/Subtract.png" class="email-icon" alt="Email">
          </div>
          <div class="contact-text">
            <span class="contact-label">EMAIL</span>
            <span class="contact-detail">h3xnightclub@gmail.com</span>
          </div>
        </div>

        <div class="contact-item">
          <div class="icon-box">
            <img src="img/iconelocalizacaopng" alt="Localização">
          </div>
          <div class="contact-text">
            <span class="contact-label">LOCALIZAÇÃO</span>
            <span class="contact-detail">Av. Brasília 66, 1200-481 Lisboa</span>
          </div>
        </div>
      </div>

      <div class="contact-form">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
              <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>


          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Escreve o teu nome"
              value="<?= htmlspecialchars($nome ?? '') ?>" required>
          </div>

          <div class="mb-3">
            <label for="assunto" class="form-label">Assunto</label>
            <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Teu número de telefone"
              value="<?= htmlspecialchars($assunto ?? '') ?>" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
              value="<?= htmlspecialchars($email ?? '') ?>" required>
          </div>



          <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Teu número de telefone"
              value="<?= htmlspecialchars($telefone ?? '') ?>" required>
          </div>

          <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem</label>
            <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Escreve a tua mensagem"
              required><?= htmlspecialchars($mensagem ?? '') ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
        </form>
      </div>
    </div>
  </section>
  <div class="mapa_container">
    <div class="mapa_discoteca">
      <div class="mapa_escuro">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3068.228507335417!2d-8.825259736107782!3d39.73451765260679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22735a4e067afb%3A0xcfaf619f4450fa76!2sPolit%C3%A9cnico%20de%20Leiria%20%7C%20ESTG%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o_Edif%C3%ADcio%20D!5e0!3m2!1spt-PT!2spt!4v1748532881324!5m2!1spt-PT!2spt"
          height="450" style="border:0; width:100%; filter: invert(90%)" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

    </div>
  </div>
  <?php include 'partials/footer.php'; ?>
</body>

</html>