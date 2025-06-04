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

$pageTitle = "H3X ADMIN - Galeria";

require 'partials/header.php';
?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Galeria</h1>
                <div>
                    <a href="admin_galeria_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Adicionar Imagem
                    </a>
                </div>
            </div>

            <?php
            require_once('partials/erros_sucesso_msgs.php');
            ?>

            <?php
            $sql = "SELECT g.*, u.nome AS nome_utilizador 
                FROM imagens_galeria g
                LEFT JOIN utilizadores u ON g.id_utilizador = u.id
                ORDER BY g.data_upload DESC";

            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="galeriaTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Imagem</th>
                            <th>Aprovado</th>
                            <th>Data Upload</th>
                            <th>Utilizador</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($img = $result->fetch_object()):
                            $id = $img->id;
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= trim($img->titulo) ?></td>
                                <td>
                                    <?php if (!empty($img->imagem)): ?>
                                        <img src="../uploads/galeria/<?= trim($img->imagem) ?>" alt="Imagem <?= $id ?>"
                                            style="width: 100px; height: 60px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imagemModal<?= $id ?>" />

                                        <div class="modal fade" id="imagemModal<?= $id ?>" tabindex="-1"
                                            aria-labelledby="imagemModalLabel<?= $id ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imagemModalLabel<?= $id ?>">Imagem -
                                                            <?= trim($img->titulo) ?>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="../uploads/<?= trim($img->imagem) ?>" alt="Imagem <?= $id ?>"
                                                            class="img-fluid" />
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
                                    <?= $img->aprovado ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($img->data_upload)) ?></td>
                                <td><?= trim($img->nome_utilizador ?? 'Desconhecido') ?></td>
                                <td>
                                    <a href="admin_galeria_edit.php?id=<?= urlencode($id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="admin_galeria_delete.php?id=<?= urlencode($id) ?>" title="Apagar" class="ms-2"><i
                                            class="fas fa-trash text-danger"></i></a>
                                    <?php if ($img->aprovado) { ?>
                                        <a href="admin_galeria_disaproveimg.php?id=<?php echo urlencode($id); ?>" title="Desaprovar"
                                            class="ms-2">
                                            <i class="fas fa-check-square text-danger"></i>
                                        </a>
                                    <?php } else { ?>
                                        <a href="admin_galeria_aproveimg.php?id=<?php echo urlencode($id); ?>" title="Aprovar"
                                            class="ms-2">
                                            <i class="fas fa-check-square text-success"></i>
                                        </a>
                                    <?php } ?>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="alert alert-warning">Sem resultados encontrados.</p>
            <?php endif; ?>

        </div>
    </div>

    <?php require 'partials/footer.php'; ?>

</body>

</html>