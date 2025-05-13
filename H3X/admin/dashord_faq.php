<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
  header('Location: login.php');
  exit();
}

require_once 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Listagem de FAQs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Listagem de FAQs</h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Pergunta</th>
        <th>Resposta</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM faq";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($faq = $result->fetch_object()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($faq->pergunta) . "</td>";
          echo "<td>" . nl2br(htmlspecialchars($faq->resposta)) . "</td>";
          echo "<td>";
          echo "<a href='editFaq.php?id=" . $faq->id . "' class='btn btn-primary btn-sm me-2'>Editar</a>";
          echo "<a href='deleteFaq.php?id=" . $faq->id . "' class='btn btn-danger btn-sm'>Eliminar</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='3'>Nenhuma FAQ encontrada.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <a href="insertFaq.php" class="btn btn-success">Nova FAQ</a>

</div>

</body>
</html>
