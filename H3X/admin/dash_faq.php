<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true
    || !isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a','f'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";
$pageTitle = "H3X ADMIN – FAQs";
?>

<?php require 'includes/header.php'; ?>
<?php require 'includes/sidebar.php'; ?>

<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">FAQs</h2>
    

    <div class="d-flex align-items-center gap-2">
      <form method="GET" class="d-flex gap-2 mb-0">
        <input type="text" name="pesquisa" class="form-control form-control-sm"
               placeholder="Pesquisar..." style="width:200px;"
               value="<?= isset($_GET['pesquisa'])?htmlspecialchars($_GET['pesquisa']):'' ?>">
        <button type="submit" class="btn btn-outline-secondary btn-sm px-2">
          <i class="ri-search-line"></i>
        </button>
        <a href="dashboard_faq.php" class="btn btn-outline-danger btn-sm px-2">
          <i class="ri-close-line"></i>
        </a>
      </form>

      <a href="adicionar_faq.php" class="btn btn-dark btn-sm px-3">
        <i class="ri-add-line me-1"></i> Adicionar
      </a>
    </div>
  </div>

  <div class="table-container">
    <?php
      if (!empty($_GET['pesquisa'])) {
        $q = mysqli_real_escape_string($conn, $_GET['pesquisa']);
        $sql = "SELECT * FROM faq WHERE pergunta LIKE '%$q%' OR resposta LIKE '%$q%'";
      } else {
        $sql = "SELECT * FROM faq ORDER BY id DESC";
      }
      $res = $conn->query($sql);

      if ($res && $res->num_rows>0) {
        echo '<table class="table table-borderless align-middle text-center shadow-sm rounded-3 overflow-hidden">
                <thead class="bg-light text-secondary">
                  <tr><th>#</th><th>Pergunta</th><th>Resposta</th><th>Ações</th></tr>
                </thead><tbody class="bg-white">';
        $i = 1;
        while($f = $res->fetch_object()) {
          echo '<tr class="border-bottom">
                  <td>'. $i++ .'</td>
                  <td>'. htmlspecialchars($f->pergunta) .'</td>
                  <td>'. htmlspecialchars(substr($f->resposta,0,100)) .'…</td>
                  <td>
                    <a href="editar_faq.php?id='.$f->id.'" class="btn btn-link text-warning p-0 me-2">
                      <i class="ri-pencil-line"></i>
                    </a>
                    <a href="apagar_faq.php?id='.$f->id.'" class="btn btn-link text-danger p-0"
                       onclick="return confirm(\'Deseja mesmo apagar esta FAQ?\')">
                      <i class="ri-delete-bin-line"></i>
                    </a>
                  </td>
                </tr>';
        }
        echo '</tbody></table>';
      } else {
        echo "<p class='alert alert-warning'>Nenhuma FAQ encontrada.</p>";
      }
    ?>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
