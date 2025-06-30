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
                <a href="admin_eventos_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-plus me-2"></i> Adicionar Evento
                </a>
            </div>

            <?php
            require_once('partials/erros_sucesso_msgs.php');

            $sql = "SELECT * FROM eventos ORDER BY data_inicio DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="eventosTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Img Card</th>
                            <th>Img Banner</th>
                            <th>Vídeo</th>
                            <th>Lineup</th>
                            <th>videoYT</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($evento = $result->fetch_object()): 
                            $conteudo_resumido = mb_strimwidth($evento->lineup, 0, 80, '...');
                            $conteudo_resumido2 = mb_strimwidth($evento->videoyt, 0, 80, '...');
                            ?>
                            
                            <tr>
                                <td><?= $evento->id ?></td>
                                <td><?= trim($evento->titulo) ?></td>
                                <td><?= date('d/m/Y', strtotime($evento->data_inicio)) ?> -
                                    <?= date('d/m/Y', strtotime($evento->data_fim)) ?>
                                </td>
                                <td><?= date('G:i', strtotime($evento->data_inicio)) ?> -
                                    <?= date('G:i', strtotime($evento->data_fim)) ?></td>
                                <td>
                                    <?php if (!empty($evento->imagem_card)): ?>
                                        <img src="../uploads/<?= trim($evento->imagem_card) ?>" alt="Card <?= $evento->id ?>"
                                            style="width: 100px; height: 60px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imagemModal<?= $evento->id ?>">

                                        <div class="modal fade" id="imagemModal<?= $evento->id ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Card - <?= trim($evento->titulo) ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="../uploads/<?= trim($evento->imagem_card) ?>" class="img-fluid"
                                                            alt="Card completo">
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
                                    <?php if (!empty($evento->video_banner)): ?>
                                        <video src="../uploads/<?= trim($evento->video_banner) ?>" alt="Video <?= $evento->id ?>"
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
                                                            alt="Video completo">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Sem vídeo</span>
                                    <?php endif; ?>
                                </td>
                                
                                

                                <td><?= trim($conteudo_resumido) ?></td>
                                <td><?= trim($conteudo_resumido2) ?></td>

                                <td>
                                    <a href="admin_eventos_edit.php?id=<?= htmlspecialchars(urlencode($evento->id)) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="admin_eventos_delete.php?id=<?= htmlspecialchars(urlencode($evento->id)) ?>" title="Apagar"><i class="fas fa-trash text-danger"></i></a>
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