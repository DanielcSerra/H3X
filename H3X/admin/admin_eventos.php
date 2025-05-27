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
require_once 'ultima_atividade.php';

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

$pageTitle = "H3X ADMIN - Eventos";

require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Eventos</h1>
                <a href="#" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-plus me-2"></i> Adicionar Evento
                </a>
            </div>

            <?php
            if (!empty($_SESSION["success"])) {
                echo "<div class='alert alert-success fade-out'>" . $_SESSION["success"] . "</div>";
                unset($_SESSION["success"]);
            }
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger fade-out'>$erro</div>";
                }
                unset($_SESSION["errors"]);
            }

            $sql = "SELECT * FROM eventos ORDER BY data_inicio DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="utilizadoresTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($evento = $result->fetch_object()): ?>
                            <tr>
                                <td><?= $evento->id ?></td>
                                <td><?= trim($evento->titulo) ?></td>
                                <td><?= date('d/m/Y', strtotime($evento->data_inicio)) ?> -
                                    <?= date('d/m/Y', strtotime($evento->data_fim)) ?>
                                </td>
                                <td><?= substr($evento->hora_inicio, 0, 5) ?> - <?= substr($evento->hora_fim, 0, 5) ?></td>
                                <td>
                                    <?php if (!empty($evento->imagem_banner)): ?>
                                        <img src="../uploads/<?= trim($evento->imagem_banner) ?>" alt="Banner <?= $evento->id ?>"
                                            style="width: 100px; height: 60px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imagemModal<?= $evento->id ?>">

                                        <div class="modal fade" id="imagemModal<?= $evento->id ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Banner - <?= trim($evento->titulo) ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="../uploads/<?= trim($evento->imagem_banner) ?>" class="img-fluid"
                                                            alt="Banner completo">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Sem imagem</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="#" title="Editar"><i class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="#" title="Apagar" class="ms-2"><i class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="alert alert-warning">Sem eventos encontrados.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>

</html>