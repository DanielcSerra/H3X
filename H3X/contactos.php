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

  
  <link rel="stylesheet" href="css/faq.css">
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
      $stmt = $conn->prepare("INSERT INTO contactos (nome,assunto, email, telefone, mensagem,data_contactos) VALUES (?,?, ?, ?, ?, NOW() )");
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
            <img src="img/Group 244.png"  alt="Telefone">
          </div>
          <div class="contact-text">
            <span class="contact-label">TELEFONE</span>
            <span class="contact-detail">959 888 888</span>
          </div>
        </div>

        <div class="contact-item">
          <div class="icon-box">
            <img src="img/email_icon.png" class="email-icon" alt="Email">
          </div>
          <div class="contact-text">
            <span class="contact-label">EMAIL</span>
            <span class="contact-detail">h3xnightclub@gmail.com</span>
          </div>
        </div>

        <div class="contact-item">
          <div class="icon-box">
            <img src="img/location_icon_aa.png" alt="Localização">
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

          <button type="submit" class="botao-faqs1">Enviar Mensagem</button>
        </form>
      </div>
    </div>
  </section>
  <div class="mapa_container"
>
    <div class="mapa_discoteca">
    <h1 class="texto-alinhado">Mapa</h1>
      <div class="mapa_escuro">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3068.228507335417!2d-8.825259736107782!3d39.73451765260679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22735a4e067afb%3A0xcfaf619f4450fa76!2sPolit%C3%A9cnico%20de%20Leiria%20%7C%20ESTG%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o_Edif%C3%ADcio%20D!5e0!3m2!1spt-PT!2spt!4v1748532881324!5m2!1spt-PT!2spt"
          height="450" style="border:0; width:100%; filter: invert(90%)" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

    </div>
  </div>




  <div class="contain">
  <section class="faq-container">
    <div class="faq-header">Perguntas Frequentes</div>

    <?php
    $sql = "SELECT * FROM faq ORDER BY id LIMIT 3";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $first = true;
        $count = 0;

        while ($faq = $result->fetch_assoc()) {
            echo '<div class="faq-item' . ($first ? ' active' : '') . '">';
            echo '<div class="faq-question">' . htmlspecialchars($faq['titulo']) . '</div>';
            echo '<div class="faq-answer">' . htmlspecialchars($faq['resposta']) . '</div>';
            echo '</div>';

            if ($count < 2) {
                echo '<div class="faq-divider"></div>';
            }

            $first = false;
            $count++;
        }

        echo '<div class="faq-spacer"></div>';
    } else {
        echo '<div class="faq-item">';
        echo '<div class="faq-question">FAQ vazio</div>';
        echo '<div class="faq-answer">Nenhuma pergunta frequente encontrada.</div>';
        echo '</div>';
    }
    ?>
    <div style="text-align: center; padding: 20px;">
      <a href="faq.php" class="botao-faqs">Ver todas as FAQs</a>
    </div>
  </section>
</div>




  <?php include 'partials/footer.php'; ?>


  <script>
document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        item.addEventListener('click', function () {
            this.classList.toggle('active');
            faqItems.forEach(otherItem => {
                if (otherItem !== this) {
                    otherItem.classList.remove('active');
                }
            });
        });
    });

    if (faqItems.length > 0) {
        faqItems[0].classList.add('active');
    }
});
</script>

  <script>
function validarFormulario(submitEvent) {
    var id = document.getElementById("id")?.value.trim(); 
    var nome = document.getElementById("nome").value.trim();
    var assunto = document.getElementById("assunto").value.trim();
    var telefone = document.getElementById("telefone").value.trim();
    var email = document.getElementById("email").value.trim();
    var mensagem = document.getElementById("mensagem").value.trim();

    if (nome.length < 2 || nome.length > 50) {
        alert("O nome deve ter entre 2 e 50 caracteres.");
        submitEvent.preventDefault();
        return;
    }

    if (assunto.length < 10 || assunto.length > 100) {
        alert("O assunto deve ter entre 10 e 100 caracteres.");
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

    if (email === "") {
        alert("O email é obrigatório.");
        submitEvent.preventDefault();
        return;
    }

    if (email.length > 150) {
        alert("O email deve ter no máximo 100 caracteres.");
        submitEvent.preventDefault();
        return;
    }


    if (mensagem.length < 5 || mensagem.length > 300) {
        alert("A mensagem deve ter entre 5 e 300 caracteres.");
        submitEvent.preventDefault();
        return;
    }
}

window.onload = function () {
    var form = document.querySelector("form");
    form.addEventListener("submit", validarFormulario);
}
</script>

</body>

</html>