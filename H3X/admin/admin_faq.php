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

$pageTitle = "H3X ADMIN - FAQ";

require 'partials/header.php';
?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">FAQ</h1>
                <div>
                    <a href="admin_faq_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Adicionar FAQ
                    </a>
                </div>
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
            ?>

            <?php
            $sql = "SELECT * FROM faq ORDER BY id DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="utilizadoresTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Resposta</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($faq = $result->fetch_object()):
                            $id = $faq->id;
                            $titulo = trim($faq->titulo);
                            $resposta_resumida = mb_strimwidth(strip_tags($faq->resposta), 0, 80, '...');
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $titulo ?></td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#respostaModal<?= $id ?>">
                                        <?= $resposta_resumida ?>
                                    </a>

                                    <div class="modal fade" id="respostaModal<?= $id ?>" tabindex="-1"
                                        aria-labelledby="respostaModalLabel<?= $id ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="respostaModalLabel<?= $id ?>">Resposta -
                                                        <?= $titulo ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= nl2br(trim($faq->resposta)) ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="admin_faq_edit.php?id=<?= urlencode($id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="admin_faq_delete.php?id=<?= urlencode($id) ?>" title="Apagar" class="ms-2"><i
                                            class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="alert alert-warning">Sem FAQs encontrados.</p>
            <?php endif; ?>

        </div>
    </div>

    <?php require 'partials/footer.php'; ?>

</body>

</html>