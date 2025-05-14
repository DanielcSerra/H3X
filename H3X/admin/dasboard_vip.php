<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a', 'f'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";

$nomeUtilizador = $_SESSION["nome"] ?? "Utilizador";
$tipoUtilizador = $_SESSION["tipo"] ?? "c";

switch ($tipoUtilizador) {
    case 'a':
        $tipoLabel = "Administrador";
        break;
    case 'f':
        $tipoLabel = "Funcionário";
        break;
    default:
        $tipoLabel = "Cliente";
        break;
}

$pageTitle = "H3X ADMIN - Serviços VIP";
?>
<?php require 'includes/header.php'; ?>
<?php require 'includes/sidebar.php'; ?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">Serviços VIP</h2>

        <div class="d-flex align-items-center gap-2">
            <form method="GET" class="d-flex align-items-center gap-2 mb-0">
                <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar..."
                    style="width: 200px;">
                <button type="submit" class="btn btn-outline-secondary btn-sm px-2">
                    <i class="ri-search-line"></i>
                </button>
                <a href="dashboard_servicos_vip.php" class="btn btn-outline-danger btn-sm px-2">
                    <i class="ri-close-line"></i>
                </a>
            </form>

            <a href="adicionar_servico_vip.php" class="btn btn-dark btn-sm px-3">
                <i class="ri-add-line me-1"></i> Adicionar
            </a>
        </div>
    </div>

    <div class="table-container">
        <?php
        if (isset($_GET["pesquisa"]) && !empty($_GET["pesquisa"])) {
            $pesquisa = mysqli_real_escape_string($conn, $_GET["pesquisa"]);
            $sql = "SELECT * FROM servicos_vip WHERE titulo LIKE '%$pesquisa%'";
        } else {
            $sql = "SELECT * FROM servicos_vip";
        }

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '
            <table class="table table-borderless align-middle text-center shadow-sm rounded-3 overflow-hidden">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white">';

            $count = 1;
            while ($servico = $result->fetch_object()) {
                echo '<tr class="border-bottom">
                        <td>' . $count++ . '</td>
                        <td>' . htmlspecialchars($servico->titulo) . '</td>';

                if (!empty($servico->imagem)) {
                    echo '<td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal' . $servico->id . '">
                            <img src="../uploads/' . trim($servico->imagem) . '" class="img-fluid" style="width: 60px; height: auto;" alt="Imagem do serviço">
                        </a>
                    </td>';

                    echo '<div class="modal fade" id="imageModal' . $servico->id . '" tabindex="-1" aria-labelledby="imageModalLabel' . $servico->id . '" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel' . $servico->id . '">Imagem do Serviço VIP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="../uploads/' . trim($servico->imagem) . '" class="img-fluid" alt="Imagem do serviço">
                                    </div>
                                </div>
                            </div>
                        </div>';
                } else {
                    echo '<td><span class="text-muted">Sem imagem</span></td>';
                }

                echo '<td>
                        <a href="edit_servico_vip.php?id=' . urlencode($servico->id) . '" class="btn btn-link text-warning p-0 me-2">
                            <i class="ri-pencil-line"></i>
                        </a>
                        <a href="delete_servico_vip.php?id=' . urlencode($servico->id) . '" class="btn btn-link text-danger p-0">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "<p class='alert alert-warning'>Sem resultados encontrados.</p>";
        }
        ?>
    </div>
</div>

<?php require 'includes/footer.php'; ?>